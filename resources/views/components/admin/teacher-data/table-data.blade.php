<div x-data="{
    editId: null,
    data: @js($gurus),
    tooltip: {
        show: false,
        content: '',
        x: 0,
        y: 0
    },
    handleOnClickDelete(e, guru) {
        Swal.fire({
            title: 'Hapus guru!',
            text: `Apakah kamu yakin ingin menghapus guru ${guru.user.name} ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            confirmButtonColor: '#ffd480',
            cancelButtonColor: '#d1d5db',
            focusCancel: true,
            customClass: {
                confirmButton: 'swal-confirm-btn text-black',
                cancelButton: 'swal-cancel-btn text-black'
            }
        }).then(result => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        })
    }
}">

    <table class="table-auto divide-y divide-gray-200">
        <thead class="bg-thead text-black">
            <tr>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[50px]">No</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[150px]">NIP</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[200px]">Nama Guru</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[120px]">Jabatan</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[70px]">Kelas</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[200px]">Mata Pelajaran</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[120px]">Jam Mengajar</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[100px]">Presensi</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[200px]">Email</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[100px]">Aksi</th>
            </tr>
        </thead>

        <tbody class="bg-white text-gray-800">
            @foreach ($gurus as $index => $guru)
                <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} text-center hover:bg-yellow-50 transition">
                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>

                    <td class="px-4 py-2 border whitespace-nowrap overflow-hidden text-ellipsis"
                        @mouseenter="tooltip.content = '{{ addslashes($guru->nip) }}'; tooltip.show = true"
                        @mouseleave="tooltip.show = false"
                        @mousemove="tooltip.x = $event.clientX; tooltip.y = $event.clientY">
                        {{ $guru->nip }}
                    </td>

                    <td class="px-4 py-2 border whitespace-nowrap overflow-hidden text-ellipsis"
                        @mouseenter="tooltip.content = '{{ addslashes($guru->user->name ?? '') }}'; tooltip.show = true"
                        @mouseleave="tooltip.show = false"
                        @mousemove="tooltip.x = $event.clientX; tooltip.y = $event.clientY">
                        {{ $guru->user->name ?? 'Data user tidak tersedia' }}
                    </td>

                    <td class="px-4 py-2 border whitespace-nowrap overflow-hidden text-ellipsis"
                        @mouseenter="tooltip.content = '{{ addslashes($guru->jabatan) }}'; tooltip.show = true"
                        @mouseleave="tooltip.show = false"
                        @mousemove="tooltip.x = $event.clientX; tooltip.y = $event.clientY">
                        {{ $guru->jabatan }}
                    </td>

                    <td class="px-4 py-2 border text-left whitespace-nowrap overflow-hidden text-ellipsis"
                        @if ($guru->kelas->isNotEmpty())
                            @mouseenter="tooltip.content = '{{ addslashes($guru->kelas->pluck('nama_kelas')->implode(', ')) }}'; tooltip.show = true"
                            @mouseleave="tooltip.show = false"
                            @mousemove="tooltip.x = $event.clientX; tooltip.y = $event.clientY"
                        @endif>
                        @foreach ($guru->kelas as $kelas)
                            <div>{{ $kelas->nama_kelas }}</div>
                        @endforeach
                    </td>

                    <td class="px-4 py-2 border text-left whitespace-nowrap overflow-hidden text-ellipsis"
                        @if ($guru->mataPelajarans->isNotEmpty())
                            @mouseenter="tooltip.content = '{{ addslashes($guru->mataPelajarans->pluck('nama_mata_pelajaran')->implode(', ')) }}'; tooltip.show = true"
                            @mouseleave="tooltip.show = false"
                            @mousemove="tooltip.x = $event.clientX; tooltip.y = $event.clientY"
                        @endif>
                        @foreach ($guru->mataPelajarans as $mapel)
                            <div>{{ $mapel->nama_mata_pelajaran }}</div>
                        @endforeach
                    </td>

                    <td class="px-4 py-2 border">{{ $guru->jumlah_jam_mengajar }}</td>
                    <td class="px-4 py-2 border">{{ $guru->jumlah_presensi }}</td>

                    <td class="px-4 py-2 border whitespace-nowrap overflow-hidden text-ellipsis"
                         @mouseenter="tooltip.content = '{{ addslashes($guru->user?->email ?? '-') }}'; tooltip.show = true"
                         @mouseleave="tooltip.show = false"
                         @mousemove="tooltip.x = $event.clientX; tooltip.y = $event.clientY">
                        {{ $guru->user?->email ?? '-' }}
                    </td>

                    <td class="px-4 py-2 border">
                        <div class="flex justify-center items-start gap-4 text-lg">
                            <button @click="editId = {{ $guru->id }}" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.dataguru.destroy', $guru->id) }}" method="POST"
                                @submit.prevent="handleOnClickDelete($event, data.find(g => g.id === {{ $guru->id }}))">
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

    <div x-show="tooltip.show" x-transition
         x-text="tooltip.content"
         :style="`position: fixed; top: ${tooltip.y + 15}px; left: ${tooltip.x + 10}px; z-index: 9999;`"
         class="bg-black text-white text-xs px-2 py-1 rounded shadow-lg pointer-events-none whitespace-nowrap">
    </div>
</div>