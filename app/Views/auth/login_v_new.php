<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIMPA - PT Surveyor Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-2xl overflow-hidden max-w-4xl w-full">
        <div class="md:w-5/12 bg-gradient-to-br from-blue-900 via-blue-800 to-slate-900 p-10 text-white flex flex-col justify-between relative overflow-hidden hidden md:flex">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 rounded-full bg-white opacity-5 mix-blend-overlay"></div>
            <div class="relative z-10">
                <h1 class="text-4xl font-extrabold tracking-tight mb-2">SIMPA</h1>
                <p class="text-blue-100 text-sm font-medium tracking-widest leading-relaxed">SISTEM INFORMASI MANAJEMEN<br />PROYEK APLIKASI</p>
            </div>
            <div class="relative z-10 mt-12 md:mt-0">
                <h2 class="text-lg font-bold mb-2">PT Surveyor Indonesia (Persero)</h2>
            </div>
        </div>

        <div class="md:w-7/12 p-8 md:p-12 flex flex-col justify-center bg-white relative">
            <div class="flex items-center justify-center gap-6 mb-8 pb-6 border-b border-slate-100">
                <img src="<?= base_url('images/logo_danantara.png') ?>" alt="Logo" class="h-8 md:h-10 object-contain">
                <img src="<?= base_url('images/logo_si.png') ?>" alt="Logo" class="h-8 md:h-10 object-contain">
            </div>

            <div class="mb-8 text-center">
                <h3 class="text-2xl font-bold text-slate-800">Selamat Datang</h3>
                <p class="text-slate-500 text-sm mt-2">Silakan masuk menggunakan kredensial Anda</p>
                
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="mt-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-xs font-bold rounded text-left">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
            </div>

            <form action="<?= base_url('login') ?>" method="POST" class="space-y-5">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Username</label>
                    <input type="text" name="username" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-600 focus:outline-none transition-all" placeholder="Username" required>
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-600 focus:outline-none transition-all" placeholder="Password" required>
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Pilih Role</label>
                    <select name="role_akses" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-600 focus:outline-none cursor-pointer text-slate-700">
                        <option value="Admin">Administrator</option>
                        <option value="User">User / PIC Proyek</option>
                    </select>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3.5 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2">
                        Masuk ke Sistem
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>