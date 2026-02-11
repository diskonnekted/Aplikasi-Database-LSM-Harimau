<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $regionIds;

    public function __construct($regionIds)
    {
        $this->regionIds = $regionIds;
    }

    public function collection()
    {
        return Member::with(['region', 'user'])->whereIn('region_id', $this->regionIds)->get();
    }

    public function map($member): array
    {
        return [
            $member->full_name,
            $member->nik,
            $member->kta_number,
            $member->phone_number,
            $member->region->name,
            $member->status,
            $member->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIK',
            'No. KTA',
            'No. Telepon',
            'Wilayah',
            'Status',
            'Tanggal Daftar',
        ];
    }
}
