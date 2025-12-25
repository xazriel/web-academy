<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARC ACADEMY - Creative Journey</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .giant-text-yellow {
            font-size: 8vw; color: #ffd628; line-height: 0.8; letter-spacing: -0.05em;
            filter: drop-shadow(0.5vw 0.5vw 0px #00001b);
        }
        .giant-text-outline {
            font-size: 8vw; -webkit-text-stroke: 0.2vw #00001b; color: transparent;
            line-height: 0.8; letter-spacing: -0.05em;
        }
        .giant-text-solid {
            font-size: 8vw; color: #00001b; line-height: 0.8; letter-spacing: -0.05em;
        }
        .giant-text-blue {
            font-size: 7vw; color: #2227f7; line-height: 1;
            filter: drop-shadow(0.5vw 0.5vw 0px #00001b);
        }
        .section-gradient {
            background: linear-gradient(to bottom, #f8f9fa, #ffffff);
        }
        /* Tambahan Smooth Scroll */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="antialiased bg-[#f8f9fa] text-arc-black overflow-x-hidden"> 

    <nav class="w-full flex items-center justify-between px-6 md:px-12 py-5 sticky top-0 z-[100] bg-arc-black border-b-4 border-arc-yellow shadow-[0_4px_0_#00001b]">
        <div class="flex items-center">
            <div class="bg-arc-blue px-4 py-1 border-2 border-white -rotate-2">
                <span class="text-white font-black text-2xl italic tracking-tighter">ARC</span>
            </div>
            <span class="text-arc-yellow font-black text-2xl uppercase ml-3 tracking-tighter">ACADEMY</span>
        </div>

        <div class="hidden lg:flex items-center space-x-6 xl:space-x-8">
            <a href="{{ Auth::check() ? route('home') : url('/') }}" 
               class="text-white/50 font-black uppercase text-[11px] tracking-[0.2em] hover:text-white transition">
               Home
            </a>
            <a href="#classes" class="text-arc-yellow font-black uppercase text-[11px] tracking-[0.2em] hover:text-white transition">Academy</a>
            
            <a href="#mentors" class="text-arc-yellow font-black uppercase text-[11px] tracking-[0.2em] hover:text-arc-yellow transition">
               Mentors
            </a>
            <a href="#about" class="text-arc-yellow font-black uppercase text-[11px] tracking-[0.2em] hover:text-arc-yellow transition">
               About
            </a>
            <a href="#contact" class="text-arc-yellow font-black uppercase text-[11px] tracking-[0.2em] hover:text-arc-yellow transition">
               Contact
            </a>
        </div>

        <div class="flex items-center space-x-6">
            @auth
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] leading-none">Welcome back,</p>
                        <p class="text-sm font-black text-arc-yellow uppercase italic tracking-tighter">
                            HI, {{ strtok(Auth::user()->name, ' ') }}!
                        </p>
                    </div>

                    <a href="{{ url('/settings/profile') }}" class="relative group">
                        <div class="bg-arc-yellow border-2 border-arc-black p-2 group-hover:bg-white transition-all shadow-[4px_4px_0_#000000] group-hover:shadow-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-arc-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('home') }}" class="hidden sm:block bg-white text-arc-black font-black uppercase text-[11px] px-5 py-2.5 border-2 border-arc-black shadow-[4px_4px_0_#ffd628] hover:shadow-none transition-all">
                        BACK TO DASHBOARD
                    </a>
                </div>
            @else
                <a href="{{ route('login') }}" class="bg-arc-blue text-white font-black uppercase text-[11px] px-8 py-3 border-2 border-white hover:bg-arc-yellow hover:text-arc-black hover:border-arc-black transition-all">
                    GET STARTED
                </a>
            @endauth
        </div>
    </nav>

    <main>
        <section class="relative min-h-screen flex flex-col items-center justify-center text-center section-gradient py-20 px-4">
            <div class="w-full flex flex-col items-center">
                <h2 class="giant-text-yellow font-black uppercase italic mb-4">LET YOUR</h2>
                <h1 class="giant-text-outline font-black uppercase italic">CREATIVE</h1>
                <h1 class="giant-text-solid font-black uppercase italic">JOURNEY</h1>
                <h1 class="giant-text-blue font-black uppercase italic mt-4">BEGIN!</h1>

                <div class="mt-20 flex flex-col items-center gap-8">
                    <a href="#classes" class="group relative inline-block">
                        <div class="absolute inset-0 bg-arc-blue translate-x-4 translate-y-4 border-4 border-black transition-all group-hover:translate-x-0 group-hover:translate-y-0"></div>
                        <div class="relative bg-arc-yellow text-black font-black text-3xl md:text-5xl px-12 py-8 border-4 border-black -translate-x-1 -translate-y-1 transition-all group-hover:translate-x-2 group-hover:translate-y-2 active:bg-white">
                            EXPLORE ACADEMY <span class="inline-block group-hover:rotate-45 transition-transform">→</span>
                        </div>
                    </a>

                    @auth
                    <a href="{{ route('home') }}" class="group mt-4 flex items-center gap-2">
                        <span class="text-arc-blue font-black uppercase italic tracking-tighter text-xl border-b-4 border-arc-blue group-hover:text-black group-hover:border-black transition-all">
                            Go back to your dashboard
                        </span>
                        <div class="bg-black text-white p-1 border-2 border-black group-hover:bg-arc-yellow group-hover:text-black transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                    </a>
                    @endauth
                </div>
            </div>
        </section>

        <section id="classes" class="w-full px-6 md:px-20 py-40 bg-white border-t-8 border-arc-black">
            <div class="max-w-[1400px] mx-auto">
                <div class="text-center mb-32">
                    <div class="bg-arc-black text-white px-12 py-4 inline-block -rotate-1 shadow-[10px_10px_0_#ffd628]">
                        <h2 class="font-black text-4xl md:text-6xl tracking-tighter uppercase italic">AVAILABLE CLASSES</h2>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-24">
                    @forelse($academies as $item)
                    <div class="p-12 flex flex-col items-center text-center bg-white border-4 border-arc-black shadow-[20px_20px_0_#00001b] transition-all group">
                        <span class="bg-arc-black text-arc-yellow text-xs font-black uppercase px-6 py-2 mb-10">
                            {{ $item->category }}
                        </span>
                        <h3 class="text-arc-black text-4xl font-black italic tracking-tighter uppercase mb-10 leading-none h-24 flex items-center justify-center">
                            {{ $item->title }}
                        </h3>
                        <div class="bg-arc-yellow border-4 border-arc-black px-12 py-6 mb-12 shadow-[10px_10px_0px_#2227f7]">
                            <span class="text-6xl font-black italic text-arc-black tracking-tighter">
                                {{ number_format($item->price / 1000) }}K
                            </span>
                        </div>
                        <a href="{{ route('academies.show', $item->slug) }}" class="bg-arc-blue text-white font-black text-xl w-full py-5 border-4 border-arc-black shadow-[8px_8px_0_#00001b] hover:shadow-none transition-all">
                            JOIN NOW
                        </a>
                    </div>
                    @empty
                    <div class="col-span-3 text-center py-20 opacity-20 font-black text-4xl uppercase">No Classes Yet</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="mentors" class="w-full px-6 md:px-20 py-40 bg-arc-blue border-t-8 border-arc-black text-white">
            <div class="max-w-[1400px] mx-auto text-center">
                <h2 class="text-6xl font-black italic uppercase mb-10 tracking-tighter">Meet The Mentors</h2>
                <p class="text-xl font-bold uppercase tracking-widest opacity-80">Professional creators ready to guide your journey.</p>
            </div>
        </section>

        <section id="about" class="w-full px-6 md:px-20 py-40 bg-arc-yellow border-t-8 border-arc-black text-arc-black">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-6xl font-black italic uppercase mb-10 tracking-tighter">About ARC</h2>
                <p class="text-2xl font-bold leading-tight uppercase">ARC Academy is a creative hub for the next generation of digital artists and creative thinkers.</p>
            </div>
        </section>

        <section id="contact" class="w-full px-6 md:px-20 py-40 bg-white border-t-8 border-arc-black">
            <div class="max-w-[1400px] mx-auto text-center">
                <h2 class="text-6xl font-black italic uppercase mb-10 tracking-tighter">Contact Us</h2>
                <div class="inline-block border-8 border-arc-black p-8 bg-arc-yellow shadow-[15px_15px_0_#000]">
                    <p class="text-3xl font-black tracking-widest">HELLO@ARCACADEMY.ID</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-32 bg-arc-black text-center border-t-8 border-arc-yellow">
        <p class="text-white/20 text-xs font-black uppercase tracking-[0.8em]">
            &copy; 2025 ARC ACADEMY . DYNAMIC PRECISION . ALL RIGHTS RESERVED
        </p>
    </footer>

</body>
</html>