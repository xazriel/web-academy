<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Academy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    /**
     * Menampilkan daftar semua diskusi (halaman forum utama)
     */
    public function index($id)
    {
        $academy = Academy::findOrFail($id);
        
        // Ambil diskusi utama (bukan balasan)
        $discussions = Discussion::where('academy_id', $id)
            ->whereNull('parent_id')
            ->with(['user', 'replies'])
            ->latest()
            ->get();

        // Data untuk Sidebar
        $allLessons = $academy->lessons()->orderBy('chapter_id', 'asc')->orderBy('order', 'asc')->get();
        $groupedLessons = $allLessons->groupBy('section_title');

        return view('user.course.discussion', compact('academy', 'discussions', 'groupedLessons'));
    }

    /**
     * Menampilkan detail satu thread diskusi beserta balasan-balasannya.
     */
    public function show($academy_id, $discussion_id)
    {
        $academy = Academy::findOrFail($academy_id);
        
        // Ambil diskusi utama beserta pengirim dan semua orang yang membalas
        // Pastikan variabel menggunakan nama '$discussion' agar sinkron dengan file Blade
        $discussion = Discussion::with(['user', 'replies.user'])
            ->where('academy_id', $academy_id)
            ->findOrFail($discussion_id);

        // Data untuk Sidebar agar tetap muncul di halaman detail
        $allLessons = $academy->lessons()->orderBy('chapter_id', 'asc')->orderBy('order', 'asc')->get();
        $groupedLessons = $allLessons->groupBy('section_title');

        return view('user.course.discussion-detail', compact('academy', 'discussion', 'groupedLessons'));
    }

    /**
     * Menyimpan diskusi baru atau balasan.
     */
    public function store(Request $request, $id) // $id adalah academy_id
    {
        $request->validate([
            'body' => 'required|min:3',
        ]);

        Discussion::create([
            'user_id' => Auth::id(),
            'academy_id' => $id,
            'lesson_id' => $request->lesson_id,
            'body' => $request->body,
            // Jika dikirim dari form balasan, parent_id akan terisi
            'parent_id' => $request->parent_id ?? null, 
        ]);

        $message = $request->parent_id ? 'Balasan berhasil dikirim!' : 'Pertanyaan telah diposting!';
        
        return back()->with('success', $message);
    }
}