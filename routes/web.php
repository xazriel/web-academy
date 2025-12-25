<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Academy;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController; // Controller baru kita
use App\Livewire\AcademyIndex;
use App\Livewire\Admin\AcademyManager; 
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\TwoFactor;
// Note: App\Livewire\Settings\Profile tidak lagi digunakan karena diganti Controller manual

/*
|--------------------------------------------------------------------------
| 1. Public Area (Bisa diakses tanpa login)
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

    /* --- A. PENGATURAN PROFIL (Selalu Terbuka agar bisa diisi) --- */
    Route::redirect('settings', 'settings/profile');
    
    // Menggunakan ProfileController manual untuk logika redirect yang lebih kuat
    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Pengaturan lainnya tetap menggunakan Livewire bawaan starter kit
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');
    Route::get('settings/two-factor', TwoFactor::class)->name('two-factor.show');


    /* --- B. AREA TERKUNCI (Wajib Lengkap Profil) --- */
    Route::middleware(['profile.complete'])->group(function () {

        // Dashboard Utama User
        Route::get('/home', function () {
            $news = Post::where('status', 'published')->latest()->take(3)->get();
            $academies = Academy::latest()->take(3)->get();
            return view('user.home', compact('news', 'academies'));
        })->name('user.home');

        // Halaman Pembayaran (Checkout)
        Route::get('/checkout/{slug}', [CheckoutController::class, 'index'])->name('checkout');

        // Tambahkan route lain yang membutuhkan data user lengkap di sini
    });
});


/*
|--------------------------------------------------------------------------
| 4. Admin Area (Hanya diakses oleh Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'is_admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', function () {
            $news = Post::latest()->take(5)->get();
            return view('admin.dashboard', compact('news'));
        })->name('admin.dashboard');

        // CRUD Academy
        Route::get('/academies', AcademyManager::class)->name('admin.academies.index');
    });