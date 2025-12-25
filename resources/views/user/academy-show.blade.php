<div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        
        body { font-family: 'Inter', sans-serif; background-color: #0a0a0a; margin: 0; }
        .font-black-italic { font-weight: 900; font-style: italic; }
        .glass-card { 
            background: #e2e1df; 
            border-radius: 2.5rem; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
    </style>

    {{-- Navigation --}}
    <nav class="absolute top-0 w-full z-50 px-10 py-8 flex justify-between items-center bg-gradient-to-b from-black/60 to-transparent">
        <div class="flex items-center gap-1">
            <span class="text-red-600 font-black-italic text-2xl tracking-tighter italic">ARC</span>
            <span class="text-white font-bold text-2xl tracking-tighter uppercase">MEDIA</span>
        </div>
        
        <div class="hidden lg:flex gap-8 text-[10px] font-black uppercase tracking-[0.3em] text-zinc-300">
            <a href="/" class="hover:text-red-600 transition">Home</a>
            <a href="#" class="hover:text-red-600 transition">News</a>
            <a href="#" class="hover:text-red-600 transition">Projects</a>
            <a href="#" class="hover:text-red-600 transition">Pro Community</a>
            <a href="/academy" class="text-red-600 underline underline-offset-4">Academy</a>
            <a href="#" class="hover:text-red-600 transition">About</a>
            <a href="#" class="hover:text-red-600 transition">Contact</a>
        </div>

        <div class="flex items-center gap-4">
            @guest
                <a href="/login" class="bg-red-600 text-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-red-600 transition duration-300">
                    Log In/Sign Up
                </a>
            @else
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-zinc-300 text-[10px] font-black uppercase tracking-widest hover:text-red-600 transition">Log Out</button>
                </form>
            @endguest
            <button class="text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="relative min-h-screen w-full flex items-center justify-end px-6 lg:px-24 py-20 overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            @if($academy->thumbnail)
                <img src="{{ asset('storage/' . $academy->thumbnail) }}" class="w-full h-full object-cover shadow-inner" alt="{{ $academy->title }}">
            @else
                <div class="w-full h-full bg-zinc-900"></div>
            @endif
            {{-- Dark Overlay to match the vibe --}}
            <div class="absolute inset-0 bg-black/20"></div>
        </div>

        {{-- Card Container --}}
        <div class="relative z-10 w-full max-w-lg">
            <div class="glass-card p-12 flex flex-col gap-8">
                <div class="space-y-2">
                    <p class="text-zinc-500 text-[11px] font-bold uppercase tracking-[0.15em] border-b border-zinc-400 pb-2 inline-block">
                        Recorded Digital Course
                    </p>
                    <h1 class="text-black text-6xl font-black tracking-tight leading-none pt-4">
                        {{ $academy->title }}
                    </h1>
                    <div class="pt-2">
                        <p class="text-black font-bold text-base leading-tight">{{ $academy->instructor_name ?? "Dawa'i Fathulwally" }}</p>
                        <p class="text-zinc-600 text-sm italic">Founder of Dream Ratio Studio</p>
                    </div>
                </div>

                {{-- Description & Features --}}
                <div class="text-zinc-800 text-[14px] leading-relaxed space-y-4">
                    <p class="font-medium">
                        {{ $academy->description }}
                    </p>
                    <ul class="space-y-1 font-semibold text-zinc-700">
                        <li>• 12 Videos</li>
                        <li>• Over 8 hours of content</li>
                        <li>• Workbook PDF</li>
                        <li>• Exercises and Prompts</li>
                        <li>• Additional Resources List</li>
                        <li>• Lifetime Updates</li>
                    </ul>
                </div>

                {{-- Price & CTA --}}
                <div class="space-y-6 pt-2">
                    <div class="flex items-center gap-3">
                        <span class="text-red-600 text-5xl font-black italic tracking-tighter">
                            {{ number_format($academy->price / 1000, 0) }}K
                        </span>
                        <span class="text-zinc-500 text-[10px] font-bold uppercase tracking-widest leading-none">IDR<br>Investment</span>
                    </div>

                    @if(session()->has('message'))
                        <div class="bg-black text-white p-3 rounded-xl text-[10px] font-bold uppercase text-center animate-pulse">
                            {{ session('message') }}
                        </div>
                    @endif

                    @guest
                        <a href="{{ route('login') }}" class="w-full block text-center bg-red-600 hover:bg-black text-white font-black uppercase py-5 rounded-full tracking-[0.2em] text-[10px] transition-all duration-300">
                            Log In to Enroll
                        </a>
                    @else
                        <button 
                            wire:click="enroll({{ $academy->id }})" 
                            wire:loading.attr="disabled"
                            class="w-full bg-red-600 hover:bg-black text-white font-black uppercase py-5 rounded-full tracking-[0.2em] text-[11px] transition-all duration-500 shadow-lg shadow-red-900/20 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span wire:loading.remove>Enroll Now</span>
                            <span wire:loading>Processing Request...</span>
                        </button>
                    @endguest
                </div>
            </div>
        </div>
    </main>
</div>