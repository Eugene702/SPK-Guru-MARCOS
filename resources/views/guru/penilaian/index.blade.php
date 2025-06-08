<title>@yield('title', 'Data Penilaian')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="text-black bg-creamy">
    <x-app-layout>
        <div class="flex h-screen">
           
            <main class="flex-1 p-10 overflow-auto">
                <div class="mb-10">
                    <div class="max-w-6xl mx-auto text-gray-800 text-center rounded-xl shadow-md p-6 bg-[#ffd480]">
                        <h2 class="text-3xl font-bold mb-2">📋 Penilaian Guru oleh Rekan Sejawat</h2>
                        <p class="text-md">
                            Selamat datang di halaman penilaian guru. Di sini, Anda dapat memberikan evaluasi secara
                            objektif terhadap performa guru dalam berbagai aspek.
                            <br>
                            <span class="font-semibold">✨ Tujuan utama penilaian ini adalah untuk meningkatkan kualitas
                                pendidikan melalui apresiasi dan pengembangan berkelanjutan.</span>
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto max-w-6xl mx-auto bg-white shadow-xl rounded-xl p-6">
                    <p class="text-center mb-4">Silakan isi penilaian berdasarkan kuesioner yang tersedia.</p>
                    <div class="text-xl font-bold mb-4">Data yang belum ternilai</div>
                    <x-teacher.assessment.ungraded-table :gurus="$gurus" />

                    <div class="text-xl font-bold mt-10 mb-4">Data yang sudah ternilai</div>
                    <x-teacher.assessment.already-graded-table :gurus="$gurus" />

                    <div class="mt-10 text-center text-sm italic text-gray-500">
                        "Penilaian bukan sekadar angka, tapi cerminan dedikasi dan kontribusi untuk masa depan yang
                        lebih baik."
                    </div>
                </div>
            </main>
        </div>
    </x-app-layout>
</body>
