<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function store(Request $request, $academy_id)
{
    $request->validate(['title' => 'required|string|max:255']);

    // Ambil order terakhir agar otomatis urut
    $lastOrder = \App\Models\Chapter::where('academy_id', $academy_id)->max('order') ?? 0;

    \App\Models\Chapter::create([
        'academy_id' => $academy_id,
        'title' => $request->title,
        'order' => $lastOrder + 1
    ]);

    return back()->with('success', 'Bab baru berhasil ditambahkan!');
}
}
