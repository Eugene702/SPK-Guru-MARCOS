<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@vite(['resources/css/app.css', 'resources/js/app.js'])
<div class="bg-sidebar w-64 !w-64 !min-w-[256px] shrink-0 text-black flex flex-col justify-between h-screen sticky top-0">
    <div>
        <ul class="p-4 space-y-6">
            <li>
                <a href="/admin" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition {{ request()->routeIs('admin.index') ? 'bg-creamy' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="/admin/datakriteria" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition {{ request()->routeIs('admin.datakriteria') ? 'bg-creamy' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i> Data Kriteria
                </a>
            </li>
            <li>
                <a href="/admin/dataguru" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition {{ request()->routeIs('admin.dataguru.index') ? 'bg-creamy' : '' }}">
                    <i class="fas fa-chalkboard-teacher w-5"></i> Data Guru
                </a>
            </li>
            <li>
                <a href="/admin/datasiswa" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition {{ request()->routeIs('admin.datasiswa.index') ? 'bg-creamy' : '' }}">
                    <i class="fas fa-user-graduate w-5"></i> Data Siswa
                </a>
            </li>
            <li>
                <a href="/admin/datapenilaian" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition {{ request()->routeIs('admin.datapenilaian.*') ? 'bg-creamy' : '' }}">
                    <i class="fas fa-check-circle w-5"></i> Penilaian Guru
                </a>
            </li>
            <li>
                <a href="/admin/dataperhitungan" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition {{ request()->routeIs('admin.dataperhitungan.*') ? 'bg-creamy' : '' }}">
                    <i class="fas fa-calculator w-5"></i> Proses Perhitungan
                </a>
            </li>
            <li>
                <a href="/admin/data-hasil-akhir" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition {{ request()->routeIs('admin.final-result-data.index') ? 'bg-creamy' : '' }}">
                    <i class="fas fa-ranking-star w-5"></i> Hasil Akhir dan Peringkat
                </a>
            </li>
        </ul>
    </div>
</div>
