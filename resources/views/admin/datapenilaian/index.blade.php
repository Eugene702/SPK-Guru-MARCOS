<title>@yield('title', 'Data Penilaian')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-creamy">
    <x-app-layout>
    <div class="flex flex-col md:flex-row min-h-screen">
        @include('components.sidebar-admin')

        <!-- Konten lainnya di sini -->
        <main class="flex-1 p-6 md:p-10">
            <!-- Header dan kata pembuka -->
            <div class="mb-10">
                <div class="text-gray-800 text-center rounded-xl shadow-md p-6 bg-amber-400/25">
                    <h2 class="text-3xl font-bold mb-2">📋 Penilaian Guru oleh Manajemen</h2>
                    <p class="text-md">
                        Selamat datang di halaman penilaian guru. Di sini, Anda dapat memberikan evaluasi secara objektif terhadap performa guru dalam berbagai aspek seperti administrasi, presensi, pengembangan kompetensi, dan keterlibatan sosial.
                        <br><br>
                        <span class="font-semibold">✨ Tujuan utama penilaian ini adalah untuk meningkatkan kualitas pendidikan melalui apresiasi dan pengembangan berkelanjutan.</span>
                    </p>
                </div>
            </div>

           
            {{-- Alert sukses start --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif
            {{-- Alert sukses end --}}

            <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6">
                {{-- Tabel start --}}
                <h1 class="text-xl font-bold mb-4">Data yang Belum Ternilai</h1>
                <div class="overflow-x-auto rounded-lg border">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-thead">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">No</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Nama Guru</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Administrasi</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Presensi</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Sertifikat Pengembangan Kompetensi</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Kegiatan Sosial</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-gray-800">
                            @foreach ($gurus as $index => $guru)
                                @if ($guru->penilaianAdmin)
                                    @continue
                                @endif
                                <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} text-center hover:bg-yellow-50 transition">
                                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="border px-4 py-2">{{ $guru->user->name ?? 'Data user tidak tersedia' }}</td>
                                    <td class="border px-4 py-2">{{ $guru->penilaianAdmin->administrasiSubKriteria->nama_sub_kriteria ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $guru->penilaianAdmin->presensi_realita ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $guru->penilaianAdmin->sertifikat_pengembangan ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $guru->penilaianAdmin->kegiatan_sosial ?? '-' }}</td>
                                    <td class="border px-4 py-2 flex justify-center gap-2">
                                        <a href="#"
                                            onclick="document.getElementById('modal{{ $guru->id }}').classList.remove('hidden')"
                                            class="text-blue-500 hover:text-blue-700">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>

                                {{-- Modal untuk Nilai dan Edit start --}}
                                <div id="modal{{ $guru->id }}" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center z-50">
                                    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                        <h2 class="text-xl font-semibold mb-4 text-center">{{ $guru->penilaianAdmin ? 'Edit' : 'Tambah' }} Penilaian - {{ $guru->user->name ?? '-' }}</h2>
                                        
                                        <form method="POST" action="{{ $guru->penilaianAdmin ? route('admin.datapenilaian.update', $guru->penilaianAdmin->id) : route('admin.datapenilaian.store') }}">
                                            @csrf
                                            @if($guru->penilaianAdmin)
                                                @method('PUT')
                                            @endif
                            
                                            <input type="hidden" name="guru_id" value="{{ $guru->id }}">
                            
                                            <!-- Administrasi -->
                                            <div class="mb-4">
                                                <label for="administrasi" class="block text-sm font-medium text-gray-700">Administrasi</label>
                                                <select name="administrasi" id="administrasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                                    <option value="">-- Pilih Sub Kriteria --</option>
                                                    @foreach($subkriteriaAdministrasi as $sub)
                                                    <option value="{{ $sub->id_sub_kriteria }}" {{ (isset($guru->penilaianAdmin) && $guru->penilaianAdmin->administrasi == $sub->id_sub_kriteria) ? 'selected' : '' }}>
                                                        {{ $sub->nama_sub_kriteria }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                            
                                            <!-- Presensi -->
                                            <div class="mb-4">
                                                <label for="presensi" class="block text-sm font-medium text-gray-700">Presensi</label>
                                                <input type="number" step="0.01" name="presensi_realita" id="presensi_realita" 
                                                value="{{ old('presensi_realita', $guru->penilaianAdmin->presensi_realita ?? '') }}"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                            </div>
                            
                                            <!-- Sertifikat Pengembangan -->
                                            <div class="mb-4">
                                                <label for="sertifikat_pengembangan" class="block text-sm font-medium text-gray-700">Sertifikat Pengembangan</label>
                                                <select name="sertifikat_pengembangan" id="sertifikat_pengembangan" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                                    <option value="">-- Pilih Nilai --</option>
                                                    @for($i = 0; $i <= 2; $i++)
                                                        <option value="{{ $i }}" {{ (isset($guru->penilaianAdmin) && $guru->penilaianAdmin->sertifikat_pengembangan == $i) ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <!-- Kegiatan Sosial -->
                                            <div class="mb-4">
                                                <label for="kegiatan_sosial" class="block text-sm font-medium text-gray-700">Kegiatan Sosial</label>
                                                <select name="kegiatan_sosial" id="kegiatan_sosial" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                                    <option value="">-- Pilih Nilai --</option>
                                                    @for($i = 0; $i <= 2; $i++)
                                                        <option value="{{ $i }}" {{ (isset($guru->penilaianAdmin) && $guru->penilaianAdmin->kegiatan_sosial == $i) ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <!-- Tombol Simpan -->
                                            <div class="flex justify-end">
                                                <button type="button" onclick="document.getElementById('modal{{ $guru->id }}').classList.add('hidden')" 
                                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 mr-2">
                                                    Batal
                                                </button>
                                                <button type="submit" class="px-4 py-2 bg-sidebar text-gray-800 rounded hover:bg-thead">
                                                    {{ $guru->penilaianAdmin ? 'Simpan Perubahan' : 'Simpan' }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- Modal untuk Nilai dan Edit end --}}
                            @endforeach
                        </tbody>                    
                    </table>
                </div>
                {{-- Tabel end --}}

                {{-- Tabel start --}}
                <h1 class="text-xl font-bold mb-4 mt-10">Data yang Sudah Ternilai</h1>
                <div class="overflow-x-auto rounded-lg border">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-thead">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">No</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Nama Guru</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Administrasi</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Presensi</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Sertifikat Pengembangan Kompetensi</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Kegiatan Sosial</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-gray-800">
                            @foreach ($gurus as $index => $guru)
                                @if (!$guru->penilaianAdmin)
                                    @continue
                                @endif
                                <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} text-center hover:bg-yellow-50 transition">
                                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="border px-4 py-2">{{ $guru->user->name ?? 'Data user tidak tersedia' }}</td>
                                    <td class="border px-4 py-2">{{ $guru->penilaianAdmin->administrasiSubKriteria->nama_sub_kriteria ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $guru->penilaianAdmin->presensi_realita ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $guru->penilaianAdmin->sertifikat_pengembangan ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $guru->penilaianAdmin->kegiatan_sosial ?? '-' }}</td>
                                    <td class="border px-4 py-2 flex justify-center gap-2">
                                        <a href="#"
                                            onclick="document.getElementById('modal{{ $guru->id }}').classList.remove('hidden')"
                                            class="text-yellow-500 hover:text-yellow-700">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                </tr>

                                {{-- Modal untuk Nilai dan Edit start --}}
                                <div id="modal{{ $guru->id }}" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center z-50">
                                    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                        <h2 class="text-xl font-semibold mb-4 text-center">{{ $guru->penilaianAdmin ? 'Edit' : 'Tambah' }} Penilaian - {{ $guru->user->name ?? '-' }}</h2>
                                        
                                        <form method="POST" action="{{ $guru->penilaianAdmin ? route('admin.datapenilaian.update', $guru->penilaianAdmin->id) : route('admin.datapenilaian.store') }}">
                                            @csrf
                                            @if($guru->penilaianAdmin)
                                                @method('PUT')
                                            @endif
                            
                                            <input type="hidden" name="guru_id" value="{{ $guru->id }}">
                            
                                            <!-- Administrasi -->
                                            <div class="mb-4">
                                                <label for="administrasi" class="block text-sm font-medium text-gray-700">Administrasi</label>
                                                <select name="administrasi" id="administrasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                                    <option value="">-- Pilih Sub Kriteria --</option>
                                                    @foreach($subkriteriaAdministrasi as $sub)
                                                    <option value="{{ $sub->id_sub_kriteria }}" {{ (isset($guru->penilaianAdmin) && $guru->penilaianAdmin->administrasi == $sub->id_sub_kriteria) ? 'selected' : '' }}>
                                                        {{ $sub->nama_sub_kriteria }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                            
                                            <!-- Presensi -->
                                            <div class="mb-4">
                                                <label for="presensi" class="block text-sm font-medium text-gray-700">Presensi</label>
                                                <input type="number" step="0.01" name="presensi_realita" id="presensi_realita" 
                                                value="{{ old('presensi_realita', $guru->penilaianAdmin->presensi_realita ?? '') }}"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                            </div>
                            
                                            <!-- Sertifikat Pengembangan -->
                                            <div class="mb-4">
                                                <label for="sertifikat_pengembangan" class="block text-sm font-medium text-gray-700">Sertifikat Pengembangan</label>
                                                <select name="sertifikat_pengembangan" id="sertifikat_pengembangan" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                                    <option value="">-- Pilih Nilai --</option>
                                                    @for($i = 0; $i <= 2; $i++)
                                                        <option value="{{ $i }}" {{ (isset($guru->penilaianAdmin) && $guru->penilaianAdmin->sertifikat_pengembangan == $i) ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <!-- Kegiatan Sosial -->
                                            <div class="mb-4">
                                                <label for="kegiatan_sosial" class="block text-sm font-medium text-gray-700">Kegiatan Sosial</label>
                                                <select name="kegiatan_sosial" id="kegiatan_sosial" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                                    <option value="">-- Pilih Nilai --</option>
                                                    @for($i = 0; $i <= 2; $i++)
                                                        <option value="{{ $i }}" {{ (isset($guru->penilaianAdmin) && $guru->penilaianAdmin->kegiatan_sosial == $i) ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <!-- Tombol Simpan -->
                                            <div class="flex justify-end">
                                                <button type="button" onclick="document.getElementById('modal{{ $guru->id }}').classList.add('hidden')" 
                                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 mr-2">
                                                    Batal
                                                </button>
                                                <button type="submit" class="px-4 py-2 bg-sidebar text-gray-800 rounded hover:bg-thead">
                                                    {{ $guru->penilaianAdmin ? 'Simpan Perubahan' : 'Simpan' }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- Modal untuk Nilai dan Edit end --}}
                            @endforeach
                        </tbody>                    
                    </table>
                </div>
            {{-- Tabel end --}}

                <div class="mt-10 text-center text-sm italic text-gray-500">
                    "Penilaian bukan sekadar angka, tapi cerminan dedikasi dan kontribusi untuk masa depan yang lebih baik."
                </div>
            </div>
        </main>
    </div>
    </x-app-layout>
</body>
