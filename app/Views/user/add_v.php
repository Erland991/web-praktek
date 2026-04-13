<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Karyawan | SI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Tambah Master Karyawan</h2>
        
        <form action="<?= base_url('user/save') ?>" method="POST" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold mb-1">NIP</label>
                    <input type="text" name="nip" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="w-full border p-2 rounded" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold mb-1">Username</label>
                <input type="text" name="username" class="w-full border p-2 rounded" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Role</label>
                    <select name="role" class="w-full border p-2 rounded">
                        <option value="Admin">Admin</option>
                        <option value="User">User / PIC</option>
                        <option value="Viewer">Viewer</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Divisi</label>
                    <input type="text" name="divisi" placeholder="Contoh: IT, Keuangan, Ops" class="w-full border p-2 rounded">
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <a href="<?= base_url('user') ?>" class="text-gray-500 hover:underline">Kembali</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded font-bold">Simpan Karyawan</button>
            </div>
        </form>
    </div>
</body>
</html>