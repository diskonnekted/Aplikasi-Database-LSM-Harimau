<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // Public methods
    public function index()
    {
        $news = News::where('is_published', true)->latest()->paginate(9);
        return view('public.news.index', compact('news'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('public.news.show', compact('news'));
    }

    // Admin methods
    public function adminIndex(Request $request)
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        $query = News::with(['region'])->whereIn('region_id', $managedRegionIds);

        // Filter Status
        if ($request->filled('is_published')) {
            $query->where('is_published', $request->is_published);
        }

        // Filter Wilayah
        if ($request->filled('region_id')) {
            $query->where('region_id', $request->region_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->latest()->paginate(10)->withQueryString();
        $regions = Region::whereIn('id', $managedRegionIds)->get();

        return view('admin.news.index', compact('news', 'regions'));
    }

    public function create()
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);
        $regions = Region::whereIn('id', $managedRegionIds)->get();

        return view('admin.news.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'region_id' => 'required|exists:regions,id',
            'is_published' => 'boolean',
            'source' => 'nullable|string|max:255',
            'video_url' => 'nullable|url',
            'social_links' => 'nullable|array',
            'social_links.youtube' => 'nullable|url',
            'social_links.tiktok' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.facebook' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
        ]);

        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        if (!in_array($request->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized region selection.');
        }

        $data = $request->except('image');
        $data['author_id'] = $user->id;
        $data['slug'] = Str::slug($request->title);
        $data['social_links'] = array_filter($request->social_links ?? [], function($value) {
            return !is_null($value) && $value !== '';
        });

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('news-images', 'public');
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dibuat.');
    }

    public function edit(News $news)
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        if (!in_array($news->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized action.');
        }

        $regions = Region::whereIn('id', $managedRegionIds)->get();

        return view('admin.news.edit', compact('news', 'regions'));
    }

    public function update(Request $request, News $news)
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        if (!in_array($news->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'region_id' => 'required|exists:regions,id',
            'is_published' => 'boolean',
            'source' => 'nullable|string|max:255',
            'video_url' => 'nullable|url',
            'social_links' => 'nullable|array',
            'social_links.youtube' => 'nullable|url',
            'social_links.tiktok' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.facebook' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
        ]);

        // Check if region changed and user has permission
        if ($request->region_id != $news->region_id && !in_array($request->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized region selection.');
        }

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);
        $data['is_published'] = $request->has('is_published');
        $data['social_links'] = array_filter($request->social_links ?? [], function($value) {
            return !is_null($value) && $value !== '';
        });

        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $data['image_path'] = $request->file('image')->store('news-images', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        $user = Auth::user();
        $managedRegionIds = $this->getManagedRegionIds($user);

        if (!in_array($news->region_id, $managedRegionIds)) {
            abort(403, 'Unauthorized action.');
        }

        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
