<?php

/**
 * View Partial untuk Cetak Bukti Penerimaan SK
 * @var yii\web\View $this
 * @var array $model Data Pendaftaran
 * @var array $modelSk Data SK
 * @var array $modelPengambilan Data Pengambilan
 */

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bukti Penyerahan SK - <?= Html::encode($model['nomor_daftar'] ?? '-') ?></title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            margin: 20mm;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-decoration: underline;
            margin-bottom: 30px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .data-table td {
            vertical-align: top;
            padding: 3px 0;
        }

        .data-table td:nth-child(1) {
            width: 30%;
            white-space: nowrap;
        }

        .data-table td:nth-child(2) {
            width: 1%;
            padding-right: 5px;
        }

        .ttd-section {
            margin-top: 40px;
        }

        .ttd-kolom {
            width: 40%;
            text-align: left;
        }

        .ttd-kiri {
            float: left;
        }

        .ttd-kanan {
            float: right;
        }

        .ttd-nama {
            margin-top: 70px;
            font-weight: bold;
        }

        .clear {
            clear: both;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 20px 0;
        }

        @media print {
            .btn-print {
                display: none;
            }

            body {
                margin: 15mm;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <button onclick="window.print()" class="btn-print" style="position:fixed; top:10px; right:10px; padding: 5px 10px; cursor:pointer; font-family: sans-serif;">Cetak Ulang</button>

    <div class="header">BUKTI PENYERAHAN SK</div>

    <table class="data-table">
        <tr>
            <td>Nomor Pendaftaran</td>
            <td>:</td>
            <td><?= Html::encode($model['nomor_daftar'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Nama Pemohon</td>
            <td>:</td>
            <td><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Jenis Izin</td>
            <td>:</td>
            <td><?= Html::encode($model['nama_izin'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Nama Usaha</td>
            <td>:</td>
            <td><?= Html::encode($model['nama_usaha'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Alamat Lokasi Usaha</td>
            <td>:</td>
            <td><?= Html::encode($model['lokasi_usaha'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Tanggal Pendaftaran</td>
            <td>:</td>
            <td><?= !empty($model['tanggal_daftar']) ? Yii::$app->formatter->asDate($model['tanggal_daftar'], 'php:d F Y') : '-' ?></td>
        </tr>
        <tr>
            <td>Tanggal Penyerahan SK</td>
            <td>:</td>
            <td><?= !empty($modelPengambilan['tanggal_diambil']) ? Yii::$app->formatter->asDate($modelPengambilan['tanggal_diambil'], 'php:d F Y') : '-' ?></td>
        </tr>
    </table>

    <div class="ttd-section">
        <div class="ttd-kolom ttd-kiri">
            Yang Menerima SK,
            <br><br><br><br><br>
            <span class="ttd-nama">( <?= Html::encode(strtoupper($modelPengambilan['nama_pengambil'] ?? '...................')) ?> )</span>
        </div>
        <div class="ttd-kolom ttd-kanan">
            Yang Menyerahkan SK,
            <br><br><br><br><br>
            <span class="ttd-nama">( <?= Html::encode(strtoupper($modelPengambilan['yang_menyerahkan'] ?? '...................')) ?> )</span>
        </div>
        <div class="clear"></div>
    </div>

    <hr>
</body>

</html>