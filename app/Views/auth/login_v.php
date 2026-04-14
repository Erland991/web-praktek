<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Monitoring Aset PT Surveyor Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white p-10 rounded-2xl shadow-2xl border-t-8 border-blue-800">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800">PT SURVEYOR INDONESIA</h1>
            <p class="text-slate-500 italic text-sm">Project Management System</p>
        </div>

        <form action="/login_action" method="POST">
            <?= csrf_field() ?>
            <div class="mb-5">
                <label class="block text-slate-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" class="w-full px-4 py-3 rounded-lg bg-slate-50 border focus:border-blue-600 focus:outline-none transition" placeholder="Masukkan Username" required>
            </div>

            <div class="mb-5">
                <label class="block text-slate-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-lg bg-slate-50 border focus:border-blue-600 focus:outline-none transition" placeholder="Masukkan Password" required>
            </div>

            <div class="mb-8">
                <label class="block text-slate-700 text-sm font-bold mb-2">Masuk Sebagai</label>
                <select name="role_akses" class="w-full px-4 py-3 rounded-lg bg-slate-50 border focus:border-blue-600 focus:outline-none">
                    <option value="admin">Administrator</option>
                    <option value="user">User / PIC Proyek</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-3 rounded-xl shadow-lg transition duration-300">
                MASUK KE SISTEM
            </button>
        </form>
    </div>
</body>
</html>