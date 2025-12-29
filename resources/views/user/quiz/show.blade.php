<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz: {{ $academy->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        [x-cloak] { display: none !important; }
        .progress-bar-transition { transition: width 0.5s ease-in-out; }
    </style>
</head>
<body x-data="quizHandler()">

<div class="flex flex-col h-screen overflow-hidden">
    <header class="bg-white border-b border-slate-100 px-8 py-4 flex justify-between items-center z-50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-black text-xs">ARC</span>
            </div>
            <span class="text-xl font-bold text-slate-900 tracking-tight">ARC <span class="text-slate-500 font-medium">Academy</span></span>
        </div>
        <nav class="hidden md:flex items-center gap-8 text-sm font-bold text-slate-600">
            <a href="/" class="hover:text-blue-600">Home</a>
            <a href="#" class="text-blue-600 border-b-2 border-blue-600 pb-1">Courses</a>
            <a href="{{ route('user.my-learning') }}" class="hover:text-blue-600">My Learning</a>
        </nav>
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold text-slate-500 mr-2">{{ auth()->user()->name }}</span>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        <aside class="w-[320px] bg-white border-r border-slate-100 flex flex-col hidden lg:flex">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <h2 class="text-lg font-black text-blue-700 uppercase italic leading-none truncate">{{ $academy->title }}</h2>
            </div>
            <div class="flex-1 overflow-y-auto custom-scrollbar p-4">
                @foreach($groupedLessons as $section => $lessons)
                    <div class="mb-6">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 px-2">Chapter {{ $loop->iteration }}</p>
                        <h4 class="text-[13px] font-black text-slate-800 mb-4 px-2">{{ $section }}</h4>
                        <div class="space-y-1">
                            @foreach($lessons as $l)
                                <div class="group flex items-center gap-3 p-3 rounded-xl transition-all {{ $lastResult ? 'bg-blue-50' : 'hover:bg-slate-50' }}">
                                    <div class="flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center {{ $lastResult ? 'bg-green-500' : 'border-2 border-slate-200' }}">
                                        @if($lastResult)
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        @endif
                                    </div>
                                    <span class="text-xs font-bold {{ $lastResult ? 'text-slate-900' : 'text-slate-500' }}">{{ $l->title }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-[#F8FAFC] p-4 md:p-10">
            <div class="max-w-4xl mx-auto">
                
                <div x-show="view === 'quiz'" class="mb-10 text-center">
                    <h1 class="text-3xl font-black text-slate-900 mb-2">Practice Quiz: {{ $academy->title }}</h1>
                    <p class="text-slate-500 text-sm mb-8">Uji pemahaman Anda mengenai materi yang telah dipelajari.</p>
                    
                    <div class="bg-white rounded-2xl p-4 flex flex-wrap justify-between items-center shadow-sm border border-slate-100 mb-6">
                        <div class="flex items-center gap-3 px-4 py-2 border-r border-slate-100 flex-1">
                            <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"></path></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-[10px] text-slate-400 uppercase font-bold">Duration</p>
                                <p class="text-xs font-black text-slate-800">No Limit</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 px-4 py-2 border-r border-slate-100 flex-1">
                            <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2"></path></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-[10px] text-slate-400 uppercase font-bold">Questions</p>
                                <p class="text-xs font-black text-slate-800">{{ $quizzes->count() }} Items</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 px-4 py-2 flex-1">
                            <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2"></path></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-[10px] text-slate-400 uppercase font-bold">Passing Score</p>
                                <p class="text-xs font-black text-slate-800">80%</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative w-full h-3 bg-slate-200 rounded-full overflow-hidden mb-2">
                        <div class="absolute top-0 left-0 h-full bg-blue-600 progress-bar-transition" :style="`width: ${((currentIndex + 1) / {{ $quizzes->count() }}) * 100}%`"></div>
                    </div>
                    <div class="flex justify-center italic font-black text-sm text-slate-800 uppercase tracking-tight">
                        Questions <span x-text="currentIndex + 1" class="mx-1"></span> of {{ $quizzes->count() }}
                    </div>
                </div>

                @if($lastResult)
                <div x-show="view === 'result'" class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8 md:p-12 text-center">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-full text-[10px] font-black uppercase tracking-widest mb-6">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                        Quiz Completed
                    </div>
                    <h2 class="text-4xl font-black text-slate-900 mb-10 italic uppercase leading-tight">Your Performance Summary</h2>
                    
                    <div class="flex flex-col md:flex-row items-center justify-around gap-8 mb-12">
                        <div class="relative w-40 h-40">
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="80" cy="80" r="70" stroke="#f1f5f9" stroke-width="12" fill="transparent" />
                                <circle cx="80" cy="80" r="70" stroke="#22c55e" stroke-width="12" fill="transparent" 
                                    stroke-dasharray="439.6" 
                                    stroke-dashoffset="{{ 439.6 - (439.6 * (($lastResult->score ?? 0) / 100)) }}" 
                                    class="progress-bar-transition" stroke-linecap="round" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-4xl font-black text-slate-900 italic">{{ round($lastResult->score ?? 0) }}%</span>
                                <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Your Score</span>
                            </div>
                        </div>

                        <div class="text-left space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold">🏆</div>
                                <div>
                                    <p class="text-xs font-black text-slate-800 italic uppercase">Best Score: {{ round($lastResult->score ?? 0) }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold">You can always try to improve</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 justify-center pt-8 border-t border-slate-50">
                        <button @click="startRetake()" class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-width="3"></path></svg>
                            Retake Quiz
                        </button>
                        <a href="{{ route('user.my-learning') }}" class="px-10 py-4 border-2 border-slate-100 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">Back to Course</a>
                    </div>
                </div>
                @endif

                <div x-show="view === 'quiz'" x-cloak>
                    <form action="{{ route('user.quiz.submit', $academy->id) }}" method="POST" id="quizForm">
                        @csrf
                        <div id="hiddenAnswersContainer"></div>

                        @foreach($quizzes as $index => $quiz)
                            <div x-show="currentIndex === {{ $index }}" class="bg-white rounded-3xl border border-slate-100 p-8 md:p-12 shadow-sm animate-in fade-in slide-in-from-bottom-4 duration-300">
                                <div class="inline-block px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-black uppercase mb-8">
                                    Question {{ $index + 1 }}
                                </div>
                                <h3 class="text-2xl font-black text-slate-800 mb-10 leading-snug">{{ $quiz->question }}</h3>
                                
                                <div class="space-y-4">
                                    @foreach(['a', 'b', 'c', 'd'] as $opt)
                                        <div @click="handleSelection({{ $index }}, '{{ $opt }}', '{{ strtolower($quiz->correct_answer) }}', {{ $quiz->id }})" 
                                             class="group p-5 border-2 rounded-2xl flex items-center transition-all cursor-pointer relative overflow-hidden"
                                             :class="getBoxClass({{ $index }}, '{{ $opt }}', '{{ strtolower($quiz->correct_answer) }}')">
                                            
                                            <div class="w-6 h-6 border-2 rounded-full mr-5 flex items-center justify-center transition-all"
                                                 :class="getCircleClass({{ $index }}, '{{ $opt }}', '{{ strtolower($quiz->correct_answer) }}')">
                                                <svg x-show="isCorrectIcon({{ $index }}, '{{ $opt }}', '{{ strtolower($quiz->correct_answer) }}')" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                <div class="w-2 h-2 rounded-full bg-blue-600" x-show="!feedback[{{ $index }}] && selectedAnswers[{{ $quiz->id }}] === '{{ $opt }}'"></div>
                                            </div>
                                            <span class="font-bold text-slate-700 group-hover:text-blue-600 transition-colors">{{ $quiz->{'option_'.$opt} }}</span>
                                        </div>
                                    @endforeach 
                                </div>

                                <div class="mt-12 flex justify-between items-center pt-8 border-t border-slate-50">
                                    <button type="button" @click="currentIndex--" x-show="currentIndex > 0" class="flex items-center gap-2 px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-50 transition-all">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        Previous
                                    </button>
                                    <div class="ml-auto flex gap-3">
                                        <button type="button" @click="currentIndex++" x-show="currentIndex < {{ $quizzes->count() - 1 }}" class="flex items-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all">
                                            Next
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        </button>
                                        <button type="button" @click="submitFinalQuiz()" x-show="currentIndex === {{ $quizzes->count() - 1 }}" class="px-8 py-3 bg-green-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-green-200 hover:bg-green-700 transition-all">
                                            Finish Quiz
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    function quizHandler() {
        return {
            view: '{{ $lastResult ? "result" : "quiz" }}',
            currentIndex: 0,
            selectedAnswers: {}, 
            feedback: {}, 

            startRetake() {
                this.view = 'quiz';
                this.currentIndex = 0;
                this.selectedAnswers = {};
                this.feedback = {};
            },

            handleSelection(index, selected, correct, quizId) {
                // Simpan jawaban yang dipilih
                this.selectedAnswers[quizId] = selected;
                
                // Berikan feedback visual langsung
                this.feedback[index] = { 
                    selected: selected, 
                    correct: correct 
                };
            },

            getBoxClass(index, opt, correct) {
                if (!this.feedback[index]) {
                    return this.selectedAnswers[Object.keys(this.selectedAnswers)[index]] === opt 
                        ? 'border-blue-600 bg-blue-50' 
                        : 'border-slate-100 bg-white hover:border-blue-600 hover:shadow-md';
                }
                
                const item = this.feedback[index];
                if (opt === item.correct) return 'border-green-500 bg-green-50';
                if (opt === item.selected && item.selected !== item.correct) return 'border-red-500 bg-red-50';
                return 'border-slate-50 opacity-40';
            },

            getCircleClass(index, opt, correct) {
                if (!this.feedback[index]) {
                    return this.selectedAnswers[Object.keys(this.selectedAnswers)[index]] === opt 
                        ? 'border-blue-600' 
                        : 'border-slate-200 group-hover:border-blue-600';
                }
                
                const item = this.feedback[index];
                if (opt === item.correct) return 'bg-green-500 border-green-500';
                if (opt === item.selected && item.selected !== item.correct) return 'bg-red-500 border-red-500';
                return 'border-slate-200';
            },

            isCorrectIcon(index, opt, correct) {
                if (!this.feedback[index]) return false;
                return opt === this.feedback[index].correct;
            },

            submitFinalQuiz() {
                const totalQuestions = {{ $quizzes->count() }};
                const answeredCount = Object.keys(this.selectedAnswers).length;

                if (answeredCount < totalQuestions) {
                    if (!confirm(`You have only answered ${answeredCount} out of ${totalQuestions} questions. Submit anyway?`)) {
                        return;
                    }
                }

                const container = document.getElementById('hiddenAnswersContainer');
                container.innerHTML = '';
                for (const [quizId, answer] of Object.entries(this.selectedAnswers)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `answers[${quizId}]`;
                    input.value = answer;
                    container.appendChild(input);
                }
                document.getElementById('quizForm').submit();
            }
        }
    }
</script>
</body>
</html>