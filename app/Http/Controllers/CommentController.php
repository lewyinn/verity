<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'news_id' => 'required|exists:news,id',
            'content' => 'required|string|max:500', // Ganti 'body' dengan 'content'
        ]);
    
        // Buat komentar baru
        $comment = new Komentar();
        $comment->news_id = $request->news_id; // Hubungkan komentar dengan berita
        $user = Auth::user(); // Dapatkan pengguna yang terautentikasi
        if ($user) {
            $comment->user_id = $user->id; // Atur ID pengguna
        } else {
            return redirect()->back()->with('error', 'Anda harus login untuk meninggalkan komentar.');
        }
        
        $comment->content = $request->content; // Atur konten komentar
        $comment->save(); // Simpan komentar ke database
    
        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}
