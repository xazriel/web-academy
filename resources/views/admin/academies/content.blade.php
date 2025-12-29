<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Manager - {{ $academy->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        trix-toolbar { background: #f8fafc; border: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; }
        trix-editor { background: #f8fafc; border: 1px solid #e2e8f0 !important; border-top: none !important; border-radius: 0 0 12px 12px !important; min-height: 150px !important; }
        trix-toolbar [data-trix-button-group="file-tools"] { display: none !important; }
        .sortable-ghost { opacity: 0.4; background-color: #eef2ff !important; border: 2px dashed #6366f1 !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

    <div class="p-10 min-h-screen">
        <div class="max-w-6xl mx-auto">
            
            <a href="{{ route('admin.academies.index') }}" class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 inline-block hover:text-indigo-600 transition">← Kembali</a>
            
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 uppercase italic">Kelola Konten: {{ $academy->title }}</h1>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Struktur Kurikulum & Materi (Drag to Reorder)</p>
                </div>
                <button onclick="document.getElementById('modalChapter').classList.remove('hidden')" class="bg-white text-indigo-600 border-2 border-indigo-600 px-6 py-2 rounded-full font-black text-xs uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                    + Tambah Bab
                </button>
            </div>

            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl text-sm font-bold flex items-center gap-3">
                    <span class="bg-emerald-500 text-white rounded-full p-1 text-[10px]">✓</span>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <div class="lg:col-span-5">
                    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200 sticky top-10">
                        <h2 class="font-bold text-lg mb-6 uppercase tracking-tight text-slate-800">Tambah Sub-Materi</h2>
                        
                        <form action="{{ route('admin.lessons.store', $academy->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Pilih Bab</label>
                                <select name="chapter_id" class="w-full p-4 bg-slate-50 rounded-xl border-none focus:ring-2 focus:ring-indigo-500 font-semibold text-slate-700 appearance-none" required>
                                    <option value="" disabled selected>-- Pilih Bab --</option>
                                    @foreach($academy->chapters as $chapter)
                                        <option value="{{ $chapter->id }}">BAB {{ $chapter->order }}: {{ $chapter->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Judul Materi</label>
                                <input type="text" name="title" class="w-full p-4 bg-slate-50 rounded-xl border-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Pengenalan Dasar" required>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Video URL (YouTube) - <span class="lowercase italic">Opsional</span></label>
                                <input type="url" name="video_url" class="w-full p-4 bg-slate-50 rounded-xl border-none focus:ring-2 focus:ring-indigo-500" placeholder="https://www.youtube.com/watch?v=...">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Isi Materi</label>
                                <input id="lesson_content" type="hidden" name="content">
                                <trix-editor input="lesson_content" class="bg-slate-50"></trix-editor>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 text-white font-black py-4 rounded-xl uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-md shadow-indigo-200">
                                Simpan Materi
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="space-y-6">
                        <h3 class="font-bold uppercase text-slate-400 text-xs tracking-widest ml-2">Struktur Kurikulum</h3>
                        
                        @if($academy->chapters->isEmpty())
                            <div class="bg-white border-2 border-dashed border-slate-200 rounded-[2rem] py-20 text-center">
                                <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Belum ada bab.</p>
                            </div>
                        @else
                            @foreach($academy->chapters as $chapter)                        
                                <div class="bg-white border border-slate-200 rounded-[2rem] shadow-sm overflow-hidden">
                                    <div class="bg-slate-50/50 px-8 py-5 flex justify-between items-center border-b border-slate-100">
                                        <h3 class="font-black uppercase text-sm tracking-tight text-slate-700">
                                            <span class="text-indigo-600 mr-2">BAB {{ $chapter->order }}:</span> {{ $chapter->title }}
                                        </h3>
                                        <form action="{{ route('admin.chapters.destroy', $chapter->id) }}" method="POST" onsubmit="return confirm('Hapus bab ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[10px] font-bold text-slate-300 hover:text-red-500 uppercase transition">Hapus Bab</button>
                                        </form>
                                    </div>
                                    
                                    <div class="divide-y divide-slate-50 sortable-container" data-chapter-id="{{ $chapter->id }}">
                                        @forelse($chapter->lessons()->orderBy('order', 'asc')->get() as $lesson)
                                            <div class="px-8 py-5 flex justify-between items-center hover:bg-slate-50/50 transition group cursor-move" data-id="{{ $lesson->id }}">
                                                <div class="flex items-center gap-4">
                                                    <svg class="w-4 h-4 text-slate-300 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                                                    <span class="w-6 h-6 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black italic lesson-order-text">{{ $lesson->order }}</span>
                                                    <div>
                                                        <h4 class="text-sm font-bold text-slate-700 group-hover:text-indigo-600 transition">{{ $lesson->title }}</h4>
                                                        @if($lesson->video_url)
                                                            <span class="text-[9px] bg-red-100 text-red-600 px-2 py-0.5 rounded font-bold uppercase tracking-tighter">Video</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <button onclick="openEditModal({{ $lesson->id }})" class="text-[10px] font-black uppercase text-indigo-400 hover:text-indigo-700 transition">Edit</button>
                                                    <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-[10px] font-black uppercase text-slate-300 hover:text-red-500 transition">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="p-10 text-center no-lessons-placeholder">
                                                <p class="text-slate-300 text-[10px] font-bold uppercase italic tracking-widest text-center">Belum ada materi</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalChapter" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-6">
        <div class="bg-white p-10 rounded-[2.5rem] max-w-sm w-full shadow-2xl border border-slate-100">
            <h2 class="text-2xl font-black uppercase italic mb-6 text-slate-900">Buat Bab Baru</h2>
            <form action="{{ route('admin.chapters.store', $academy->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Nama Bab</label>
                    <input type="text" name="title" class="w-full p-4 bg-slate-50 rounded-xl border-none focus:ring-2 focus:ring-indigo-500 shadow-inner" placeholder="Contoh: Dasar Dasar Kopi" required>
                </div>
                <div class="flex flex-col gap-2 pt-4">
                    <button type="submit" class="bg-indigo-600 text-white font-black py-4 rounded-xl uppercase tracking-widest hover:bg-indigo-700 transition shadow-md shadow-indigo-100">Buat Bab</button>
                    <button type="button" onclick="document.getElementById('modalChapter').classList.add('hidden')" class="text-slate-400 text-xs font-bold uppercase py-2 hover:text-slate-600 transition">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditLesson" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center z-[100] p-6">
        <div class="bg-white p-10 rounded-[2.5rem] max-w-2xl w-full shadow-2xl border border-slate-100 overflow-y-auto max-h-[90vh]">
            <h2 class="text-2xl font-black uppercase italic mb-6 text-indigo-600">Edit Materi</h2>
            <form id="formEditLesson" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Judul Materi</label>
                    <input type="text" name="title" id="edit_title" class="w-full p-4 bg-slate-50 rounded-xl border-none focus:ring-2 focus:ring-indigo-500 shadow-inner" required>
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Video URL (YouTube)</label>
                    <input type="url" name="video_url" id="edit_video_url" class="w-full p-4 bg-slate-50 rounded-xl border-none focus:ring-2 focus:ring-indigo-500 shadow-inner">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Isi Konten</label>
                    <input id="edit_content_input" type="hidden" name="content">
                    <trix-editor input="edit_content_input" id="edit_trix" class="bg-slate-50"></trix-editor>
                </div>
                <div class="flex gap-4 pt-6">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white font-black py-4 rounded-xl uppercase tracking-widest hover:bg-indigo-700 transition shadow-md shadow-indigo-100">Update Materi</button>
                    <button type="button" onclick="closeEditModal()" class="px-6 text-slate-400 text-xs font-bold uppercase hover:text-slate-600 transition">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.sortable-container').forEach(container => {
            new Sortable(container, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: function (evt) {
                    let lessonIds = [];
                    container.querySelectorAll('[data-id]').forEach(el => {
                        lessonIds.push(el.dataset.id);
                    });

                    container.querySelectorAll('.lesson-order-text').forEach((el, index) => {
                        el.innerText = index + 1;
                    });

                    fetch("{{ route('admin.lessons.reorder') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ ids: lessonIds })
                    })
                    .then(response => response.json())
                    .then(data => console.log('Order updated'));
                }
            });
        });

        function openEditModal(lessonId) {
            const modal = document.getElementById('modalEditLesson');
            const form = document.getElementById('formEditLesson');
            form.action = `/admin/lessons/${lessonId}`;

            fetch(`/admin/lessons/${lessonId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_title').value = data.title;
                    document.getElementById('edit_video_url').value = data.video_url || '';
                    const trixEditor = document.querySelector("#edit_trix");
                    trixEditor.editor.loadHTML(data.content || "");
                    modal.classList.remove('hidden');
                });
        }

        function closeEditModal() {
            document.getElementById('modalEditLesson').classList.add('hidden');
        }

        window.onclick = function(event) {
            if (event.target.id && event.target.id.includes('modal')) {
                event.target.classList.add('hidden');
            }
        }
    </script>
</body>
</html>