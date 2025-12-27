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
    
    Route::get('/my-learning', [CourseController::class, 'myLearning'])->name('user.my-learning')->middleware(['auth', 'verified']);
    Route::get('/course/{id}/quiz', [QuizController::class, 'show'])->name('user.quiz.show');
    Route::post('/course/{id}/quiz', [QuizController::class, 'submit'])->name('user.quiz.submit');
    Route::delete('/admin/quiz/{id}', [QuizController::class, 'destroy'])->name('admin.quiz.destroy');

    // 1. Pindahkan route Sertifikat ke ATAS agar tidak tertabrak route course
    Route::get('/certificate/print/{id}', function($id) {
    $certificate = App\Models\Certificate::with('academy')->findOrFail($id);
    // Tambahkan variabel academy di sini
    return view('user.certificate.print', [
        'certificate' => $certificate,
        'academy' => $certificate->academy // Ini yang melengkapi kepingan puzzle yang hilang
    ]);
    })->name('certificate.print');

    // 2. Dashboard Utama User
    Route::get('/home', function () {
        $news = Post::where('status', 'published')->latest()->take(3)->get();
        $academies = Academy::latest()->take(3)->get();
        return view('user.home', compact('news', 'academies'));
    })->name('user.home');

    // 3. Checkout & Enrollment
    Route::get('/checkout/{slug}', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/{id}', [App\Http\Controllers\CourseController::class, 'enroll'])->name('checkout.store');
    
    // 4. Sertifikat Claim
    Route::get('/course/{id}/claim', [App\Http\Controllers\CourseController::class, 'claimCertificate'])->name('user.course.claim');

    Route::get('/course/{id}/quiz', [CourseController::class, 'showQuiz'])->name('user.quiz.show');
    Route::post('/course/{id}/quiz', [CourseController::class, 'submitQuiz'])->name('user.quiz.submit');

    // 5. Belajar (Route ini harus paling bawah karena menggunakan parameter opsional {slug?})
    Route::get('/course/{id}/{slug?}', [CourseController::class, 'show'])->name('user.course');
    
    // 6. Progress & Diskusi
    Route::post('/course/{academy_id}/lesson/{lesson_id}/complete', [CourseController::class, 'completeLesson'])->name('user.lesson.complete');
    Route::post('/discussion/{lesson_id}', [DiscussionController::class, 'store'])->name('discussion.store');
    Route::get('/member/{id}', [App\Http\Controllers\ProfileController::class, 'showPublic'])->name('profile.public');
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
            $academy = \App\Models\Academy::with('lessons')->findOrFail($id);
            return view('admin.academies.content', compact('academy'));
        })->name('admin.academies.content');

        // Route simpan lesson
        Route::post('/academies/{academy_id}/lessons', [LessonController::class, 'store'])->name('admin.lessons.store');

        //Route CRUD quiz
        Route::get('/academies/{id}/quiz', [App\Http\Controllers\QuizController::class, 'index'])->name('admin.quiz.index');
        Route::post('/academies/{id}/quiz', [App\Http\Controllers\QuizController::class, 'store'])->name('admin.quiz.store');

    });