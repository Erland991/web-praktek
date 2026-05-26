<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Hadir</title>
    <style>
        @media print {
            @page { margin: 1.5cm; size: A4; }
            body { -webkit-print-color-adjust: exact; }
        }
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 11pt;
            margin: 10px;
            color: #000;
        }
        .header-container {
            width: 100%;
            margin-bottom: 30px;
        }
        .logo-img {
            height: 45px;
        }
        .doc-info {
            text-align: right;
            font-size: 9pt;
            line-height: 1.2;
        }
        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 40px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 5px 0;
            vertical-align: top;
            font-size: 11pt;
        }
        .meta-label {
            width: 180px;
            text-transform: uppercase;
        }
        .meta-colon {
            width: 20px;
        }
        .meta-val {
            border-bottom: 1px solid #000;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }
        .main-table th, .main-table td {
            border: 1px solid #000;
            padding: 8px 6px;
            font-size: 10pt;
        }
        .main-table th {
            background-color: #FFC000;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
        .col-no { width: 5%; text-align: center; }
        .col-nama { width: 23%; }
        .col-jabatan { width: 27%; }
        .col-hp { width: 15%; text-align: center; }
        .col-email { width: 15%; text-align: center; }
        .col-ttd { width: 15%; }
        
        .ttd-box {
            height: 25px; /* Minimum height for manual signature */
        }
    </style>
</head>
<body>

    <table class="header-container" style="border-collapse: collapse; border: none;">
        <tr>
            <td style="width: 50%; border: none;">
                <?php if (extension_loaded('gd')): ?>
                    <?php 
                        $path = FCPATH . 'images/logo_si.png';
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    ?>
                    <img src="<?= $base64 ?>" class="logo-img">
                <?php else: ?>
                    <h3 style="margin: 0; padding: 0; color: #004b87; font-family: Helvetica, sans-serif;">PT SURVEYOR INDONESIA</h3>
                <?php endif; ?>
            </td>
            <td style="width: 50%; border: none;" class="doc-info">
                FP-MR10-01<br>
                Rev.02<br>
                Tgl. Rev: 01 Maret 2022
            </td>
        </tr>
    </table>

    <div class="title">DAFTAR HADIR</div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">ACARA</td>
            <td class="meta-colon">:</td>
            <td class="meta-val"><?= esc($absensi['acara']) ?></td>
        </tr>
        <tr>
            <td class="meta-label">HARI/TANGGAL</td>
            <td class="meta-colon">:</td>
            <td class="meta-val"><?= date('l / d F Y', strtotime($absensi['tanggal'])) ?></td>
        </tr>
        <tr>
            <td class="meta-label">WAKTU</td>
            <td class="meta-colon">:</td>
            <td class="meta-val"><?= esc($absensi['waktu']) ?></td>
        </tr>
        <tr>
            <td class="meta-label">TEMPAT</td>
            <td class="meta-colon">:</td>
            <td class="meta-val"><?= esc($absensi['tempat']) ?></td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th class="col-no">NO.</th>
                <th class="col-nama">NAMA</th>
                <th class="col-jabatan">JABATAN -<br>UNIT KERJA</th>
                <th class="col-hp">HP/ext</th>
                <th class="col-email">EMAIL</th>
                <th class="col-ttd">TANDATANGAN</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $count = count($absensi['peserta'] ?? []);
                $maxRows = max(16, $count); // Minimum 16 rows to fill the page exactly like the template
                
                for ($i = 0; $i < $maxRows; $i++): 
                    $p = $absensi['peserta'][$i] ?? null;
            ?>
            <tr>
                <td class="col-no"><?= $i + 1 ?>.</td>
                <td class="col-nama"><?= $p ? esc($p['nama']) : '' ?></td>
                <td class="col-jabatan"><?= $p ? esc($p['jabatan']) : '' ?></td>
                <td class="col-hp"><?= $p ? esc($p['hp']) : '' ?></td>
                <td class="col-email"><?= $p ? esc($p['email']) : '' ?></td>
                <td class="col-ttd">
                    <div class="ttd-box">
                        <?php if($p): ?>
                            <span style="font-size: 7pt; color: #999; margin-left: 2px;"><?= $i + 1 ?>.</span>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>

</body>
</html>
