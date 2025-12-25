<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard ARC EDUCATION</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #000000; color: white; }
        .outline-text { -webkit-text-stroke: 1px rgba(255, 255, 255, 0.2); color: transparent; }
    </style>
</head>
<body class="antialiased">

    <nav class="flex items-center justify-between px-6 md:px-12 py-6 sticky top-0 z-50 bg-black/80 backdrop-blur-md border-b border-white/5">
        <div class="flex items-center space-x-1">
            <span class="text-red-600 font-black text-2xl tracking-tighter">ARC</span>
            <span class="text-white font-black text-2xl tracking-tighter">EDUCATION</span>
        </div>

        <div class="hidden lg:flex items-center space-x-8 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">
            <a href="#" class="hover:text-red-600 transition">Home</a>
            <a href="#" class="hover:text-red-600 transition">My Academy</a>
            <a href="#" class="hover:text-red-600 transition">Projects</a>
            <a href="#" class="hover:text-red-600 transition">About</a>
        </div>

        <div class="flex items-center space-x-6">
            <div class="flex items-center space-x-3 group">
                <div class="text-right hidden sm:block">
                    <span class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 leading-none">Logged in as</span>
                    <span class="text-[11px] font-black uppercase text-white tracking-tighter italic">Hi, {{ Auth::user()->name }}</span>
                </div>
                
                <a href="{{ url('/settings/profile') }}" 
                   class="p-2 bg-zinc-900 border border-white/10 rounded-xl hover:bg-red-600 hover:border-red-600 transition-all duration-300 shadow-lg group-hover:scale-105"
                   title="Edit Profile">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            </div>

            <div class="h-8 w-[1px] bg-white/10"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[10px] font-bold uppercase bg-white/5 border border-white/10 text-white px-5 py-2 rounded-full hover:bg-red-600 hover:border-red-600 transition-all">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="pb-20">
        <section class="px-6 md:px-12 pt-16 pb-10">
            <h2 class="text-white text-4xl md:text-5xl font-black italic tracking-tighter uppercase leading-none">
                Welcome <span class="text-red-600">{{ explode(' ', Auth::user()->name)[0] }}!</span>
            </h2>
            <p class="text-gray-500 text-xs uppercase tracking-[0.3em] mt-4 italic font-light">Continue your creative journey where you left off.</p>
        </section>

        <section class="px-6 md:px-12 mb-20">
            <div class="bg-zinc-900/50 border border-white/5 rounded-[2rem] p-8 md:p-12 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div>
                        <span class="bg-red-600 text-[9px] font-black uppercase px-3 py-1 rounded-full text-white">Currently Learning</span>
                        <h3 class="text-3xl font-black italic uppercase tracking-tighter mt-4">Lighting Basic Class</h3>
                        <p class="text-gray-400 text-sm mt-2 max-w-md italic font-light">Master the logic thinking to set up the right way lighting in Unreal Engine.</p>
                        <div class="mt-8">
                            <div class="flex justify-between text-[10px] font-bold uppercase tracking-widest mb-2">
                                <span>Progress</span>
                                <span class="text-red-600">15% Complete</span>
                            </div>
                            <div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-red-600 w-[15%] shadow-[0_0_10px_rgba(220,38,38,0.5)]"></div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="bg-white text-black font-black uppercase text-[11px] px-10 py-4 rounded-full hover:bg-red-600 hover:text-white transition-all text-center">Resume Lesson</a>
                </div>
                <div class="absolute top-0 right-0 w-1/2 h-full bg-linear-to-l from-red-600/10 to-transparent pointer-events-none"></div>
            </div>
        </section>

        <section class="px-6 md:px-12 mb-20">
            <div class="flex items-center justify-between mb-10 border-b border-white/5 pb-6">
                <div class="flex items-center space-x-2">
                    <span class="text-red-600 font-black text-2xl tracking-tighter">EXPLORE</span>
                    <span class="text-white font-black text-2xl tracking-tighter uppercase">ACADEMY</span>
                </div>
                <a href="{{ route('academy.index') }}" class="text-red-600 font-bold text-[10px] uppercase tracking-widest hover:underline">See All Catalog</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($academies as $academy)
                <a href="{{ route('academies.show', $academy->slug) }}" class="group block">
                    <div class="relative aspect-[4/5] rounded-3xl overflow-hidden border border-white/10 mb-5">
                        @if($academy->thumbnail)
                            <img src="{{ asset('storage/' . $academy->thumbnail) }}" class="object-cover w-full h-full group-hover:scale-110 transition duration-700">
                        @else
                            <div class="w-full h-full bg-zinc-900 flex items-center justify-center text-[10px] text-zinc-500 font-black">NO IMAGE</div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <span class="text-red-500 text-[10px] font-black uppercase tracking-widest">{{ $academy->category }}</span>
                            <h4 class="text-xl font-bold italic uppercase tracking-tighter text-white mt-1 leading-tight">{{ $academy->title }}</h4>
                            <p class="text-white font-black text-lg mt-3 italic tracking-tighter">{{ number_format($academy->price / 1000, 0) }}K</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

        <section class="px-6 md:px-12">
            <div class="flex items-center space-x-2 mb-10">
                <span class="text-red-600 font-black text-2xl tracking-tighter">LATEST</span>
                <span class="text-white font-black text-2xl tracking-tighter uppercase">NEWS</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($news as $item)
                <a href="{{ route('posts.show', $item->slug) }}" class="group block bg-zinc-900/30 p-4 rounded-3xl border border-white/5 hover:border-red-600/50 transition duration-500">
                    <div class="aspect-video rounded-2xl overflow-hidden mb-5">
                        @if($item->thumbnail)
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @endif
                    </div>
                    <p class="text-red-600 text-[9px] font-bold uppercase tracking-widest mb-2">{{ $item->created_at->format('d M Y') }}</p>
                    <h4 class="text-white font-bold text-sm leading-tight group-hover:text-red-500 transition uppercase italic">{{ $item->title }}</h4>
                </a>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="py-10 text-center text-gray-700 text-[10px] uppercase tracking-widest border-t border-white/5">
        &copy; 2025 ARC Media Creative. Member Area.
    </footer>

</body>
</html>