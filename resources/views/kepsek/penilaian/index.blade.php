<title>@yield('title', 'Data Penilaian')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="text-black bg-creamy">
    <x-app-layout>
        <div class="flex h-screen">

            <main class="flex-1 p-10 overflow-auto">
                <div class="mb-10">
                    <div class="max-w-6xl mx-auto text-gray-800 text-center rounded-xl shadow-md p-6 bg-[#ffd480]">
                        <h2 class="text-3xl font-bold mb-2">📋 Penilaian Guru oleh Kepala Sekolah</h2>
                        <p class="text-md">
                            Selamat datang di halaman penilaian guru. Di sini, Anda dapat memberikan evaluasi secara objektif terhadap performa guru dalam aspek supervisi di kelas.
                            <br>
                            <span class="font-semibold">✨ Tujuan utama penilaian ini adalah untuk meningkatkan kualitas pendidikan melalui apresiasi dan pengembangan berkelanjutan.</span>
                        </p>
                    </div>
                </div>

                {{-- Tabel Start --}}
                <div class="overflow-x-auto max-w-6xl mx-auto bg-white shadow-xl rounded-xl p-6">
                    <p class="text-center mb-4">Silakan isi penilaian berdasarkan kuesioner yang tersedia.</p>
                    <div class="text-xl font-bold mb-4">Data yang belum ternilai</div>
                    <table class="min-w-full table-auto border border-gray-200">
                        <thead class="bg-thead">
                            <tr>
                                <th class="px-6 py-3 border">No</th>
                                <th class="px-6 py-3 border">Nama Guru</th>
                                <th class="px-6 py-3 border">Nilai</th>
                                <th class="px-6 py-3 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($gurus as $index => $guru)
                                @php
                                    $penilaian = $guru
                                        ->penilaianOlehKepalaSekolah()
                                        ->where('kepala_sekolah_id', auth()->user()->guru->id)
                                        ->whereYear('created_at', now()->year)
                                        ->first();

                                    if ($penilaian != null) {
                                        continue;
                                    }
                                @endphp
                                <tr class="text-center">
                                    <td class="px-6 py-4 border">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 border">{{ $guru->user->name }}</td>
                                    <td class="px-6 py-4 border">
                                        @if ($penilaian)
                                            {{ number_format($penilaian->nilai_akhir, 2) }}%
                                        @else
                                            <span class="text-gray-400 italic">Belum dinilai</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 border">
                                        @if ($penilaian)
                                            <a href="{{ route('kepsek.penilaian.form', $guru->id) }}"
                                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded transition">
                                                Edit
                                            </a>
                                        @else
                                            <a href="{{ route('kepsek.penilaian.form', $guru->id) }}"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                                                Nilai
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                

                <div class="overflow-x-auto shadow rounded-lg mt-10">
                    <h1 class="text-xl font-bold mb-4">Data yang sudah ternilai</h1>
                    <table class="min-w-full table-auto border border-gray-200">
                        <thead class="bg-thead">
                            <tr>
                                <th class="px-6 py-3 border">No</th>
                                <th class="px-6 py-3 border">Nama Guru</th>
                                <th class="px-6 py-3 border">Nilai</th>
                                <th class="px-6 py-3 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($gurus as $index => $guru)
                                @php
                                    $penilaian = $guru
                                        ->penilaianOlehKepalaSekolah()
                                        ->where('kepala_sekolah_id', auth()->user()->guru->id)
                                        ->whereYear('created_at', now()->year)
                                        ->first();

                                    if ($penilaian == null) {
                                        continue;
                                    }
                                @endphp
                                <tr class="text-center">
                                    <td class="px-6 py-4 border">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 border">{{ $guru->user->name }}</td>
                                    <td class="px-6 py-4 border">
                                        @if ($penilaian)
                                            {{ number_format($penilaian->nilai_akhir, 2) }}%
                                        @else
                                            <span class="text-gray-400 italic">Belum dinilai</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 border">
                                        @if ($penilaian)
                                            <a href="{{ route('kepsek.penilaian.form', $guru->id) }}"
                                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded transition">
                                                Edit
                                            </a>
                                        @else
                                            <a href="{{ route('kepsek.penilaian.form', $guru->id) }}"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                                                Nilai
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-10 text-center text-sm italic text-gray-500">
                        "Penilaian bukan sekadar angka, tapi cerminan dedikasi dan kontribusi untuk masa depan yang
                        lebih baik."
                    </div>
            </div>
            </main>
        </div>
    </x-app-layout>
</body>
