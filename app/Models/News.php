<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image_path',
        'author_id',
        'region_id',
        'is_published',
        'source',
        'video_url',
        'social_links',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'social_links' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
