<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kehadiran Mahasiswa</title>
    <link href="css/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Subtle grid overlay -->
    <div class="absolute inset-0 bg-[radial-gradient(#d1d5db_1px,transparent_1px)] [background-size:32px_32px] opacity-30"></div>

    <!-- Decorative blurred elements -->
    <div class="card-decor top-[-140px] left-[-100px] w-[400px] h-[400px] bg-gradient-to-br from-emerald-200/30 to-emerald-400/10 blur-3xl"></div>
    <div class="card-decor bottom-[-200px] right-[-120px] w-[500px] h-[500px] bg-gradient-to-tl from-gray-300/25 to-white/10 blur-3xl"></div>
    <div class="card-decor top-[15%] right-[-60px] w-[220px] h-[220px] bg-emerald-200/15 blur-2xl"></div>
    <div class="card-decor bottom-[20%] left-[-40px] w-[180px] h-[180px] bg-white/30 blur-2xl"></div>

    <!-- Main card -->
    <div class="w-full max-w-md relative z-10 animate-fade-up">

        <!-- Notification area -->
        <div id="resultArea" class="mb-6 p-4 rounded-2xl glass-notif hidden transition-all duration-500">
        </div>

        <!-- Form card -->
        <div class="glass-card rounded-3xl p-8 relative">
            <!-- Subtle top highlight -->
            <div class="absolute top-0 left-8 right-8 h-px bg-gradient-to-r from-transparent via-white/80 to-transparent"></div>

            <h2 class="text-2xl text-center text-gray-800 mb-7 tracking-tight min-h-[2.5rem]">
                <span id="typewriter-text"></span><span id="typewriter-cursor"></span>
            </h2>
            
            <form id="kehadiranForm" method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                <div class="mb-5">
                    <label class="block text-gray-500 font-semibold mb-2 text-xs tracking-widest uppercase">Nama Lengkap</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="text" name="nama" id="nama" 
                               class="input-field w-full pl-10 pr-4 py-3.5 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none transition-all duration-300"
                               placeholder="Masukkan nama mahasiswa" required>
                    </div>
                    <p id="namaError" class="text-red-500 text-xs mt-1.5 hidden">Nama harus diisi</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-500 font-semibold mb-2 text-xs tracking-widest uppercase">Status Kehadiran</label>
                    <div class="relative">
                        <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <select name="status" id="status" 
                                class="input-field w-full px-4 pr-10 py-3.5 rounded-xl text-gray-800 focus:outline-none transition-all duration-300 appearance-none cursor-pointer"
                                required>
                            <option value="" class="bg-white text-gray-400">Pilih status</option>
                            <option value="Hadir" class="bg-white text-gray-800">Hadir</option>
                            <option value="Izin" class="bg-white text-gray-800">Izin</option>
                            <option value="Sakit" class="bg-white text-gray-800">Sakit</option>
                            <option value="Tidak Hadir" class="bg-white text-gray-800">Tidak Hadir</option>
                        </select>
                    </div>
                    <p id="statusError" class="text-red-500 text-xs mt-1.5 hidden">Pilih status</p>
                </div>

                <button type="submit" name="submit" 
                        class="w-full bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-emerald-200/50 hover:shadow-emerald-300/50 transition-all duration-300 active:scale-[0.98]">
                    Submit
                </button>
            </form>
        </div>
    </div>

    <script src="js/typewriter.js"></script>
    <script src="js/script.js"></script>
</body>
</html>