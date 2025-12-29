<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function store(Request $request, $academy_id)
{
    $request->validate(['title' => 'required|string|max:255']);

    $lastOrder = \App\Models\Chapter::where('academy_id', $academy_id)->max('order') ?? 0;

    \App\Models\Chapter::create([
        'academy_id' => $academy_id,
        'title' => $request->title,
        'order' => $lastOrder + 1
    ]);

    return back()->with('success', 'Bab baru berhasil ditambahkan!');
}
    public function destroy($id)
{
    $chapter = Chapter::findOrFail($id);
    // Hapus semua lesson di dalam chapter ini dulu (opsional, tergantung setting DB)
    $chapter->lessons()->delete(); 
    $chapter->delete();
    return back()->with('success', 'Bab dan seluruh materinya berhasil dihapus!');
}
}
