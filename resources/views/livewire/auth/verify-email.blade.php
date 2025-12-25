<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email - ARC ACADEMY</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-arc-yellow { background-color: #ffd628; }
        .bg-arc-blue { background-color: #2227f7; }
    </style>
</head>
<body class="bg-[#f8f9fa] min-h-screen flex items-center justify-center p-6 text-black">

    <div class="w-full max-w-lg">
        <div class="text-center mb-10">
            <a href="/" class="inline-flex items-center group">
                <div class="bg-arc-blue px-4 py-1 border-4 border-black -rotate-2 group-hover:rotate-0 transition-transform shadow-[4px_4px_0_#000]">
                    <span class="text-white font-black text-3xl italic tracking-tighter">ARC</span>
                </div>
                <span class="text-black font-black text-3xl uppercase ml-3 tracking-tighter">ACADEMY</span>
            </a>
        </div>

        <div class="bg-white border-4 border-black shadow-[16px_16px_0_#00001b] p-8 md:p-12 relative overflow-hidden text-center">
            
            <div class="absolute top-0 right-0 w-16 h-16 bg-arc-yellow border-b-4 border-l-4 border-black flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <h2 class="text-4xl font-black italic uppercase tracking-tighter mb-6 leading-none text-left">
                CHECK YOUR <br> <span class="text-arc-blue">INBOX!</span>
            </h2>

            <p class="text-[11px] font-bold uppercase tracking-widest text-black/60 mb-8 leading-relaxed text-left border-l-4 border-arc-yellow pl-4">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-8 bg-black text-arc-yellow p-4 border-2 border-black font-black uppercase text-[10px] tracking-widest animate-bounce">
                    ✨ A new verification link has been sent!
                </div>
            @endif

            <div class="flex flex-col gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" 
                        class="w-full bg-arc-yellow text-black font-black text-lg uppercase py-5 border-4 border-black shadow-[8px_8px_0_#00001b] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all active:bg-black active:text-white">
                        RESEND EMAIL →
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-[10px] font-black uppercase tracking-[0.3em] text-black/40 hover:text-red-600 transition-colors underline decoration-2 underline-offset-4">
                        Logout and try another email
                    </button>
                </form>
            </div>
        </div>

        <p class="mt-12 text-center text-[10px] font-black uppercase tracking-[0.4em] text-black/20 italic">
            &copy; 2025 ARC ACADEMY . Dynamic Precision
        </p>
    </div>

</body>
</html>