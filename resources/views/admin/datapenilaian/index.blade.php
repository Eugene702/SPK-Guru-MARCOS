<title>@yield('title', 'Data Penilaian')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-white text-black">
    <x-app-layout>
    <div class="flex h-screen">
        @include('components.sidebar-admin')

        <!-- Konten lainnya di sini -->
        <main class="flex-1 p-10">
            <h1 class="text-2xl font-bold">Penilaian Guru oleh Manajemen</h1>
           
            {{-- Alert sukses start --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif
            {{-- Alert sukses end --}}

            {{-- Tabel start --}}
            <h1 class="text-xl font-bold mb-2 mt-10">Data yang belum ternilai</h1>
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-thead">
                    <tr>
                        <th class="border px-4 py-2">No</th>
                        <th class="border px-4 py-2">Nama Guru</th>
                        <th class="border px-4 py-2">Administrasi</th>
                        <th class="border px-4 py-2">Presensi</th>
                        <th class="border px-4 py-2">Sertifikat Pengembangan Kompetensi</th>
                        <th class="border px-4 py-2">Kegiatan Sosial</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gurus as $index => $guru)
                        @if($guru->penilaianAdmin)
                            @continue
                        @endif

                        <tr class="text-center border-b">
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-2 py-1">
                                {{ $guru->user->name ?? 'Data user tidak tersedia' }}
                            </td>
                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->administrasiSubKriteria->nama_sub_kriteria ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->presensi_realita ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->sertifikat_pengembangan ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->kegiatan_sosial ?? '-' }}</td>
                            <td class="border px-4 py-2 flex justify-center gap-2">
                                <a href="#" onclick="document.getElementById('modal{{ $guru->id }}').classList.remove('hidden')" 
                                    class="{{ $guru->penilaianAdmin ? 'text-yellow-500 hover:text-yellow-700' : 'text-blue-500 hover:text-blue-700' }}">
                                    @if($guru->penilaianAdmin)
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    @else
                                        <i class="fa-solid fa-plus"></i>
                                    @endif
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
            {{-- Tabel end --}}

            {{-- Tabel start --}}
            <h1 class="text-xl font-bold mb-2 mt-10">Data yang sudah ternilai</h1>
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-thead">
                    <tr>
                        <th class="border px-4 py-2">No</th>
                        <th class="border px-4 py-2">Nama Guru</th>
                        <th class="border px-4 py-2">Administrasi</th>
                        <th class="border px-4 py-2">Presensi</th>
                        <th class="border px-4 py-2">Sertifikat Pengembangan Kompetensi</th>
                        <th class="border px-4 py-2">Kegiatan Sosial</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gurus as $index => $guru)
                        @if(!$guru->penilaianAdmin)
                            @continue
                        @endif

                        <tr class="text-center border-b">
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-2 py-1">
                                {{ $guru->user->name ?? 'Data user tidak tersedia' }}
                            </td>
                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->administrasiSubKriteria->nama_sub_kriteria ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->presensi_realita ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->sertifikat_pengembangan ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->kegiatan_sosial ?? '-' }}</td>
                            <td class="border px-4 py-2 flex justify-center gap-2">
                                <a href="#" onclick="document.getElementById('modal{{ $guru->id }}').classList.remove('hidden')" 
                                    class="{{ $guru->penilaianAdmin ? 'text-yellow-500 hover:text-yellow-700' : 'text-blue-500 hover:text-blue-700' }}">
                                    @if($guru->penilaianAdmin)
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    @else
                                        <i class="fa-solid fa-plus"></i>
                                    @endif
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
            {{-- Tabel end --}}

        </main>
    </div>
</x-app-layout>
</body>
