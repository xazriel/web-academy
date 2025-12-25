<div class="space-y-8">
    @if (session()->has('message'))
        <div class="bg-green-600/20 border border-green-600 text-green-400 p-4 rounded-lg mb-6 transition-all shadow-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-zinc-900 p-6 rounded-xl border border-white/5 shadow-xl">
        <h2 class="text-xl font-bold text-white mb-6 flex items-center">
            <span class="w-2 h-6 bg-red-600 rounded-full mr-3"></span>
            Create New Post
        </h2>

        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-2 font-bold">Judul Berita</label>
                <input type="text" wire:model="title" placeholder="Masukkan judul menarik..." 
                    class="w-full bg-black border border-white/10 rounded-xl p-3 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-all">
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-2 font-bold">Isi Berita</label>
                <textarea wire:model="content" rows="6" placeholder="Tulis konten berita di sini..." 
                    class="w-full bg-black border border-white/10 rounded-xl p-3 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-all"></textarea>
                @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="bg-black/50 p-4 rounded-xl border border-dashed border-white/10">
                <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-3 font-bold">Thumbnail Image</label>
                <input type="file" wire:model="thumbnail" class="text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700 cursor-pointer">
                <div wire:loading wire:target="thumbnail" class="text-xs text-red-500 mt-2 italic">Uploading...</div>
                @error('thumbnail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" wire:loading.attr="disabled" class="bg-red-600 hover:bg-red-700 text-white font-black py-3 px-10 rounded-full transition-all uppercase text-xs tracking-widest shadow-[0_10px_20px_rgba(220,38,38,0.3)] disabled:opacity-50">
                    <span wire:loading.remove wire:target="save text-white">Publish Post</span>
                    <span wire:loading wire:target="save text-white">Processing...</span>
                </button>
            </div>
        </form>
    </div>

    <div class="bg-zinc-900 p-6 rounded-xl border border-white/5 shadow-xl">
        <h3 class="text-gray-400 text-[10px] uppercase tracking-widest font-bold mb-4">Recent Posts</h3>
        <div class="overflow-hidden rounded-xl border border-white/5">
            <table class="w-full text-left text-sm text-gray-300">
                <thead class="bg-white/5 text-[10px] uppercase tracking-wider text-gray-400">
                    <tr>
                        <th class="p-4">Title</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($posts as $post)
                    <tr class="hover:bg-white/[0.02] transition">
                        <td class="p-4">
                            <div class="font-medium text-white">{{ $post->title }}</div>
                            <div class="text-[10px] text-gray-500 uppercase mt-1">{{ $post->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2 py-1 bg-green-500/10 text-green-500 text-[10px] rounded-full uppercase font-bold">
                                {{ $post->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <button 
                                onclick="confirm('Yakin ingin menghapus berita ini?') || event.stopImmediatePropagation()"
                                wire:click="delete({{ $post->id }})" 
                                class="text-gray-500 hover:text-red-600 transition p-2"
                                title="Hapus Berita">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-600 italic text-xs">Belum ada berita yang diterbitkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>