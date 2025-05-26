<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="bg-sidebar w-64 text-black flex flex-col justify-between">
    <div>
  
        <ul class="p-4 space-y-6">
            <li>
                <a href="{{ route('kepsek.penilaian.index') }}" class="{{ request()->routeIs('kepsek.penilaian.index') ? 'bg-creamy' : '' }} flex items-center gap-2 hover:bg-creamy hover:text-black px-2 py-2 rounded transition">
                    <i class="fas fa-check-circle w-5"></i> Data Penilaian
                </a>
            </li>
        </ul>
        
    </div>
</div>
