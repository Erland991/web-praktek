<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Karyawan | PT Surveyor Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-blue-900 text-white shadow-lg py-3 px-6 flex justify-between items-center mb-8">
        <div class="flex items-center space-x-3">
            <i class="fas fa-users-cog text-blue-300 text-xl"></i>
            <span class="font-bold text-lg tracking-tight">PT Surveyor Indonesia</span>
        </div>
        <div class="flex items-center space-x-4 uppercase font-bold text-[11px]">
            <a href="<?= base_url('dashboard') ?>" class="hover:text-blue-200 transition">Dashboard</a>
            <span class="text-blue-700">|</span>
            <a href="<?= base_url('master/divisi') ?>" class="hover:text-blue-300 transition">Master Divisi</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 pb-12">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-black text-gray-800 uppercase tracking-tight">Manajemen Karyawan</h1>
                <p class="text-gray-500 text-sm italic border-l-4 border-blue-500 pl-3 mt-1">Daftar personil dan hak akses sistem monitoring.</p>
            </div>
            <button onclick="document.getElementById('modalTambah').style.display='flex'" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-lg font-bold transition flex items-center transform hover:scale-105">
                <i class="fas fa-user-plus mr-2"></i> TAMBAH KARYAWAN
            </button>
        </div>

        <?php if (session()->getFlashdata('sukses')) : ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <?= session()->getFlashdata('sukses') ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest border-b">
                        <th class="px-6 py-4 font-bold text-center w-16">No</th>
                        <th class="px-6 py-4 font-bold">NIP & Nama</th>
                        <th class="px-6 py-4 font-bold">Username</th>
                        <th class="px-6 py-4 font-bold text-center">Role</th>
                        <th class="px-6 py-4 font-bold text-center">Divisi</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $no = 1; foreach ($karyawan as $k) : ?>
                    <tr class="hover:bg-blue-50/40 transition">
                        <td class="px-6 py-4 text-center text-xs text-gray-400 font-mono"><?= str_pad($no++, 2, '0', STR_PAD_LEFT) ?></td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800"><?= $k['nama_lengkap'] ?></div>
                            <div class="text-[10px] text-blue-600 font-mono"><?= $k['nip'] ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500"><?= $k['username'] ?></td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase <?= $k['role'] == 'Admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' ?>">
                                <?= $k['role'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if (!empty($k['divisi'])) : ?>
                                <span class="text-xs font-bold text-gray-600 bg-gray-100 px-3 py-1 rounded-md"><?= $k['divisi'] ?></span>
                            <?php else : ?>
                                <span class="text-[10px] italic text-gray-400">Belum diatur</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center flex justify-center space-x-3">
                            <button onclick="editKaryawan(<?= htmlspecialchars(json_encode($k)) ?>)" class="text-blue-400 hover:text-blue-600 transition">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            
                            <a href="<?= base_url('master/karyawan/delete/'.$k['id']) ?>" onclick="return confirm('Hapus karyawan ini?')" class="text-gray-300 hover:text-red-500 transition">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalTambah" style="display:none;" class="fixed inset-0 bg-black/60 backdrop-blur-sm items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="bg-blue-900 p-6 text-white flex justify-between items-center">
                <h3 class="font-bold uppercase tracking-widest text-sm">Karyawan Baru</h3>
                <button onclick="document.getElementById('modalTambah').style.display='none'" class="text-white text-2xl">&times;</button>
            </div>
            <form action="<?= base_url('master/karyawan/save') ?>" method="POST" class="p-8 space-y-5">
                <?= csrf_field() ?>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="nip" placeholder="NIP" class="border-b-2 py-2 outline-none" required>
                    <input type="text" name="username" placeholder="Username" class="border-b-2 py-2 outline-none" required>
                </div>
                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" class="w-full border-b-2 py-2 outline-none" required>
                <div class="grid grid-cols-2 gap-4">
                    <select name="role" class="border-b-2 py-2 bg-transparent" required>
                        <option value="User">User</option>
                        <option value="Admin">Admin</option>
                    </select>
                    <select name="divisi" class="border-b-2 py-2 bg-transparent" required>
                        <option value="">Pilih Divisi</option>
                        <?php foreach($list_divisi as $d): ?>
                            <option value="<?= $d['nama_divisi'] ?>"><?= $d['nama_divisi'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold uppercase">Simpan</button>
            </form>
        </div>
    </div>

    <div id="modalEdit" style="display:none;" class="fixed inset-0 bg-black/60 backdrop-blur-sm items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="bg-blue-600 p-6 text-white flex justify-between items-center">
                <h3 class="font-bold uppercase tracking-widest text-sm">Edit Karyawan</h3>
                <button onclick="document.getElementById('modalEdit').style.display='none'" class="text-white text-2xl">&times;</button>
            </div>
            <form id="formEdit" method="POST" class="p-8 space-y-5">
                <?= csrf_field() ?>
                <input type="text" name="nama_lengkap" id="edit_nama" placeholder="Nama Lengkap" class="w-full border-b-2 py-2 outline-none" required>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="nip" id="edit_nip" placeholder="NIP" class="border-b-2 py-2 outline-none" required>
                    <input type="text" name="username" id="edit_username" placeholder="Username" class="border-b-2 py-2 outline-none" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <select name="role" id="edit_role" class="border-b-2 py-2 bg-transparent">
                        <option value="User">User</option>
                        <option value="Admin">Admin</option>
                    </select>
                    <select name="divisi" id="edit_divisi" class="border-b-2 py-2 bg-transparent">
                        <?php foreach($list_divisi as $d): ?>
                            <option value="<?= $d['nama_divisi'] ?>"><?= $d['nama_divisi'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                    <label class="block text-[9px] font-bold text-yellow-700 uppercase">Ganti Password (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="w-full bg-transparent border-b border-yellow-300 py-1 outline-none text-sm">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold uppercase">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        function editKaryawan(data) {
            document.getElementById('modalEdit').style.display = 'flex';
            document.getElementById('formEdit').action = '<?= base_url('master/karyawan/update') ?>/' + data.id;
            document.getElementById('edit_nama').value = data.nama_lengkap;
            document.getElementById('edit_nip').value = data.nip;
            document.getElementById('edit_username').value = data.username;
            document.getElementById('edit_role').value = data.role;
            document.getElementById('edit_divisi').value = data.divisi;
        }
    </script>
</body>
</html>