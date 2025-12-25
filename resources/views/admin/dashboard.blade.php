<x-layouts.app :title="__('Dashboard')">
    <div class="flex flex-col gap-8 p-4">
        
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    </div>
    
    <a href="{{ route('user.home') }}" target="_blank" class="flex items-center gap-2 bg-zinc-900 hover:bg-zinc-800 border border-white/10 px-3 py-1.5 rounded-md transition group shrink-0">
        <div class="relative flex h-2 w-2">
            <div class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></div>
            <div class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></div>
        </div>
        <span class="text-[9px] font-black uppercase tracking-widest text-gray-400 group-hover:text-white">View User Site</span>
        
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-600 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
        </svg>
    </a>
</div>

    <div class="bg-zinc-900/50 rounded-[2rem] border border-white/5 p-6 shadow-2xl mt-10">
    <div class="mb-6 border-b border-white/5 pb-4">
        <h2 class="text-white text-2xl font-black italic tracking-tighter uppercase">Academy Manager</h2>
        <p class="text-gray-500 text-[10px] uppercase tracking-[0.3em]">Manage your courses and pricing.</p>
    </div>
    @livewire('admin.academy-manager')
</div>

        <div class="bg-zinc-900/50 rounded-[2rem] border border-white/5 p-6 shadow-2xl">
            <div class="mb-6 border-b border-white/5 pb-4">
                <h2 class="text-white text-2xl font-black italic tracking-tighter uppercase">Content Manager</h2>
                <p class="text-gray-500 text-[10px] uppercase tracking-[0.3em]">Create and manage your latest news.</p>
            </div>
            @livewire('admin.news-manager')
        </div>

        <div class="flex flex-col gap-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="group relative aspect-video overflow-hidden rounded-3xl border border-white/5 bg-zinc-900/30 p-6">
                    <div class="relative z-10">
                        <p class="text-gray-500 text-[10px] uppercase tracking-widest font-bold">Total Articles</p>
                        <h3 class="text-4xl font-black italic text-white mt-2">{{ $news->count() }}</h3>
                    </div>
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-white/5 opacity-50" />
                </div>
                
                <div class="relative aspect-video overflow-hidden rounded-3xl border border-white/5 bg-zinc-900/30">
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-white/5" />
                </div>

                <div class="relative aspect-video overflow-hidden rounded-3xl border border-white/5 bg-zinc-900/30">
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-white/5" />
                </div>
            </div>

            <div class="relative min-h-[400px] flex-1 overflow-hidden rounded-[2rem] border border-white/5 bg-black">
                <div class="p-6 border-b border-white/5 flex justify-between items-center">
                    <h3 class="text-white font-black italic uppercase tracking-tighter">Recent Activity</h3>
                    <span class="text-[9px] text-red-600 font-bold uppercase tracking-widest">Live Updates</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] uppercase tracking-widest text-gray-500 border-b border-white/5">
                                <th class="p-6">Title</th>
                                <th class="p-6">Status</th>
                                <th class="p-6">Date</th>
                                <th class="p-6 text-right">Action</th> </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($news as $item)
                            <tr class="hover:bg-white/[0.02] transition group">
                                <td class="p-6 font-bold text-sm uppercase italic tracking-tighter text-white">
                                    {{ $item->title }}
                                </td>
                                <td class="p-6">
                                    <span class="px-3 py-1 bg-red-600 text-white text-[9px] font-black uppercase rounded">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="p-6 text-gray-500 text-[10px] uppercase">
                                    {{ $item->created_at->format('d M Y') }}
                                </td>
                                <td class="p-6 text-right">
                                    <a href="{{ route('posts.show', $item->slug) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-red-600 transition shadow-sm" title="Preview Article">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>