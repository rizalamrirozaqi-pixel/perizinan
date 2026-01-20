<?php
/**
 * View Partial untuk Cetak SKRD
 * @var yii\web\View $this
 * @var array $model Data Pendaftaran
 * @var array $modelSkr Data SKRD
 * @var array $rincianData Data Rincian Perhitungan
 */
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SKRD - <?= Html::encode($modelSkr['nomor_skr'] ?? '-') ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; margin: 20mm; }
        .header { text-align: center; font-weight: bold; font-size: 12pt; text-decoration: underline; margin-bottom: 5px; }
        .nomor-skr { text-align: center; font-size: 11pt; margin-bottom: 20px; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .data-table td { vertical-align: top; padding: 2px 0; }
        .data-table td:nth-child(1) { width: 30%; white-space: nowrap; }
        .data-table td:nth-child(2) { width: 1%; padding-right: 5px; }
        .rincian-table { width: 100%; border-collapse: collapse; margin-top: 15px; border: 1px solid #000; }
        .rincian-table th, .rincian-table td { border: 1px solid #000; padding: 4px; }
        .rincian-table th { background-color: #f2f2f2; text-align: center; }
        .rincian-table .text-end { text-align: right; }
        .rincian-table .fw-bold { font-weight: bold; }
        .ttd-section { margin-top: 40px; }
        .ttd-kolom { width: 45%; float: right; text-align: left; }
        .nama-ttd { margin-top: 60px; font-weight: bold; text-decoration: underline; }
        .clear { clear: both; }
        @media print {
            .btn-print { display: none; }
            body { margin: 15mm; }
        }
    </style>
</head>
<body onload="window.print()">
    <button onclick="window.print()" class="btn-print" style="position:fixed; top:10px; right:10px; padding: 5px 10px; cursor:pointer; font-family: sans-serif;">Cetak Ulang</button>
    <table style="width: 100%; border-bottom: 1px solid #000;">
        <tr>
            <td style="width: 20%; text-align: center;"> <span style="font-size: 9pt;">[LOGO]</span> </td>
            <td style="width: 60%; text-align: center; line-height: 1.3;">
                <span style="font-size: 14pt; font-weight: bold;">PEMERINTAH KABUPATEN XYZ</span><br>
                <span style="font-size: 16pt; font-weight: bold;">BADAN/DINAS PENDAPATAN ...</span><br>
                <span style="font-size: 9pt;">Alamat, Telepon, Website, Email...</span>
            </td>
            <td style="width: 20%; text-align: right; vertical-align: top;">
                 <div style="border: 1px solid #000; padding: 5px; font-size: 9pt;">
                    No. Kode <br>
                    <strong><?= Html::encode($modelSkr['nomor_skr'] ?? '-') ?></strong>
                 </div>
            </td>
        </tr>
    </table>
    <div class="header" style="margin-top: 15px;">SURAT KETETAPAN RETRIBUSI DAERAH</div>
    <div class="nomor-skr">(S K R D)</div>
    <p style="text-align: center; font-size: 10pt; margin-bottom: 15px;">Tahun: <?= Html::encode($modelSkr['masa'] ?? date('Y')) ?></p>
    <table class="data-table" style="margin-bottom: 15px;">
        <tr> <td>Nama</td> <td>:</td> <td><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td> </tr>
         <tr> <td>Alamat Rumah</td> <td>:</td> <td><?= Html::encode($model['alamat'] ?? '-') ?></td> </tr>
        <tr> <td>Nama Usaha</td> <td>:</td> <td><?= Html::encode($model['nama_usaha'] ?? '-') ?></td> </tr>
    </table>
    <table class="rincian-table">
        <thead class="table-light">
            <tr>
                <th class="text-center">No.</th> <th class="text-center">Kode Rekening</th>
                <th class="text-center">Uraian</th> <th class="text-center">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; vertical-align: top;">1.</td>
                <td style="text-align: center; vertical-align: top;">1.16.1.20.30.0000.005.4.1.2.03.01</td>
                <td style="padding-left: 10px;">
                    <strong><?= Html::encode(strtoupper($model['nama_izin'] ?? 'RINCIAN RETRIBUSI')) ?></strong>
                    <div style="font-size: 9pt; padding-left: 10px;"> Rincian 1 (Contoh)... </div>
                </td>
                <td style="text-align: right; vertical-align: top; white-space: nowrap;">
                    Rp. ...
                </td>
            </tr>
             <tr>
                <td colspan="3" class="text-end fw-bold">Jumlah Ketetapan Pokok SKR</td>
                <td class="text-end fw-bold">Rp. <?= Html::encode(Yii::$app->formatter->asDecimal($rincianData['pokok'], 0)) ?></td>
            </tr>
             <tr>
                <td colspan="3" style="padding-left: 30px;">a. Denda (Rp. ... x 2% x(0) bulan)</td>
                <td class="text-end">Rp. <?= Html::encode(Yii::$app->formatter->asDecimal($rincianData['sanksi_denda'], 0)) ?></td>
            </tr>
             <tr>
                <td colspan="3" style="padding-left: 30px;">b. Kenaikan</td>
                <td class="text-end">Rp. <?= Html::encode(Yii::$app->formatter->asDecimal($rincianData['kenaikan'], 0)) ?></td>
            </tr>
            <tr>
                <td colspan="3" style="padding-left: 30px;">c. Pembulatan</td>
                <td class="text-end">Rp. <?= Html::encode(Yii::$app->formatter->asDecimal($rincianData['pembulatan'], 0)) ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-end fw-bold">Jumlah Keseluruhan</td>
                <td class="text-end fw-bold">Rp. <?= Html::encode(Yii::$app->formatter->asDecimal($rincianData['keseluruhan'], 0)) ?></td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top: 15px;">
        <strong>Dengan Huruf:</strong> <i>(Terbilang: ...)</i>
    </div>
    <div style="margin-top: 15px; border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px 0;">
        <strong style="text-decoration: underline;">Perhatian:</strong>
        <ul style="font-size: 9pt; margin: 5px 0 5px 20px; padding-left: 0; list-style-type: disc;">
            <li>Harap Penyetoran Dilakukan pada Bank / Bendahara Penerima</li>
            <li>Apabila SKR ini tidak atau kurang bayar lewat waktu paling lama 30 hari setelah SKR ini diterima atau (tanggal Jatuh Tempo) dikenakan sanksi administrasi berupa bunga sebesar 2 % per bulan.</li>
        </ul>
    </div>
    <div class="ttd-section">
        <div class="ttd-kolom">
            Pemalang, <?= Yii::$app->formatter->asDate($modelSkr['tanggal_skr'] ?? 'now', 'php:d F Y') ?> <br>
            <br>
            <b>Pemalang,<br>Yang Membayar</b>
            <br><br><br><br><br>
            <span class="nama-ttd" style="text-decoration: none;"><?= Html::encode(strtoupper($model['nama_pemohon'] ?? '(.........................)')) ?></span>
        </div>
        <div class="ttd-kolom" style="float: left; width: 45%;"> </div>
         <div class="clear"></div>
    </div>
</body>
</html>