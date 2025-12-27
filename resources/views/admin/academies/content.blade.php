<div class="min-h-screen bg-black text-white p-6 lg:p-12">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <style>
        /* Custom Trix Styling to match ARC Dark Theme */
        trix-toolbar {
            background-color: #18181b; /* zinc-900 */
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 1rem 1rem 0 0 !important;
            padding: 10px !important;
        }
        trix-toolbar .trix-button-group {
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            background-color: #09090b; /* black */
        }
        trix-toolbar .trix-button {
            border-bottom: none !important;
            filter: invert(1); /* Makes icons white */
        }
        trix-editor {
            background-color: #000000;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-top: none !important;
            border-radius: 0 0 1.5rem 1.5rem !important;
            min-height: 300px !important;
            color: white !important;
            padding: 1.25rem !important;
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }
        trix-editor:focus {
            border-color: #dc2626 !important; /* red-600 */
            outline: none;
        }
        /* Style for content inside editor */
        .trix-content h1 { font-size: 1.5rem; font-weight: 800; color: #dc2626; }
        .trix-content a { color: #dc2626; text-decoration: underline; }
        .trix-content blockquote { border-left: 4px solid #dc2626; padding-left: 1rem; color: #a1a1aa; }
    </style>

    <div class="max-w-7xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
            <div>
                <h1 class="text-4xl font-black uppercase italic tracking-tighter leading-none">
                    Content Manager <span class="text-red-600">/</span> {{ $academy->title }}
                </h1>
                <p class="text-zinc-500 font-bold uppercase text-[10px] tracking-[0.3em] mt-2">
                    Academy ID: #{{ $academy->id }} • Total Lessons: {{ $academy->lessons->count() }}
                </p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-zinc-900 hover:bg-white hover:text-black text-white px-6 py-3 rounded-2xl border border-white/10 font-black uppercase text-xs transition-all shadow-2xl">
                ← Back to Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-red-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <div class="lg:col-span-5">
                <div class="bg-zinc-900/50 border border-white/10 p-8 rounded-[2.5rem] sticky top-8">
                    <h2 class="text-xl font-black uppercase mb-8 italic tracking-widest">Add Lesson</h2>
                    
                    <form action="{{ route('admin.lessons.store', $academy->id) }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-zinc-500 mb-2">Section / Bab</label>
                                <input type="text" name="section_title" class="w-full bg-black border border-white/10 rounded-2xl px-5 py-4 text-white text-sm focus:border-red-600 outline-none transition-all font-bold" placeholder="e.g. Intro" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-zinc-500 mb-2">YouTube URL</label>
                                <input type="url" name="video_url" class="w-full bg-black border border-white/10 rounded-2xl px-5 py-4 text-white text-sm focus:border-red-600 outline-none transition-all font-bold" placeholder="https://...">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-zinc-500 mb-2">Lesson Title</label>
                            <input type="text" name="title" class="w-full bg-black border border-white/10 rounded-2xl px-5 py-4 text-white text-sm focus:border-red-600 outline-none transition-all font-bold" placeholder="e.g. Setting up Unreal" required>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-zinc-500 mb-2">Rich Content Material</label>
                            <input id="lesson_content" type="hidden" name="content">
                            <trix-editor input="lesson_content" class="trix-content shadow-inner"></trix-editor>
                        </div>

                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-5 rounded-2xl uppercase text-xs tracking-[0.2em] transition-all shadow-[0_10px_20px_-10px_rgba(220,38,38,0.5)]">
                            Save Material +
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-7 space-y-8">
                @if($academy->lessons->isEmpty())
                    <div class="bg-zinc-900/20 border-2 border-dashed border-white/5 rounded-[3rem] py-32 text-center">
                        <p class="text-zinc-600 font-black uppercase tracking-[0.3em] text-xs">No Material Yet</p>
                    </div>
                @else
                    @foreach($academy->lessons->groupBy('section_title') as $section => $lessons)
                        <div class="bg-zinc-900/30 border border-white/5 rounded-[2.5rem] overflow-hidden">
                            <div class="bg-white/5 px-8 py-5 border-b border-white/5">
                                <h3 class="text-red-600 font-black uppercase text-[10px] tracking-[0.3em] italic">{{ $section }}</h3>
                            </div>
                            
                            <div class="divide-y divide-white/5">
                                @foreach($lessons as $lesson)
                                    <div class="px-8 py-6 flex justify-between items-center hover:bg-white/[0.02] transition-all group">
                                        <div class="flex items-center gap-6">
                                            <div class="h-10 w-10 bg-black rounded-xl border border-white/10 flex items-center justify-center text-red-600 font-black text-xs shadow-2xl">
                                                {{ $lesson->order }}
                                            </div>
                                            <div>
                                                <h4 class="text-white font-bold text-base tracking-tight group-hover:text-red-500 transition-all italic uppercase">{{ $lesson->title }}</h4>
                                                <div class="flex gap-4 mt-1">
                                                     <p class="text-zinc-600 text-[9px] uppercase font-black tracking-widest">Slug: {{ $lesson->slug }}</p>
                                                     @if($lesson->video_url)
                                                        <span class="text-red-500 text-[9px] font-black uppercase tracking-widest italic">[Video Attached]</span>
                                                     @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </div>
</div>