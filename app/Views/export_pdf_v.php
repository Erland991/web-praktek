<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris Aplikasi - PT Surveyor Indonesia</title>
    <style>
        @page { margin: 1.2cm 1.5cm; size: A4 portrait; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9.5pt;
            margin: 0; padding: 0; color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid #333;
            padding: 6px 7px;
            vertical-align: middle;
        }
        .bg-header  { background-color: #1e3a5f; color: #fff; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 9pt; }
        .bg-title   { background-color: #dddddd; text-align: center; font-weight: bold; font-size: 12pt; }
        .bg-info    { background-color: #fafafa; font-size: 9pt; }
        .row-even   { background-color: #f5f5f5; }
        .row-odd    { background-color: #ffffff; }
        .td-center  { text-align: center; }
        .bold       { font-weight: bold; }
        .company    { font-size: 13.5pt; font-weight: bold; color: #1e3a5f; line-height: 1.35; }
        .dok-info   { font-size: 9pt; line-height: 2; vertical-align: top; }
    </style>
</head>
<body>

<?php
    $path = FCPATH . 'images/logo_si.png';
    if (file_exists($path)) {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $b64 = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($path));
        $logoHtml = '<img src="' . $b64 . '" style="width:66px; height:auto; display:block;">';
    } else {
        $logoHtml = '<div style="width:66px;height:66px;background:#1e3a5f;border-radius:6px;text-align:center;line-height:66px;color:#fff;font-weight:bold;font-size:14pt;">SI</div>';
    }
?>

<!--
    Struktur 5 kolom tetap (didefinisikan via colgroup):
    Col 1 (NO)   : 5%
    Col 2 (NAMA) : 33%
    Col 3 (KAT)  : 22%
    Col 4 (STAT) : 15%
    Col 5 (PIC)  : 25%

    Header baris pakai colspan:
    - Logo + nama perusahaan  : colspan="3"  (5+33+22=60%)
    - No dok                  : colspan="2"  (15+25=40%)
-->

<table>
    <colgroup>
        <col style="width:5%;">
        <col style="width:33%;">
        <col style="width:22%;">
        <col style="width:15%;">
        <col style="width:25%;">
    </colgroup>

    <!-- BARIS 1: Logo & No Dok -->
    <tr>
        <td colspan="3" style="padding:8px 12px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td style="width:80px; vertical-align:middle;"><?= $logoHtml ?></td>
                    <td class="company" style="padding-left:10px;">PT SURVEYOR INDONESIA (Persero)</td>
                </tr>
            </table>
        </td>
        <td colspan="2" class="dok-info">
            No Dok. : SI-IT-LAP-01<br>
            Revisi &nbsp;&nbsp;&nbsp;&nbsp;: 01<br>
            Halaman : 1/1
        </td>
    </tr>

    <!-- BARIS 2: Judul & Tanggal -->
    <tr>
        <td colspan="3" class="bg-title">LAPORAN INVENTARIS &amp; APLIKASI DIGITAL</td>
        <td colspan="2" class="dok-info">
            Tanggal : <?= date('d/m/Y') ?><br>
            Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Unit IT
        </td>
    </tr>

    <!-- BARIS 3: Info Cetak -->
    <tr>
        <td colspan="5" class="bg-info">
            Dicetak oleh: <strong><?= esc($user) ?></strong> &nbsp;|&nbsp;
            Tanggal: <strong><?= $tgl_cetak ?></strong>
            <?php if (!empty($filters['keyword'])): ?>&nbsp;|&nbsp; Kata Kunci: <strong>"<?= esc($filters['keyword']) ?>"</strong><?php endif; ?>
            <?php if (!empty($filters['kategori'])): ?>&nbsp;|&nbsp; Kategori: <strong><?= esc($filters['kategori']) ?></strong><?php endif; ?>
            <?php if (!empty($filters['status'])): ?>&nbsp;|&nbsp; Status: <strong><?= esc($filters['status']) ?></strong><?php endif; ?>
        </td>
    </tr>

    <!-- BARIS 4: Header Kolom -->
    <tr>
        <th class="bg-header">NO</th>
        <th class="bg-header">NAMA APLIKASI / ASET</th>
        <th class="bg-header">KATEGORI</th>
        <th class="bg-header">STATUS</th>
        <th class="bg-header">PIC</th>
    </tr>

    <!-- BARIS DATA -->
    <?php
        $no = 1;
        foreach ($semua_aset as $row):
            $st = $row['status'] ?? '-';
            $stColor = ($st === 'Aktif')        ? '#155724'
                     : (($st === 'Maintenance')  ? '#856404'
                     : (($st === 'Development')  ? '#0c3370' : '#555555'));
            $rowClass = ($no % 2 === 0) ? 'row-even' : 'row-odd';
            $namaAset = esc($row['nama_aset'] ?? $row['nama_app'] ?? '-');
    ?>
    <tr class="<?= $rowClass ?>">
        <td class="td-center"><?= $no++ ?></td>
        <td class="bold"><?= $namaAset ?></td>
        <td><?= esc($row['kategori'] ?? '-') ?></td>
        <td class="td-center bold" style="color:<?= $stColor ?>;"><?= esc($st) ?></td>
        <td><?= esc($row['pic'] ?? '-') ?></td>
    </tr>
    <?php endforeach; ?>

    <!-- BARIS TOTAL -->
    <tr>
        <td colspan="3" class="bg-info">
            Total: <strong><?= count($semua_aset) ?></strong> data
        </td>
        <td colspan="2" class="bg-info" style="text-align:right;">
            Sistem SIMPA &mdash; <?= date('d F Y, H:i') ?> WIB
        </td>
    </tr>

    <!-- BARIS TANDA TANGAN -->
    <tr>
        <td colspan="2" style="text-align:center; height:85px; vertical-align:bottom; padding:6px; font-size:9pt;">
            Disiapkan oleh<br><br><br>
            <strong>(<?= esc($user) ?>)</strong><br>Unit IT
        </td>
        <td colspan="3" style="text-align:center; height:85px; vertical-align:bottom; padding:6px; font-size:9pt;">
            Diketahui oleh<br><br><br>
            <strong>( _________________________ )</strong><br>Kepala Divisi IT
        </td>
    </tr>

</table>
</body>
</html>