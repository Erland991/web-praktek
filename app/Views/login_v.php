<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIMPA - PT Surveyor Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-2xl overflow-hidden max-w-4xl w-full">

        <!-- Kolom Kiri: Visual & Landing Branding -->
        <div
            class="md:w-6/12 bg-cover bg-center p-10 text-white flex flex-col justify-between relative overflow-hidden hidden md:flex"
            style="background-image: url('<?= base_url('images/1663301594-surveyor-indonesia.png') ?>');">
            
            <!-- Overlay untuk Keterbacaan -->
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/40 to-transparent z-0"></div>

            <div class="relative z-10">
                <div class="bg-white/10 backdrop-blur-md inline-block px-4 py-2 rounded-lg border border-white/20 mb-6">
                    <span class="text-xs font-bold tracking-[0.2em] uppercase">Enterprise Management System</span>
                </div>
                <h1 class="text-5xl font-extrabold leading-tight mb-4 drop-shadow-2xl">
                    Integrasi & <br><span class="text-blue-400">Integritas</span> Untuk Negeri.
                </h1>
                <p class="text-lg text-blue-100/90 max-w-md leading-relaxed">
                    Menjamin kepastian melalui layanan inspeksi, pengujian, sertifikasi, konsultansi, dan verifikasi untuk masa depan Indonesia yang lebih baik.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-4">
                <div class="w-12 h-1 bg-blue-500 rounded-full"></div>
                <p class="text-sm font-semibold tracking-widest uppercase opacity-80">PT Surveyor Indonesia</p>
            </div>
        </div>

        <!-- Kolom Kanan: Form Login -->
        <div class="md:w-6/12 p-8 md:p-14 flex flex-col justify-center bg-white relative">

            <!-- Deretan Logo Perusahaan -->
            <div class="flex items-center justify-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <img src="<?= base_url('images/logo_danantara.png') ?>" alt="Logo Danantara"
                    class="h-5 md:h-6 object-contain opacity-60">
                <img src="<?= base_url('images/logo_idsurvey.png') ?>" alt="Logo IDSurvey"
                    class="h-5 md:h-6 object-contain opacity-60">
                <img src="<?= base_url('images/logo_si.png') ?>" alt="Logo Surveyor Indonesia"
                    class="h-10 md:h-12 object-contain drop-shadow-sm px-1">
                <img src="<?= base_url('images/logo_simpa.png') ?>" alt="Logo SIMPA"
                    class="h-6 md:h-8 object-contain drop-shadow-md -ml-4">
            </div>

            <!-- Header Form -->
            <div class="mb-8 text-center">
                <h3 class="text-2xl font-bold text-slate-800">Selamat Datang</h3>
                <p class="text-slate-500 text-sm mt-2">Silakan masuk menggunakan kredensial Anda</p>
                
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="mt-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm font-medium">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>


            </div>

            <!-- Form -->
            <form action="<?= base_url('login') ?>" method="POST" class="space-y-5">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="username"
                            class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 focus:outline-none transition-all duration-300"
                            placeholder="Masukkan Username" required autofocus>
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="password" name="password"
                            class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 focus:outline-none transition-all duration-300"
                            placeholder="Masukkan Password" required>
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Pilih Role</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <select name="role_akses"
                            class="w-full pl-11 pr-10 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 focus:outline-none transition-all duration-300 appearance-none cursor-pointer text-slate-700">
                            <option value="Admin">Administrator</option>
                            <option value="User">User / PIC Proyek</option>
                            <option value="Viewer">Viewer / Eksekutif Pemantau</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-700 to-blue-800 hover:from-blue-800 hover:to-blue-900 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex justify-center items-center gap-2 group">
                        <span>Masuk ke Sistem</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1.5 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-10 text-center text-slate-400 text-xs font-medium">
                &copy; <?= date('Y') ?> PT Surveyor Indonesia (Persero). All rights reserved.
            </div>
        </div>
    </div>
</body>

</html>
