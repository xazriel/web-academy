<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Academy;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function show($academy_id)
    {
        $academy = Academy::with(['quizzes', 'chapters.lessons'])->findOrFail($academy_id);
        
        $groupedLessons = [];
        foreach ($academy->chapters as $chapter) {
            $groupedLessons[$chapter->title] = $chapter->lessons;
        }

        $lastResult = QuizResult::where('user_id', Auth::id())
                             ->where('academy_id', $academy_id)
                             ->latest()
                             ->first();

        $firstQuizWithLesson = Quiz::where('academy_id', $academy_id)
                                    ->whereNotNull('lesson_id')
                                    ->with('lesson')
                                    ->first();

        $lesson = ($firstQuizWithLesson && $firstQuizWithLesson->lesson) 
                  ? $firstQuizWithLesson->lesson 
                  : (Lesson::where('academy_id', $academy_id)->first() ?? (object)['section_title' => 'General Quiz', 'title' => 'Quiz']);

        $lastResult = QuizResult::where('user_id', Auth::id())
                                 ->where('academy_id', $academy_id)
                                 ->latest()
                                 ->first();

        $highestScore = QuizResult::where('user_id', Auth::id())
                                   ->where('academy_id', $academy_id)
                                   ->max('score') ?? 0;

        $quizzes = Quiz::where('academy_id', $academy_id)->get();

        return view('user.quiz.show', compact('academy', 'highestScore', 'lastResult', 'groupedLessons', 'lesson', 'quizzes'));
    }

    public function submit(Request $request, $academy_id)
    {
        $userAnswers = $request->input('answers', []); 
        $questions = Quiz::where('academy_id', $academy_id)->get();
        
        $correctCount = 0;
        $totalQuestions = $questions->count();

        if ($totalQuestions > 0) {
            foreach ($questions as $question) {
                if (isset($userAnswers[$question->id])) {
                    $userAns = strtolower(trim($userAnswers[$question->id]));
                    $dbAns = strtolower(trim($question->correct_answer));

                    if ($userAns === $dbAns) {
                        $correctCount++;
                    }
                }
            }
            $score = ($correctCount / $totalQuestions) * 100;
        } else {
            $score = 0;
        }

        QuizResult::create([
            'user_id' => Auth::id(),
            'academy_id' => $academy_id,
            'score' => $score,
            'correct_answers' => $correctCount,
            'total_questions' => $totalQuestions,
        ]);

        return redirect()->route('user.quiz.show', $academy_id)->with('quiz_completed', true);
    }
}