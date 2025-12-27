<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-[#F8FAFC] p-6 lg:p-12">
    <div class="max-w-7xl mx-auto">
        
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('user.home') }}" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors uppercase tracking-widest">Dashboard</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-black text-indigo-600 uppercase tracking-widest">My Learning</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="mb-12">
            <h1 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tighter uppercase italic mb-2">My Learning Journey</h1>
            <p class="text-slate-500 font-bold italic">Teruskan belajarmu dan raih sertifikat kompetensimu.</p>
        </div>

        @if($enrolledAcademies->isEmpty())
            <div class="bg-white rounded-[3rem] p-20 text-center border-2 border-dashed border-slate-200">
                <div class="bg-slate-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 uppercase italic mb-4">Wah, Rak Bukumu Masih Kosong!</h3>
                <p class="text-slate-500 mb-10 max-w-md mx-auto font-medium">Kamu belum terdaftar di kursus apapun. Temukan materi yang menarik dan mulai tingkatkan skill-mu sekarang.</p>
                <a href="{{ route('user.home') }}" class="bg-indigo-600 text-white font-black py-5 px-12 rounded-2xl uppercase tracking-widest hover:bg-indigo-700 hover:scale-105 transition-all shadow-xl shadow-indigo-100">
                    Eksplor Kursus
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($enrolledAcademies as $academy)
                    <div class="group bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        
                        <div class="aspect-video bg-indigo-900 relative flex items-center justify-center overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-indigo-900 opacity-90"></div>
                            <span class="relative z-10 text-white font-black text-5xl opacity-20 italic group-hover:scale-125 transition-transform duration-700">ARC</span>
                            
                            @if($academy->progress_percentage == 100)
                                <div class="absolute top-6 right-6 bg-emerald-500 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest flex items-center gap-2 shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Completed
                                </div>
                            @endif
                        </div>

                        <div class="p-8">
                            <div class="mb-6">
                                <h3 class="text-2xl font-black text-slate-900 mb-2 tracking-tighter uppercase italic leading-[1.1] group-hover:text-indigo-600 transition-colors">
                                    {{ $academy->title }}
                                </h3>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">
                                    {{ $academy->lessons->count() }} Modul Pelatihan
                                </p>
                            </div>

                            <div class="mb-8">
                                <div class="flex justify-between items-end mb-2">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Your Progress</span>
                                    <span class="text-sm font-black text-indigo-600 italic">{{ $academy->progress_percentage }}%</span>
                                </div>
                                <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-600 rounded-full transition-all duration-1000" style="width: {{ $academy->progress_percentage }}%"></div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between border-t border-slate-50 pt-6">
                                @if($academy->progress_percentage == 100)
                                    <a href="{{ route('user.course.claim', $academy->id) }}" class="flex items-center gap-2 text-indigo-600 font-black text-[10px] uppercase tracking-[0.15em] hover:text-indigo-800 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Certificate
                                    </a>
                                @else
                                    <span class="text-slate-300 font-black text-[10px] uppercase tracking-widest italic">Belajar Aktif</span>
                                @endif

                                <a href="{{ route('user.course', $academy->id) }}" class="inline-flex items-center justify-center w-12 h-12 bg-slate-900 text-white rounded-2xl group-hover:bg-indigo-600 transition-all shadow-lg shadow-slate-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>