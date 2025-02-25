<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Categorie;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image_url',
        'category_id',
        'user_id',
        'status',
        'likes_count',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            $news->slug = Str::slug($news->title);
            if (Auth::check()) {
                $news->user_id = Auth::id(); 
            }
        });

        static::updating(function ($news) {
            $news->slug = Str::slug($news->title);
        });
    }

    public function getFilteredNews($categoryName = null)
    {
        $query = News::query();

        if ($categoryName) {
            $query->where('category', $categoryName); // Sesuaikan dengan nama kolom kategori di tabel Anda
        }

        return $query->get();
    }

    public function isLikedByUser($userId)
    {
        return $this->like()->where('user_id', $userId)->exists();
    }

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Komentar::class);
    }

    // Relationship with User (Writer)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    use HasFactory;
}
