<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    public function show($slug)
    {
        // Cari academy berdasarkan slug
        $academy = Academy::where('slug', $slug)->firstOrFail();
        $academy = Academy::with('lessons')->findOrFail($academy_id);
        
        // Ambil materi (lessons) yang terkait dengan academy ini
        $lessons = $academy->lessons()->orderBy('order')->get();
        $lesson = Lesson::findOrFail($lesson_id);

        $quizzes = Quiz::where('academy_id', $academy_id)
                    ->where('lesson_id', $lesson->id) // Atau filter berdasarkan section_title
                    ->get();

        return view('user.academy-show', compact('academy', 'lessons','quizzes'));
    }
}