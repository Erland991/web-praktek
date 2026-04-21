<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Monitoring Aset PT Surveyor Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.4s ease-out forwards; }
    </style>
</head>
<body class="bg-slate-50 font-sans min-h-screen flex text-slate-800">
    <!-- Left Section - Login Form -->
    <div class="w-full lg:w-5/12 xl:w-1/3 flex flex-col justify-center px-8 sm:px-16 md:px-24 bg-white relative z-10 shadow-2xl">
        <div class="mb-10 text-center lg:text-left">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-xl bg-blue-600 shadow-lg shadow-blue-600/30 mb-6 mx-auto lg:mx-0">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Welcome Back</h1>
            <p class="text-slate-500 font-medium">Monitoring Aset PT Surveyor Indonesia</p>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r flex items-start shadow-sm fade-in">
                <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-red-700 text-sm font-medium"><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase">Username</label>
                <input type="text" name="username" class="w-full px-5 py-4 rounded-xl bg-slate-100 border-transparent focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-slate-800" placeholder="Enter your username" required>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-bold text-slate-700 tracking-wide uppercase">Password</label>
                </div>
                <input type="password" name="password" class="w-full px-5 py-4 rounded-xl bg-slate-100 border-transparent focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-slate-800" placeholder="Enter your password" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase">Role Access</label>
                <div class="relative">
                    <select name="role_akses" class="w-full px-5 py-4 rounded-xl bg-slate-100 border-transparent focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all duration-300 appearance-none text-slate-800 font-medium">
                        <option value="admin">Administrator (IT/System Ops)</option>
                        <option value="user">User / PIC Project</option>
                        <option value="viewer">Viewer / Eksekutif Pemantau</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-600/30 transform hover:-translate-y-1 transition duration-300 mt-8 tracking-wider">
                SIGN IN SECURELY
            </button>
        </form>
        
        <div class="mt-12 text-center lg:text-left">
            <p class="text-sm text-slate-400 font-medium">&copy; <?= date('Y') ?> PT Surveyor Indonesia. All rights reserved.</p>
        </div>
    </div>

    <!-- Right Section - Image/Branding -->
    <div class="hidden lg:flex w-full lg:w-7/12 xl:w-2/3 bg-slate-900 relative items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-blue-900 opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 to-slate-900 z-0"></div>
        
        <!-- Abstract Shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-blue-600 mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-40 -right-40 w-96 h-96 rounded-full bg-cyan-500 mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-40 left-20 w-96 h-96 rounded-full bg-blue-800 mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative z-10 p-20 flex flex-col items-center text-center">
            <h2 class="text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight drop-shadow-lg">
                Enterprise<br>
                <span class="text-blue-400">Asset Intelligence</span>
            </h2>
            <p class="text-xl text-blue-100/80 max-w-2xl leading-relaxed mb-10">
                Empowering PT Surveyor Indonesia with real-time monitoring, infrastructure control, and comprehensive analytics for secure operations.
            </p>
            
            <!-- Glassmorphism Stats -->
            <div class="grid grid-cols-2 gap-6 w-full max-w-xl">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl">
                    <p class="text-blue-200 font-medium mb-1">System Uptime</p>
                    <p class="text-4xl font-bold text-white">99.98%</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl">
                    <p class="text-blue-200 font-medium mb-1">Active Assets</p>
                    <p class="text-4xl font-bold text-white">2,400+</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>