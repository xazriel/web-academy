<div class="min-h-screen bg-[#0a0a0a] text-white p-8 lg:p-20">
    <header class="mb-16">
        <div class="flex items-center gap-1 mb-4">
            <span class="text-red-600 font-black italic text-3xl tracking-tighter">ARC</span>
            <span class="text-white font-bold text-3xl tracking-tighter uppercase">ACADEMY</span>
        </div>
        <p class="text-zinc-500 max-w-md text-sm leading-relaxed italic">
            Upgrade your architectural visualization skills with our professional recorded courses.
        </p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($academies as $item)
            <a href="{{ route('academy.show', $item->slug) }}" class="group relative bg-zinc-900/50 rounded-[2rem] overflow-hidden border border-zinc-800 hover:border-red-600/50 transition-all duration-500">
                
                <div class="aspect-video w-full overflow-hidden">
                    @if($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700" 
                             alt="{{ $item->title }}">
                    @else
                        <div class="w-full h-full bg-zinc-800 flex items-center justify-center">
                            <span class="text-zinc-600 text-[10px] font-black tracking-widest uppercase">No Preview</span>
                        </div>
                    @endif
                </div>

                <div class="p-8 space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-red-600 text-[9px] font-black uppercase tracking-widest mb-1">{{ $item->category }}</p>
                            <h3 class="text-2xl font-black italic uppercase tracking-tighter leading-none group-hover:text-red-600 transition">
                                {{ $item->title }}
                            </h3>
                        </div>
                        <p class="bg-zinc-800 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">
                            {{ number_format($item->price/1000) }}K
                        </p>
                    </div>

                    <p class="text-zinc-500 text-xs line-clamp-2 italic font-medium">
                        {{ $item->description }}
                    </p>

                    <div class="flex items-center justify-between pt-4 border-t border-zinc-800">
                        <div class="flex flex-col">
                            <span class="text-zinc-400 text-[8px] font-black uppercase tracking-widest">Instructor</span>
                            <span class="text-white text-[10px] font-bold uppercase">{{ $item->instructor_name }}</span>
                        </div>
                        <span class="text-red-600 group-hover:translate-x-2 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>