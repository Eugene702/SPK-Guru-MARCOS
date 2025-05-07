<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="bg-sidebar w-64 text-black flex flex-col justify-between">
    <div>
  
        <ul class="p-4 space-y-6">
            <li>
                <a href="/admin" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition">
                    <i class="fas fa-tachometer-alt w-5"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="/admin/datakriteria" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition">
                    <i class="fas fa-stream w-5"></i> Data Kriteria
                </a>
            </li>
            <li>
                <a href="/admin/datasubkriteria" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition">
                    <i class="fas fa-layer-group w-5"></i> Data Sub Kriteria
                </a>
            </li>
            <li>
                <a href="/admin/dataguru" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition">
                    <i class="fas fa-chalkboard-teacher w-5"></i> Data Guru
                </a>
            </li>
            <li>
                <a href="/admin/datasiswa" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition">
                    <i class="fas fa-user-graduate w-5"></i> Data Siswa
                </a>
            </li>
            <li>
                <a href="/admin/datapenilaian" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition">
                    <i class="fas fa-check-circle w-5"></i> Data Penilaian
                </a>
            </li>
            <li>
                <a href="/admin/dataperhitungan" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition">
                    <i class="fas fa-calculator w-5"></i> Data Perhitungan
                </a>
            </li>
            <li>
                <a href="/admin/data-hasil-akhir" class="flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition">
                    <i class="fas fa-ranking-star w-5"></i> Data Hasil Akhir
                </a>
            </li>
        </ul>
    </div>
</div>
