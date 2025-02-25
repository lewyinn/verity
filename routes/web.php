<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use App\Models\News;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 

Route::get('/', [NewsController::class, 'index'])->name('home');
Route::get('/about', [NewsController::class, 'index'])->name('about');
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/category', [NewsController::class, 'index'])->name('category.index');
Route::get('/category/{slug}', [NewsController::class, 'index'])->name('category.show');
Route::get('/news/{slug}', [NewsController::class, 'index'])->name('newsitem');

Route::post('/news/{id}/toggle-like', [NewsController::class, 'toggleLike'])->middleware('auth');

Route::get('/news/{id}', function ($id) {
    $news = News::findOrFail($id);
    return view('news.show', ['news' => $news]);
})->name('news.show');

Route::post('/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');

Route::post('/logout', function () {
    Auth::logout(); // Memanggil metode logout dari Auth facade
    return redirect('/'); // Redirect ke halaman depan atau login
})->name('logout');