<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notula Rapat - PDF Export</title>
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }
        .main-table td, .main-table th {
            border: 1px solid black;
            padding: 8px;
            vertical-align: top;
        }
        .header-logo {
            width: 70%;
            text-align: left;
            vertical-align: middle;
        }
        .header-info {
            width: 30%;
            font-size: 9pt;
        }
        .bg-grey {
            background-color: #eeeeee;
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
        }
        .text-center { text-align: center; }
        .logo-img {
            height: 40px;
        }
    </style>
</head>
<body>
    <table class="main-table">
        <!-- Baris 1: Logo & No Dok -->
        <tr>
            <td class="header-logo" colspan="2">
                <table style="border: none; width: 100%;">
                    <tr style="border: none;">
                        <td style="border: none; width: 50px;">
                            <?php if($logo_base64): ?>
                                <img src="<?= $logo_base64 ?>" class="logo-img">
                            <?php else: ?>
                                <div style="width: 40px; height: 40px; background: #1e40af; border-radius: 50%; text-align: center; line-height: 40px; color: white; font-weight: bold; font-size: 14pt;">SI</div>
                            <?php endif; ?>
                        </td>
                        <td style="border: none; vertical-align: middle;">
                            <span style="font-size: 16pt; font-weight: bold; color: #1e40af;">PT SURVEYOR INDONESIA (Persero)</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="header-info">
                No Dok. : <?= $doc_number ?><br>
                Revisi &nbsp;&nbsp;&nbsp;&nbsp;: <?= $revision ?>
            </td>
        </tr>

        <!-- Baris 2: Judul & Waktu -->
        <tr>
            <td class="bg-grey" colspan="2">
                NOTULA RAPAT
            </td>
            <td class="header-info">
                Tanggal : <?= date('d/m/Y', strtotime($notula['tanggal'])) ?><br>
                Tempat : <?= $notula['tempat'] ?>
            </td>
        </tr>

        <!-- Baris 3: Agenda & Distribusi -->
        <tr>
            <td colspan="2" style="height: 60px;">
                <strong>AGENDA</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $notula['agenda'] ?><br>
                <strong>PESERTA</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <br>
                <?php 
                    $peserta = explode(',', $notula['peserta']);
                    foreach($peserta as $p):
                ?>
                - <?= trim($p) ?><br>
                <?php endforeach; ?>
            </td>
            <td class="header-info">
                <strong>DISTRIBUSI NOTULA RAPAT:</strong><br>
                - Unit Kerja Terkait
            </td>
        </tr>

        <!-- Baris Header Tabel Data -->
        <tr>
            <td class="text-center" style="width: 10%;"><strong>ITEM</strong></td>
            <td class="text-center" style="width: 50%;"><strong>HASIL PEMBAHASAN</strong></td>
            <td style="padding: 0; width: 40%;">
                <table style="width: 100%; border-collapse: collapse; height: 100%;">
                    <tr>
                        <td class="text-center" style="border: none; border-right: 1px solid black; width: 50%;"><strong>PENANGGUNG JAWAB</strong></td>
                        <td class="text-center" style="border: none;"><strong>TARGET WAKTU</strong></td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Isi Tabel Data -->
        <?php foreach($notula['hasil_pembahasan'] as $it): ?>
        <tr>
            <td class="text-center"><?= $it['item'] ?></td>
            <td><?= nl2br(esc($it['hasil'])) ?></td>
            <td style="padding: 0;">
                <table style="width: 100%; border-collapse: collapse; height: 100%;">
                    <tr>
                        <td class="text-center" style="border: none; border-right: 1px solid black; width: 50%;"><?= $it['pic'] ?></td>
                        <td class="text-center" style="border: none;"><?= !empty($it['target']) ? date('d/m/Y', strtotime($it['target'])) : '-' ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php endforeach; ?>

        <!-- Footer: Tanda Tangan -->
        <tr>
            <td class="footer-label" style="width: 33.33%;">
                Disiapkan oleh
            </td>
            <td class="footer-label" style="width: 33.33%;">
                Disetujui oleh
            </td>
            <td class="footer-label" style="width: 33.33%;">
                Disetujui oleh
            </td>
        </tr>
        <tr>
            <td class="text-center" style="height: 80px; vertical-align: bottom;">
                <strong><?= $notula['nama_disiapkan'] ?></strong><br>
                <?= $notula['jabatan_disiapkan'] ?>
            </td>
            <td class="text-center" style="height: 80px; vertical-align: bottom;">
                <strong><?= $notula['nama_setuju1'] ?></strong><br>
                <?= $notula['jabatan_setuju1'] ?>
            </td>
            <td class="text-center" style="height: 80px; vertical-align: bottom;">
                <strong><?= $notula['nama_setuju2'] ?></strong><br>
                <?= $notula['jabatan_setuju2'] ?>
            </td>
        </tr>
    </table>
</body>
</html>
