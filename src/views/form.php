<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kehadiran Mahasiswa</title>
    <link href="css/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-teal-950 via-teal-900 to-cyan-950 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Subtle underwater light overlay -->
    <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,0.10)_1px,transparent_1px)] [background-size:40px_40px]"></div>

    <!-- Decorative blurred underwater elements -->
    <div class="card-decor top-[-140px] left-[-100px] w-[400px] h-[400px] bg-gradient-to-br from-teal-400/15 to-cyan-500/10 blur-3xl"></div>
    <div class="card-decor bottom-[-200px] right-[-120px] w-[500px] h-[500px] bg-gradient-to-tl from-cyan-400/15 to-teal-500/10 blur-3xl"></div>
    <div class="card-decor top-[15%] right-[-60px] w-[220px] h-[220px] bg-teal-300/10 blur-2xl"></div>
    <div class="card-decor bottom-[20%] left-[-40px] w-[180px] h-[180px] bg-cyan-300/10 blur-2xl"></div>

    <!-- Main card -->
    <div class="w-full max-w-md relative z-10 animate-fade-up">

        <!-- Notification area -->
        <div id="resultArea" class="mb-6 p-4 rounded-2xl glass-notif hidden transition-all duration-500">
        </div>

        <!-- Form card -->
        <div class="glass-card rounded-3xl p-8 relative">
            <!-- Subtle top highlight -->
            <div class="absolute top-0 left-8 right-8 h-px bg-gradient-to-r from-transparent via-white/80 to-transparent"></div>

            <h2 class="text-2xl text-center text-white/90 mb-7 tracking-tight min-h-[2.5rem]">
                <span id="typewriter-text"></span><span id="typewriter-cursor"></span>
            </h2>
            
            <form id="kehadiranForm" method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                <div class="mb-5">
                    <label class="block text-teal-200/80 font-semibold mb-2 text-xs tracking-widest uppercase">Nama Lengkap</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-teal-300/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="text" name="nama" id="nama" 
                               class="input-field w-full pl-10 pr-4 py-3.5 rounded-xl text-white placeholder-teal-300/50 focus:outline-none transition-all duration-300"
                               placeholder="Masukkan nama mahasiswa" required>
                    </div>
                    <p id="namaError" class="text-red-500 text-xs mt-1.5 hidden">Nama harus diisi</p>
                </div>

                <div class="mb-6">
                    <label class="block text-teal-200/80 font-semibold mb-2 text-xs tracking-widest uppercase">Status Kehadiran</label>
                    <div class="relative">
                        <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-teal-300/60 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <select name="status" id="status" 
                                class="input-field w-full px-4 pr-10 py-3.5 rounded-xl text-white focus:outline-none transition-all duration-300 appearance-none cursor-pointer"
                                required>
                            <option value="" class="bg-teal-900 text-teal-300/50">Pilih status</option>
                            <option value="Hadir" class="bg-teal-900 text-white">Hadir</option>
                            <option value="Izin" class="bg-teal-900 text-white">Izin</option>
                            <option value="Sakit" class="bg-teal-900 text-white">Sakit</option>
                            <option value="Tidak Hadir" class="bg-teal-900 text-white">Tidak Hadir</option>
                        </select>
                    </div>
                    <p id="statusError" class="text-red-500 text-xs mt-1.5 hidden">Pilih status</p>
                </div>

                <button type="submit" name="submit" 
                        class="w-full bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-400 hover:to-cyan-500 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-teal-950/50 hover:shadow-teal-900/50 transition-all duration-300 active:scale-[0.98]">
                    Submit
                </button>
            </form>
        </div>
    </div>

    <script src="js/typewriter.js"></script>
    <script src="js/script.js"></script>
</body>
</html>