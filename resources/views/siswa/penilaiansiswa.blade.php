<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<title>@yield('title', 'Penilaian Guru Oleh Siswa')</title>

<body class="text-black bg-creamy">
    <x-app-layout>
        <div class="flex h-screen">

            {{-- Konten lainnya disini --}}
            <main class="flex-1 p-10 overflow-auto">
                <div class="mb-10">
                    <div class="max-w-6xl mx-auto text-gray-800 text-center rounded-xl shadow-md p-6 bg-[#ffd480]">
                        <h2 class="text-3xl font-bold mb-2">📋 Penilaian Guru oleh Siswa</h2>
                        <p class="text-md">
                            Selamat datang di halaman penilaian guru. Di sini, Anda dapat memberikan evaluasi secara
                            objektif terhadap performa guru dalam aspek kehadiran di kelas.
                            <br>
                            <span class="font-semibold">✨ Tujuan utama penilaian ini adalah untuk meningkatkan kualitas
                                pendidikan melalui apresiasi dan pengembangan berkelanjutan.</span>
                        </p>
                    </div>
                </div>

                {{-- Tabel Start --}}
                <div class="max-w-6xl mx-auto bg-white shadow-xl rounded-xl p-6">
                    <p class="text-center mb-4">Silakan isi sesuai agenda kelasmu!</p>
                    <div class="overflow-x-auto">
                        <h1 class="text-xl font-bold mb-4">Data yang belum ternilai</h1>
                        <table class="min-w-full table-auto border border-gray-300">
                            <thead class="bg-thead">
                                <tr>
                                    <th class="border px-6 py-3 text-sm">No</th>
                                    <th class="border px-6 py-3 text-sm">Nama Guru</th>
                                    <th class="border px-6 py-3 text-sm">Mata Pelajaran</th>
                                    <th class="border px-6 py-3 text-sm">Jumlah Jam Masuk Kelas</th>
                                    <th class="border px-6 py-3 text-sm">Jumlah Jam Pemberian Tugas di Kelas</th>
                                    <th class="border px-6 py-3 text-sm">Jumlah Jam Tidak Masuk Kelas</th>
                                    <th class="border px-6 py-3 text-sm">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($gurus as $guru)
                                    @php
                                        $penilaian = $guru
                                            ->penilaianSiswa()
                                            ->where('siswa_id', auth()->user()->siswa->id)
                                            ->whereYear('created_at', now()->year)
                                            ->first();

                                        if ($penilaian != null) {
                                            continue;
                                        }
                                    @endphp
                                    <tr>
                                        <td class="border px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="border px-6 py-4">{{ $guru->user->name }}</td>
                                        <td class="border px-6 py-4 text-center">
                                            @foreach ($guru->mataPelajarans as $mapel)
                                                {{ $mapel->nama_mata_pelajaran }}<br>
                                            @endforeach
                                        </td>
                                        <td class="border px-6 py-4 text-center">
                                            {{ $penilaian->jam_mengajar_realita ?? '-' }}</td>
                                        <td class="border px-6 py-4 text-center">{{ $penilaian->jam_tugas ?? '-' }}</td>
                                        <td class="border px-6 py-4 text-center">
                                            {{ $penilaian->jam_tidak_masuk ?? '-' }}
                                        </td>
                                        <td class="border px-6 py-4 text-center">
                                            <a href="#"
                                                onclick="document.getElementById('penilaianModal{{ $guru->id }}').classList.remove('hidden')"
                                                class="{{ $penilaian ? 'bg-yellow-500 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded transition' : 'bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition' }}">
                                                @if ($penilaian)
                                                    Edit
                                                @else
                                                    Nilai
                                                @endif
                                            </a>
                                        </td>
                                    </tr>

                                    {{-- Modal --}}
                                    <div id="penilaianModal{{ $guru->id }}"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
                                        <div class="bg-white rounded-lg w-full max-w-md p-6 relative">

                                            <h2 class="text-2xl font-semibold mb-6 text-center">Tambah Penilaian -
                                                {{ $guru->user->name }}</h2>

                                            @php
                                                $penilaian = $guru
                                                    ->penilaianSiswa()
                                                    ->where('siswa_id', auth()->user()->siswa->id)
                                                    ->whereYear('created_at', now()->year)
                                                    ->first();
                                            @endphp

                                            <div x-data="{
                                                expectTeachingHour: {{ $guru->jam_mengajar_ekspektasi / $guru->kelas_count }},
                                                form: {
                                                    expectTeachingHour: 0,
                                                    assignment: 0,
                                                    absent: 0,
                                                    error: null
                                                },
                                            
                                                onSubmit(e) {
                                                    const total = parseInt(this.form.expectTeachingHour) + parseInt(this.form.assignment) + parseInt(this.form.absent);
                                                    if (total != parseInt(this.expectTeachingHour)) {
                                                        this.form.error = `Jumlah jam tidak sesuai dengan jam mengajar ekspektasi ${this.expectTeachingHour}`;
                                                    } else {
                                                        this.form.error = null;
                                                        e.target.submit();
                                                    }
                                                }
                                            }">
                                                <form
                                                    action="{{ $penilaian ? route('siswa.penilaiansiswa.update', $penilaian->id) : route('siswa.penilaiansiswa.store', $guru->id) }}"
                                                    method="POST" class="space-y-4" x-on:submit.prevent="onSubmit">
                                                    @csrf
                                                    @if ($penilaian)
                                                        @method('PUT')
                                                    @endif

                                                    <input type="hidden" name="guru_id" value="{{ $guru->id }}">
                                                    <div>
                                                        <label for="jam_masuk" class="block text-gray-700">Jumlah Jam
                                                            Masuk</label>
                                                        <input type="number" id="jam_masuk" name="jam_masuk"
                                                            min="0" value="{{ $penilaian->jam_masuk ?? '' }}"
                                                            required
                                                            max="{{ $guru->jam_mengajar_ekspektasi / $guru->kelas_count }}"
                                                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                            x-model="form.expectTeachingHour">
                                                    </div>

                                                    <div>
                                                        <label for="jam_tugas" class="block text-gray-700">Jumlah Jam
                                                            Pemberian
                                                            Tugas</label>
                                                        <input type="number" id="jam_tugas" name="jam_tugas"
                                                            min="0" value="{{ $penilaian->jam_tugas ?? '' }}"
                                                            required
                                                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                            x-model="form.assignment">
                                                    </div>

                                                    <div>
                                                        <label for="jam_tidak_masuk" class="block text-gray-700">Jumlah
                                                            Jam
                                                            Tidak Masuk</label>
                                                        <input type="number" id="jam_tidak_masuk"
                                                            name="jam_tidak_masuk" min="0"
                                                            value="{{ $penilaian->jam_tidak_masuk ?? '' }}" required
                                                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                            x-model="form.absent">
                                                    </div>

                                                    <p x-show="form.error != null" x-text="form.error"
                                                        class="text-red-400 mt-4"></p>
                                                    <div class="flex justify-end mt-2">
                                                        <button type="button"
                                                            onclick="document.getElementById('penilaianModal{{ $guru->id }}').classList.add('hidden')"
                                                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 mr-2">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-sidebar text-gray-800 rounded hover:bg-thead">
                                                            {{-- {{ $guru->penilaianSiswa ? 'Simpan Perubahan' : 'Simpan' }} --}}
                                                            Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="overflow-x-auto mt-10">
                        <h1 class="text-xl font-bold mb-4">Data yang sudah ternilai</h1>
                        <table class="min-w-full table-auto border border-gray-300">
                            <thead class="bg-thead">
                                <tr>
                                    <th class="border px-6 py-3 text-sm">No</th>
                                    <th class="border px-6 py-3 text-sm">Nama Guru</th>
                                    <th class="border px-6 py-3 text-sm">Mata Pelajaran</th>
                                    <th class="border px-6 py-3 text-sm">Jumlah Jam Masuk Kelas</th>
                                    <th class="border px-6 py-3 text-sm">Jumlah Jam Pemberian Tugas di Kelas</th>
                                    <th class="border px-6 py-3 text-sm">Jumlah Jam Tidak Masuk Kelas</th>
                                    <th class="border px-6 py-3 text-sm">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($gurus as $guru)
                                    @php
                                        $penilaian = $guru
                                            ->penilaianSiswa()
                                            ->where('siswa_id', auth()->user()->siswa->id)
                                            ->whereYear('created_at', now()->year)
                                            ->first();

                                        if ($penilaian == null) {
                                            continue;
                                        }
                                    @endphp
                                    <tr>
                                        <td class="border px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="border px-6 py-4">{{ $guru->user->name }}</td>
                                        <td class="border px-6 py-4 text-center">
                                            @foreach ($guru->mataPelajarans as $mapel)
                                                {{ $mapel->nama_mata_pelajaran }}<br>
                                            @endforeach
                                        </td>
                                        <td class="border px-6 py-4 text-center">
                                            {{ $penilaian->jam_mengajar_realita ?? '-' }}
                                        </td>
                                        <td class="border px-6 py-4 text-center">{{ $penilaian->jam_tugas ?? '-' }}
                                        </td>
                                        <td class="border px-6 py-4 text-center">
                                            {{ $penilaian->jam_tidak_masuk ?? '-' }}
                                        </td>
                                        <td class="border px-6 py-4 text-center">
                                            <a href="#"
                                                onclick="document.getElementById('penilaianModal{{ $guru->id }}').classList.remove('hidden')"
                                                class="{{ $penilaian ? 'bg-yellow-500 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded transition' : 'bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition' }}">
                                                @if ($penilaian)
                                                    Edit
                                                @else
                                                    Nilai
                                                @endif
                                            </a>
                                        </td>
                                    </tr>

                                    <div id="penilaianModal{{ $guru->id }}"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
                                        <div class="bg-white rounded-lg w-full max-w-md p-6 relative">

                                            <h2 class="text-2xl font-semibold mb-6 text-center">Edit Penilaian -
                                                {{ $guru->user->name }}</h2>

                                            @php
                                                $penilaian = $guru
                                                    ->penilaianSiswa()
                                                    ->where('siswa_id', auth()->user()->siswa->id)
                                                    ->whereYear('created_at', now()->year)
                                                    ->first();
                                            @endphp

                                            <div x-data="{
                                                expectTeachingHour: {{ $guru->jam_mengajar_ekspektasi / $guru->kelas_count }},
                                                form: {
                                                    expectTeachingHour: {{ $penilaian->jam_mengajar_realita ?? 0 }},
                                                    assignment: {{ $penilaian->jam_tugas ?? 0 }},
                                                    absent: {{ $penilaian->jam_tidak_masuk ?? 0 }},
                                                    error: null
                                                },
                                            
                                                onSubmit(e) {
                                                    const total = parseInt(this.form.expectTeachingHour) + parseInt(this.form.assignment) + parseInt(this.form.absent);
                                                    if (total != parseInt(this.expectTeachingHour)) {
                                                        this.form.error = `Jumlah jam tidak sesuai dengan jam mengajar ekspektasi ${this.expectTeachingHour}`;
                                                    } else {
                                                        this.form.error = null;
                                                        e.target.submit();
                                                    }
                                                }
                                            }">
                                                <form
                                                    action="{{ $penilaian ? route('siswa.penilaiansiswa.update', $penilaian->id) : route('siswa.penilaiansiswa.store', $guru->id) }}"
                                                    method="POST" class="space-y-4" x-on:submit.prevent="onSubmit">
                                                    @csrf
                                                    @if ($penilaian)
                                                        @method('PUT')
                                                    @endif

                                                    <input type="hidden" name="guru_id"
                                                        value="{{ $guru->id }}">
                                                    <div>
                                                        <label for="jam_masuk" class="block text-gray-700">Jumlah Jam
                                                            Masuk</label>
                                                        <input type="number" id="jam_masuk" name="jam_masuk"
                                                            min="0" value="{{ $penilaian->jam_masuk ?? '' }}"
                                                            required
                                                            max="{{ $guru->jam_mengajar_ekspektasi / $guru->kelas_count }}"
                                                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                            x-model="form.expectTeachingHour">
                                                    </div>

                                                    <div>
                                                        <label for="jam_tugas" class="block text-gray-700">Jumlah Jam
                                                            Pemberian
                                                            Tugas</label>
                                                        <input type="number" id="jam_tugas" name="jam_tugas"
                                                            min="0" value="{{ $penilaian->jam_tugas ?? '' }}"
                                                            required
                                                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                            x-model="form.assignment">
                                                    </div>

                                                    <div>
                                                        <label for="jam_tidak_masuk"
                                                            class="block text-gray-700">Jumlah
                                                            Jam
                                                            Tidak Masuk</label>
                                                        <input type="number" id="jam_tidak_masuk"
                                                            name="jam_tidak_masuk" min="0"
                                                            value="{{ $penilaian->jam_tidak_masuk ?? '' }}" required
                                                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                            x-model="form.absent">
                                                    </div>

                                                    <p x-show="form.error != null" x-text="form.error"
                                                        class="text-red-400 mt-4"></p>
                                                    <div class="flex justify-end mt-2">
                                                        <button type="button"
                                                            onclick="document.getElementById('penilaianModal{{ $guru->id }}').classList.add('hidden')"
                                                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 mr-2">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-sidebar text-gray-800 rounded hover:bg-thead">
                                                            {{-- {{ $guru->penilaianSiswa ? 'Simpan Perubahan' : 'Simpan' }} --}}
                                                            Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-10 text-center text-sm italic text-gray-500">
                            "Penilaian bukan sekadar angka, tapi cerminan dedikasi dan kontribusi untuk masa depan yang
                            lebih baik."
                        </div>
                    </div>
            </main>
        </div>
    </x-app-layout>
</body>
