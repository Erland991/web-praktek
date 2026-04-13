<?= $this->extend('layout_template') // Jika kamu pakai template, kalau tidak pakai header/footer biasa ?>

<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen User & Karyawan</h1>
        <button class="bg-green-600 text-white px-4 py-2 rounded">+ Tambah Karyawan</button>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4">NIP</th>
                    <th class="p-4">Nama Lengkap</th>
                    <th class="p-4">Username</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Divisi</th>
                    <th class="p-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($semua_user as $u): ?>
                <tr class="border-b">
                    <td class="p-4"><?= $u['nip'] ?></td>
                    <td class="p-4"><?= $u['nama_lengkap'] ?></td>
                    <td class="p-4"><?= $u['username'] ?></td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded text-xs <?= $u['role'] == 'Admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' ?>">
                            <?= $u['role'] ?>
                        </span>
                    </td>
                    <td class="p-4"><?= $u['divisi'] ?></td>
                    <td class="p-4">
                        <a href="<?= base_url('user/delete/'.$u['id']) ?>" class="text-red-600" onclick="return confirm('Hapus user ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>