<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Monitoring Aset Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-900 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl text-yellow-400">PT SURVEYOR INDONESIA</h1>
            <div class="flex items-center gap-4">
                <span>Halo, <b><?= session()->get('username') ?></b></span>
                <a href="/logout" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg text-sm transition font-bold">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-10 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-md border-l-8 border-blue-500">
                <h3 class="text-gray-500 font-bold uppercase text-xs">Total Aset</h3>
                <p class="text-4xl font-bold text-gray-800"><?= $total_aset ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md border-l-8 border-green-500">
                <h3 class="text-gray-500 font-bold uppercase text-xs">Sistem</h3>
                <p class="text-4xl font-bold text-gray-800">Online</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md border-l-8 border-yellow-500">
                <h3 class="text-gray-500 font-bold uppercase text-xs">Server</h3>
                <p class="text-4xl font-bold text-green-600">Stable</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-700">Daftar Aset Digital</h2>
                    <p class="text-sm text-gray-500">Monitoring real-time aset digital perusahaan.</p>
                </div>
                <a href="/dashboard/add" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded-xl font-bold shadow-lg transition duration-300">
                    + Tambah Aset Baru
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                            <th class="p-4 border-b">Nama Aset</th>
                            <th class="p-4 border-b">Kategori</th>
                            <th class="p-4 border-b">Status</th>
                            <th class="p-4 border-b">PIC</th>
                            <th class="p-4 border-b text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if(empty($semua_aset)): ?>
                            <tr><td colspan="5" class="p-10 text-center text-gray-400 italic">Belum ada data.</td></tr>
                        <?php else: ?>
                            <?php foreach($semua_aset as $row): ?>
                            <tr class="hover:bg-blue-50/50 transition duration-150">
                                <td class="p-4 font-semibold text-gray-700"><?= $row['nama_aset'] ?></td>
                                <td class="p-4 text-gray-600 text-sm"><?= $row['kategori'] ?></td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold 
                                        <?= $row['status'] == 'Aktif' ? 'bg-green-100 text-green-700' : ($row['status'] == 'Maintenance' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600 text-sm font-medium"><?= $row['pic'] ?></td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="/dashboard/edit/<?= $row['id'] ?>" class="bg-amber-100 text-amber-700 px-3 py-1 rounded hover:bg-amber-200 transition text-sm font-medium">Edit</a>
                                        <a href="/dashboard/delete/<?= $row['id'] ?>" onclick="return confirm('Hapus aset ini?')" class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 transition text-sm font-medium">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>