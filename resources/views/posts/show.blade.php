<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - ARC MEDIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { background-color: black; color: white; }</style>
</head>
<body class="antialiased">
    <nav class="p-6 border-b border-white/5">
        <a href="/" class="text-red-600 font-black text-xl tracking-tighter uppercase">← Back to Home</a>
    </nav>

    <main class="max-w-4xl mx-auto px-6 py-20">
        <header class="mb-12">
            <p class="text-red-600 font-bold uppercase tracking-widest text-xs mb-4">Published {{ $post->created_at->format('d M Y') }}</p>
            <h1 class="text-4xl md:text-6xl font-black italic tracking-tighter leading-tight uppercase">{{ $post->title }}</h1>
        </header>

        @if($post->thumbnail)
        <div class="rounded-3xl overflow-hidden mb-12 border border-white/10">
            <img src="{{ asset('storage/' . $post->thumbnail) }}" class="w-full h-auto object-cover">
        </div>
        @endif

        <article class="prose prose-invert max-w-none text-gray-300 leading-relaxed text-lg">
            {!! nl2br(e($post->content)) !!}
        </article>
    </main>
</body>
</html>