<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Academy;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController; 
use App\Livewire\AcademyIndex;
use App\Livewire\Admin\AcademyManager; 
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\TwoFactor;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\User\QuizController as UserQuizController;
use App\Http\Controllers\QuizController as AdminQuizController;

/*
|--------------------------------------------------------------------------
| 1. Public Area
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $news = Post::where('status', 'published')->latest()->take(3)->get();
    $academies = Academy::all(); 
    return view('welcome', compact('news', 'academies'));
})->name('home');

Route::get('/news/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/academy', AcademyIndex::class)->name('academy.index');
Route::get('/academy/{slug}', AcademyManager::class)->name('academies.show');


/*
|--------------------------------------------------------------------------
| 2. Redirect Logic (Setelah Login)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.home');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| 3. User Area (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /* --- A. PENGATURAN PROFIL --- */
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');
    Route::get('settings/two-factor', TwoFactor::class)->name('two-factor.show');

    /* --- B. AREA TERKUNCI (Wajib Lengkap Profil) --- */
    Route::middleware(['profile.complete'])->group(function () {
    
        Route::get('/my-learning', [CourseController::class, 'myLearning'])->name('user.my-learning');

        // --- KUIS USER ---
        Route::get('/course/{id}/quiz', [UserQuizController::class, 'show'])->name('user.quiz.show');
        Route::post('/course/{id}/quiz/submit', [UserQuizController::class, 'submit'])->name('user.quiz.submit');

        // --- SERTIFIKAT ---
        Route::get('/certificate/print/{id}', function($id) {
            $certificate = App\Models\Certificate::with('academy')->findOrFail($id);
            return view('user.certificate.print', [
                'certificate' => $certificate,
                'academy' => $certificate->academy 
            ]);
        })->name('certificate.print');

        // --- DASHBOARD USER ---
        Route::get('/home', function () {
            $news = Post::where('status', 'published')->latest()->take(3)->get();
            $academies = Academy::latest()->take(3)->get();
            return view('user.home', compact('news', 'academies'));
        })->name('user.home');

        // --- CHECKOUT & ENROLLMENT ---
        Route::get('/checkout/{slug}', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout/{id}', [App\Http\Controllers\CourseController::class, 'enroll'])->name('checkout.store');
        
        // --- PROGRESS & CLAIM ---
        Route::get('/course/{id}/claim', [App\Http\Controllers\CourseController::class, 'claimCertificate'])->name('user.course.claim');
        Route::post('/course/{academy_id}/lesson/{lesson_id}/complete', [CourseController::class, 'completeLesson'])->name('user.lesson.complete');
        
        // --- DISKUSI / AFTER CLASS CHAT ---
        // Route ini harus di atas route belajar agar tidak tertukar dengan slug
        Route::get('/course/{id}/discussion', [DiscussionController::class, 'index'])->name('user.discussion.show');
        Route::get('/course/{id}/discussion/{discussion_id}', [DiscussionController::class, 'show'])->name('user.discussion.detail');
        Route::post('/course/{id}/discussion/store', [DiscussionController::class, 'store'])->name('user.discussion.store');
        
        // --- PROFIL PUBLIK ---
        Route::get('/member/{id}', [App\Http\Controllers\ProfileController::class, 'showPublic'])->name('profile.public');

        // --- BELAJAR (Paling Bawah karena ada parameter slug opsional) ---
        Route::get('/course/{id}/{slug?}', [CourseController::class, 'show'])->name('user.course');
    });
});


/*
|--------------------------------------------------------------------------
| 4. Admin Area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'is_admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', function () {
            $news = Post::latest()->take(5)->get();
            return view('admin.dashboard', compact('news'));
        })->name('admin.dashboard');

        // CRUD Academy Utama
        Route::get('/academies', AcademyManager::class)->name('admin.academies.index');

        // Management Isi Materi (Lessons)
        Route::get('/academies/{id}/content', function ($id) {
            $academy = \App\Models\Academy::with(['chapters.lessons' => function($query) {
                $query->orderBy('order', 'asc');
            }])->findOrFail($id);
            return view('admin.academies.content', compact('academy'));
        })->name('admin.academies.content');

        // Route Bab & Lesson
        Route::post('/academies/{academy_id}/chapters', [ChapterController::class, 'store'])->name('admin.chapters.store');
        Route::post('/academies/{academy_id}/lessons', [LessonController::class, 'store'])->name('admin.lessons.store');

        Route::delete('/chapters/{id}', [ChapterController::class, 'destroy'])->name('admin.chapters.destroy');
        Route::delete('/lessons/{id}', [LessonController::class, 'destroy'])->name('admin.lessons.destroy');

        Route::get('/lessons/{id}/edit', [LessonController::class, 'edit'])->name('admin.lessons.edit');
        Route::put('/lessons/{id}', [LessonController::class, 'update'])->name('admin.lessons.update');
        Route::post('/lessons/reorder', [LessonController::class, 'reorder'])->name('admin.lessons.reorder');

        // Route Management Quiz (Admin Area)
        Route::get('/academies/{id}/quiz', [QuizController::class, 'index'])->name('admin.quiz.index');
        Route::post('/academies/{id}/quiz', [QuizController::class, 'store'])->name('admin.quiz.store');
        Route::delete('/quiz/{id}', [QuizController::class, 'destroy'])->name('admin.quiz.destroy');
    });