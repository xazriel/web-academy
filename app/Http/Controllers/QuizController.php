<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Fungsi untuk menampilkan halaman kuis (Tadi kita sudah ubah dari adminIndex ke index)
    public function index($id)
    {
        $academy = Academy::with('quizzes')->findOrFail($id);
        return view('admin.quiz.index', compact('academy'));
    }

    // Fungsi untuk menyimpan soal baru (Ini yang error tadi karena belum ada)
    public function store(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        Quiz::create([
            'academy_id' => $id,
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->back()->with('success', 'Question added successfully!');
    }

    // Fungsi untuk menghapus soal
    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return redirect()->back()->with('success', 'Question deleted successfully!');
    }
}