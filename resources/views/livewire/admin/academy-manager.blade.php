<div class="space-y-8">
    @if (session()->has('message'))
        <div class="p-4 bg-green-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest animate-pulse">
            {{ session('message') }}
        </div>
    @endif

    {{-- FORM INPUT (BAGIAN ATAS) --}}
    <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-black p-8 rounded-[2rem] border border-white/5 shadow-2xl">
        <div class="space-y-4">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Course Title</label>
                <input wire:model="title" type="text" class="w-full bg-zinc-900 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-red-600 outline-none transition" placeholder="e.g. Lighting Unreal: Basic">
                @error('title') <span class="text-red-600 text-[9px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Category</label>
                <select wire:model="category" class="w-full bg-zinc-900 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-red-600 outline-none transition">
                    <option value="">Select Category</option>
                    <option value="LRC">LRC (Lighting/Render/Compose)</option>
                    <option value="Animation">Animation</option>
                </select>
                @error('category') <span class="text-red-600 text-[9px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Course Description</label>
                <textarea wire:model="description" rows="5" class="w-full bg-zinc-900 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-red-600 outline-none transition" placeholder="Describe what students will learn..."></textarea>
                @error('description') <span class="text-red-600 text-[9px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Price (IDR)</label>
                <input wire:model="price" type="number" class="w-full bg-zinc-900 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-red-600 outline-none transition" placeholder="150000">
                @error('price') <span class="text-red-600 text-[9px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Instructor Name</label>
                <input wire:model="instructor_name" type="text" class="w-full bg-zinc-900 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-red-600 outline-none transition" placeholder="Dawa'i Fathulwally">
                @error('instructor_name') <span class="text-red-600 text-[9px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Course Thumbnail</label>
                <div class="relative group">
                    <input type="file" wire:model="thumbnail" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="w-full bg-zinc-900 border-2 border-dashed border-white/10 rounded-xl p-6 text-center group-hover:border-red-600/50 transition">
                        @if ($thumbnail)
                            <img src="{{ $thumbnail->temporaryUrl() }}" class="mx-auto h-32 object-cover rounded-lg mb-2">
                            <p class="text-[10px] text-red-600 font-bold uppercase tracking-widest">Change Image</p>
                        @else
                            <svg class="mx-auto h-8 w-8 text-gray-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Click to Upload Thumbnail</p>
                        @endif
                    </div>
                </div>
                <div wire:loading wire:target="thumbnail" class="text-[10px] text-red-600 font-bold mt-2 uppercase animate-pulse">Uploading...</div>
                @error('thumbnail') <span class="text-red-600 text-[9px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="md:col-span-2">
            <button type="submit" wire:loading.attr="disabled" class="w-full bg-red-600 hover:bg-red-700 disabled:bg-red-900 text-white font-black uppercase text-[11px] tracking-[0.3em] py-4 rounded-xl transition shadow-lg shadow-red-900/20">
                <span wire:loading.remove wire:target="save">Publish New Academy</span>
                <span wire:loading wire:target="save">Processing...</span>
            </button>
        </div>
    </form>

    {{-- TABEL ACADEMY (BAGIAN BAWAH) --}}
    <div class="overflow-x-auto bg-zinc-900/30 rounded-[2rem] border border-white/5 shadow-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-[10px] uppercase tracking-widest text-gray-500 border-b border-white/5">
                    <th class="p-6">Thumbnail</th>
                    <th class="p-6">Course Details</th>
                    <th class="p-6 text-center border-x border-white/5">Price</th>
                    <th class="p-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($academies as $academy)
                <tr class="hover:bg-white/[0.02] transition group">
                    <td class="p-6">
                        @if($academy->thumbnail)
                            <img src="{{ asset('storage/' . $academy->thumbnail) }}" class="h-12 w-20 object-cover rounded-lg border border-white/10 group-hover:border-red-600/50 transition shadow-lg">
                        @else
                            <div class="h-12 w-20 bg-zinc-800 rounded-lg border border-white/10 flex items-center justify-center text-[8px] text-gray-600 font-black italic uppercase">No Img</div>
                        @endif
                    </td>
                    <td class="p-6">
                        <div class="flex flex-col">
                            <span class="text-red-600 text-[9px] font-black uppercase tracking-widest mb-1">{{ $academy->category }}</span>
                            <span class="font-bold text-sm text-white italic uppercase tracking-tighter leading-tight">{{ $academy->title }}</span>
                            <span class="text-[9px] text-gray-600 font-medium normal-case line-clamp-1 mt-1 italic tracking-widest">{{ $academy->instructor_name }}</span>
                        </div>
                    </td>
                    <td class="p-6 text-center border-x border-white/5">
                        <span class="text-red-600 font-black italic italic tracking-tighter text-lg">{{ number_format($academy->price/1000) }}K</span>
                    </td>
                    <td class="p-6 text-right">
                        <div class="flex justify-end items-center gap-2">
                            {{-- TOMBOL MANAGE QUIZ (NEW INDIGO) --}}
                            <a href="{{ route('admin.quiz.index', $academy->id) }}" 
                               class="bg-zinc-800 hover:bg-indigo-600 text-zinc-400 hover:text-white p-2.5 rounded-xl transition-all duration-300 border border-white/5 group/quiz"
                               title="Manage Quiz">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </a>

                            {{-- TOMBOL MANAGE CONTENT (BLUE) --}}
                            <a href="{{ route('admin.academies.content', $academy->id) }}" 
                               class="bg-zinc-800 hover:bg-blue-600 text-zinc-400 hover:text-white p-2.5 rounded-xl transition-all duration-300 border border-white/5 group/btn"
                               title="Manage Materials">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </a>

                            {{-- TOMBOL DELETE (RED) --}}
                            <button wire:click="delete({{ $academy->id }})" 
                                    wire:confirm="Are you sure you want to delete this course?"
                                    class="bg-zinc-800 hover:bg-red-600 text-red-600 hover:text-white p-2.5 rounded-xl transition-all duration-300 border border-white/5"
                                    title="Delete Course">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>