<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Like extends Model
{
    protected $fillable = ['news_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($like) {
            DB::transaction(function () use ($like) {
                $like->news->increment('likes_count');
            });
        });
    
        static::deleted(function ($like) {
            DB::transaction(function () use ($like) {
                $like->news->decrement('likes_count');
            });
        });
    }    

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id();
            }
        });
    }
    public function news()
    {
        return $this->belongsTo(News::class);
    }

    use HasFactory;
}
