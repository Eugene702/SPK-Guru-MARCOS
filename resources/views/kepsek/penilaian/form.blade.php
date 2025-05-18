<title>@yield('title', 'Dashboard')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-creamy text-black">
<x-app-layout>
    <div class="flex h-screen">
        @include('components.sidebar-kepsek')

        <main class="flex-1 p-10 overflow-auto min-h-screen">
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg">
                <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Form Penilaian Guru</h1>

                <form method="POST" action="{{ route('kepsek.penilaian.store') }}">
                    @csrf
                    <input type="hidden" name="guru_id" value="{{ $guru->id }}">

                    <!-- Info Guru -->
                    <div class="flex gap-6 mb-6">
                        <!-- Nama Guru -->
                        <div class="w-1/2">
                            <label class="block font-semibold text-gray-700 mb-1">Nama Guru</label>
                            <input type="text" value="{{ $guru->user->name }}" disabled
                                class="w-full bg-gray-100 text-gray-800 rounded-lg px-4 py-2 border border-gray-300 cursor-not-allowed" />
                        </div>

                        <!-- Jabatan -->
                        <div class="w-1/2">
                            <label class="block font-semibold text-gray-700 mb-1">Jabatan</label>
                            <input type="text" value="{{ $guru->jabatan }}" disabled
                                class="w-full bg-gray-100 text-gray-800 rounded-lg px-4 py-2 border border-gray-300 cursor-not-allowed" />
                        </div>
                    </div>

                    <!-- Judul Kuesioner -->
                    <div class="text-lg text-orange-800 font-semibold mb-6">
                        Berikut kuesioner penilaian guru oleh kepala sekolah:
                    </div>

                    <!-- Pernyataan -->
                    @foreach ($pernyataan as $item)
                    <div class="bg-gray-50 rounded-xl px-5 py-4 border border-gray-300 shadow-sm flex justify-between items-center mb-4">
                        <!-- Kolom Pernyataan -->
                        <div class="w-2/3">
                            <label class="block font-medium text-gray-800">{{ $item->pernyataan }}</label>
                        </div>

                        <!-- Kolom Radio Button -->
                        <div class="w-1/3 flex justify-end space-x-4">
                            @for ($i = 1; $i <= 4; $i++)
                            <label class="flex items-center space-x-1 text-gray-700">
                                <input type="radio" name="nilai[{{ $item->id }}]" value="{{ $i }}" required
                                    {{ isset($nilaiSebelumnya[$item->id]) && $nilaiSebelumnya[$item->id] == $i ? 'checked' : '' }}
                                    class="accent-orange-500">
                                <span>{{ $i }}</span>
                            </label>
                            @endfor
                        </div>
                    </div>
                    @endforeach

                    <!-- Tombol Aksi -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('kepsek.penilaian.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 px-6 py-2 rounded-lg transition duration-200">
                            Batal
                        </a>
                        <button type="submit"
                                class="bg-sidebar hover:bg-thead px-6 py-2 rounded-lg transition duration-200">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
</body>
