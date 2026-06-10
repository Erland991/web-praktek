<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris Aplikasi</title>
    <style>
        @page { margin: 1cm; size: A4 portrait; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10pt; margin: 0; padding: 0; color: #000; }
    </style>
</head>
<body>

<?php
    $path = FCPATH . 'images/logo_si.png';
    if (file_exists($path)) {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $b64 = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($path));
        $logoHtml = '<img src="' . $b64 . '" style="height:36px;">';
    } else {
        $logoHtml = '<span style="display:inline-block;width:36px;height:36px;background:#1e3a5f;border-radius:50%;text-align:center;line-height:36px;color:#fff;font-weight:bold;">SI</span>';
    }
?>

<table border="1" cellspacing="0" cellpadding="6" width="100%" style="border-collapse:collapse;">
    <!-- BARIS 1: Logo & No Dok -->
    <tr>
        <td width="70%" valign="middle" style="padding:7px 10px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td width="46" valign="middle"><?= $logoHtml ?></td>
                    <td valign="middle" style="padding-left:8px; font-size:13pt; font-weight:bold; color:#1e3a5f;">PT SURVEYOR INDONESIA (Persero)</td>
                </tr>
            </table>
        </td>
        <td width="30%" valign="top" style="font-size:9pt; line-height:1.9; padding:6px 8px;">
            No Dok. : SI-IT-LAP-01<br>
            Revisi &nbsp;&nbsp;&nbsp;&nbsp;: 01<br>
            Halaman : 1/1
        </td>
    </tr>

    <!-- BARIS 2: Judul & Tanggal -->
    <tr>
        <td valign="middle" style="background-color:#dddddd; text-align:center; font-weight:bold; font-size:12pt; padding:7px;">
            LAPORAN INVENTARIS &amp; APLIKASI DIGITAL
        </td>
        <td valign="top" style="font-size:9pt; line-height:1.9; padding:6px 8px;">
            Tanggal : <?= date('d/m/Y') ?><br>
            Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Unit IT
        </td>
    </tr>

    <!-- BARIS 3: Info -->
    <tr>
        <td colspan="2" style="font-size:9pt; padding:4px 8px;">
            Dicetak oleh: <strong><?= esc($user) ?></strong> &nbsp;|&nbsp;
            Tanggal: <strong><?= $tgl_cetak ?></strong>
            <?php if (!empty($filters['keyword'])): ?>&nbsp;|&nbsp; Kata Kunci: <strong>"<?= esc($filters['keyword']) ?>"</strong><?php endif; ?>
            <?php if (!empty($filters['kategori'])): ?>&nbsp;|&nbsp; Kategori: <strong><?= esc($filters['kategori']) ?></strong><?php endif; ?>
            <?php if (!empty($filters['status'])): ?>&nbsp;|&nbsp; Status: <strong><?= esc($filters['status']) ?></strong><?php endif; ?>
        </td>
    </tr>

    <!-- BARIS 4: Header kolom -->
    <tr>
        <th width="4%" align="center" style="font-size:9pt; background-color:#1e3a5f; color:#ffffff; text-transform:uppercase; padding:6px 4px;">NO</th>
        <th width="33%" align="center" style="font-size:9pt; background-color:#1e3a5f; color:#ffffff; text-transform:uppercase; padding:6px 4px;">NAMA APLIKASI / ASET</th>
        <th width="20%" align="center" style="font-size:9pt; background-color:#1e3a5f; color:#ffffff; text-transform:uppercase; padding:6px 4px;">KATEGORI</th>
        <th width="15%" align="center" style="font-size:9pt; background-color:#1e3a5f; color:#ffffff; text-transform:uppercase; padding:6px 4px;">STATUS</th>
        <th width="28%" align="center" style="font-size:9pt; background-color:#1e3a5f; color:#ffffff; text-transform:uppercase; padding:6px 4px;">PIC</th>
    </tr>

    <!-- BARIS DATA -->
    <?php $no = 1; foreach ($semua_aset as $row):
        $st  = $row['status'] ?? '-';
        $stC = ($st=='Aktif') ? '#155724' : (($st=='Maintenance') ? '#856404' : '#0c3370');
        $bg  = ($no % 2 == 0) ? ' bgcolor="#f5f5f5"' : '';
    ?>
    <tr<?= $bg ?>>
        <td align="center" style="font-size:9.5pt; padding:5px 4px;"><?= $no++ ?></td>
        <td style="font-size:9.5pt; padding:5px 6px;"><strong><?= esc($row['nama_aset'] ?? $row['nama_app'] ?? '-') ?></strong></td>
        <td style="font-size:9.5pt; padding:5px 6px;"><?= esc($row['kategori'] ?? '-') ?></td>
        <td style="font-size:9.5pt; padding:5px 6px; color:<?= $stC ?>; font-weight:bold;"><?= esc($st) ?></td>
        <td style="font-size:9.5pt; padding:5px 6px;"><?= esc($row['pic'] ?? '-') ?></td>
    </tr>
    <?php endforeach; ?>

    <!-- Footer total -->
    <tr>
        <td colspan="2" style="font-size:9pt; padding:4px 8px;">Total: <strong><?= count($semua_aset) ?></strong> data</td>
        <td colspan="3" align="right" style="font-size:9pt; padding:4px 8px;">Sistem SIMPA &mdash; <?= date('d F Y, H:i') ?> WIB</td>
    </tr>

    <!-- Tanda Tangan -->
    <tr>
        <td colspan="2" align="center" valign="bottom" height="80" style="font-size:9pt; padding:6px;">
            Disiapkan oleh<br><br><br>
            <strong>(<?= esc($user) ?>)</strong><br>Unit IT
        </td>
        <td colspan="3" align="center" valign="bottom" height="80" style="font-size:9pt; padding:6px;">
            Diketahui oleh<br><br><br>
            <strong>( _________________________ )</strong><br>Kepala Divisi IT
        </td>
    </tr>
</table>

</body>
</html>