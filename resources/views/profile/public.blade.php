<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-slate-50">
    <div class="absolute top-6 left-6 z-50">
    <a href="{{ route('user.home') }}" class="group flex items-center gap-3 bg-white/20 hover:bg-white backdrop-blur-md px-5 py-2.5 rounded-2xl transition-all duration-300 border border-white/30 shadow-xl">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-indigo-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        <span class="text-xs font-black text-white group-hover:text-indigo-600 uppercase tracking-[0.2em] transition-colors">Kembali ke Beranda</span>
    </a>
</div>
    <div class="h-64 bg-indigo-900 relative">
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
    </div>

    <div class="max-w-5xl mx-auto px-6 -mt-32 relative z-10 pb-20">
        <div class="bg-white rounded-[3rem] shadow-xl p-8 md:p-12 mb-10 border border-slate-100">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                <div class="w-40 h-40 bg-indigo-100 rounded-[2.5rem] flex items-center justify-center border-8 border-white shadow-lg overflow-hidden">
                    <span class="text-5xl font-black text-indigo-600 uppercase">{{ substr($user->name, 0, 1) }}</span>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                        <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">{{ $user->name }}</h1>
                        <span class="bg-indigo-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest self-center md:self-auto">Verified Student</span>
                    </div>
                    
                    <p class="text-slate-500 font-medium mb-8 max-w-xl italic">"Antusias dalam mempelajari teknologi baru dan berkomitmen untuk terus meningkatkan kompetensi melalui ARC Academy."</p>

                    <div class="flex flex-wrap justify-center md:justify-start gap-4">
                        <div class="bg-slate-50 px-6 py-3 rounded-2xl border border-slate-100">
                            <span class="block text-2xl font-black text-slate-900 leading-none">{{ $coursesCount }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kursus</span>
                        </div>
                        <div class="bg-slate-50 px-6 py-3 rounded-2xl border border-slate-100">
                            <span class="block text-2xl font-black text-slate-900 leading-none">{{ $user->certificates->count() }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sertifikat</span>
                        </div>
                        <div class="bg-slate-50 px-6 py-3 rounded-2xl border border-slate-100">
                            <span class="block text-2xl font-black text-slate-900 leading-none">{{ $completedLessonsCount }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Materi Selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="flex items-center gap-4 mb-8 px-4">
                <h2 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Achievement Gallery</h2>
                <div class="h-px flex-1 bg-slate-200"></div>
            </div>

            @if($user->certificates->isEmpty())
                <div class="bg-white rounded-[2.5rem] p-16 text-center border-2 border-dashed border-slate-200">
                    <p class="text-slate-400 font-bold italic uppercase tracking-widest text-sm">Belum ada sertifikat yang diterbitkan.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($user->certificates as $cert)
                        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                            <div class="flex items-center gap-6">
                                <div class="w-20 h-20 bg-indigo-600 rounded-[1.5rem] flex items-center justify-center shrink-0 shadow-lg rotate-3 group-hover:rotate-0 transition-transform">
                                    <span class="text-white font-black italic">ARC</span>
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-black text-slate-900 uppercase italic leading-tight mb-1 group-hover:text-indigo-600 transition-colors">
                                        {{ $cert->academy->title }}
                                    </h3>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">
                                        Diterbitkan: {{ $cert->created_at->format('M Y') }}
                                    </p>
                                    
                                    <a href="{{ route('certificate.print', $cert->id) }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b-2 border-indigo-100 hover:border-indigo-600 transition-all">
                                        Lihat Kredensial →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>