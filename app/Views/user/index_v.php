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
                    <td class="p-4">
                        <button onclick="showUserDetail(<?= $u['id'] ?>)" class="text-blue-600 hover:underline font-semibold text-left">
                            <?= $u['nama_lengkap'] ?>
                        </button>
                    </td>
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

<!-- Modal Detail User -->
<div id="userDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Detail Pegawai</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="flex flex-col items-center mb-6">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-50 mb-4 shadow-md">
                    <img id="detailPhoto" src="" alt="Profile" class="w-full h-full object-cover">
                </div>
                <h4 id="detailNama" class="text-xl font-bold text-gray-900"></h4>
                <p id="detailRole" class="text-sm font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-full mt-1"></p>
            </div>

            <div class="space-y-4">
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">NIP</p>
                        <p id="detailNip" class="text-gray-800 font-medium"></p>
                    </div>
                </div>

                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Divisi</p>
                        <p id="detailDivisi" class="text-gray-800 font-medium"></p>
                    </div>
                </div>

                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Username</p>
                        <p id="detailUsername" class="text-gray-800 font-medium"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 p-4 text-center">
            <button onclick="closeModal()" class="w-full bg-white border border-gray-300 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">Tutup</button>
        </div>
    </div>
</div>

<script>
function showUserDetail(id) {
    fetch('<?= base_url('user/detail/') ?>' + '/' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailNama').innerText = data.nama_lengkap;
            document.getElementById('detailNip').innerText = data.nip;
            document.getElementById('detailRole').innerText = data.role;
            document.getElementById('detailDivisi').innerText = data.divisi;
            document.getElementById('detailUsername').innerText = data.username;
            
            const photoSrc = data.photo ? '<?= base_url('uploads/profile/') ?>/' + data.photo : '<?= base_url('uploads/profile/default.png') ?>';
            document.getElementById('detailPhoto').src = photoSrc;
            
            const modal = document.getElementById('userDetailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
}

function closeModal() {
    const modal = document.getElementById('userDetailModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>