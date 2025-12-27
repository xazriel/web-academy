<div class="p-10 bg-[#f8f9fa] min-h-screen">
    <a href="{{ url()->previous() }}" class="font-black uppercase text-sm mb-4 inline-block hover:underline">← Kembali</a>
    
    <h1 class="text-4xl font-black italic uppercase mb-10">
        ADD LESSON TO: <span class="text-arc-blue">{{ $chapter->title }}</span>
    </h1>

    <div class="max-w-4xl bg-white border-8 border-black p-8 shadow-[15px_15px_0_#000]">
        <form action="{{ route('admin.lessons.store', $chapter->id) }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block font-black uppercase mb-2">Lesson Title</label>
                <input type="text" name="title" class="w-full border-4 border-black p-4 focus:bg-arc-yellow outline-none font-bold" required placeholder="Contoh: Mengenal Machine Learning">
            </div>

            <div class="mb-6">
                <label class="block font-black uppercase mb-2">Video URL (YouTube/Vimeo)</label>
                <input type="url" name="video_url" class="w-full border-4 border-black p-4 focus:bg-arc-yellow outline-none font-bold" placeholder="https://youtube.com/watch?v=...">
            </div>

            <div class="mb-6">
                <label class="block font-black uppercase mb-2">Materi (Text Content)</label>
                <textarea name="content" rows="10" class="w-full border-4 border-black p-4 focus:bg-arc-yellow outline-none font-bold" placeholder="Tulis isi materi di sini..."></textarea>
            </div>

            <button type="submit" class="w-full bg-arc-blue text-white font-black py-5 uppercase text-xl hover:bg-black transition-all border-4 border-black shadow-[8px_8px_0_#ffd628]">
                PUBLISH LESSON 👍
            </button>
        </form>
    </div>
</div>