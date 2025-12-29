<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\Discussion;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function show($id, $slug = null)
    {
        // 1. Ambil data utama
        $academy = Academy::with('lessons')->findOrFail($id);

        // 2. Cek Enrollment
        $isEnrolled = Enrollment::where('user_id', Auth::id())
                                ->where('academy_id', $id)
                                ->exists();

        if (!$isEnrolled) {
            return view('user.checkout', compact('academy'));
        }

        // 3. Ambil SEMUA materi berurutan sesuai Bab (chapter_id) dan Urutan (order)
        $allLessons = Lesson::where('academy_id', $id)
            ->orderBy('chapter_id', 'asc') 
            ->orderBy('order', 'asc')          
            ->get();

        // 4. Tentukan materi yang sedang dibuka (Current Lesson)
        if ($slug) {
            $currentLesson = $allLessons->where('slug', $slug)->first();
        } else {
            $currentLesson = $allLessons->first();
        }

        if (!$currentLesson) {
            $currentLesson = $allLessons->first();
        }

        // 5. Cari Next Lesson
        $currentIndex = $allLessons->pluck('id')->search($currentLesson->id);
        $nextLesson = $allLessons->get($currentIndex + 1);

        // Cek apakah materi saat ini adalah materi TERAKHIR di bab-nya?
        $currentChapter = $currentLesson->chapter_id;
        $nextLessonInSameChapter = $allLessons->where('chapter_id', $currentChapter)
                                              ->where('order', '>', $currentLesson->order)
                                              ->first();
        
        // Flag untuk menentukan apakah tombol "Lanjut" mengarah ke Kuis atau Materi
        $isLastInChapter = !$nextLessonInSameChapter;

        // 6. Data pendukung lainnya
        $groupedLessons = $allLessons->groupBy('section_title');
        $isCurrentLessonCompleted = auth()->user()->completedLessons->contains($currentLesson->id);
        
        $discussions = Discussion::with('user')
            ->where('lesson_id', $currentLesson->id)
            ->latest()
            ->get();

        return view('user.course.show', compact(
            'academy', 
            'currentLesson', 
            'nextLesson', 
            'groupedLessons', 
            'discussions',
            'isCurrentLessonCompleted',
            'isLastInChapter' 
        ));
    }

    public function enroll($id)
    {
        $user_id = Auth::id();

        $exists = Enrollment::where('user_id', $user_id)
                            ->where('academy_id', $id)
                            ->exists();

        if (!$exists) {
            Enrollment::create([
                'user_id' => $user_id,
                'academy_id' => $id
            ]);
        }

        return redirect()->route('user.course', $id)->with('success', 'Akses dibuka! Selamat belajar.');
    }

    public function completeLesson(Request $request, $academy_id, $lesson_id)
    {
        $user = Auth::user();
        
        // Simpan progress
        $user->completedLessons()->syncWithoutDetaching([$lesson_id]);
        
        $currentLesson = Lesson::findOrFail($lesson_id);

        // Ambil semua materi (Sudah Fix: Menggunakan $academy_id)
        $allLessons = Lesson::where('academy_id', $academy_id)
            ->orderBy('chapter_id', 'asc')
            ->orderBy('order', 'asc')
            ->get();

        // Cek apakah ada materi lagi di BAB yang sama
        $nextInChapter = $allLessons->where('chapter_id', $currentLesson->chapter_id)
                                   ->where('order', '>', $currentLesson->order)
                                   ->first();

        // ALUR: Jika bab habis, paksa ke Kuis
        if (!$nextInChapter) {
            return redirect()->route('user.quiz.show', $academy_id)
                             ->with('success', 'Bab selesai! Silakan kerjakan kuis untuk melanjutkan.');
        }

        // Jika masih ada materi dalam bab yang sama, cari materi berikutnya
        $currentIndex = $allLessons->pluck('id')->search($currentLesson->id);
        $nextLesson = $allLessons->get($currentIndex + 1);

        if ($nextLesson) {
            return redirect()->route('user.course', [$academy_id, $nextLesson->slug])
                ->with('success', 'Materi selesai, lanjut ke materi berikutnya.');
        }

        return redirect()->route('user.quiz.show', $academy_id)
                         ->with('success', 'Semua materi telah diselesaikan!');
    }

    public function claimCertificate($id)
    {
        $user = Auth::user();
        $academy = Academy::findOrFail($id);

        $totalLessons = $academy->lessons->count();
        $completedCount = $user->completedLessons()->where('academy_id', $id)->count();

        if ($completedCount < $totalLessons) {
            return redirect()->back()->with('error', 'Selesaikan semua materi terlebih dahulu!');
        }

        $certificate = Certificate::firstOrCreate(
            ['user_id' => $user->id, 'academy_id' => $id],
            [
                'certificate_number' => 'ARC-' . strtoupper(Str::random(5)) . '-' . date('Ymd'),
                'issued_at' => now(),
            ]
        );

        session()->forget('course_finished');

        return redirect()->route('certificate.print', $certificate->id)
                         ->with('success', 'Selamat! Sertifikat Anda telah terbit.');
    }

    public function myLearning()
    {
        $user = Auth::user();
        
        $enrolledAcademies = Academy::whereHas('enrollments', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['lessons'])->get()->map(function($academy) use ($user) {
            $totalLessons = $academy->lessons->count();
            $completedLessonsCount = $user->completedLessons()
                                          ->where('academy_id', $academy->id)
                                          ->count();
            
            $academy->progress_percentage = $totalLessons > 0 
                ? round(($completedLessonsCount / $totalLessons) * 100) 
                : 0;
                
            return $academy;
        });

        return view('user.my-learning', compact('enrolledAcademies'));
    }

    public function showQuiz($academy_id)
    {
        $academy = Academy::with('quizzes')->findOrFail($academy_id);
        
        if ($academy->quizzes->isEmpty()) {
            return redirect()->back()->with('error', 'Kuis belum tersedia untuk kursus ini.');
        }

        return view('user.quiz.show', compact('academy'));
    }

    public function submitQuiz(Request $request, $academy_id)
    {
        $academy = Academy::with('quizzes')->findOrFail($academy_id);
        $totalQuestions = $academy->quizzes->count();
        $correctCount = 0;

        foreach ($academy->quizzes as $quiz) {
            $answer = $request->input('question_' . $quiz->id);
            if ($answer == $quiz->correct_answer) {
                $correctCount++;
            }
        }

        $score = ($totalQuestions > 0) ? ($correctCount / $totalQuestions) * 100 : 0;

        if ($score >= 70) {
            return redirect()->route('user.course', $academy_id)
                             ->with('success', "Selamat! Skor kamu $score. Kamu lulus kuis!");
        } else {
            return redirect()->back()
                             ->with('error', "Skor kamu $score. Minimal 70 untuk lulus. Silakan coba lagi!");
        }
    }

    public function showDiscussion($id)
    {
    $academy = Academy::with(['lessons'])->findOrFail($id);

    // Ambil diskusi yang terkait dengan academy_id ini
    $discussions = Discussion::with('user')
        ->where('academy_id', $id)
        ->latest()
        ->get();

    // Mengelompokkan materi untuk Sidebar tetap konsisten
    $allLessons = $academy->lessons()->orderBy('chapter_id', 'asc')->orderBy('order', 'asc')->get();
    $groupedLessons = $allLessons->groupBy('section_title');

    return view('user.course.discussion', compact('academy', 'discussions', 'groupedLessons'));
    }

}