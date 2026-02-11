<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'reporter_name',
        'whatsapp',
        'address',
        'status',
        'title',
        'content',
        'is_truth_statement',
        'is_public',
        'report_status',
        'evidence_path',
        'disposition_to_region_id',
        'disposition_notes',
        'investigation_notes',
        'resolution_notes',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'rt',
        'rw',
    ];

    protected $casts = [
        'is_truth_statement' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function province()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Province::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\District::class, 'district_id');
    }

    public function village()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Village::class, 'village_id');
    }
    
    // Helper untuk status label
    public function getStatusLabelAttribute()
    {
        return match($this->report_status) {
            'pending' => 'Menunggu',
            'escalated' => 'Diteruskan ke Pimpinan',
            'disposition' => 'Disposisi ke Wilayah',
            'investigating' => 'Dalam Investigasi',
            'investigation_done' => 'Investigasi Selesai',
            'resolved' => 'Selesai',
            'rejected' => 'Ditolak',
            default => $this->report_status,
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->report_status) {
            'pending' => 'gray',
            'escalated' => 'yellow',
            'disposition' => 'blue',
            'investigating' => 'indigo',
            'investigation_done' => 'purple',
            'resolved' => 'green',
            'rejected' => 'red',
            default => 'gray',
        };
    }
}
