<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index($slug)
    {
        $academy = Academy::where('slug', $slug)->firstOrFail();
        
        // Kirim data academy yang dipilih ke halaman checkout
        return view('user.checkout', compact('academy'));
    }
}