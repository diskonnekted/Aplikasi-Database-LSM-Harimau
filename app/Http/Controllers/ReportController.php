<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource (Admin).
     */
    public function index()
    {
        $reports = Report::latest()->paginate(10);
        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource (Public).
     */
    public function create()
    {
        // Tampilkan laporan yang sudah selesai atau statusnya jelas untuk publik
        $latestReports = Report::where('report_status', 'resolved')
            ->where('is_public', true)
            ->latest()
            ->take(5)
            ->get();
            
        return view('public.reports.create', compact('latestReports'));
    }

    /**
     * Store a newly created resource in storage (Public).
     */
    public function store(Request $request)
    {
        $request->validate([
            'reporter_name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'province_id' => 'required|exists:indonesia_provinces,id',
            'city_id' => 'required|exists:indonesia_cities,id',
            'district_id' => 'required|exists:indonesia_districts,id',
            'village_id' => 'required|exists:indonesia_villages,id',
            'rt' => 'required|integer|min:1|max:20',
            'rw' => 'required|integer|min:1|max:20',
            'address' => 'required|string',
            'status' => 'required|string',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_truth_statement' => 'required|accepted',
            'is_public' => 'required|boolean',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')->store('reports/evidence', 'public');
        }

        Report::create([
            'reporter_name' => $request->reporter_name,
            'whatsapp' => $request->whatsapp,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'address' => $request->address,
            'status' => $request->status,
            'title' => $request->title,
            'content' => $request->content,
            'is_truth_statement' => true,
            'is_public' => $request->is_public,
            'evidence_path' => $evidencePath,
            'report_status' => 'pending', // Default status
        ]);

        return redirect()->back()->with('success', 'Laporan Anda telah berhasil dikirim. Kami akan segera menindaklanjutinya.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        $regions = Region::all(); // Untuk dropdown disposisi
        return view('admin.reports.show', compact('report', 'regions'));
    }

    /**
     * Update the specified resource in storage (Admin).
     */
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'report_status' => 'required|string',
            'disposition_to_region_id' => 'nullable|exists:regions,id',
            'disposition_notes' => 'nullable|string',
            'investigation_notes' => 'nullable|string',
            'resolution_notes' => 'nullable|string',
        ]);

        // Logic update berdasarkan status
        $data = ['report_status' => $request->report_status];

        if ($request->report_status === 'disposition') {
            $data['disposition_to_region_id'] = $request->disposition_to_region_id;
            $data['disposition_notes'] = $request->disposition_notes;
        } elseif ($request->report_status === 'investigation_done') {
            $data['investigation_notes'] = $request->investigation_notes;
        } elseif ($request->report_status === 'resolved') {
            $data['resolution_notes'] = $request->resolution_notes;
        }

        $report->update($data);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
