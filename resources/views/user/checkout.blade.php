<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | ARC MEDIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0a0a0a; font-family: 'Inter', sans-serif; color: white; }
        .font-black-italic { font-weight: 900; font-style: italic; }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex items-center justify-center px-6">
        <div class="max-w-md w-full bg-zinc-900 border border-white/5 p-10 rounded-[2.5rem] shadow-2xl">
            <div class="text-center mb-8">
                <span class="text-red-600 font-black-italic text-xl tracking-tighter">ARC</span>
                <span class="text-white font-bold text-xl tracking-tighter uppercase">MEDIA</span>
                <h2 class="mt-6 text-2xl font-black italic uppercase tracking-tighter">Secure Checkout</h2>
                <p class="text-zinc-500 text-[10px] uppercase tracking-[0.2em] mt-2">Complete your investment to start learning</p>
            </div>

            <div class="bg-black/40 rounded-2xl p-6 mb-8 border border-white/5">
                <p class="text-[9px] font-black text-zinc-500 uppercase tracking-widest mb-1">Course Selected</p>
                <h4 class="text-lg font-bold italic uppercase tracking-tighter">{{ $academy->title }}</h4>
                <div class="flex justify-between items-end mt-4">
                    <span class="text-zinc-500 text-[10px] uppercase">Total Investment</span>
                    <span class="text-red-600 text-2xl font-black-italic italic leading-none">IDR {{ number_format($academy->price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="space-y-4">
                <p class="text-[9px] font-black text-zinc-500 uppercase tracking-widest text-center">Transfer Bank (Manual Confirmation)</p>
                <div class="bg-white/5 p-5 rounded-2xl border border-white/10 text-center">
                    <p class="text-xs text-zinc-400">BCA Digital / Blu</p>
                    <p class="text-xl font-black tracking-widest mt-1">0812 3456 7890</p>
                    <p class="text-[9px] font-bold uppercase text-zinc-500 mt-2">A/N ARC MEDIA CREATIVE</p>
                </div>

                <form action="{{ route('checkout.store', $academy->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 text-white font-black py-4 rounded-xl uppercase hover:bg-green-700 transition">
                        Konfirmasi Pembayaran & Mulai Belajar
                    </button>
                </form>
                
                <a href="{{ route('user.home') }}" class="w-full block text-center text-zinc-600 hover:text-zinc-400 font-bold uppercase py-2 tracking-[0.2em] text-[8px] transition-all">
                    Cancel and Return
                </a>
            </div>
        </div>
    </div>
</body>
</html>