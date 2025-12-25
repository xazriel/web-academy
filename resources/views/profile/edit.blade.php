<!DOCTYPE html>
<html lang="en" x-data="{ status: '{{ old('occupation_status', $user->occupation_status ?? '') }}' }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complete Profile - ARC ACADEMY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* INI KUNCI KOTAK INPUTNYA - JANGAN DIUBAH */
        .brutalist-input {
            display: block !important;
            width: 100% !important;
            border: 4px solid black !important;
            background-color: white !important;
            padding: 1.25rem !important;
            font-weight: 900 !important;
            font-family: 'Inter', sans-serif !important;
            color: black !important;
            outline: none !important;
            transition: all 0.15s ease !important;
            border-radius: 0 !important;
            margin-top: 4px !important;
        }

        /* EFEK SAAT KOTAK DIKLIK */
        .brutalist-input:focus {
            background-color: #ffd628 !important;
            box-shadow: 8px 8px 0px 0px black !important;
            transform: translate(-4px, -4px) !important;
        }

        /* INPUT KHUSUS EMAIL (READ ONLY) */
        .brutalist-input:read-only {
            background-color: #eeeeee !important;
            border-style: dashed !important;
            cursor: not-allowed !important;
            opacity: 0.7;
        }

        /* LABEL DI ATAS KOTAK */
        .brutalist-label {
            display: block !important;
            font-size: 12px !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.15em !important;
            color: black !important;
            margin-left: 4px !important;
        }

        /* STYLING DROPDOWN/SELECT */
        select.brutalist-input {
            appearance: none !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='black'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='4' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 1.5rem center !important;
            background-size: 1.2em !important;
        }

        /* TEXTAREA */
        textarea.brutalist-input {
            min-height: 120px !important;
            resize: vertical !important;
        }
    </style>
</head>
<body class="bg-[#f0f0f0] py-20 px-6 font-['Inter'] antialiased">

    <div class="max-w-4xl mx-auto">
        <div class="mb-20 border-b-[10px] border-black pb-10">
            <h1 class="text-7xl md:text-9xl font-black italic uppercase tracking-tighter leading-[0.8]">
                EDIT <br> <span class="text-arc-blue">PROFILE</span>
            </h1>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-20">
            @csrf
            @method('PATCH')

            <div class="bg-white border-8 border-black shadow-[20px_20px_0_#000] p-12">
                <h2 class="bg-black text-white px-8 py-3 inline-block font-black uppercase italic text-xl mb-12 -rotate-1 shadow-[6px_6px_0_#2227f7]">
                    01. Personal Data
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="md:col-span-2 flex flex-col md:row items-center gap-10 p-8 border-4 border-black bg-gray-50 mb-4">
                        <div class="w-40 h-40 border-8 border-black bg-arc-yellow shadow-[10px_10px_0_#000] overflow-hidden">
                            <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.Auth::user()->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 w-full text-center md:text-left">
                            <label class="brutalist-label mb-4">Update Profile Photo</label>
                            <input type="file" name="photo" class="font-black text-sm uppercase cursor-pointer">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="brutalist-label">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="brutalist-input" placeholder="WAKIDUN KLONTONG">
                    </div>

                    <div class="space-y-2">
                        <label class="brutalist-label">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="brutalist-input" placeholder="wakidun_99">
                    </div>

                    <div class="space-y-2">
                        <label class="brutalist-label">Email Address (Locked)</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="brutalist-input" readonly>
                    </div>

                    <div class="space-y-2">
                        <label class="brutalist-label">WhatsApp No.</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="brutalist-input" placeholder="08123456789">
                    </div>

                    <div class="space-y-2">
                        <label class="brutalist-label">Gender</label>
                        <select name="gender" class="brutalist-input">
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="brutalist-label">Birth Date</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" class="brutalist-input">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="brutalist-label">Current City</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}" class="brutalist-input" placeholder="YOGYAKARTA, INDONESIA">
                    </div>
                </div>
            </div>

            <div class="bg-white border-8 border-black shadow-[20px_20px_0_#2227f7] p-12">
                <h2 class="bg-arc-blue text-white px-8 py-3 inline-block font-black uppercase italic text-xl mb-12 -rotate-1 shadow-[6px_6px_0_#000]">
                    02. Occupation
                </h2>

                <div class="space-y-12">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <template x-for="item in ['Pelajar', 'Mahasiswa', 'Pekerja', 'Freelancer']">
                            <button type="button" @click="status = item"
                                :class="status === item ? 'bg-arc-yellow shadow-none translate-x-2 translate-y-2' : 'bg-white shadow-[8px_8px_0_#000]'"
                                class="border-4 border-black py-6 font-black uppercase text-sm transition-all flex items-center justify-center">
                                <span x-text="item"></span>
                            </button>
                        </template>
                    </div>
                    <input type="hidden" name="occupation_status" :value="status">

                    <div x-show="status" x-transition class="p-10 border-4 border-black bg-gray-50 space-y-8 shadow-[10px_10px_0_#000]">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div x-show="status === 'Pelajar' || status === 'Mahasiswa'" class="space-y-2">
                                <label class="brutalist-label" x-text="status === 'Pelajar' ? 'Nama Sekolah' : 'Nama Kampus'"></label>
                                <input type="text" name="institution_name" class="brutalist-input">
                            </div>
                            <div x-show="status === 'Mahasiswa'" class="space-y-2">
                                <label class="brutalist-label">Program Studi</label>
                                <input type="text" name="major" class="brutalist-input">
                            </div>
                            <div x-show="status === 'Pekerja' || status === 'Freelancer'" class="space-y-2">
                                <label class="brutalist-label">Company / Studio</label>
                                <input type="text" name="company_name" class="brutalist-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border-8 border-black shadow-[20px_20px_0_#ffd628] p-12">
                <h2 class="bg-arc-yellow text-black px-8 py-3 inline-block font-black uppercase italic text-xl mb-12 -rotate-1 shadow-[6px_6px_0_#000]">
                    03. Professional
                </h2>
                <div class="space-y-10">
                    <div class="space-y-2">
                        <label class="brutalist-label">Tell About You</label>
                        <textarea name="about_me" class="brutalist-input" placeholder="I am a 3D artist..."></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="brutalist-label">Portfolio URL</label>
                        <input type="url" name="portfolio_link" class="brutalist-input" placeholder="https://artstation.com/username">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pb-32">
                <button type="submit" class="w-full md:w-auto bg-black text-white font-black text-4xl uppercase px-20 py-10 border-4 border-black shadow-[15px_15px_0_#ffd628] hover:shadow-none hover:translate-x-4 hover:translate-y-4 transition-all active:scale-95">
                    SAVE CHANGES →
                </button>
            </div>
        </form>
    </div>

</body>
</html>