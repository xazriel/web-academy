<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Detail | {{ $academy->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="bg-white overflow-hidden">

<div class="flex flex-col h-screen">
    {{-- Header --}}
    <header class="h-20 bg-white border-b border-slate-100 px-8 flex justify-between items-center z-50 shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
            <span class="text-xl font-extrabold text-slate-900 tracking-tight">ARC <span class="text-blue-600">Academy</span></span>
        </div>
        <div class="flex items-center gap-4">
            <nav class="hidden md:flex items-center gap-8 mr-8">
                <a href="#" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">Home</a>
                <a href="#" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-1">Courses</a>
                <a href="#" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">My Learning</a>
                <a href="#" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">About</a>
            </nav>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff" class="w-11 h-11 rounded-full border-2 border-slate-50 shadow-sm">
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        {{-- Sidebar --}}
        <aside class="w-[380px] border-r border-slate-100 bg-white flex flex-col hidden lg:flex">
            <div class="p-8">
                <h2 class="text-2xl font-black text-blue-600 italic uppercase tracking-tighter leading-none mb-2">{{ $academy->title }}</h2>
            </div>
            
            <div class="flex-1 overflow-y-auto custom-scrollbar px-6 pb-8">
                @foreach($groupedLessons as $section => $lessons)
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Chapter {{ $loop->iteration }}: {{ $section }}</h4>
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                        <div class="space-y-1">
                            @foreach($lessons as $lesson)
                                <a href="{{ route('user.course', [$academy->id, $lesson->slug]) }}" class="flex items-center gap-3 p-3 rounded-xl transition-all hover:bg-slate-50 group">
                                    <div class="w-6 h-6 rounded-full border-2 border-emerald-500 flex items-center justify-center bg-emerald-50">
                                        <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700 group-hover:text-blue-600 transition-colors">{{ $lesson->title }}</span>
                                        <span class="text-[10px] text-slate-400 font-medium tracking-wide">VIDEO • 4 MIN</span>
                                    </div>
                                </a>
                            @endforeach
                            
                            {{-- Active Discussion Link --}}
                            <a href="{{ route('user.discussion.show', $academy->id) }}" class="flex items-center gap-3 p-3 rounded-2xl bg-blue-50/50 border border-blue-100 shadow-sm transition-all group">
                                <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-blue-200 shadow-lg">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[13px] font-black text-blue-700">After Class Chat</p>
                                    <p class="text-[10px] text-blue-400 font-bold uppercase tracking-widest">Discussion Forum</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto bg-slate-50/30 custom-scrollbar">
            <div class="max-w-4xl mx-auto px-6 py-12 lg:px-12">
                
                {{-- Breadcrumb/Back --}}
                <div class="mb-8 flex items-center gap-2">
                    <a href="{{ route('user.discussion.show', $academy->id) }}" class="flex items-center gap-2 text-slate-400 hover:text-blue-600 transition-all font-bold group text-sm">
                        <div class="p-2 rounded-lg group-hover:bg-blue-50 transition-colors">
                            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        Back to Discussions
                    </a>
                </div>

                {{-- Main Thread --}}
                <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm mb-10">
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($discussion->user->name) }}&background=2563eb&color=fff" class="w-14 h-14 rounded-2xl shadow-sm">
                            <div>
                                <div class="flex items-center gap-2 mb-0.5">
                                    <h3 class="text-lg font-black text-slate-900 leading-tight">{{ $discussion->user->name }}</h3>
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-wider rounded-md">Learner</span>
                                </div>
                                <p class="text-xs text-slate-400 font-bold">{{ $discussion->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="pl-0 lg:pl-18">
                        <p class="text-slate-600 text-lg leading-relaxed font-medium">
                            {{ $discussion->body }}
                        </p>
                    </div>
                </div>

                {{-- Replies Section --}}
                <div class="space-y-6 mb-32">
                    <div class="flex items-center gap-4 mb-8">
                        <h3 class="text-xl font-black text-slate-900 italic uppercase tracking-tighter">Replies</h3>
                        <div class="h-px flex-1 bg-slate-100"></div>
                        <span class="px-4 py-1.5 bg-white border border-slate-100 shadow-sm text-slate-500 rounded-full font-bold text-xs">
                            {{ $discussion->replies->count() }} Comments
                        </span>
                    </div>

                    @forelse($discussion->replies as $reply)
                        <div class="flex gap-4 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&background=64748b&color=fff" class="w-10 h-10 rounded-xl">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-black text-slate-800 text-sm">{{ $reply->user->name }}</h4>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">• {{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <p class="text-slate-600 text-[15px] leading-relaxed font-medium">{{ $reply->body }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-slate-50/50 rounded-3xl border border-dashed border-slate-200">
                            <p class="text-slate-400 font-bold">No replies yet. Be the first to respond!</p>
                        </div>
                    @endforelse
                </div>

                {{-- Floating Input Field --}}
                <div class="fixed bottom-8 right-8 left-[430px] z-50">
                    <form action="{{ route('user.discussion.store', $academy->id) }}" method="POST" class="bg-white/80 backdrop-blur-xl p-3 rounded-[28px] shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-white/50 flex items-center gap-4">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $discussion->id }}">
                        <input type="hidden" name="lesson_id" value="{{ $discussion->lesson_id }}">
                        
                        <div class="flex-1 relative flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff" class="w-10 h-10 rounded-xl ml-2 mr-3">
                            <input type="text" name="body" placeholder="Write your reply here..." 
                                   class="w-full bg-transparent outline-none text-slate-700 font-bold placeholder:text-slate-300 py-3" required>
                        </div>
                        
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3.5 rounded-2xl font-black text-xs uppercase tracking-[0.1em] hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 active:scale-95">
                            Post Reply
                        </button>
                    </form>
                </div>

            </div>
        </main>
    </div>
</div>

</body>
</html>