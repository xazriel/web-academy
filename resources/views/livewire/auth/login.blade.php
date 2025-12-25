<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - ARC ACADEMY</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-arc-yellow { background-color: #ffd628; }
        .bg-arc-blue { background-color: #2227f7; }
        .text-arc-blue { color: #2227f7; }
    </style>
</head>
<body class="bg-[#f8f9fa] min-h-screen flex items-center justify-center p-6 text-black">

    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <a href="/" class="inline-flex items-center group">
                <div class="bg-black px-4 py-1 border-4 border-black rotate-2 group-hover:rotate-0 transition-transform shadow-[4px_4px_0_#2227f7]">
                    <span class="text-white font-black text-3xl italic tracking-tighter">ARC</span>
                </div>
                <span class="text-black font-black text-3xl uppercase ml-3 tracking-tighter">ACADEMY</span>
            </a>
        </div>

        <div class="bg-white border-4 border-black shadow-[16px_16px_0_#00001b] p-8 md:p-10 relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-14 h-14 bg-arc-blue border-b-4 border-l-4 border-black flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            <h2 class="text-4xl font-black italic uppercase tracking-tighter mb-2 leading-none">
                WELCOME <br> <span class="text-arc-blue">BACK!</span>
            </h2>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-10 text-black/40 italic">Input your credentials to enter the system</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2 ml-1">Account Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full border-4 border-black p-4 font-bold focus:bg-arc-yellow transition-all outline-none placeholder:text-black/20"
                        placeholder="MEMBER@ARC.COM">
                    @error('email')
                        <div class="mt-2 bg-red-500 text-white p-2 border-2 border-black font-black text-[9px] uppercase tracking-widest shadow-[3px_3px_0_#000]">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div x-data="{ show: false }">
                    <div class="flex justify-between items-end mb-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest ml-1">Secure Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[9px] font-black uppercase tracking-tighter text-arc-blue hover:text-black underline">Forgot?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" required
                            class="w-full border-4 border-black p-4 font-bold focus:bg-arc-yellow transition-all outline-none placeholder:text-black/20"
                            placeholder="••••••••">
                        
                        <button type="button" @click="show = !show" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-black text-white p-1 border-2 border-black hover:bg-arc-blue transition-colors shadow-[2px_2px_0_#ffd628]">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" 
                        class="w-6 h-6 border-4 border-black rounded-none appearance-none cursor-pointer 
                               checked:bg-arc-yellow relative transition-all
                               before:content-['✓'] before:absolute before:inset-0 before:flex before:items-center 
                               before:justify-center before:text-black before:font-black before:opacity-0 
                               checked:before:opacity-100">
                    <label for="remember" class="ml-3 text-[10px] font-black uppercase tracking-tighter cursor-pointer select-none">
                        Keep me signed in
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-arc-yellow text-black font-black text-xl uppercase py-5 border-4 border-black shadow-[8px_8px_0_#00001b] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all active:bg-black active:text-white">
                        LOGIN NOW →
                    </button>
                </div>
            </form>

            <div class="mt-10 pt-8 border-t-2 border-black border-dashed flex flex-col items-center gap-4 text-center">
                <p class="text-[10px] font-black uppercase tracking-widest text-black/40">Not a member yet?</p>
                <a href="{{ route('register') }}" class="w-full border-4 border-black py-4 text-[10px] font-black uppercase tracking-[0.2em] hover:bg-black hover:text-white transition-all shadow-[4px_4px_0_#2227f7] hover:shadow-none">
                    Create New Account
                </a>
            </div>
        </div>
        
        <p class="mt-12 text-center text-[10px] font-black uppercase tracking-[0.5em] text-black/20 italic">
            ARC ACADEMY &copy; 2025 . ALL RIGHTS RESERVED
        </p>
    </div>

</body>
</html>