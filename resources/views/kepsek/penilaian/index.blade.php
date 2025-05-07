<title>@yield('title', 'Data Penilaian')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="text-black bg-creamy">
    <x-app-layout>
        <div class="flex h-screen">
            @include('components.sidebar-kepsek')

            {{-- Konten lainnya disini --}}
            <main class="flex-1 p-10 overflow-auto">
                <h1 class="text-2xl font-bold mb-6">Daftar Guru untuk Dinilai</h1>

                {{-- Tabel Start --}}
                <div class="overflow-x-auto shadow rounded-lg">
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
                            $penilaian = $guru->penilaianOlehKepalaSekolah()
                                ->where('kepala_sekolah_id', auth()->user()->guru->id)
                                ->first();
                            @endphp
                            <tr class="text-center">
                                {{-- Nomor --}}
                                <td class="px-6 py-4 border">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 border">{{ $guru->user->name }}</td>
                                <td class="px-6 py-4 border">
                                    @if ($penilaian)
                                        {{ number_format($penilaian->nilai_akhir, 2) }}%
                                    @else
                                        <span class="text-gray-400 italic">Belum dinilai</span>
                                    @endif
                                </td>
                                {{-- Aksi --}}
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
                                {{-- Aksi End --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Tabel End --}}
            </main>
        </div>
    </x-app-layout>
</body>
