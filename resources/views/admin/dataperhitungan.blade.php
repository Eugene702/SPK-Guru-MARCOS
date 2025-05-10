<title>@yield('title', 'Data Perhitungan')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-white text-black">
    <x-app-layout>
        <div class="flex min-h-screen">
            @include('components.sidebar-admin')

            <!-- Konten dashboard lainnya di sini -->
            <main class="flex-1 p-10">
                <h1 class="text-2xl font-bold">Data Perhitungan</h1>

                {{-- Table start --}}
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-thead">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Nama Guru</th>
                            <th class="border px-4 py-2">Supervisi Guru</th>
                            <th class="border px-4 py-2">Administrasi</th>
                            <th class="border px-4 py-2">Presensi</th>
                            <th class="border px-4 py-2">Kehadiran Di Kelas</th>
                            <th class="border px-4 py-2">Sertifikat Pengembangan Kompetensi</th>
                            <th class="border px-4 py-2">Kegiatan Sosial</th>
                            <th class="border px-4 py-2">Penilaian Antar Rekan Sejawat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perhitungans as $index => $perhitungan)
                            <tr class="text-center border-b">
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-2 py-1">
                                    {{ $perhitungan->guru->user->name ?? 'Data user tidak tersedia' }}
                                </td>
                                <td class="border px-4 py-2">
                                    @php $supervisi = $perhitungan->supervisi ?? 0; @endphp
                                    {{ fmod($supervisi, 1) == 0 ? number_format($supervisi, 0) : number_format($supervisi, 2) }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $perhitungan->administrasiSubKriteria->bobot_sub_kriteria ?? 0 }}
                                </td>
                                <td class="border px-4 py-2">
                                    @php
                                        $presensi = $perhitungan->presensi ?? 0;
                                        if ($presensi == 4) {
                                            echo 'Sangat Baik';
                                        } elseif ($presensi == 3) {
                                            echo 'Baik';
                                        } elseif ($presensi == 2) {
                                            echo 'Cukup';
                                        } elseif ($presensi == 1) {
                                            echo 'Kurang';
                                        } else {
                                            echo 'Tidak Diketahui';
                                        }
                                    @endphp
                                </td>

                                <td class="border px-4 py-2">
                                    @php
                                        $kehadiran_dikelas = $perhitungan->kehadiran_dikelas ?? 0;
                                        if ($presensi == 4) {
                                            echo 'Sangat Baik';
                                        } elseif ($kehadiran_dikelas == 3) {
                                            echo 'Baik';
                                        } elseif ($kehadiran_dikelas == 2) {
                                            echo 'Cukup';
                                        } elseif ($kehadiran_dikelas == 1) {
                                            echo 'Kurang';
                                        } else {
                                            echo 'Tidak Diketahui';
                                        }
                                    @endphp
                                </td>
                                <td class="border px-4 py-2">{{ $perhitungan->sertifikat_pengembangan ?? 0 }}</td>
                                <td class="border px-4 py-2">{{ $perhitungan->kegiatan_sosial ?? 0 }}</td>
                                <td class="border px-4 py-2">{{ $perhitungan->rekan_sejawat ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>

                {{-- Table start --}}
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-thead">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Nama Guru</th>
                            <th class="border px-4 py-2">Supervisi Guru</th>
                            <th class="border px-4 py-2">Administrasi</th>
                            <th class="border px-4 py-2">Presensi</th>
                            <th class="border px-4 py-2">Kehadiran Di Kelas</th>
                            <th class="border px-4 py-2">Sertifikat Pengembangan Kompetensi</th>
                            <th class="border px-4 py-2">Kegiatan Sosial</th>
                            <th class="border px-4 py-2">Penilaian Antar Rekan Sejawat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perhitungans as $index => $perhitungan)
                            <tr class="text-center border-b">
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-2 py-1">
                                    {{ $perhitungan->guru->user->name ?? 'Data user tidak tersedia' }}
                                </td>
                                <td class="border px-4 py-2">
                                    @php $supervisi = $perhitungan->supervisi ?? 0; @endphp
                                    {{ fmod($supervisi, 1) == 0 ? number_format($supervisi, 0) : number_format($supervisi, 2) }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $perhitungan->administrasiSubKriteria->bobot_sub_kriteria ?? 0 }}
                                </td>
                                <td class="border px-4 py-2">{{ $perhitungan->presensi ?? 0 }}</td>
                                <td class="border px-4 py-2">{{ $perhitungan->kehadiran_dikelas ?? 0 }}</td>
                                <td class="border px-4 py-2">{{ $perhitungan->sertifikat_pengembangan ?? 0 }}</td>
                                <td class="border px-4 py-2">{{ $perhitungan->kegiatan_sosial ?? 0 }}</td>
                                <td class="border px-4 py-2">{{ $perhitungan->rekan_sejawat ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h1 class="text-2xl font-bold mb-6">Data Perhitungan Metode MARCOS</h1>

                {{-- Matriks Keputusan --}}
                <div class="mb-10">
                    <h2 class="text-xl font-semibold mb-2">1. Matriks Keputusan</h2>
                    <table class="table-auto border-collapse border border-gray-300 w-full mb-4">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama Guru</th>
                                @foreach($kriteria_keys as $key)
                                    <th class="border px-4 py-2">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matriks as $row)
                                <tr class="text-center border-b">
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    @foreach($kriteria_keys as $key)
                                        <td class="border px-4 py-2">
                                            {{ isset($row[$key]) ? number_format($row[$key], 2) : 0 }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="mb-10">
                    <h2 class="text-xl font-semibold mb-2">2. Nilai Ideal dan Anti-Ideal</h2>
                    <table class="table-auto border-collapse border border-gray-300 w-full mb-4">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Kriteria</th>
                                <th class="border px-4 py-2">Ideal (Max)</th>
                                <th class="border px-4 py-2">Anti-Ideal (Min)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kriteria_keys as $key)
                                <tr class="text-center border-b">
                                    <td class="border px-4 py-2">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                    <td class="border px-4 py-2">{{ number_format($ideal[$key], 2) }}</td>
                                    <td class="border px-4 py-2">{{ number_format($anti_ideal[$key], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Matriks Normalisasi --}}
                <div class="mb-10">
                    <h2 class="text-xl font-semibold mb-2">2. Matriks Normalisasi</h2>
                    <table class="table-auto border-collapse border border-gray-300 w-full mb-4">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama Guru</th>
                                @foreach($kriteria_keys as $key)
                                    <th class="border px-4 py-2">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($normalisasi as $row)
                                <tr class="text-center border-b">
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    @foreach($kriteria_keys as $key)
                                        <td class="border px-4 py-2">{{ number_format($row[$key], 4) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Matriks Pembobotan --}}
                <div class="mb-10">
                    <h2 class="text-xl font-semibold mb-2">3. Matriks Pembobotan</h2>
                    <table class="table-auto border-collapse border border-gray-300 w-full mb-4">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama Guru</th>
                                @foreach($kriteria_keys as $key)
                                    <th class="border px-4 py-2">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembobotan as $row)
                                <tr class="text-center border-b">
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    @foreach($kriteria_keys as $key)
                                        <td class="border px-4 py-2">{{ number_format($row[$key], 4) }}</td>
                                    @endforeach
                                    {{-- <td class="border px-4 py-2">
                                        {{ isset($row[$key]) ? number_format($row[$key], 2) : '-' }}
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Hasil Akhir MARCOS --}}
                <div class="mb-10">
                    <h2 class="text-xl font-semibold mb-2">4. Hasil Perhitungan (f(Ki) dan Ranking)</h2>
                    <table class="table-auto border-collapse border border-gray-300 w-full mb-4">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Ranking</th>
                                <th class="border px-4 py-2">Nama Guru</th>
                                <th class="border px-4 py-2">Si</th>
                                <th class="border px-4 py-2">Ki+</th>
                                <th class="border px-4 py-2">Ki-</th>
                                <th class="border px-4 py-2">f(Ki)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasil as $row)
                                <tr class="text-center border-b">
                                    <td class="border px-4 py-2 font-bold">{{ $row['ranking'] }}</td>
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    <td class="border px-4 py-2">{{ number_format($row['si'], 4) }}</td>
                                    <td class="border px-4 py-2">{{ number_format($row['ki_plus'], 4) }}</td>
                                    <td class="border px-4 py-2">{{ number_format($row['ki_minus'], 4) }}</td>
                                    <td class="border px-4 py-2 font-semibold">{{ number_format($row['f_ki'], 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mb-10">
                    <h2 class="text-xl font-semibold mb-2">5. Nilai Si, Si Ideal, dan Si Anti-Ideal</h2>
                    <table class="table-auto border-collapse border border-gray-300 w-full mb-4">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama Guru</th>
                                <th class="border px-4 py-2">Nilai Si</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasil as $row)
                                <tr class="text-center border-b">
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    <td class="border px-4 py-2">{{ number_format($row['si'], 4) }}</td>
                                    {{-- <td class="border px-4 py-2">
                                        {{ isset($row[$key]) ? number_format($row[$key], 2) : '-' }}
                                    </td> --}}
                                </tr>
                            @endforeach
                            <tr class="text-center font-bold bg-gray-100">
                                <td class="border px-4 py-2">Si Ideal (Max)</td>
                                <td class="border px-4 py-2">{{ number_format($si_ideal, 4) }}</td>
                            </tr>
                            <tr class="text-center font-bold bg-gray-100">
                                <td class="border px-4 py-2">Si Anti-Ideal (Min)</td>
                                <td class="border px-4 py-2">{{ number_format($si_anti_ideal, 4) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </x-app-layout>
</body>