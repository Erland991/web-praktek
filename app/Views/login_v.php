<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Monitoring Aset SI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-900 to-blue-600 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden">
        
        <div class="hidden md:flex md:w-1/2 bg-blue-50 items-center justify-center p-12">
            <div class="text-center">
                <div class="bg-blue-600 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-server text-white text-4xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-blue-900 mb-2">Monitoring Aset</h2>
                <p class="text-blue-600 font-medium">PT Surveyor Indonesia</p>
                <div class="mt-8 space-y-3 text-left inline-block text-gray-600 text-sm">
                    <p><i class="fas fa-check-circle text-green-500 mr-2"></i> COBIT-19 Integration</p>
                    <p><i class="fas fa-check-circle text-green-500 mr-2"></i> Real-time Application Tracking</p>
                    <p><i class="fas fa-check-circle text-green-500 mr-2"></i> Security Verified</p>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12">
            <div class="mb-10 text-center md:text-left">
                <h3 class="text-2xl font-bold text-gray-800">Selamat Datang</h3>
                <p class="text-gray-500">Silakan masuk ke akun Anda</p>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3"></i>
                    <span class="text-sm"><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" autofocus
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition duration-200" 
                            placeholder="Username" required>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition duration-200" 
                            placeholder="Password" required>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Login Sebagai</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center justify-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50 transition border-gray-300 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                            <input type="radio" name="role_akses" value="Admin" class="hidden" checked>
                            <span class="text-sm font-medium text-gray-700">Admin</span>
                        </label>
                        <label class="relative flex items-center justify-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50 transition border-gray-300 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                            <input type="radio" name="role_akses" value="User" class="hidden">
                            <span class="text-sm font-medium text-gray-700">User / PIC</span>
                        </label>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-lg transform transition active:scale-95 duration-200 uppercase tracking-wider">
                    Sign In
                </button>
            </form>

            <div class="mt-12 text-center text-gray-400 text-xs">
                &copy; 2026 PT Surveyor Indonesia. All rights reserved.
            </div>
        </div>
    </div>

</body>
</html>