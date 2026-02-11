<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'uuid',
        'user_id',
        'nik',
        'kta_number',
        'full_name',
        'position',
        'birth_place',
        'birth_date',
        'address',
        'religion',
        'phone_number',
        'image_path',
        'ktp_path',
        'join_date',
        'region_id',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

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

    public static function generateKtaNumber($member)
    {
        // Format: REGION_CODE.YEAR.RANDOM
        return sprintf('%04d.%s.%05d', $member->region_id, date('Y'), $member->id);
    }
}
