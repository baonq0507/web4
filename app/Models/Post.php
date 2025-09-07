<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;
use Illuminate\Support\Str;
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'featured_image',
        'status',
        'tags',
        'author',
        'views',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getImageAttribute()
    {
        if ($this->attributes['image']) {
            return asset($this->attributes['image']);
        }
        return null;
    }

    public function getFeaturedImageAttribute()
    {
        if ($this->attributes['featured_image']) {
            return asset($this->attributes['featured_image']);
        }
        return null;
    }

    public function getExcerptAttribute()
    {
        if ($this->attributes['excerpt']) {
            return $this->attributes['excerpt'];
        }
        return Str::limit(strip_tags($this->content), 150);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc')->orderBy('created_at', 'desc');
    }
}
