<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Monitoring Aset SI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-blue-900 text-white shadow-lg text-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-600 p-2 rounded-lg shadow-inner">
                        <i class="fas fa-server text-blue-200"></i>
                    </div>
                    <span class="font-bold text-lg tracking-tight">PT Surveyor Indonesia</span>
                </div>

                <?php if (session()->get('role') == 'Admin') : ?>
                    <div class="hidden md:flex space-x-4 border-l border-blue-800 pl-6 text-[11px] uppercase tracking-wider font-bold">
                        <a href="<?= base_url('dashboard') ?>" class="text-white hover:text-blue-200 transition flex items-center bg-blue-800/50 px-3 py-1.5 rounded-md">
                            <i class="fas fa-chart-pie mr-2"></i> Dashboard
                        </a>
                        <a href="<?= base_url('master/karyawan') ?>" class="text-blue-300 hover:text-white transition flex items-center px-3 py-1.5">
                            <i class="fas fa-users-cog mr-2"></i> Kelola User
                        </a>
                        <a href="<?= base_url('master/divisi') ?>" class="text-blue-300 hover:text-white transition flex items-center px-3 py-1.5">
                            <i class="fas fa-building mr-2"></i> Kelola Divisi
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-right hidden md:block border-r border-blue-800 pr-4">
                    <p class="text-[9px] text-blue-400 uppercase font-black leading-none"><?= session()->get('role') ?></p>
                    <p class="text-sm font-medium text-white"><?= session()->get('nama_lengkap') ?></p>
                </div>
                <a href="<?= base_url('logout') ?>" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg text-[10px] font-black transition flex items-center shadow-md uppercase">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Monitoring Progres Aplikasi</h1>
                <p class="text-gray-500 text-sm italic">Selamat datang kembali di portal manajemen aset teknologi informasi.</p>
            </div>
            
            <?php if (session()->get('role') == 'Admin') : ?>
                <a href="<?= base_url('dashboard/add') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-lg font-bold transition flex items-center justify-center transform hover:-translate-y-1">
                    <i class="fas fa-plus-circle mr-2 text-lg text-blue-200"></i> TAMBAH ASET BARU
                </a>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                <h3 class="font-bold text-gray-700 flex items-center uppercase text-xs tracking-widest">
                    <i class="fas fa-database mr-3 text-blue-500"></i> Daftar Inventaris Aplikasi
                </h3>
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                    Total: <?= count($semua_aset) ?> Aset Terdaftar
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest">
                            <th class="px-6 py-4 font-black w-16 text-center">No</th>
                            <th class="px-6 py-4 font-black">Detail Aplikasi</th>
                            <th class="px-6 py-4 font-black text-center">Kategori</th>
                            <th class="px-6 py-4 font-black">Person In Charge (PIC)</th>
                            <th class="px-6 py-4 font-black text-center">Status System</th>
                            <?php if (session()->get('role') == 'Admin') : ?>
                                <th class="px-6 py-4 font-black text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                        <?php $no = 1; foreach ($semua_aset as $a) : ?>
                        <tr class="hover:bg-blue-50/50 transition duration-150 group">
                            <td class="px-6 py-4 text-center font-mono text-gray-400"><?= str_pad($no++, 2, '0', STR_PAD_LEFT) ?></td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-bold text-blue-900 leading-tight"><?= $a['nama_aset'] ?></div>
                                <div class="text-[10px] text-gray-400 font-medium uppercase mt-0.5 tracking-tighter">Asset-ID: #<?= $a['id'] ?></div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-[10px] bg-white text-gray-600 px-3 py-1 rounded-md font-black border border-gray-200 shadow-sm uppercase">
                                    <?= $a['kategori'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center mr-3 border border-blue-200">
                                        <i class="fas fa-user-tie text-[10px] text-blue-600"></i>
                                    </div>
                                    <span class="font-semibold text-gray-700"><?= $a['pic'] ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php if ($a['status'] == 'Aktif') : ?>
                                    <span class="inline-flex items-center bg-green-50 text-green-700 text-[10px] px-3 py-1 rounded-full font-black border border-green-200 uppercase tracking-tighter">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2 animate-pulse"></span> Online
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center bg-orange-50 text-orange-700 text-[10px] px-3 py-1 rounded-full font-black border border-orange-200 uppercase tracking-tighter">
                                        <span class="w-1.5 h-1.5 bg-orange-500 rounded-full mr-2"></span> Maintenance
                                    </span>
                                <?php endif; ?>
                            </td>

                            <?php if (session()->get('role') == 'Admin') : ?>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="<?= base_url('dashboard/edit/' . $a['id']) ?>" class="p-2 text-blue-500 hover:bg-blue-100 rounded-lg transition" title="Edit Aset">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <a href="<?= base_url('dashboard/delete/' . $a['id']) ?>" onclick="return confirm('Hapus aset aplikasi ini?')" class="p-2 text-red-400 hover:bg-red-50 rounded-lg transition" title="Hapus Aset">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($semua_aset)) : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-folder-open text-5xl text-gray-200 mb-4"></i>
                                    <p class="text-gray-400 text-sm font-medium italic">Data inventaris masih kosong.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center space-x-2">
                <div class="w-2 h-2 bg-blue-900 rounded-full"></div>
                <p class="text-gray-400 text-[11px] font-bold tracking-widest uppercase">
                    &copy; 2026 PT Surveyor Indonesia <span class="mx-2 text-gray-200">|</span> Portal Monitoring Progres Aplikasi
                </p>
            </div>
            <div class="flex space-x-6 text-gray-300">
                <i class="fab fa-linkedin-in hover:text-blue-600 transition cursor-pointer text-sm"></i>
                <i class="fas fa-globe hover:text-blue-600 transition cursor-pointer text-sm"></i>
                <i class="fas fa-shield-alt hover:text-blue-600 transition cursor-pointer text-sm"></i>
            </div>
        </div>
    </div>

</body>
</html>