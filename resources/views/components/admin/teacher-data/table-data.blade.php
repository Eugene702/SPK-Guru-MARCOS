<div x-data="{
    editId: null,
    data: {{ $gurus }},
    handleOnClickDelete(e) {
        Swal.fire({
            title: 'Hapus guru!',
            text: 'Apakah kamu yakin ingin menghapus guru ini?',
            icon: 'question',
            showCancelButton: true,
        }).then(result => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        })
    }
}">
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
                <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} text-center hover:bg-yellow-50 transition">
                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>

                    <td class="px-4 py-2 border whitespace-nowrap truncate max-w-[120px] relative">
                        <div x-data="{ show: false, tooltipX: 0, tooltipY: 0 }" @mouseenter="show = true" @mouseleave="show = false"
                            @mousemove="tooltipX = $event.clientX; tooltipY = $event.clientY">
                            <span>{{ $guru->nip }}</span>
                            <div x-show="show" x-transition
                                :style="`top: ${tooltipY + 10}px; left: ${tooltipX + 10}px`"
                                class="fixed z-50 bg-black text-white text-xs px-2 py-1 rounded shadow pointer-events-none">
                                {{ $guru->nip }}
                            </div>
                        </div>
                    </td>


                    <td class="px-4 py-2 border text-left">
                        {{ $guru->user->name ?? 'Data user tidak tersedia' }}
                    </td>

                    <td class="px-4 py-2 border">{{ $guru->jabatan }}</td>

                    <td class="px-4 py-2 border text-left">
                        @foreach ($guru->kelas as $kelas)
                            <div>{{ $kelas->nama_kelas }}</div>
                        @endforeach
                    </td>

                    <td class="px-4 py-2 border text-left">
                        @foreach ($guru->mataPelajarans as $mapel)
                            <div>{{ $mapel->nama_mata_pelajaran }}</div>
                        @endforeach
                    </td>

                    <td class="px-4 py-2 border">{{ $guru->jumlah_jam_mengajar }}</td>
                    <td class="px-4 py-2 border">{{ $guru->jumlah_presensi }}</td>

                    <td class="px-4 py-2 border whitespace-nowrap truncate max-w-[150px] relative">
                        <div x-data="{ show: false, tooltipX: 0, tooltipY: 0 }" @mouseenter="show = true" @mouseleave="show = false"
                            @mousemove="tooltipX = $event.clientX; tooltipY = $event.clientY">
                            <span>{{ $guru->user?->email ?? '-' }}</span>
                            <div x-show="show" x-transition
                                :style="`top: ${tooltipY + 10}px; left: ${tooltipX + 10}px`"
                                class="fixed z-50 bg-black text-white text-xs px-2 py-1 rounded shadow pointer-events-none">
                                {{ $guru->user?->email ?? '-' }}
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-2 border">
                        <div class="flex justify-center items-start gap-4 text-lg">
                            <button @click="editId = {{ $guru->id }}" class="text-yellow-500 hover:text-yellow-700"
                                title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.dataguru.destroy', $guru->id) }}" method="POST"
                                @submit.prevent="handleOnClickDelete">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <x-admin.teacher-data.edit-modal :$opsiKelas :$mataPelajarans />
</div>
