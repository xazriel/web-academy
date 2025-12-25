<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Join ARC ACADEMY - Start Your Journey</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-arc-yellow { background-color: #ffd628; }
        .bg-arc-blue { background-color: #2227f7; }
        .text-arc-blue { color: #2227f7; }
    </style>
</head>
<body class="bg-[#f8f9fa] min-h-screen flex items-center justify-center p-6 text-black">

    <div class="w-full max-w-xl">
        <div class="text-center mb-10">
            <a href="/" class="inline-flex items-center group">
                <div class="bg-arc-blue px-4 py-1 border-4 border-black -rotate-2 group-hover:rotate-0 transition-transform shadow-[4px_4px_0_#000]">
                    <span class="text-white font-black text-3xl italic tracking-tighter">ARC</span>
                </div>
                <span class="text-black font-black text-3xl uppercase ml-3 tracking-tighter">ACADEMY</span>
            </a>
            <p class="text-[10px] font-black uppercase tracking-[0.5em] mt-4 text-black/40">Creative Journey Starts Here</p>
        </div>

        <div class="bg-white border-4 border-black shadow-[16px_16px_0_#00001b] p-8 md:p-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-arc-yellow border-b-4 border-l-4 border-black flex items-center justify-center">
                <span class="font-black text-2xl">?</span>
            </div>

            <h2 class="text-4xl font-black italic uppercase tracking-tighter mb-8 text-black leading-none">
                CREATE <br> <span class="text-arc-blue">NEW ACCOUNT</span>
            </h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="relative">
                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2 ml-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full border-4 border-black p-4 font-bold focus:bg-arc-yellow transition-all outline-none placeholder:text-black/20"
                        placeholder="WAKIDUN KLONTONG">
                    @error('name')
                        <p class="text-red-600 text-[10px] font-black uppercase mt-1 italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative">
                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2 ml-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full border-4 border-black p-4 font-bold focus:bg-arc-yellow transition-all outline-none placeholder:text-black/20"
                        placeholder="USER@CREATIVE.COM">
                    @error('email')
                        <p class="text-red-600 text-[10px] font-black uppercase mt-1 italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2 ml-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full border-4 border-black p-4 font-bold focus:bg-arc-yellow transition-all outline-none placeholder:text-black/20"
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-red-600 text-[10px] font-black uppercase mt-1 italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2 ml-1">Confirm</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full border-4 border-black p-4 font-bold focus:bg-arc-yellow transition-all outline-none placeholder:text-black/20"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center py-2">
                    <div class="relative flex items-center justify-center">
                        <input type="checkbox" id="terms" required 
                            class="w-7 h-7 border-4 border-black rounded-none appearance-none cursor-pointer 
                                   checked:bg-arc-yellow transition-all duration-100">
                        <svg class="absolute w-5 h-5 pointer-events-none hidden" 
                             style="display:none" id="check-icon"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <label for="terms" class="ml-3 text-[10px] font-black uppercase tracking-tighter cursor-pointer">
                        I agree to the <span class="text-arc-blue underline">creative terms</span> & conditions
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-arc-blue text-white font-black text-xl uppercase py-5 border-4 border-black shadow-[8px_8px_0_#00001b] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all active:bg-arc-yellow active:text-black">
                        REGISTER NOW →
                    </button>
                </div>
            </form>

            <div class="mt-10 pt-10 border-t-2 border-black border-dashed flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-black/40">Already a member?</p>
                <a href="{{ route('login') }}" class="bg-black text-white px-8 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-arc-yellow hover:text-black transition-all shadow-[4px_4px_0_#2227f7] hover:shadow-none">
                    Login Here
                </a>
            </div>
        </div>
        
        <p class="mt-12 text-center text-[10px] font-black uppercase tracking-[0.4em] text-black/20 italic">
            &copy; 2025 ARC ACADEMY . Dynamic Precision
        </p>
    </div>

    <script>
        const checkbox = document.getElementById('terms');
        const checkIcon = document.getElementById('check-icon');

        checkbox.addEventListener('change', function() {
            if (this.checked) {
                checkIcon.style.display = 'block';
            } else {
                checkIcon.style.display = 'none';
            }
        });
    </script>
</body>
</html>