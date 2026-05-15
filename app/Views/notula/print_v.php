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
        .main-table td {
            border: 1.5px solid black;
            padding: 8px;
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
            height: 45px;
            vertical-align: middle;
        }
        .company-name {
            font-size: 16pt;
            font-weight: bold;
            color: #1e40af;
            margin-left: 10px;
        }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        
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
        <!-- Baris 1: Logo & Header Info -->
        <tr>
            <td colspan="2" style="width: 70%; border-right: 1.5px solid black; vertical-align: middle;">
                <table style="border: none; width: 100%;">
                    <tr style="border: none;">
                        <td style="border: none; width: 50px;">
                            <img src="<?= base_url('images/logo_si.png') ?>" class="logo-img">
                        </td>
                        <td style="border: none; vertical-align: middle;">
                            <span class="company-name">PT SURVEYOR INDONESIA (Persero)</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 30%; font-size: 9pt;">
                No Dok. &nbsp;: <?= $doc_number ?><br>
                Revisi &nbsp;&nbsp;&nbsp;&nbsp;: <?= $revision ?>
            </td>
        </tr>

        <!-- Baris 2: Judul & Waktu -->
        <tr>
            <td class="bg-grey" colspan="2" style="height: 40px;">
                NOTULA RAPAT
            </td>
            <td style="font-size: 9pt;">
                Tanggal : <?= date('d/m/Y', strtotime($notula['tanggal'])) ?><br>
                Tempat : <?= $notula['tempat'] ?>
            </td>
        </tr>

        <!-- Baris 3: Agenda & Distribusi -->
        <tr>
            <td colspan="2" style="height: 80px;">
                <table style="border: none; width: 100%; border-collapse: collapse;">
                    <tr style="border: none;">
                        <td style="border: none; width: 80px; padding: 0 0 5px 0;"><strong>AGENDA</strong></td>
                        <td style="border: none; width: 10px; padding: 0 0 5px 0;">:</td>
                        <td style="border: none; padding: 0 0 5px 0;"><?= $notula['agenda'] ?></td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none; vertical-align: top;"><strong>PESERTA</strong></td>
                        <td style="border: none; vertical-align: top;">:</td>
                        <td style="border: none;">
                            <?php 
                                $peserta = explode(',', $notula['peserta']);
                                foreach($peserta as $p):
                            ?>
                            - <?= trim($p) ?><br>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="font-size: 9pt;">
                <strong>DISTRIBUSI NOTULA RAPAT:</strong><br>
                - Unit Kerja Terkait
            </td>
        </tr>

        <!-- Table Header -->
        <tr>
            <td class="text-center" style="width: 8%;"><strong>ITEM</strong></td>
            <td class="text-center" style="width: 52%;"><strong>HASIL PEMBAHASAN</strong></td>
            <td style="padding: 0; width: 40%;">
                <table style="width: 100%; border-collapse: collapse; height: 100%;">
                    <tr>
                        <td class="text-center" style="border: none; border-right: 1.5px solid black; width: 50%; padding: 8px;"><strong>PENANGGUNG JAWAB</strong></td>
                        <td class="text-center" style="border: none; padding: 8px;"><strong>TARGET WAKTU</strong></td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Table Content -->
        <?php foreach($notula['hasil_pembahasan'] as $it): ?>
        <tr>
            <td class="text-center"><?= $it['item'] ?></td>
            <td><?= nl2br(esc($it['hasil'])) ?></td>
            <td style="padding: 0;">
                <table style="width: 100%; border-collapse: collapse; height: 100%;">
                    <tr>
                        <td class="text-center" style="border: none; border-right: 1.5px solid black; width: 50%; padding: 8px;"><?= $it['pic'] ?></td>
                        <td class="text-center" style="border: none; padding: 8px;"><?= !empty($it['target']) ? date('d/m/Y', strtotime($it['target'])) : '-' ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php endforeach; ?>

        <!-- Footer signatures labels -->
        <tr>
            <td class="text-center" style="width: 33.33%;">Disiapkan oleh</td>
            <td class="text-center" style="width: 33.33%;">Disetujui oleh</td>
            <td class="text-center" style="width: 33.33%;">Disetujui oleh</td>
        </tr>
        <!-- Footer names/titles -->
        <tr>
            <td class="text-center" style="height: 120px; vertical-align: bottom; border-top: none;">
                <strong><?= $notula['nama_disiapkan'] ?></strong><br>
                <?= $notula['jabatan_disiapkan'] ?>
            </td>
            <td class="text-center" style="height: 120px; vertical-align: bottom; border-top: none;">
                <strong><?= $notula['nama_setuju1'] ?></strong><br>
                <?= $notula['jabatan_setuju1'] ?>
            </td>
            <td class="text-center" style="height: 120px; vertical-align: bottom; border-top: none;">
                <strong><?= $notula['nama_setuju2'] ?></strong><br>
                <?= $notula['jabatan_setuju2'] ?>
            </td>
        </tr>
    </table>
</body>
</html>
