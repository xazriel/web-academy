<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="p-6 lg:p-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('admin.academies.index') }}" class="group flex items-center text-sm font-bold text-slate-400 uppercase tracking-widest mb-6 transition-colors hover:text-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Akademi
        </a>

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <h1 class="text-4xl font-black text-slate-900 uppercase italic leading-none tracking-tighter">Kelola Kuis</h1>
                <p class="text-slate-500 mt-2 font-medium">Akademi: <span class="text-indigo-600 font-bold">{{ $academy->title }}</span></p>
            </div>
            <div class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-widest">
                Total: {{ $academy->quizzes->count() }} Pertanyaan
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl font-bold text-sm flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-8 lg:p-10 rounded-[2.5rem] shadow-sm mb-12 border border-slate-200">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-2 h-8 bg-indigo-600 rounded-full"></div>
                <h2 class="font-extrabold text-xl text-slate-800 uppercase tracking-tight">Tambah Pertanyaan Baru</h2>
            </div>

            <form action="{{ route('admin.quiz.store', $academy->id) }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Pilih Bab Kuis</label>
                    <select name="section_title" class="w-full p-4 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition-all font-bold text-slate-700 uppercase" required>
                        <option value="" class="normal-case">-- Pilih Bab untuk Kuis Ini --</option>
                        @foreach($chapters as $chapter)
                            <option value="{{ $chapter->section_title }}">
                                {{ strtoupper($chapter->section_title) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Pertanyaan</label>
                    <textarea name="question" rows="3" placeholder="Tulis teks pertanyaan di sini..." class="w-full p-4 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition-all font-medium text-slate-800" required></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-indigo-300">A</span>
                        <input type="text" name="option_a" placeholder="Jawaban A" class="w-full pl-10 pr-4 py-4 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition-all font-bold" required>
                    </div>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-indigo-300">B</span>
                        <input type="text" name="option_b" placeholder="Jawaban B" class="w-full pl-10 pr-4 py-4 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition-all font-bold" required>
                    </div>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-indigo-300">C</span>
                        <input type="text" name="option_c" placeholder="Jawaban C" class="w-full pl-10 pr-4 py-4 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition-all font-bold" required>
                    </div>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-indigo-300">D</span>
                        <input type="text" name="option_d" placeholder="Jawaban D" class="w-full pl-10 pr-4 py-4 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition-all font-bold" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Kunci Jawaban</label>
                    <select name="correct_answer" class="w-full p-4 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition-all font-black text-indigo-600 uppercase tracking-widest" required>
                        <option value="">Pilih Jawaban Benar</option>
                        <option value="a">Opsi A</option>
                        <option value="b">Opsi B</option>
                        <option value="c">Opsi C</option>
                        <option value="d">Opsi D</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-black py-5 rounded-2xl uppercase tracking-[0.2em] text-xs hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-200 transition-all active:scale-[0.98]">
                    Simpan Pertanyaan
                </button>
            </form>
        </div>

        <div class="space-y-6">
            <div class="flex items-center gap-4 mb-4">
                <h3 class="font-black uppercase text-slate-400 text-xs tracking-[0.3em]">Review Pertanyaan</h3>
                <div class="h-px flex-1 bg-slate-200"></div>
            </div>

            @forelse($academy->quizzes as $q)
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-[9px] bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full font-black uppercase tracking-tighter border border-indigo-100">
                                {{ $q->lesson->section_title ?? 'Tanpa Bab' }}
                            </span>
                            
                            <span class="text-[9px] bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full font-black uppercase tracking-tighter border border-emerald-100">
                                Kunci: {{ strtoupper($q->correct_answer) }}
                            </span>
                        </div>
                        <p class="font-bold text-slate-800 leading-relaxed">{{ $q->question }}</p>
                    </div>
                    
                    <form action="{{ route('admin.quiz.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="p-3 bg-red-50 text-red-400 rounded-2xl hover:bg-red-500 hover:text-white transition-all group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            @empty
                <div class="text-center py-20 bg-slate-100/50 rounded-[3rem] border-2 border-dashed border-slate-200">
                    <p class="text-slate-400 font-bold italic tracking-wide text-sm uppercase">Belum ada pertanyaan kuis</p>
                </div>
            @endforelse
        </div>
    </div>
</div>