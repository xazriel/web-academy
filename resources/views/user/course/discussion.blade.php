<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion | ARC Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fff; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #F1F5F9; border-radius: 10px; }
    </style>
</head>
<body class="overflow-hidden">

<div class="flex flex-col h-screen">
    {{-- Header Tetap Sama --}}
    <header class="h-20 bg-white border-b border-slate-100 px-8 flex justify-between items-center z-50 shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-width="2.5"></path></svg>
            </div>
            <span class="text-xl font-extrabold text-slate-900 tracking-tight">ARC <span class="text-blue-600">Academy</span></span>
        </div>
        <nav class="hidden md:flex items-center gap-10">
            <a href="{{ route('user.home') }}" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors">Home</a>
            <a href="#" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-1">Courses</a>
            <a href="{{ route('user.my-learning') }}" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors">My Learning</a>
            <a href="#" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors">About</a>
        </nav>
        <div class="flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff" class="w-11 h-11 rounded-full border-2 border-white shadow-md">
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        {{-- Sidebar Konsisten dengan show.blade --}}
        <aside class="w-[380px] border-r border-slate-100 bg-white flex flex-col hidden lg:flex">
            <div class="p-8 border-b border-slate-50">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-black text-blue-700 italic uppercase leading-none">{{ $academy->title }}</h2>
                    <button class="text-slate-300 hover:text-slate-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5"></path></svg>
                    </button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar p-6">
                @foreach($groupedLessons as $section => $lessons)
                    <div class="mb-10">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Chapter {{ $loop->iteration }}</span>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 mb-4 px-1">{{ $section }}</h4>

                        <div class="space-y-2">
                            @foreach($lessons as $lesson)
                                @php $isCompleted = auth()->user()->completedLessons->contains($lesson->id); @endphp
                                <a href="{{ route('user.course', [$academy->id, $lesson->slug]) }}" 
                                   class="flex items-center gap-4 p-4 rounded-2xl transition-all hover:bg-slate-50">
                                    <div class="shrink-0">
                                        @if($isCompleted)
                                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3.5"></path></svg>
                                            </div>
                                        @else
                                            <div class="w-6 h-6 border-2 border-slate-200 rounded-full bg-white"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-600 leading-tight">{{ $lesson->title }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-wider">{{ $lesson->video_url ? 'Video' : 'Reading' }} • 5 min</p>
                                    </div>
                                </a>
                            @endforeach

                            {{-- Item Kuis --}}
                            <a href="{{ route('user.quiz.show', $academy->id) }}" class="flex items-center gap-4 p-4 rounded-2xl transition-all hover:bg-slate-50">
                                <div class="shrink-0 w-6 h-6 border-2 border-slate-200 rounded-full bg-white flex items-center justify-center">
                                    <svg class="w-3 h-3 text-slate-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-600">Quick Quiz: {{ $section }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-wider">Practice Assignment</p>
                                </div>
                            </a>

                            {{-- After Class Chat (Active) --}}
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-blue-50 border border-blue-100">
                                <div class="shrink-0 w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center shadow-lg shadow-blue-200">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-blue-700">After Class Chat</p>
                                    <p class="text-[10px] text-blue-400 font-bold uppercase mt-1 tracking-wider">Discussion Forum</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </aside>

        {{-- Content Area --}}
        <main class="flex-1 overflow-y-auto bg-white p-6 lg:p-12 custom-scrollbar">
            <div class="max-w-4xl mx-auto">
                {{-- Header Discussion --}}
                <div class="flex flex-col sm:flex-row justify-between items-start gap-6 mb-10">
                    <div class="flex gap-4">
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-black text-slate-900 mb-1 tracking-tight">Start the Discussion</h1>
                            <p class="text-slate-500 font-semibold">Ask questions and share knowledge with fellow learners.</p>
                        </div>
                    </div>
                    <button class="w-full sm:w-auto bg-blue-600 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3"></path></svg>
                        Ask a Question
                    </button>
                </div>

                {{-- Search --}}
                <div class="relative mb-12">
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="3"></path></svg>
                    </div>
                    <input type="text" placeholder="Search questions..." class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-5 pl-14 pr-6 font-bold text-slate-600 focus:outline-none focus:border-blue-500/30 focus:ring-4 focus:ring-blue-500/5 transition-all">
                </div>

                {{-- Discussion List --}}
                <div class="space-y-6 mb-20">
                    @forelse($discussions as $post)
                    <div class="group bg-white p-6 rounded-3xl border border-slate-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-500/5 transition-all">
                        <div class="flex gap-5">
                            <div class="shrink-0 w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-black shadow-lg shadow-blue-100 uppercase">
                                {{ substr($post->user->name, 0, 2) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-bold text-slate-900">{{ $post->user->name }}</h3>
                                    <span class="bg-blue-50 text-blue-600 text-[10px] font-black px-2 py-0.5 rounded-lg uppercase tracking-wider">Learner</span>
                                </div>
                                <p class="text-[11px] text-slate-400 font-bold mb-4 uppercase tracking-tighter">{{ $post->created_at->diffForHumans() }}</p>
                                <p class="text-slate-600 font-medium leading-relaxed mb-6">{{ $post->body }}</p>
                                
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('user.discussion.detail', [$academy->id, $post->id]) }}" 
                                       class="flex items-center gap-2 px-4 py-2 bg-slate-50 group-hover:bg-blue-600 rounded-xl text-slate-500 group-hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" stroke-width="2.5"></path></svg>
                                        <span class="text-xs font-black uppercase tracking-widest">{{ $post->replies->count() }} Replies</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="text-center py-20 bg-slate-50 rounded-[40px] border-4 border-dashed border-slate-100">
                            <p class="text-slate-400 font-black uppercase tracking-widest">No discussions yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>