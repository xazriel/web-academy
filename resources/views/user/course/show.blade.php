<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    arc: {
                        yellow: '#facc15',
                    }
                }
            }
        }
    }
</script>

<div class="flex flex-col lg:flex-row min-h-screen bg-[#F8FAFC]">
    
    <div class="w-full lg:w-80 bg-white border-r border-slate-200 lg:h-screen lg:sticky lg:top-0 overflow-y-auto shadow-sm">
        <div class="p-8 border-b border-slate-100">
            <a href="{{ route('user.home') }}" class="flex items-center gap-3 text-slate-500 font-bold text-xs uppercase tracking-widest hover:text-indigo-600 transition-all group">
                <span class="bg-slate-100 text-slate-500 p-2 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </span> 
                Exit Course
            </a>
        </div>

        <div class="p-6">
            <h2 class="font-black uppercase text-[10px] tracking-[0.2em] text-slate-400 mb-6 px-2">Course Curriculum</h2>
            
            <div class="space-y-8">
                @foreach($groupedLessons as $section => $lessons)
                    <div>
                        <h3 class="font-black text-[10px] uppercase text-indigo-600 mb-4 flex items-center gap-2 px-2">
                            <span class="w-1.5 h-1.5 bg-indigo-600 rounded-full"></span>
                            {{ $section }}
                        </h3>
                        <ul class="space-y-2">
                            @foreach($lessons as $lesson)
                                @php
                                    $isActive = $currentLesson->id == $lesson->id;
                                    $isCompleted = auth()->user()->completedLessons->contains($lesson->id);
                                @endphp
                                <li>
                                    <a href="{{ route('user.course', [$academy->id, $lesson->slug]) }}" 
                                       class="group flex items-center justify-between p-4 rounded-2xl border transition-all duration-300 {{ $isActive ? 'bg-indigo-50 border-indigo-200 shadow-md shadow-indigo-100' : 'bg-white border-slate-100 hover:border-indigo-200 hover:shadow-lg' }}">
                                        <div class="flex items-center gap-3">
                                            <span class="text-[10px] font-black {{ $isActive ? 'text-indigo-600' : 'text-slate-300' }}">
                                                {{ str_pad($lesson->order ?? $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                            </span>
                                            <span class="text-sm font-bold {{ $isActive ? 'text-indigo-900' : 'text-slate-600' }} group-hover:text-indigo-700 transition-colors line-clamp-1">
                                                {{ $lesson->title }}
                                            </span>
                                        </div>
                                        
                                        @if($isCompleted)
                                            <div class="bg-emerald-100 p-1 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex-1 p-6 lg:p-16">
        <div class="max-w-4xl mx-auto">
            
            @if(session('course_finished'))
                <div class="bg-indigo-600 text-white p-10 rounded-[3rem] shadow-2xl shadow-indigo-200 text-center mb-12 relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-4xl lg:text-5xl font-black uppercase tracking-tighter mb-4 italic">Bravo! Content Mastered.</h2>
                        <p class="text-indigo-100 font-bold mb-8 italic">Kamu telah menuntaskan kurikulum {{ $academy->title }}.</p>
                        <a href="{{ route('user.course.claim', $academy->id) }}" class="inline-flex items-center gap-3 bg-white text-indigo-600 font-black py-5 px-10 rounded-2xl uppercase hover:scale-105 transition-all shadow-xl text-lg">
                            Claim Certificate
                        </a>
                    </div>
                </div>
            @endif

            @if($currentLesson)
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest italic">Now Learning</span>
                        <div class="h-px flex-1 bg-slate-100"></div>
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-black text-slate-900 leading-[0.9] tracking-tighter mb-10 italic uppercase">
                        {{ $currentLesson->title }}
                    </h1>

                    <div class="aspect-video bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200 border border-slate-200 mb-12">
                        @if($currentLesson->video_url)
                            @php
                                $videoId = '';
                                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $currentLesson->video_url, $match)) {
                                    $videoId = $match[1];
                                }
                            @endphp
                            @if($videoId)
                                <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                            @endif
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-slate-500">
                                <p class="italic font-bold text-sm tracking-widest uppercase opacity-40 text-center">Video Belum Tersedia / Materi Teks</p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-[2.5rem] p-8 lg:p-12 border border-slate-100 shadow-sm mb-12">
                        <div class="prose prose-indigo prose-lg max-w-none text-slate-700 font-medium leading-relaxed rich-content-rendered">
                            {!! $currentLesson->content !!}
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-center gap-6 border-t border-slate-100 pt-10 mb-20">
                        <div class="flex items-center gap-4">
                            <p class="font-black uppercase italic text-xs tracking-widest text-slate-400">
                                ARC ACADEMY // {{ $academy->title }}
                            </p>
                        </div>
                        
                        <form action="{{ route('user.lesson.complete', [$academy->id, $currentLesson->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-indigo-600 text-white font-black py-5 px-12 rounded-2xl uppercase tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:scale-105 transition-all">
                                Selesai & Lanjut →
                            </button>
                        </form>
                    </div>

                    <div class="bg-slate-50 p-8 lg:p-12 rounded-[3rem] border border-slate-200">
                        <h3 class="font-black text-3xl uppercase italic text-indigo-900 mb-10 tracking-tighter">Community Hub</h3>
                        
                        <form action="{{ route('discussion.store', $currentLesson->id) }}" method="POST" class="mb-12">
                            @csrf
                            <input type="hidden" name="academy_id" value="{{ $academy->id }}">
                            <div class="relative group">
                                <textarea name="body" required class="w-full p-6 bg-white border border-slate-200 rounded-3xl font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 outline-none transition-all" rows="3" placeholder="Tanyakan sesuatu..."></textarea>
                                <button type="submit" class="mt-4 bg-indigo-600 text-white font-black py-3 px-8 rounded-2xl uppercase text-xs shadow-lg shadow-indigo-200">
                                    Post Question
                                </button>
                            </div>
                        </form>

                        <div class="space-y-6">
                            @forelse($discussions as $chat)
                                <div class="p-6 bg-white border border-slate-100 rounded-3xl shadow-sm">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="font-black text-[10px] uppercase text-indigo-600">{{ $chat->user->name }}</span>
                                        <span class="text-[9px] font-bold text-slate-300 uppercase tracking-widest">{{ $chat->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="font-bold text-slate-700 text-sm leading-relaxed">{{ $chat->body }}</p>
                                </div>
                            @empty
                                <p class="text-center italic font-bold text-slate-300 uppercase text-[10px] tracking-widest">Belum ada diskusi.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Render styling untuk isi materi dari Trix */
    .rich-content-rendered h1 { font-size: 2rem; font-weight: 800; color: #1e1b4b; margin: 1.5rem 0 1rem 0; }
    .rich-content-rendered h2 { font-size: 1.5rem; font-weight: 800; color: #1e1b4b; margin: 1.5rem 0 1rem 0; }
    .rich-content-rendered p { margin-bottom: 1.25rem; }
    .rich-content-rendered ul { list-style: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; }
    .rich-content-rendered blockquote { border-left: 5px solid #4f46e5; padding-left: 1.5rem; font-style: italic; color: #64748b; background: #f8fafc; padding: 1rem; border-radius: 0 1rem 1rem 0; margin: 1.5rem 0; }
</style>