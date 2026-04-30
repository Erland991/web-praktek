<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIMPA - PT Surveyor Indonesia (Persero)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }
        h1, h2, h3 {
            font-family: 'Outfit', sans-serif;
        }
        .bg-animate {
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4 overflow-hidden relative">
    
    <!-- Animated Background Elements -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-[pulse_6s_ease-in-out_infinite]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-yellow-400 rounded-full mix-blend-multiply filter blur-[100px] opacity-30 animate-[pulse_8s_ease-in-out_infinite]" style="animation-delay: 2s;"></div>

    <div class="flex flex-col md:flex-row glass-panel rounded-3xl shadow-[0_20px_50px_rgba(8,_112,_184,_0.15)] overflow-hidden max-w-5xl w-full relative z-10 border border-white/50" data-aos="zoom-in" data-aos-duration="1000">

        <!-- Kolom Kiri: Visual & Landing Branding -->
        <div
            class="md:w-6/12 bg-cover bg-center p-10 text-white flex flex-col justify-between relative overflow-hidden hidden md:flex"
            style="background-image: url('<?= base_url('images/1663301594-surveyor-indonesia.png') ?>');">
            
            <!-- Overlay untuk Keterbacaan -->
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/40 to-transparent z-0"></div>

            <div class="relative z-10">
                <div class="bg-white/10 backdrop-blur-md inline-block px-4 py-2 rounded-lg border border-white/20 mb-6" data-aos="fade-right" data-aos-delay="300">
                    <span class="text-xs font-bold tracking-[0.2em] uppercase text-yellow-400">Enterprise Management System</span>
                </div>
                <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight mb-4 drop-shadow-2xl" data-aos="fade-right" data-aos-delay="500">
                    Integrasi & <br><span class="text-blue-300">Integritas</span><br>Untuk Negeri.
                </h1>
                <p class="text-lg text-blue-100/90 max-w-md leading-relaxed" data-aos="fade-up" data-aos-delay="700">
                    Menjamin kepastian melalui layanan inspeksi, pengujian, sertifikasi, konsultansi, dan verifikasi untuk masa depan Indonesia yang lebih baik.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-4" data-aos="fade-up" data-aos-delay="900">
                <div class="w-12 h-1 bg-yellow-400 rounded-full"></div>
                <p class="text-sm font-semibold tracking-widest uppercase opacity-90">PT Surveyor Indonesia (Persero)</p>
            </div>
        </div>

        <!-- Kolom Kanan: Form Login -->
        <div class="md:w-6/12 p-8 md:p-14 flex flex-col justify-center bg-white/80 backdrop-blur-md relative" data-aos="fade-left" data-aos-delay="200">

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

            </form>

            <div class="mt-10 text-center text-slate-400 text-xs font-medium" data-aos="fade-up" data-aos-delay="600">
                &copy; <?= date('Y') ?> PT Surveyor Indonesia (Persero). All rights reserved.
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 800,
            easing: 'ease-out-cubic',
        });
    </script>
</body>

</html>
