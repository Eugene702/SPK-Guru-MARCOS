<title>@yield('title', 'Data Guru')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])

<body class="bg-creamy">
    <x-app-layout>
        <div class="flex flex-col md:flex-row min-h-screen">
            @include('components.sidebar-admin')

            <!-- Konten lainnya di sini -->
            <main class="flex-1 p-6 md:p-10">
                <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Data Guru</h1>
                    <p class="text-gray-600 text-center mb-4">
                        Menampilkan daftar lengkap seluruh guru beserta detail informasinya.
                    </p>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-400 text-white p-4 rounded-xl w-full mb-4 mt-2">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <!-- Tombol membuka modal tambah data-->
                            <div class="flex justify-end mb-4">
                                <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
                                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow font-semibold">
                                    Tambah Data
                                </button>
                            </div>

                            <!-- Modal Tambah Data Guru -->
                            <div id="modal-tambah"
                                class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white p-6 rounded-lg shadow-lg w-[95%] max-w-screen-xl">
                                    <h2 class="text-xl font-bold mb-6 text-center">Tambah Data Guru</h2>
                                    <form action="{{ route('admin.dataguru.storeguru') }}" method="POST">
                                        @csrf
                                        <div class="grid grid-cols-4 gap-6">

                                            <!-- Kolom 1: User Info -->
                                            <div class="space-y-4">
                                                <h4 class="text-md font-semibold mb-2 text-center">User Info</h4>
                                                <div>
                                                    <label class="block mb-1 text-sm">Nama Guru</label>
                                                    <input type="text" name="name"
                                                        class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                        placeholder="Nama Guru" required>
                                                </div>
                                                <div>
                                                    <label class="block mb-1 text-sm">Email</label>
                                                    <input type="email" name="email"
                                                        class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                        placeholder="Email" required>
                                                </div>
                                                <div>
                                                    <label class="block mb-1 text-sm">Password</label>
                                                    <input type="password" name="password"
                                                        class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                        placeholder="Password" required>
                                                </div>
                                                <div>
                                                    <label class="block mb-1 text-sm">Role</label>
                                                    <select name="role"
                                                        class="w-full border px-3 py-2 rounded-md border-gray-300 shadow-sm"
                                                        required>
                                                        <option value="">-- Pilih Role --</option>
                                                        <option value="Guru">Guru</option>
                                                        <option value="KepalaSekolah">KepalaSekolah</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Kolom 2: Guru Info -->
                                            <div class="space-y-4">
                                                <h4 class="text-md font-semibold mb-2 text-center">Guru Info</h4>
                                                <div>
                                                    <label class="block mb-1 text-sm">NIP</label>
                                                    <input type="text" name="nip"
                                                        class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                        placeholder="NIP" required>
                                                </div>
                                                <div>
                                                    <label class="block mb-1 text-sm">Jabatan</label>
                                                    <select name="jabatan"
                                                        class="w-full border px-3 py-2 rounded-md border-gray-300 shadow-sm"
                                                        required>
                                                        <option value="">-- Pilih Jabatan --</option>
                                                        <option value="Guru">Guru</option>
                                                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block mb-1 text-sm">Jumlah Jam Mengajar</label>
                                                    <input type="number" name="jumlah_jam_mengajar"
                                                        class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                        placeholder="Jumlah Jam Mengajar" required>
                                                </div>
                                                <div>
                                                    <label class="block mb-1 text-sm">Jumlah Presensi</label>
                                                    <input type="number" name="jumlah_presensi"
                                                        class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                        placeholder="Jumlah Presensi" required>
                                                </div>
                                            </div>

                                            <!-- Kolom 3: Mata Pelajaran -->
                                            <div class="space-y-4">
                                                <h4 class="text-md font-semibold mb-2 text-center">Pilih Mata Pelajaran
                                                </h4>
                                                <div
                                                    class="h-[300px] overflow-y-auto border p-3 space-y-2 rounded-md border-gray-300 shadow-sm">
                                                    @foreach ($mataPelajarans as $mapel)
                                                        <label class="flex items-center space-x-2">
                                                            <input type="checkbox" name="mata_pelajaran[]"
                                                                value="{{ $mapel->id }}" class="accent-green-500">
                                                            <span>{{ $mapel->nama_mata_pelajaran }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <!-- Kolom 4: Kelas -->
                                            <div class="space-y-4">
                                                <h4 class="text-md font-semibold mb-2 text-center">Pilih Kelas</h4>
                                                <div
                                                    class="h-[300px] overflow-y-auto border p-3 space-y-2 rounded-md border-gray-300 shadow-sm">
                                                    @foreach ($opsiKelas as $item)
                                                        <label class="flex items-center space-x-2">
                                                            <input type="checkbox" name="kelas[]"
                                                                value="{{ $item->id }}"
                                                                {{ isset($guru) && $guru->kelas->contains($item->id) ? 'checked' : '' }}>
                                                            <span>{{ $item->nama_kelas }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tombol Aksi -->
                                        <div class="flex justify-end gap-2 mt-6">
                                            <button type="button"
                                                onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                            <button type="submit"
                                                class="px-4 py-2 bg-sidebar text-gray-800 rounded hover:bg-thead">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                    @endif

                    <x-admin.teacher-data.create-modal :$opsiKelas :$mataPelajarans />
                    <x-admin.teacher-data.table-data :$gurus :$opsiKelas :$mataPelajarans />
            </main>
        </div>
        <!-- Tabel -->
        <div class="overflow-x-auto rounded-lg border ">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-thead text-black">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-center border">No</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center border max-w-[120px]">NIP</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center border">Nama Guru</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center border">Jabatan</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center border">Kelas</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center border">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center border">Jam Mengajar</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center border">Presensi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center border max-w-[150px]">Email</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center border">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white text-gray-800">
                    @foreach ($gurus as $index => $guru)
                        <tr
                            class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} text-center hover:bg-yellow-50 transition">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>

                            <!-- NIP dengan truncate dan tooltip -->
                            <td class="px-4 py-2 border whitespace-nowrap truncate max-w-[120px]"
                                title="{{ $guru->nip }}">{{ $guru->nip }}</td>

                            <td class="px-4 py-2 border text-left">
                                {{ $guru->user->name ?? 'Data user tidak tersedia' }}
                            </td>
                            <td class="px-4 py-2 border">{{ $guru->jabatan }}</td>

                            <!-- Tampilkan kelas dalam satu kolom, list vertikal -->
                            <td class="px-4 py-2 border text-left">
                                @foreach ($guru->kelas as $kelas)
                                    <div>{{ $kelas->nama_kelas }}</div>
                                @endforeach
                            </td>

                            <!-- Tampilkan mapel dalam satu kolom, list vertikal -->
                            <td class="px-4 py-2 border text-left">
                                @foreach ($guru->mataPelajarans as $mapel)
                                    <div>{{ $mapel->nama_mata_pelajaran }}</div>
                                @endforeach
                            </td>

                            <td class="px-4 py-2 border">{{ $guru->jumlah_jam_mengajar }}</td>
                            <td class="px-4 py-2 border">{{ $guru->jumlah_presensi }}</td>

                            <!-- Email dengan truncate -->
                            <td class="px-4 py-2 border whitespace-nowrap truncate max-w-[150px]"
                                title="{{ $guru->user?->email ?? '-' }}">
                                {{ $guru->user?->email ?? '-' }}
                            </td>

                            <!-- Aksi dengan ikon, rapih dan di satu baris -->
                            <td class="px-4 py-2 border">
                                <div class="flex justify-center gap-4 text-lg">
                                    <a href="#"
                                        onclick="document.getElementById('modal-edit-{{ $guru->id }}').classList.remove('hidden')"
                                        class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.dataguru.destroy', $guru->id) }}" method="POST"
                                        class="deleteUser" onsubmit="return handleOnClickDelete(event)">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700"
                                            title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Modal Edit Data Guru -->
                                <div id="modal-edit-{{ $guru->id }}"
                                    class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-screen-xl">
                                        <h2 class="text-xl font-bold mb-4">Edit Data Guru</h2>
                                        <form action="{{ route('admin.dataguru.update', ['id' => $guru->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="grid grid-cols-4 gap-6">

                                                <!-- Kolom 1: User Info -->
                                                <div class="space-y-4">
                                                    <h4 class="text-md font-semibold mb-2 text-center">User Info
                                                    </h4>
                                                    <div>
                                                        <label class="block mb-1 text-sm">Nama Guru</label>
                                                        <input type="text" name="name"
                                                            class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                            value="{{ $guru->user->name ?? '' }}"
                                                            placeholder="Nama Guru" required>
                                                    </div>
                                                    <div>
                                                        <label class="block mb-1 text-sm">Email</label>
                                                        <input type="email" name="email"
                                                            class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                            value="{{ $guru->user->email ?? '' }}"
                                                            placeholder="Email" required>
                                                    </div>
                                                    <div>
                                                        <label class="block mb-1 text-sm">Password</label>
                                                        <input type="password" name="password"
                                                            class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                            placeholder="Password">
                                                    </div>
                                                    <div>
                                                        <label class="block mb-1 text-sm">Role</label>
                                                        <select name="role"
                                                            class="w-full border px-3 py-2 rounded-md border-gray-300 shadow-sm"
                                                            required>
                                                            <option value="">-- Pilih Role --</option>
                                                            <option value="Guru">Guru</option>
                                                            <option value="KepalaSekolah">KepalaSekolah</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Kolom 2: Guru Info -->
                                                <div class="space-y-4">
                                                    <h4 class="text-md font-semibold mb-2 text-center">Guru Info
                                                    </h4>
                                                    <div>
                                                        <label class="block mb-1 text-sm">NIP</label>
                                                        <input type="text" name="nip"
                                                            class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                            value="{{ $guru->nip }}" placeholder="NIP" required>
                                                    </div>
                                                    <div>
                                                        <label class="block mb-1 text-sm">Jabatan</label>
                                                        <select name="jabatan"
                                                            class="w-full border px-3 py-2 rounded-md border-gray-300 shadow-sm"
                                                            required>
                                                            <option value="">-- Pilih Jabatan --</option>
                                                            <option value="Guru">Guru</option>
                                                            <option value="Kepala Sekolah">Kepala Sekolah</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block mb-1 text-sm">Jumlah Jam
                                                            Mengajar</label>
                                                        <input type="number" name="jumlah_jam_mengajar"
                                                            class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                            value="{{ $guru->jumlah_jam_mengajar }}"
                                                            placeholder="Jumlah Jam Mengajar" required>
                                                    </div>
                                                    <div>
                                                        <label class="block mb-1 text-sm">Jumlah Presensi</label>
                                                        <input type="number" name="jumlah_presensi"
                                                            class="w-full border p-2 rounded-md border-gray-300 shadow-sm"
                                                            value="{{ $guru->jumlah_presensi }}"
                                                            placeholder="Jumlah Presensi" required>
                                                    </div>
                                                </div>

                                                <!-- Kolom 3: Mata Pelajaran -->
                                                <div class="space-y-4">
                                                    <h4 class="text-md font-semibold mb-2 text-center">Pilih Mata
                                                        Pelajaran
                                                    </h4>
                                                    <div
                                                        class="h-[300px] overflow-y-auto border p-3 space-y-2 rounded-md border-gray-300 shadow-sm">
                                                        @foreach ($mataPelajarans as $mapel)
                                                            <label class="flex items-center space-x-2">
                                                                <input type="checkbox" name="mata_pelajaran[]"
                                                                    value="{{ $mapel->id }}"
                                                                    class="accent-green-500"
                                                                    checked="{{ $guru->mataPelajarans->contains($mapel->id) ? 'checked' : '' }}">
                                                                <span>{{ $mapel->nama_mata_pelajaran }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <!-- Kolom 4: Kelas -->
                                                <div class="space-y-4">
                                                    <h4 class="text-md font-semibold mb-2 text-center">Pilih Kelas
                                                    </h4>
                                                    <div
                                                        class="h-[300px] overflow-y-auto border p-3 space-y-2 rounded-md border-gray-300 shadow-sm">
                                                        @foreach ($opsiKelas as $kelasItem)
                                                            <label class="flex items-center space-x-2">
                                                                <input type="checkbox" name="kelas[]"
                                                                    value="{{ $kelasItem->id ?? '' }}"
                                                                    {{ $guru->kelas->contains($kelasItem->id ?? '') ? 'checked' : '' }}>
                                                                <span>{{ $kelasItem->nama_kelas ?? '' }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 flex justify-end gap-2">
                                                <button type="button"
                                                    onclick="document.getElementById('modal-edit-{{ $guru->id }}').classList.add('hidden')"
                                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                                <button type="submit"
                                                    class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </main>
        </div>

        <script>
            function bukaEdit(guru) {
                const form = document.getElementById('form-edit');
                form.action = `/dataguru/${guru.id}`;

                for (const key in guru) {
                    const input = form.querySelector(`[name=${key}]`);
                    if (input && key !== 'password') {
                        input.value = guru[key];
                    }
                }

                document.getElementById('modal-edit').classList.remove('hidden');
            }

            $("document").ready(() => {
                $(".deleteUser").on("submit", e => {
                    e.preventDefault()
                    Swal.fire({
                        title: "Hapus guru!",
                        text: "Apakah Anda yakin ingin menghapus guru ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Tidak, batalkan!",
                    }).then(result => {
                        if (result.isConfirmed) {
                            e.target.submit()
                        }
                    })
                })
            })
        </script>
    </x-app-layout>
</body>
