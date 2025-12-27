<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class DiscussionController extends Controller
{
    public function store(Request $request, $lesson_id)
    {
        $request->validate([
            'body' => 'required|min:3',
        ]);

        Discussion::create([
            'user_id' => auth()->id(),
            'academy_id' => $request->academy_id,
            'lesson_id' => $lesson_id,
            'body' => $request->body
        ]);

        return back()->with('success', 'Pertanyaan kamu telah diposting!');
    }
}