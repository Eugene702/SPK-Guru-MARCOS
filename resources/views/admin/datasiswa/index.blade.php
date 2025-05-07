<title>@yield('title', 'Data Siswa')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])

<body class="bg-creamy">
    <x-app-layout>
    <div class="flex h-screen">
        @include('components.sidebar-admin')

        {{-- Konten lainnya disini --}}
        <main class="flex-1 p-10">
            <h1 class="text-2xl font-bold">Data Siswa</h1>

            {{-- Alert sukses start --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif
            {{-- Alert sukses end --}}

            <!-- Tombol membuka modal -->
            <div class="flex justify-end mb-4">
                <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-green-600 text-white px-4 py-2 rounded bg">
                    + Tambah Data
                </button>
            </div>
            
            <!-- Modal Tambah Data -->
            <div id="modalTambah" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded w-full max-w-md">
                    <h2 class="text-xl font-bold mb-4 text-center">Tambah Data Siswa</h2>
                    <form action="{{ route('admin.datasiswa.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="text-sm text-gray-700">Nama</label>
                            <input type="text" name="nama_siswa" class="w-full border p-2 rounded-md border-gray-300 shadow-sm" placeholder="Nama Siswa" required>
                        </div>
                        <div class="mb-2">
                            <label class="text-sm text-gray-700">Email</label>
                            <input type="email" name="email" class="w-full border p-2 rounded-md border-gray-300 shadow-sm" placeholder="Email" required>
                        </div>
                        <div class="mb-2">
                            <label class="text-sm text-gray-700">Password</label>
                            <input type="password" name="password" class="w-full border p-2 rounded-md border-gray-300 shadow-sm" placeholder="Password" required>
                        </div>
                        <div class="mb-4">
                            <label for="kelas_id" class="text-sm text-gray-700">Kelas</label>
                            <select name="kelas_id" class="w-full border p-2 rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelass as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-sidebar text-gray-800 rounded hover:bg-thead">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table start --}}
            <table class="w-full table-auto border-collapse border border-gray-300 mt-6">
                <thead class="bg-thead">
                    <tr>
                        <th class="border px-4 py-2">No</th>
                        <th class="border px-4 py-2">Nama Siswa</th>
                        <th class="border px-4 py-2">Kelas</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswas as $index => $siswa)

                    <!-- Modal Edit -->
                    <div id="modalEdit{{ $siswa->id }}" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center z-50">
                        <div class="bg-white p-6 rounded w-full max-w-md">
                            <h2 class="text-xl font-bold mb-4 text-center">Edit Data Siswa</h2>
                            <form action="{{ route('admin.datasiswa.update', $siswa->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-2">
                                    <label class="text-sm text-gray-700">Nama</label>
                                    <input type="text" name="nama_siswa" value="{{ $siswa->user->name }}" class="w-full border p-2 rounded-md border-gray-300 shadow-sm">
                                </div>           
                                <div class="mb-2">
                                    <label class="text-sm text-gray-700">Email</label>
                                    <input type="email" name="email" value="{{ $siswa->user->email }}" class="w-full border p-2 rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div class="mb-2">
                                    <label class="text-sm text-gray-700">Password (kosongkan jika tidak diganti):</label>
                                    <input type="password" name="password" class="w-full border p-2 rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="text-sm text-gray-700">Kelas</label>
                                    <select name="kelas_id" class="w-full border p-2 rounded-md border-gray-300 shadow-sm">
                                        @foreach ($kelass as $kelas)
                                            <option value="{{ $kelas->id }}" {{ $kelas->id == $siswa->kelas_id ? 'selected' : '' }}>
                                                {{ $kelas->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>     
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="document.getElementById('modalEdit{{ $siswa->id }}').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-sidebar text-gray-800 rounded hover:bg-thead">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Modal Edit -->

                    <tr class="text-center border-b">
                        <td class="border px-4 py-2">{{ $index + 1 }}</td>
                        <td class="border px-4 py-2">{{ $siswa->user->name}}</td>
                        <td class="border px-4 py-2">{{ $siswa->kelas->nama_kelas }}</td>
                        <td class="border px-4 py-2">{{ $siswa->user->email}}</td>
                        <td class="border px-4 py-2 flex justify-center gap-2">
                            <a href="#" onclick="document.getElementById('modalEdit{{ $siswa->id }}').classList.remove('hidden')" class="text-yellow-500 hover:text-yellow-700">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.datasiswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </div>
</x-app-layout>
</body>