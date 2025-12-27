<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Academy;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function store(Request $request, $academy_id)
    {
        $request->validate([
            'section_title' => 'required|string', // Contoh: "Bab 1: Pengenalan"
            'title' => 'required|string',         // Contoh: "Apa itu AI?"
            'content' => 'required',
            'video_url' => 'nullable|url',
        ]);

        $lastOrder = Lesson::where('academy_id', $academy_id)->max('order') ?? 0;

        Lesson::create([
            'academy_id' => $academy_id,
            'section_title' => $request->section_title,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'content' => $request->content,
            'video_url' => $request->video_url,
            'order' => $lastOrder + 1,
        ]);

        return back()->with('success', 'Sub-materi berhasil ditambahkan!');
    }
}