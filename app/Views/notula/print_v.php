<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notula Rapat - Official</title>
    <style>
        @media print {
            @page { margin: 1cm; size: A4; }
            body { -webkit-print-color-adjust: exact; }
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            margin: 30px;
            color: #000;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid black;
        }
        .main-table > tbody > tr > td {
            border: 1.5px solid black;
            padding: 5px 8px;
            vertical-align: top;
        }
        .bg-grey {
            background-color: #cccccc !important;
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            vertical-align: middle !important;
        }
        .logo-img {
            height: 40px;
            vertical-align: middle;
        }
        .company-name {
            font-size: 15pt;
            font-weight: bold;
            color: #1e40af;
            margin-left: 10px;
            vertical-align: middle;
        }
        .text-center { text-align: center; }
        .text-middle { vertical-align: middle !important; }
        
        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #198754;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            z-index: 1000;
        }
        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">KLIK UNTUK DOWNLOAD (SIMPAN KE PDF)</button>

    <table class="main-table">
        <colgroup>
            <col style="width: 8%;">
            <col style="width: 60%;">
            <col style="width: 16%;">
            <col style="width: 16%;">
        </colgroup>
        <tbody>
            <!-- Baris 1: Logo & Header Info -->
            <tr>
                <td colspan="2" class="text-middle">
                    <img src="<?= base_url('images/logo_si.png') ?>" class="logo-img">
                    <span class="company-name">PT SURVEYOR INDONESIA (Persero)</span>
                </td>
                <td colspan="2" style="font-size: 9pt;">
                    <table style="border: none; border-collapse: collapse;">
                        <tr><td style="border: none; padding: 0 10px 2px 0;">No Dok.</td><td style="border: none; padding: 0 5px 2px 0;">:</td><td style="border: none; padding: 0 0 2px 0;"><?= $doc_number ?></td></tr>
                        <tr><td style="border: none; padding: 0 10px 0 0;">Revisi</td><td style="border: none; padding: 0 5px 0 0;">:</td><td style="border: none; padding: 0;"><?= $revision ?></td></tr>
                    </table>
                </td>
            </tr>

            <!-- Baris 2: Judul & Waktu -->
            <tr>
                <td colspan="2" class="bg-grey" style="height: 40px;">
                    NOTULA RAPAT
                </td>
                <td colspan="2" style="font-size: 9pt;">
                    Tanggal : <?= date('d/m/Y', strtotime($notula['tanggal'])) ?><br>
                    Tempat &nbsp;: <?= $notula['tempat'] ?>
                </td>
            </tr>

            <!-- Baris 3: Agenda & Distribusi -->
            <tr>
                <td colspan="2" style="height: 80px;">
                    <table style="border: none; width: 100%; border-collapse: collapse; font-size: 10pt;">
                        <tr style="border: none;">
                            <td style="border: none; width: 80px; padding: 0 0 5px 0;">AGENDA</td>
                            <td style="border: none; width: 10px; padding: 0 0 5px 0;">:</td>
                            <td style="border: none; padding: 0 0 5px 0;"><?= $notula['agenda'] ?></td>
                        </tr>
                        <tr style="border: none;">
                            <td style="border: none; vertical-align: top;">PESERTA</td>
                            <td style="border: none; vertical-align: top;">:</td>
                            <td style="border: none;">
                                <?php 
                                    $peserta = explode(',', $notula['peserta']);
                                    foreach($peserta as $p):
                                ?>
                                &nbsp;&nbsp;- <?= trim($p) ?><br>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td colspan="2" style="font-size: 10pt;">
                    DISTRIBUSI NOTULA RAPAT:<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;- Unit Kerja Terkait
                </td>
            </tr>

            <!-- Table Header -->
            <tr>
                <td class="text-center text-middle">ITEM</td>
                <td class="text-center text-middle">HASIL PEMBAHASAN</td>
                <td class="text-center text-middle">PENANGGUNG<br>JAWAB</td>
                <td class="text-center text-middle">TARGET<br>WAKTU</td>
            </tr>

            <!-- Table Content -->
            <?php foreach($notula['hasil_pembahasan'] as $it): ?>
            <tr>
                <td class="text-center"><?= $it['item'] ?></td>
                <td><?= nl2br(esc($it['hasil'])) ?></td>
                <td class="text-center"><?= $it['pic'] ?></td>
                <td class="text-center"><?= !empty($it['target']) ? date('d/m/Y', strtotime($it['target'])) : '-' ?></td>
            </tr>
            <?php endforeach; ?>

            <!-- Signatures (One single cell to prevent vertical borders) -->
            <tr>
                <td colspan="4" style="padding: 0;">
                    <table style="width: 100%; border-collapse: collapse; border: none; height: 140px;">
                        <tr>
                            <td class="text-center" style="border: none; width: 33.33%; padding-top: 15px;">Disiapkan oleh</td>
                            <td class="text-center" style="border: none; width: 33.33%; padding-top: 15px;">Disetujui oleh</td>
                            <td class="text-center" style="border: none; width: 33.33%; padding-top: 15px;">Disetujui oleh</td>
                        </tr>
                        <tr>
                            <td class="text-center" style="border: none; vertical-align: bottom; padding-bottom: 15px;">
                                <?= $notula['nama_disiapkan'] ?><br>
                                <?= $notula['jabatan_disiapkan'] ?>
                            </td>
                            <td class="text-center" style="border: none; vertical-align: bottom; padding-bottom: 15px;">
                                <?= $notula['nama_setuju1'] ?><br>
                                <?= $notula['jabatan_setuju1'] ?>
                            </td>
                            <td class="text-center" style="border: none; vertical-align: bottom; padding-bottom: 15px;">
                                <?= $notula['nama_setuju2'] ?><br>
                                <?= $notula['jabatan_setuju2'] ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
