<title>@yield('title', 'Data Guru')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])

<body class="bg-creamy">
    <x-app-layout>
        <div class="flex h-screen">
            @include('components.sidebar-admin')

            <!-- Konten lainnya di sini -->
            <main class="flex-1 p-10">
                <h1 class="text-2xl font-bold">Data Guru</h1>

                {{-- Alert sukses start --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                {{-- Alert sukses end --}}

                <!-- Tombol membuka modal tambah data-->
                <div class="flex justify-end mb-2">
                    <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
                        class="bg-green-600 text-white px-4 py-2 rounded mb-4">Tambah Data</button>
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
                                    <h4 class="text-md font-semibold mb-2 text-center">Pilih Mata Pelajaran</h4>
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
                                        @foreach ($kelas as $item)
                                            <label class="flex items-center space-x-2">
                                                <input type="checkbox" name="kelas[]" value="{{ $item->id }}"
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
                </div>

                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-thead">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">NIP</th>
                            <th class="border px-4 py-2">Nama Guru</th>
                            <th class="border px-4 py-2">Jabatan</th>
                            <th class="border px-4 py-2">Kelas</th>
                            <th class="border px-4 py-2">Mata Pelajaran</th>
                            <th class="border px-4 py-2">Jumlah Jam Mengajar</th>
                            <th class="border px-4 py-2">Jumlah Presensi</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gurus as $index => $guru)
                            <!-- Modal Edit Data Guru -->
                            <div id="modal-edit-{{ $guru->id }}"
                                class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
                                    <h2 class="text-xl font-bold mb-4">Edit Data Guru</h2>
                                    <form action="{{ route('admin.dataguru.update', ['id' => $guru->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid grid-cols-2 gap-4">
                                            <input type="text" name="nip" class="border p-2 rounded"
                                                value="{{ $guru->nip }}" required>
                                            <input type="text" name="nama" class="..."
                                                value="{{ $guru->user->name }}">
                                            <input type="text" name="jabatan" class="border p-2 rounded"
                                                value="{{ $guru->jabatan }}" required>
                                            <input type="text" name="mata_pelajaran" class="border p-2 rounded"
                                                value="{{ $guru->mata_pelajaran }}" required>
                                            <input type="number" name="jumlah_jam_mengajar"
                                                class="border p-2 rounded" value="{{ $guru->jumlah_jam_mengajar }}"
                                                required>
                                            <input type="number" name="jumlah_presensi" class="border p-2 rounded"
                                                value="{{ $guru->jumlah_presensi }}" required>
                                            <input type="email" name="email" class="border p-2 rounded"
                                                value="{{ $guru->user->email }}">
                                            <input type="password" name="password" class="border p-2 rounded"
                                                placeholder="Kosongkan jika tidak diubah">
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

                            <tr class="text-center border-b">
                                <td class="border px-2 py-1">{{ $index + 1 }}</td>
                                <td class="border px-2 py-1">{{ $guru->nip }}</td>
                                <td class="border px-2 py-1">
                                    @if ($guru->user)
                                        {{ $guru->user->name }}
                                    @else
                                        Data user tidak tersedia
                                    @endif
                                </td>
                                <td class="border px-2 py-1">{{ $guru->jabatan }}</td>
                                <!-- Tampilkan semua kelas -->
                                <td class="border px-2 py-1">
                                    @foreach ($guru->kelas as $kelas)
                                        <div>{{ $kelas->nama_kelas }}</div>
                                    @endforeach
                                </td>
                                <!-- Tampilkan semua mata pelajaran -->
                                <td class="border px-2 py-1">
                                    @foreach ($guru->mataPelajarans as $mapel)
                                        <div>{{ $mapel->nama_mata_pelajaran }}</div>
                                    @endforeach
                                </td>
                                <td class="border px-2 py-1">{{ $guru->jumlah_jam_mengajar }}</td>
                                <td class="border px-2 py-1">{{ $guru->jumlah_presensi }}</td>
                                <td class="border px-2 py-1">{{ $guru->user?->email ?? '-' }}</td>
                                <td class="border px-2 py-1 flex justify-center gap-2">
                                    <a href="#"
                                        onclick="document.getElementById('modal-edit-{{ $guru->id }}').classList.remove('hidden')"
                                        class="text-yellow-500 hover:text-yellow-700">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.dataguru.destroy', $guru->id) }}" method="POST"
                                        class="deleteUser" onsubmit="return handleOnClickDelete(event)">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
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
