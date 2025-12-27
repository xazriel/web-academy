<script src="https://cdn.tailwindcss.com"></script>
<div class="min-h-screen bg-slate-50 py-12 px-6">
    <div class="max-w-3xl mx-auto">
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter">Final Assessment</h1>
            <p class="text-slate-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">{{ $academy->title }}</p>
        </div>

        <form action="{{ route('user.quiz.submit', $academy->id) }}" method="POST" class="space-y-6">
            @csrf
            @foreach($academy->quizzes as $index => $quiz)
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <p class="text-lg font-black text-slate-900 mb-6 leading-tight">
                        <span class="text-indigo-600 mr-2">#{{ $index + 1 }}</span> {{ $quiz->question }}
                    </p>
                    
                    <div class="grid gap-3">
                        @foreach(['a', 'b', 'c', 'd'] as $opt)
                            <label class="flex items-center p-4 rounded-2xl border-2 border-slate-50 hover:border-indigo-100 hover:bg-indigo-50/30 cursor-pointer transition-all group">
                                <input type="radio" name="question_{{ $quiz->id }}" value="{{ $opt }}" class="hidden peer" required>
                                <div class="w-6 h-6 rounded-full border-2 border-slate-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 mr-4 transition-all"></div>
                                <span class="text-slate-600 font-bold group-hover:text-slate-900">{{ $quiz->{'option_' . $opt} }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit" class="w-full bg-slate-900 hover:bg-indigo-600 text-white font-black py-6 rounded-[2rem] uppercase tracking-[0.3em] transition-all shadow-xl shadow-indigo-100">
                Submit Jawaban
            </button>
        </form>
    </div>
</div>