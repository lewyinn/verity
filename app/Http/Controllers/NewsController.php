<?php

namespace App\Http\Controllers;
use App\Models\Categorie;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'likes_count' => 'nullable|integer',
        ]);

        $news = News::create([
            'title' => $request->title,
            'content' => $request->content,
            'image_url' => $request->image_url,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'status' => $request->status,
            'likes_count' => $request->likes_count,
        ]);
    }

    public function index(Request $request, $slug = null)
    {
        // Ambil kategori jika slug ada
        $category = null;
        if ($slug) {
            $category = Categorie::where('slug', $slug)->first();
        }
        
        // Cari news berdasarkan slug
        $newsOne = News::with(['category', 'comments.user'])
                    ->where('slug', $slug)
                    ->first();

        // Ambil kategori dari query string jika ada
        $categoryId = $request->query('category_id');
        $page = $request->path(); // Mengambil path saat ini

        // Query untuk menampilkan berita terbaru (limit 5)
        $latestNews = News::latest()->limit(6)->get();

        // Query untuk menampilkan berita dengan like terbanyak (limit 5)
        $mostLikedNews = News::orderBy('likes_count', 'desc')->limit(5)->get();

        // Query untuk menampilkan berita dengan like terbanyak (limit 1)
        $mostLikedNews1 = News::orderBy('likes_count', 'desc')->limit(1)->get();

        // Query untuk menampilkan berita secara acak (limit 3)
        $randomNews = News::inRandomOrder()->limit(3)->get();

        // Ambil semua kategori
        $categories = Categorie::all();

        // Query untuk mendapatkan penulis terbanyak
        $topWriters = User::withCount('news') // Menghitung jumlah berita yang ditulis oleh setiap pengguna
            ->whereHas('roles', function($query) {
                $query->where('name', 'Penulis'); // Memastikan hanya yang memiliki role Penulis
            })
            ->orderBy('news_count', 'desc') // Mengurutkan berdasarkan jumlah berita terbanyak
            ->limit(4)
            ->get();

        // Query untuk menampilkan semua berita, atau berdasarkan kategori jika ada
        if ($categoryId) {
            $allNews = News::where('category_id', $categoryId)->get();
        } elseif ($category) {
            // Jika kategori ditemukan berdasarkan slug
            $allNews = News::where('category_id', $category->id)->get();
        } else {
            // Jika tidak ada kategori, ambil semua
            $allNews = News::all();
        }

        // Kirimkan hasil query ke view berdasarkan halaman
        if ($page === '/') {
            return view('home', compact('latestNews', 'mostLikedNews', 'allNews', 'categories'));
        } elseif ($page === 'about') {
            return view('about', compact('latestNews', 'mostLikedNews', 'allNews'));
        } elseif ($page === 'news') {
            return view('news', compact('latestNews', 'mostLikedNews', 'randomNews', 'mostLikedNews1', 'allNews', 'topWriters'));
        } elseif ($page === 'category') {
            return view('category', compact('latestNews', 'mostLikedNews', 'allNews', 'categories', 'category'));
        } elseif (strpos($page, 'category/') === 0) {
            return view('category', compact('latestNews', 'mostLikedNews', 'allNews', 'categories', 'category'));
        } elseif (strpos($page, 'news/') === 0) {
            // Halaman detail berita berdasarkan slug
            return view('newsitem', compact('newsOne'));
        }

        // Default return (jika tidak ada match)
        return view('home', compact('latestNews', 'mostLikedNews', 'allNews', 'categories'));
    }

    public function toggleLike($id)
    {
        $user = Auth::user();   
        $userId = $user->id;
        $news = News::findOrFail($id);

        // Check if the user has already liked this news
        $like = Like::where('user_id', $userId)->where('news_id', $news->id)->first();

        if ($like) {
            // Unlike the news
            $like->delete();
            $news->decrement('likes_count');
            $liked = false;
        } else {
            Like::create([
                'user_id' => $userId,
                'news_id' => $news->id,
            ]);
            $news->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'likes_count' => $news->likes_count,
            'liked' => $liked,
        ]);
    }

}
