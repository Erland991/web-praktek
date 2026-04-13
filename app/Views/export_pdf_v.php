<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #004b87; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { color: #004b87; margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 14px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th, table td { border: 1px solid #ccc; padding: 10px; text-align: left; font-size: 12px; }
        table th { background-color: #004b87; color: white; text-transform: uppercase; }
        table tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { margin-top: 30px; text-align: right; font-size: 11px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PT SURVEYOR INDONESIA</h2>
        <p>Laporan Monitoring Aset Digital - Unit IT</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>PIC</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($semua_aset as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_aset'] ?></td>
                <td><?= $row['kategori'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['pic'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh: <?= $user ?> | Tanggal: <?= $tgl_cetak ?>
    </div>
</body>
</html>