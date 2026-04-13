<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Aset | PT Surveyor Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg border-t-8 border-amber-500">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Data Aset</h2>
        
        <form action="/dashboard/update/<?= $aset['id'] ?>" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Aset</label>
                <input type="text" name="nama_aset" value="<?= $aset['nama_aset'] ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-amber-500" required>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-2 border rounded-lg">
                        <option value="Software" <?= $aset['kategori'] == 'Software' ? 'selected' : '' ?>>Software</option>
                        <option value="Hardware" <?= $aset['kategori'] == 'Hardware' ? 'selected' : '' ?>>Hardware</option>
                        <option value="Server" <?= $aset['kategori'] == 'Server' ? 'selected' : '' ?>>Server</option>
                        <option value="Data" <?= $aset['kategori'] == 'Data' ? 'selected' : '' ?>>Data</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border rounded-lg">
                        <option value="Aktif" <?= $aset['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Maintenance" <?= $aset['status'] == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                        <option value="Non-Aktif" <?= $aset['status'] == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">PIC</label>
                <input type="text" name="pic" value="<?= $aset['pic'] ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-amber-500" required>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-amber-500 text-white px-6 py-2 rounded-lg font-bold hover:bg-amber-600">Update Data</button>
                <a href="/dashboard" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>