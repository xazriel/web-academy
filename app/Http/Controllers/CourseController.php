<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate; 
use Illuminate\Support\Str; 

class CourseController extends Controller
{
    public function show($id, $slug = null)
    {
        $academy = Academy::with(['lessons' => function($query) {
            $query->orderBy('order', 'asc');
        }])->findOrFail($id);

        // 1. Cek apakah user sudah terdaftar di kursus ini
        $isEnrolled = Enrollment::where('user_id', Auth::id())
                                ->where('academy_id', $id)
                                ->exists();

        // 2. JIKA BELUM TERDAFTAR: Lempar ke halaman checkout
        if (!$isEnrolled) {
            return view('user.checkout', compact('academy'));
        }

        // 3. JIKA SUDAH TERDAFTAR: Lanjutkan ke materi
        if ($slug) {
            $currentLesson = $academy->lessons->where('slug', $slug)->first();
            if (!$currentLesson) {
                $currentLesson = $academy->lessons->first();
            }
        } else {
            $currentLesson = $academy->lessons->first();
        }

        $groupedLessons = $academy->lessons->groupBy('section_title');

        $discussions = [];
        if($currentLesson) {
            $discussions = Discussion::with('user')
                            ->where('lesson_id', $currentLesson->id)
                            ->latest()
                            ->get();
        }

        return view('user.course.show', compact('academy', 'currentLesson', 'groupedLessons', 'discussions'));
    }

    // FUNGSI UNTUK PROSES ENROLL (DARI TOMBOL KONFIRMASI CHECKOUT)
    public function enroll($id)
    {
        $user_id = Auth::id();

        // Cek lagi untuk mencegah double data
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

    // 1. Catat bahwa materi ini sudah selesai
    // syncWithoutDetaching memastikan jika diklik 2x, datanya tidak double di database
    $user->completedLessons()->syncWithoutDetaching([$lesson_id]);

    $currentLesson = Lesson::findOrFail($lesson_id);

    // 2. Cari materi berikutnya berdasarkan kolom 'order'
    $nextLesson = Lesson::where('academy_id', $academy_id)
        ->where('order', '>', $currentLesson->order)
        ->orderBy('order', 'asc')
        ->first();

    if ($nextLesson) {
        // Jika ada materi selanjutnya, pindah ke sana
        return redirect()->route('user.course', [$academy_id, $nextLesson->slug])
                         ->with('success', 'Bagus! Materi diselesaikan.');
    } else {
        // JIKA INI MATERI TERAKHIR:
        // Cek apakah semua materi di kursus ini sudah diselesaikan
        $totalLessons = Lesson::where('academy_id', $academy_id)->count();
        $userCompletedCount = $user->completedLessons()->where('academy_id', $academy_id)->count();

        if ($userCompletedCount >= $totalLessons) {
            // Semua materi selesai, tampilkan tombol klaim sertifikat
            return redirect()->route('user.course', [$academy_id, $currentLesson->slug])
                             ->with('course_finished', true);
        }

        return redirect()->route('user.course', [$academy_id, $currentLesson->slug])
                         ->with('success', 'Materi terakhir selesai!');
    }
}

    public function claimCertificate($id)
{
    $user = Auth::user(); // Gunakan Auth facade yang sudah kamu import
    $academy = Academy::findOrFail($id);

    $totalLessons = $academy->lessons->count();
    $completedCount = $user->completedLessons()->where('academy_id', $id)->count();

    if ($completedCount < $totalLessons) {
        return redirect()->back()->with('error', 'Selesaikan semua materi terlebih dahulu!');
    }

    // Gunakan updateOrCreate atau firstOrCreate
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
    
    // Ambil kursus yang di-enroll user beserta jumlah materi dan progresnya
    $enrolledAcademies = Academy::whereHas('enrollments', function($query) use ($user) {
        $query->where('user_id', $user->id);
    })->with(['lessons'])->get()->map(function($academy) use ($user) {
        $totalLessons = $academy->lessons->count();
        $completedLessonsCount = $user->completedLessons()
                                      ->where('academy_id', $academy->id)
                                      ->count();
        
        // Hitung persentase progres
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
    
    // Pastikan ada kuisnya
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

    $score = ($correctCount / $totalQuestions) * 100;

    if ($score >= 70) { // Syarat lulus 70%
        return redirect()->route('user.course', $academy_id)
                         ->with('success', "Selamat! Skor kamu $score. Kamu lulus kuis!");
    } else {
        return redirect()->back()
                         ->with('error', "Skor kamu $score. Minimal 70 untuk lulus. Silakan coba lagi!");
    }
}
    
}