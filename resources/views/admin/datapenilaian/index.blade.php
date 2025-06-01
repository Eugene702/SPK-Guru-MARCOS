<title>@yield('title', 'Data Penilaian')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<body class="bg-creamy">
    <x-app-layout>
        <div class="flex flex-col md:flex-row min-h-screen">
            @include('components.sidebar-admin')

            <main class="flex-1 p-6 md:p-10">
                <div class="mb-10">
                    <div class="text-gray-800 text-center rounded-xl shadow-md p-6 bg-amber-400/25">
                        <h2 class="text-3xl font-bold mb-2">📋 Penilaian Guru oleh Manajemen</h2>
                        <p class="text-md">
                            Selamat datang di halaman penilaian guru. Di sini, Anda dapat memberikan evaluasi secara
                            objektif terhadap performa guru dalam berbagai aspek seperti administrasi, presensi,
                            pengembangan kompetensi, dan keterlibatan sosial.
                            <br><br>
                            <span class="font-semibold">✨ Tujuan utama penilaian ini adalah untuk meningkatkan kualitas
                                pendidikan melalui apresiasi dan pengembangan berkelanjutan.</span>
                        </p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {!! session('error') !!}
                    </div>
                @endif

                <div x-data="{ 
                    showModal: false,
                    currentGuru: null,
                    isEdit: false,
                    formData: {
                        guru_id: '',
                        administrasi: '',
                        presensi_realita: '',
                        sertifikat_pengembangan: '',
                        kegiatan_sosial: ''
                    },
                    get formAction() {
                        if (this.isEdit) {
                            return `/admin/datapenilaian/${this.currentGuru.penilaian_admin.id}`;
                        }
                        return '/admin/datapenilaian';
                    }
                }" class="max-w-7xl mx-auto">
                    <div class="bg-white shadow-xl rounded-xl p-6">
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
                                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->administrasi ?? '-' }}</td>
                                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->presensi_realita ?? '-' }}</td>
                                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->sertifikat_pengembangan ?? '-' }}</td>
                                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->kegiatan_sosial ?? '-' }}</td>
                                            <td class="border px-4 py-2 flex justify-center gap-2">
                                                <button @click="
                                                    currentGuru = {{ json_encode($guru) }};
                                                    formData.guru_id = {{ $guru->id }};
                                                    showModal = true;
                                                    isEdit = false;
                                                " class="text-blue-500 hover:text-blue-700">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

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
                                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->administrasi ?? '-' }}</td>
                                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->presensi_realita ?? '-' }}</td>
                                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->sertifikat_pengembangan ?? '-' }}</td>
                                            <td class="border px-4 py-2">{{ $guru->penilaianAdmin->kegiatan_sosial ?? '-' }}</td>
                                            <td class="border px-4 py-2 flex justify-center gap-2">
                                                <button @click="
                                                    currentGuru = {{ json_encode($guru) }};
                                                    formData = {
                                                        guru_id: {{ $guru->id }},
                                                        administrasi: '{{ $guru->penilaianAdmin->administrasi }}',
                                                        presensi_realita: '{{ $guru->penilaianAdmin->presensi_realita }}',
                                                        sertifikat_pengembangan: '{{ $guru->penilaianAdmin->sertifikat_pengembangan }}',
                                                        kegiatan_sosial: '{{ $guru->penilaianAdmin->kegiatan_sosial }}'
                                                    };
                                                    showModal = true;
                                                    isEdit = true;
                                                " class="text-yellow-500 hover:text-yellow-700">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-10 text-center text-sm italic text-gray-500">
                            "Penilaian bukan sekadar angka, tapi cerminan dedikasi dan kontribusi untuk masa depan yang lebih baik."
                        </div>
                    </div>

                    <div x-show="showModal" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                            <h2 class="text-xl font-semibold mb-4 text-center">
                                <span x-text="isEdit ? 'Edit' : 'Tambah'"></span> Penilaian -
                                <span x-text="currentGuru?.user?.name || '-'"></span>
                            </h2>

                            <form method="POST" :action="formAction">
                                @csrf
                                <input type="hidden" name="_method" x-bind:value="isEdit ? 'PUT' : 'POST'">
                                <input type="hidden" name="guru_id" :value="formData.guru_id">

                                <div class="mb-4">
                                    <label for="administrasi" class="block text-sm font-medium text-gray-700">Administrasi</label>
                                    <select name="administrasi" id="administrasi" x-model="formData.administrasi"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                        <option value="">-- Pilih Sub Kriteria --</option>
                                        <option value="4">Lengkap</option>
                                        <option value="3">Cukup</option>
                                        <option value="2">Kurang</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="presensi" class="block text-sm font-medium text-gray-700">Presensi</label>
                                    <input type="number" step="0.01" name="presensi_realita" id="presensi_realita"
                                        x-model="formData.presensi_realita"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                </div>

                                <div class="mb-4">
                                    <label for="sertifikat_pengembangan" class="block text-sm font-medium text-gray-700">Sertifikat Pengembangan</label>
                                    <select name="sertifikat_pengembangan" id="sertifikat_pengembangan"
                                        x-model="formData.sertifikat_pengembangan"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                        <option value="">-- Pilih Nilai --</option>
                                        <template x-for="i in 3">
                                            <option :value="i-1" x-text="i-1"></option>
                                        </template>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="kegiatan_sosial" class="block text-sm font-medium text-gray-700">Kegiatan Sosial</label>
                                    <select name="kegiatan_sosial" id="kegiatan_sosial"
                                        x-model="formData.kegiatan_sosial"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                        <option value="">-- Pilih Nilai --</option>
                                        <template x-for="i in 3">
                                            <option :value="i-1" x-text="i-1"></option>
                                        </template>
                                    </select>
                                </div>

                                <div class="flex justify-end">
                                    <button type="button" @click="showModal = false"
                                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 mr-2">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-sidebar text-gray-800 rounded hover:bg-thead">
                                        <span x-text="isEdit ? 'Simpan Perubahan' : 'Simpan'"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </x-app-layout>
</body>
