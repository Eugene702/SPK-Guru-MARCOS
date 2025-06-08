<title>@yield('title', 'Form Penilaian Guru oleh Rekan Sejawat')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-creamy text-black">
<x-app-layout>
    <div class="flex h-screen">
     
        <main class="flex-1 p-10 overflow-auto">
            <div class="max-w-5xl mx-auto bg-[#ffd5805d] p-8 rounded-xl shadow-lg">
                <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Form Penilaian Guru</h1>

                <form method="POST" action="{{ route('guru.penilaian.store') }}">
                    @csrf

                    @if(isset($nilaiSebelumnya) && !empty($nilaiSebelumnya))
                        @method('PUT')
                    @endif

                    <input type="hidden" name="guru_id" value="{{ $guru->id }}">

                    <div class="flex gap-6 mb-6">
                        <div class="w-1/2">
                        <!-- Nama Guru -->
                            <label class="block font-semibold text-lg mb-1">Nama Guru</label>
                            <input type="text" value="{{ $guru->user->name }}" disabled
                                   class="w-full bg-white text-black rounded-lg px-4 py-2 cursor-not-allowed" />
                        </div>

                        <!-- Jabatan -->
                        <div class="w-1/2">
                            <label class="block font-semibold text-lg mb-1">Jabatan</label>
                            <input type="text" value="{{ $guru->jabatan }}" disabled
                                   class="w-full bg-white text-black rounded-lg px-4 py-2 cursor-not-allowed" />
                        </div>
                    </div>

                    <!-- Judul Kuesioner -->
                    <div class="text-lg text-orange-800 font-semibold mb-6">
                        Berikut kuesioner penilaian guru oleh rekan sejawat:
                    </div>

                        <!-- Pernyataan -->
                        @foreach ($pernyataan as $item)
                        <div class="bg-white rounded-lg px-4 py-3 border border-gray-400 flex justify-between items-center mb-4">
                            <!-- Kolom Pernyataan -->
                            <div class="w-2/3">
                                <label class="block font-medium text-black">{{ $item->pernyataan }}</label>
                            </div>

                            <!-- Kolom Radio Button -->
                            <div class="w-1/3 flex justify-end space-x-4">
                                @for ($i = 0; $i <= 2; $i++)
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="nilai[{{ $item->id }}]" value="{{ $i }}" required
                                        {{ isset($nilaiSebelumnya[$item->id]) && $nilaiSebelumnya[$item->id] == $i ? 'checked' : '' }}>
                                    <span>{{ $i }}</span>
                                </label>
                            @endfor
                            </div>
                        </div>
                        @endforeach

                    <!-- Tombol -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('guru.penilaian.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">Batal</a>
                        <button type="submit" class="bg-sidebar hover:bg-thead text-black px-4 py-2 rounded-lg">
                            {{-- Logika untuk mengubah teks tombol --}}
                            @if(isset($nilaiSebelumnya) && !empty($nilaiSebelumnya))
                                Simpan Perubahan
                            @else
                                Simpan
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
</body>
