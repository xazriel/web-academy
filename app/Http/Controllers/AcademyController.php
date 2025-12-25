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
        
        // Ambil materi (lessons) yang terkait dengan academy ini
        $lessons = $academy->lessons()->orderBy('order')->get();

        return view('user.academy-show', compact('academy', 'lessons'));
    }
}