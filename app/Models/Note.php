<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Note extends Model
{
    protected $fillable = [
        'user_id',
        'is_published',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
        'is_published' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTitleAttribute()
    {
        return $this->data['title'] ?? '';
    }

    public function setTitleAttribute($value)
    {
        $data = $this->data ?? [];
        $data['title'] = $value;
        $this->data = $data;
    }

    public function getContentAttribute()
    {
        return $this->data['content'] ?? '';
    }

    public function setContentAttribute($value)
    {
        $data = $this->data ?? [];
        $data['content'] = $value;
        $this->data = $data;
    }

    public function getSlugAttribute()
    {
        return $this->data['slug'] ?? null;
    }

    public function setSlugAttribute($value)
    {
        $data = $this->data ?? [];
        $data['slug'] = $value;
        $this->data = $data;
    }

    public function getIsPinnedAttribute()
    {
        return $this->data['is_pinned'] ?? false;
    }

    public function setIsPinnedAttribute($value)
    {
        $data = $this->data ?? [];
        $data['is_pinned'] = (bool) $value;
        $this->data = $data;
    }

    public function getImagePathAttribute()
    {
        return $this->data['image_path'] ?? null;
    }

    public function setImagePathAttribute($value)
    {
        $data = $this->data ?? [];
        $data['image_path'] = $value;
        $this->data = $data;
    }

    public function generateSlug()
    {
        if (!empty($this->title)) {
            $slug = Str::slug($this->title);
            $count = 1;
            $originalSlug = $slug;

            while (self::whereJsonContains('data->slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $this->slug = $slug;
        }
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePinned($query)
    {
        return $query->whereJsonContains('data->is_pinned', true);
    }

    public function scopeBySlug($query, $slug)
    {
        return $query->whereJsonContains('data->slug', $slug);
    }
}