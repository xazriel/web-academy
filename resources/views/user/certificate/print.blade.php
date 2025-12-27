<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - {{ $academy->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;700;900&display=swap');

        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                margin: 0;
            }
            .no-print { display: none !important; }
            @page {
                size: landscape;
                margin: 0;
            }
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .cert-container {
            width: 297mm; /* Lebar A4 Landscape */
            height: 210mm; /* Tinggi A4 Landscape */
            margin: 0 auto;
        }
    </style>
</head>
<body class="bg-slate-500 py-10">

    <div class="no-print max-w-[297mm] mx-auto mb-6 flex justify-between items-center px-4">
        <a href="{{ url()->previous() }}" class="text-white font-bold flex items-center gap-2">
            <span>←</span> Kembali
        </a>
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-black shadow-2xl transition-all">
            DOWNLOAD / PRINT SERTIFIKAT
        </button>
    </div>

    <div class="cert-container bg-white shadow-2xl relative overflow-hidden flex items-center justify-center border-[20px] border-indigo-600">
        
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-50 rounded-full -ml-32 -mb-32"></div>

        <div class="w-[calc(100%-40px)] h-[calc(100%-40px)] border-2 border-indigo-100 p-16 flex flex-col items-center justify-center text-center">
            
            <div class="mb-6">
                <span class="text-indigo-600 font-black tracking-[0.5em] uppercase text-sm italic">Official Certificate</span>
            </div>

            <h2 class="text-slate-400 font-bold uppercase tracking-widest text-xs mb-10">Sertifikat ini diberikan kepada:</h2>
            
            <h1 class="text-7xl font-serif text-slate-900 mb-4">{{ auth()->user()->name }}</h1>
            <div class="w-48 h-1.5 bg-indigo-600 mb-10"></div>

            <p class="text-2xl text-slate-600 max-w-3xl leading-relaxed">
                Telah dinyatakan lulus dan menyelesaikan seluruh kurikulum pelatihan pada program <br>
                <span class="text-indigo-900 font-black uppercase italic">{{ $academy->title }}</span>
            </p>

            <div class="mt-20 flex justify-between items-end w-full px-20">
                <div class="text-center">
                    <p class="font-black text-slate-900 border-b-2 border-slate-300 pb-2 px-6">
                        {{ now()->format('d F Y') }}
                    </p>
                    <p class="text-[10px] font-black text-slate-400 mt-2 uppercase tracking-widest">Tanggal Terbit</p>
                </div>

                <div class="relative flex items-center justify-center">
                    <div class="h-28 w-28 bg-indigo-600 rounded-full flex items-center justify-center border-8 border-indigo-50 shadow-xl relative z-10 rotate-12">
                        <span class="text-white font-black text-3xl italic">ARC</span>
                    </div>
                    <div class="absolute w-32 h-32 border-2 border-dashed border-indigo-200 rounded-full animate-spin-slow"></div>
                </div>

                <div class="text-center">
                    <p class="font-black text-slate-900 border-b-2 border-slate-300 pb-2 px-6 italic font-serif text-lg">
                        Admin ARC Academy
                    </p>
                    <p class="text-[10px] font-black text-slate-400 mt-2 uppercase tracking-widest">Otoritas Penyelenggara</p>
                </div>
            </div>

            <div class="absolute bottom-10 flex justify-between w-full px-16 text-[9px] font-mono text-slate-300 italic uppercase">
                <span>Certificate ID: ARC-{{ strtoupper(Str::random(8)) }}</span>
                <span>arc-academy.io/verification</span>
            </div>
        </div>
    </div>

</body>
</html>