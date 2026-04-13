<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Master Divisi | PT Surveyor Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-blue-900 text-white shadow-lg py-3 px-6 flex justify-between items-center mb-8">
        <div class="flex items-center space-x-3">
            <i class="fas fa-building text-blue-300 text-xl"></i>
            <span class="font-bold text-lg tracking-tight">Master Divisi</span>
        </div>
        <a href="<?= base_url('dashboard') ?>" class="text-xs bg-blue-800 hover:bg-blue-700 px-4 py-2 rounded-lg transition font-bold">
            <i class="fas fa-home mr-2"></i> DASHBOARD
        </a>
    </nav>

    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 h-fit">
                <h3 class="font-bold mb-6 text-gray-700 flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-green-500"></i> Tambah Divisi
                </h3>
                <form action="<?= base_url('master/divisi/save') ?>" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Kode Divisi</label>
                        <input type="text" name="kode_divisi" placeholder="Contoh: IT" class="w-full border-b-2 border-gray-100 p-2 focus:border-blue-500 outline-none transition" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Nama Divisi</label>
                        <input type="text" name="nama_divisi" placeholder="Contoh: Teknologi Informasi" class="w-full border-b-2 border-gray-100 p-2 focus:border-blue-500 outline-none transition" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg transition transform hover:scale-[1.02]">
                        SIMPAN DIVISI
                    </button>
                </form>
            </div>

            <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b text-gray-400 text-[10px] uppercase tracking-widest">
                            <th class="px-6 py-4 font-bold">Kode</th>
                            <th class="px-6 py-4 font-bold">Nama Divisi</th>
                            <th class="px-6 py-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach($divisi as $d): ?>
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-6 py-4 font-bold text-blue-600 font-mono"><?= $d['kode_divisi'] ?></td>
                            <td class="px-6 py-4 text-gray-700 font-medium"><?= $d['nama_divisi'] ?></td>
                            <td class="px-6 py-4 text-center">
                                <a href="<?= base_url('master/divisi/delete/'.$d['id']) ?>" onclick="return confirm('Hapus divisi ini?')" class="text-red-400 hover:text-red-600 transition">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($divisi)): ?>
                            <tr><td colspan="3" class="p-8 text-center text-gray-400 italic text-sm">Belum ada data divisi tersedia.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>