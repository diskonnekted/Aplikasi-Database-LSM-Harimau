<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\News;
use App\Models\Region;
use App\Models\User;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MembersExport;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('member')) {
            $member = $user->member;
            return view('member.dashboard', compact('member'));
        }

        $managedRegionIds = $this->getManagedRegionIds($user);

        $stats = [
            'total_members' => Member::whereIn('region_id', $managedRegionIds)->count(),
            'pending_members' => Member::whereIn('region_id', $managedRegionIds)->where('status', 'pending')->count(),
            'approved_members' => Member::whereIn('region_id', $managedRegionIds)->where('status', 'approved')->count(),
            'total_news' => News::whereIn('region_id', $managedRegionIds)->count(),
            'total_reports' => \App\Models\Report::count(), // Add reports count
        ];

        $recentMembers = Member::with('region')
            ->whereIn('region_id', $managedRegionIds)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentMembers'));
    }

    public function members(Request $request)
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        $query = Member::with(['user', 'region'])->whereIn('region_id', $managedRegionIds);

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Wilayah
        if ($request->filled('region_id')) {
            $query->where('region_id', $request->region_id);
        }

        // Filter Jabatan (Member atau Pengurus)
        if ($request->filled('position_type')) {
            if ($request->position_type === 'pengurus') {
                $query->where('position', '!=', 'Member');
            } else {
                $query->where('position', '=', 'Member');
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('kta_number', 'like', "%{$search}%");
            });
        }

        $members = $query->latest()->paginate(10)->withQueryString();
        $regions = Region::whereIn('id', $managedRegionIds)->get();

        return view('admin.members.index', compact('members', 'regions'));
    }

    public function updateMemberStatus(Request $request, Member $member)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Check authorization
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);
        
        if (!in_array($member->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized action.');
        }

        $member->update([
            'status' => $request->status,
            'kta_number' => $request->status === 'approved' && !$member->kta_number ? Member::generateKtaNumber($member) : $member->kta_number,
        ]);

        return back()->with('success', 'Status anggota berhasil diperbarui.');
    }

    // Pages CRUD
    public function pagesIndex()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function pagesCreate()
    {
        return view('admin.pages.create');
    }

    public function pagesStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dibuat.');
    }

    public function pagesEdit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function pagesUpdate(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function pagesDestroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }

    // Settings
    public function settingsIndex()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function settingsUpdate(Request $request)
    {
        // Handle text inputs
        $inputs = $request->except('_token', '_method', 'files');
        foreach ($inputs as $key => $value) {
             Setting::where('key', $key)->update(['value' => $value]);
        }

        // Handle file inputs
        foreach ($request->allFiles() as $key => $file) {
             $setting = Setting::where('key', $key)->first();
             if ($setting && $setting->type === 'image') {
                  $path = $file->store('settings', 'public');
                  $setting->update(['value' => $path]);
             }
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function exportMembers()
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        return Excel::download(new MembersExport($managedRegionIds), 'members.xlsx');
    }

    public function createMember()
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);
        $regions = Region::whereIn('id', $managedRegionIds)->get();

        return view('admin.members.create', compact('regions'));
    }

    public function storeMember(Request $request)
    {
        $validationRules = [
            'nik' => ['required', 'string', 'size:16', 'unique:'.Member::class],
            'full_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:L,P'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'max:20'],
            'position' => ['required', 'string', 'max:255'],
            'region_id' => ['required', 'exists:regions,id'],
            'image' => ['nullable', 'image', 'max:2048'],
            'province_id' => ['nullable', 'exists:indonesia_provinces,id'],
            'city_id' => ['nullable', 'exists:indonesia_cities,id'],
            'district_id' => ['nullable', 'exists:indonesia_districts,id'],
            'village_id' => ['nullable', 'exists:indonesia_villages,id'],
        ];

        if ($request->has('create_user')) {
            $validationRules = array_merge($validationRules, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        }

        $request->validate($validationRules);

        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        if (!in_array($request->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized region selection.');
        }

        $userId = null;
        if ($request->has('create_user')) {
            // Create User
            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'region_id' => $request->region_id, // Sync region with member
            ]);

            $newUser->assignRole('member');
            $userId = $newUser->id;
        }

        // Create Member
        $memberData = [
            'user_id' => $userId,
            'nik' => $request->nik,
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'position' => $request->position,
            'region_id' => $request->region_id,
            'status' => 'approved', // Auto approve if added by admin
        ];

        if ($request->hasFile('image')) {
            $memberData['image_path'] = $request->file('image')->store('member-images', 'public');
        }

        if ($request->hasFile('ktp_image')) {
            $memberData['ktp_path'] = $request->file('ktp_image')->store('member-ktp', 'public');
        }

        $member = Member::create($memberData);
        
        // Generate KTA immediately for admin created members
        $member->update([
            'kta_number' => Member::generateKtaNumber($member)
        ]);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan' . ($userId ? ' dan akun user telah dibuat.' : '.'));
    }

    public function showMember(Member $member)
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        if (!in_array($member->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.members.show', compact('member'));
    }

    public function editMember(Member $member)
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        if (!in_array($member->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized action.');
        }

        $regions = Region::whereIn('id', $managedRegionIds)->get();

        return view('admin.members.edit', compact('member', 'regions'));
    }

    public function updateMember(Request $request, Member $member)
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        if (!in_array($member->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:members,nik,'.$member->id],
            'full_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:L,P'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'max:20'],
            'position' => ['required', 'string', 'max:255'],
            'region_id' => ['required', 'exists:regions,id'],
            'image' => ['nullable', 'image', 'max:2048'],
            'ktp_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->region_id != $member->region_id && !in_array($request->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized region selection.');
        }

        $memberData = [
            'nik' => $request->nik,
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'position' => $request->position,
            'region_id' => $request->region_id,
        ];

        if ($request->hasFile('image')) {
            if ($member->image_path) {
                Storage::disk('public')->delete($member->image_path);
            }
            $memberData['image_path'] = $request->file('image')->store('member-images', 'public');
        }

        if ($request->hasFile('ktp_image')) {
            if ($member->ktp_path) {
                Storage::disk('public')->delete($member->ktp_path);
            }
            $memberData['ktp_path'] = $request->file('ktp_image')->store('member-ktp', 'public');
        }

        $member->update($memberData);

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroyMember(Member $member)
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        if (!in_array($member->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized action.');
        }

        if ($member->image_path) {
            Storage::disk('public')->delete($member->image_path);
        }

        $memberUser = $member->user;
        $member->delete();

        // Optionally delete the user account too, but be careful if they have other roles
        // For now, we'll keep the user account but they won't have member profile
        // Or we can delete the user if they only have 'member' role
        if ($memberUser && $memberUser->hasRole('member') && $memberUser->roles->count() == 1) {
            $memberUser->delete();
        }

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
    }

    public function downloadKta(Member $member)
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        if (!in_array($member->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized action.');
        }

        if ($member->status !== 'approved') {
            return back()->with('error', 'KTA hanya dapat dicetak untuk anggota yang aktif.');
        }

        $pdf = Pdf::loadView('pdf.kta', compact('member'));
        // ID Card Size: 85.60 x 53.98 mm
        // 1 mm = 2.83465 pt
        // width = 242.64 pt, height = 153.01 pt
        $pdf->setPaper([0, 0, 242.64, 153.01], 'landscape');
        
        return $pdf->stream('KTA-' . str_replace(' ', '-', $member->full_name) . '.pdf');
    }
}
