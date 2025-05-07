<title>@yield('title', 'Dashboard')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-creamy text-black">
<x-app-layout>
    <div class="flex h-screen">
        @include('components.sidebar-kepsek')

        <main class="flex-1 p-10 overflow-auto">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-bold mb-6">Data Penilaian</h1>

                <form method="POST" action="{{ route('kepsek.penilaian.store') }}">
                    @csrf
                    <input type="hidden" name="guru_id" value="{{ $guru->id }}">

                    <div class="space-y-4">
                        <!-- Nama Guru -->
                        <div>
                            <label class="block font-semibold text-lg mb-1">Nama Guru</label>
                            <input type="text" value="{{ $guru->user->name }}" disabled
                                   class="w-full bg-white text-black rounded-lg px-4 py-2 cursor-not-allowed" />
                        </div>

                        <!-- Jabatan -->
                        <div>
                            <label class="block font-semibold text-lg mb-1">Jabatan</label>
                            <input type="text" value="{{ $guru->jabatan }}" disabled
                                   class="w-full bg-white text-black rounded-lg px-4 py-2 cursor-not-allowed" />
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
                                @for ($i = 1; $i <= 4; $i++)
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="nilai[{{ $item->id }}]" value="{{ $i }}" required
                                        {{ isset($nilaiSebelumnya[$item->id]) && $nilaiSebelumnya[$item->id] == $i ? 'checked' : '' }}>
                                    <span>{{ $i }}</span>
                                </label>
                            @endfor
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Tombol -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('kepsek.penilaian.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 px-6 py-2 rounded-lg">Batal</a>
                        <button type="submit" class="bg-sidebar hover:bg-thead text-black font-semibold px-6 py-2 rounded-lg">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
</body>
