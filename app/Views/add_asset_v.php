<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Aset | PT Surveyor Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg border-t-8 border-blue-900">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Aset Digital Baru</h2>
        
        <form action="/dashboard/save" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Aset</label>
                <input type="text" name="nama_aset" class="w-full px-4 py-2 border rounded-lg focus:outline-blue-900" placeholder="Contoh: Server Jakarta" required>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-2 border rounded-lg">
                        <option value="Software">Software</option>
                        <option value="Hardware">Hardware</option>
                        <option value="Server">Server</option>
                        <option value="Data">Data</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border rounded-lg">
                        <option value="Aktif">Aktif</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">PIC (Penanggung Jawab)</label>
                <input type="text" name="pic" class="w-full px-4 py-2 border rounded-lg focus:outline-blue-900" placeholder="Nama Penanggung Jawab" required>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-800">Simpan Data</button>
                <a href="/dashboard" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>