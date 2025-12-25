<?php

namespace App\Livewire;

use App\Models\Academy;
use Livewire\Component;

class AcademyIndex extends Component
{
    public function render()
    {
        return view('livewire.academy-index', [
            // Mengambil semua kursus terbaru
            'academies' => Academy::latest()->get()
        ])->layout('layouts.guest'); // Atau gunakan layout bersihmu sendiri
    }
}