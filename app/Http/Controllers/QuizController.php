<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index($id)
    {
        // Eager load quizzes dan relasi lesson-nya agar section_title muncul
        $academy = Academy::with(['quizzes.lesson', 'lessons'])->findOrFail($id);

        // Ambil daftar bab yang unik untuk dropdown
        $chapters = Lesson::where('academy_id', $id)
                ->select('section_title')
                ->distinct()
                ->get();

        return view('admin.quiz.index', compact('academy', 'chapters'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'section_title' => 'required|string',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        // Cari lesson_id berdasarkan section_title yang dipilih
        $lesson = Lesson::where('academy_id', $id)
                ->where('section_title', $request->section_title)
                ->first();

        Quiz::create([
            'academy_id' => $id,
            'lesson_id' => $lesson ? $lesson->id : null, // Penting: Mengambil ID dari hasil pencarian
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan ke Bab: ' . $request->section_title);
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus!');
    }

    public function submit(Request $request, $academy_id)
{
    $questions = Quiz::where('academy_id', $academy_id)->get();
    $totalQuestions = $questions->count();
    $userAnswers = $request->input('answers', []); 

    $correctCount = 0;

    foreach ($questions as $question) {
        if (isset($userAnswers[$question->id])) {
            // Kita paksa keduanya jadi huruf kecil dan tanpa spasi
            $userAns = strtolower(trim($userAnswers[$question->id]));
            $dbAns = strtolower(trim($question->correct_answer));

            if ($userAns === $dbAns) {
                $correctCount++;
            }
        }
    }

    $score = ($totalQuestions > 0) ? ($correctCount / $totalQuestions) * 100 : 0;

    // Simpan ke database
    QuizResult::create([
        'user_id' => auth()->id(),
        'academy_id' => $academy_id,
        'score' => $score,
        'correct_answers' => $correctCount,
        'total_questions' => $totalQuestions,
    ]);

    return redirect()->route('user.quiz.show', $academy_id)->with('quiz_completed', true);
}
}