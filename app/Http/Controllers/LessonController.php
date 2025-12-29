<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Chapter; 
use App\Models\Academy;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function store(Request $request, $academy_id)
    {
        $request->validate([
            'chapter_id' => 'required|exists:chapters,id', // Validasi harus ada di tabel chapters
            'title' => 'required|string',
            'content' => 'required',
            'video_url' => 'nullable|url',
        ]);

        $chapter = Chapter::findOrFail($request->chapter_id);
        $lastOrder = Lesson::where('chapter_id', $request->chapter_id)->max('order') ?? 0;

        Lesson::create([
            'academy_id' => $academy_id,
            'chapter_id' => $request->chapter_id, // Simpan ID Babnya
            'section_title' => $chapter->title, 
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'content' => $request->content,
            'video_url' => $request->video_url,
            'order' => $lastOrder + 1,
        ]);

        return back()->with('success', 'Sub-materi berhasil ditambahkan ke ' . $chapter->title);
    }

    public function destroy($id)
    {
    $lesson = Lesson::findOrFail($id);
    $lesson->delete();

    return back()->with('success', 'Materi berhasil dihapus!');
    }

        public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);
        return response()->json($lesson); // Kita gunakan JSON agar bisa di-load ke Modal secara instan
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required',
            'video_url' => 'nullable|url',
        ]);

        $lesson = Lesson::findOrFail($id);
        $lesson->update([
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $request->video_url,
        ]);

        return back()->with('success', 'Materi berhasil diperbarui!');
    }

    public function reorder(Request $request)
    {
    $ids = $request->ids; // Array ID materi sesuai urutan baru
    foreach ($ids as $index => $id) {
        Lesson::where('id', $id)->update(['order' => $index + 1]);
    }
    return response()->json(['status' => 'success']);
    }
}