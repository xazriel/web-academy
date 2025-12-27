<script src="https://cdn.tailwindcss.com"></script>
<div class="p-10 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('admin.academies.index') }}" class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 inline-block">← Kembali</a>
        <h1 class="text-3xl font-black text-slate-900 uppercase italic mb-8">Kelola Kuis: {{ $academy->title }}</h1>

        <div class="bg-white p-8 rounded-[2rem] shadow-sm mb-10 border border-slate-200">
            <h2 class="font-bold text-lg mb-6 uppercase tracking-tight">Tambah Pertanyaan Baru</h2>
            <form action="{{ route('admin.quiz.store', $academy->id) }}" method="POST" class="space-y-4">
                @csrf
                <textarea name="question" placeholder="Tulis Pertanyaan..." class="w-full p-4 bg-slate-50 rounded-xl border-none focus:ring-2 focus:ring-indigo-500" required></textarea>
                
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="option_a" placeholder="Opsi A" class="p-4 bg-slate-50 rounded-xl border-none" required>
                    <input type="text" name="option_b" placeholder="Opsi B" class="p-4 bg-slate-50 rounded-xl border-none" required>
                    <input type="text" name="option_c" placeholder="Opsi C" class="p-4 bg-slate-50 rounded-xl border-none" required>
                    <input type="text" name="option_d" placeholder="Opsi D" class="p-4 bg-slate-50 rounded-xl border-none" required>
                </div>

                <select name="correct_answer" class="w-full p-4 bg-slate-50 rounded-xl border-none font-bold text-indigo-600" required>
                    <option value="">Pilih Jawaban Benar</option>
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="d">D</option>
                </select>

                <button type="submit" class="w-full bg-indigo-600 text-white font-black py-4 rounded-xl uppercase tracking-widest hover:bg-indigo-700 transition-all">Simpan Pertanyaan</button>
            </form>
        </div>

        <div class="space-y-4">
            <h3 class="font-bold uppercase text-slate-400 text-xs tracking-widest">Daftar Pertanyaan ({{ $academy->quizzes->count() }})</h3>
            @foreach($academy->quizzes as $q)
                <div class="bg-white p-6 rounded-2xl border border-slate-100 flex justify-between items-center">
                    <div>
                        <p class="font-bold text-slate-800">{{ $q->question }}</p>
                        <span class="text-xs font-black text-indigo-600 uppercase">Kunci: {{ strtoupper($q->correct_answer) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>