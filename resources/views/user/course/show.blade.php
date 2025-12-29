<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $currentLesson->title ?? 'Materi' }} | ARC Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fff; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #F1F5F9; border-radius: 10px; }
        .rich-content-rendered p { margin-bottom: 1.5rem; color: #334155; line-height: 1.8; font-size: 1.05rem; }
        .rich-content-rendered h2 { font-size: 1.875rem; font-weight: 800; margin-bottom: 1.5rem; color: #0f172a; }
        #sidebar-panel { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="overflow-hidden">

<div class="flex flex-col h-screen">
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
        <aside id="sidebar-panel" class="w-[380px] border-r border-slate-100 bg-white flex flex-col hidden lg:flex">
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
                            {{-- 1. List Materi --}}
                            @foreach($lessons as $lesson)
                                @php
                                    $isActive = $currentLesson && $currentLesson->id == $lesson->id;
                                    $isCompleted = auth()->user()->completedLessons->contains($lesson->id);
                                @endphp
                                <a href="{{ route('user.course', [$academy->id, $lesson->slug]) }}" 
                                   class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ $isActive ? 'bg-blue-50 border border-blue-100' : 'hover:bg-slate-50' }}">
                                    <div class="shrink-0">
                                        @if($isCompleted)
                                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3.5"></path></svg>
                                            </div>
                                        @else
                                            <div class="w-6 h-6 border-2 {{ $isActive ? 'border-blue-400' : 'border-slate-200' }} rounded-full bg-white flex items-center justify-center">
                                                @if($isActive) <div class="w-2 h-2 bg-blue-400 rounded-full"></div> @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold {{ $isActive ? 'text-blue-700' : 'text-slate-600' }} leading-tight">{{ $lesson->title }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-wider">
                                            {{ $lesson->video_url ? 'Video' : 'Reading' }} • 5 min
                                        </p>
                                    </div>
                                </a>
                            @endforeach

                            {{-- 2. Item Kuis (Sekarang Di Atas After Class Chat) --}}
                            <a href="{{ route('user.quiz.show', $academy->id) }}" 
                               class="flex items-center gap-4 p-4 rounded-2xl transition-all hover:bg-slate-50">
                                <div class="shrink-0 w-6 h-6 border-2 border-slate-200 rounded-full bg-white flex items-center justify-center">
                                    <svg class="w-3 h-3 text-slate-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-600">Quick Quiz: {{ $section }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-wider">Practice Assignment</p>
                                </div>
                            </a>

                            {{-- 3. After Class Chat (Sekarang Paling Bawah) --}}
                            <a href="{{ route('user.discussion.show', $academy->id) }}" 
                               class="flex items-center gap-4 p-4 rounded-2xl transition-all hover:bg-blue-50 group border border-transparent hover:border-blue-100">
                                <div class="shrink-0 w-6 h-6 bg-slate-100 group-hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors">
                                    <svg class="w-3 h-3 text-slate-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-600 group-hover:text-blue-700">After Class Chat</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-wider">Discussion Forum</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-white p-6 lg:p-12 relative">
            <div class="max-w-4xl mx-auto">
                <div class="mb-10">
                    <h1 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                        {{ $currentLesson->title }}
                    </h1>
                </div>

                @if($currentLesson->video_url)
                    @php
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $currentLesson->video_url, $match);
                        $videoId = $match[1] ?? null;
                    @endphp
                    @if($videoId)
                        <div class="aspect-video rounded-3xl overflow-hidden bg-slate-900 mb-10 border-4 border-white shadow-2xl">
                            <iframe id="video-player" class="w-full h-full" 
                                    src="https://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1&rel=0" 
                                    allowfullscreen></iframe>
                        </div>
                    @endif
                @endif

                <div class="rich-content-rendered prose prose-slate max-w-none">
                    {!! $currentLesson->content !!}
                </div>

                {{-- NAVIGASI BOTTOM --}}
                <div class="mt-20 pt-8 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-6 mb-20">
                    @php 
                        $isCompletedNow = auth()->user()->completedLessons->contains($currentLesson->id);
                    @endphp

                    <div class="flex-1">
                        @if(!$currentLesson->video_url)
                            <form id="complete-form" action="{{ route('user.lesson.complete', [$academy->id, $currentLesson->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-10 py-4 {{ $isCompletedNow ? 'bg-green-500' : 'bg-blue-600' }} text-white font-black rounded-2xl text-xs uppercase tracking-widest shadow-lg transition-all active:scale-95">
                                    {{ $isCompletedNow ? '✓ Completed' : 'Mark as Read' }}
                                </button>
                            </form>
                        @else
                            <form id="complete-form" action="{{ route('user.lesson.complete', [$academy->id, $currentLesson->id]) }}" method="POST" class="hidden">@csrf</form>
                            @if($isCompletedNow)
                                <button disabled class="px-10 py-4 bg-green-500 text-white font-black rounded-2xl text-xs uppercase tracking-widest shadow-lg opacity-80">
                                    ✓ Completed
                                </button>
                            @endif
                        @endif
                    </div>

                    <div>
                        @if($isLastInChapter)
                            <a href="{{ route('user.quiz.show', $academy->id) }}" 
                               class="w-full sm:w-auto px-10 py-4 bg-blue-700 hover:bg-blue-800 text-white font-black rounded-2xl text-xs uppercase tracking-widest shadow-xl shadow-blue-200 transition-all text-center block active:scale-95">
                                Take Chapter Quiz
                            </a>
                        @elseif($nextLesson)
                            <a href="{{ route('user.course', [$academy->id, $nextLesson->slug]) }}" 
                               class="w-full sm:w-auto px-10 py-4 border-2 border-slate-200 text-slate-700 font-black rounded-2xl text-xs uppercase tracking-widest hover:border-blue-600 hover:text-blue-600 transition-all text-center block active:scale-95">
                                Go to next item
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    let player;
    function onYouTubeIframeAPIReady() {
        if (document.getElementById('video-player')) {
            player = new YT.Player('video-player', {
                events: { 'onStateChange': onPlayerStateChange }
            });
        }
    }

    function onPlayerStateChange(event) {
        if (event.data === YT.PlayerState.ENDED) {
            @if(!$isCompletedNow)
                document.getElementById('complete-form').submit();
            @endif
        }
    }
</script>
</body>
</html>