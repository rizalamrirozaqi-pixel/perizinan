<?php

/**
 * View Partial untuk Cetak Laporan HTML
 * @var yii\web\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var array $models
 * @var string $dari_tanggal
 * @var string $sampai_tanggal
 */

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Penyerahan SK</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 20px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            vertical-align: middle;
        }

        .report-table th {
            background-color: #f2f2f2;
            white-space: nowrap;
        }

        .report-table td {
            text-align: left;
        }

        .report-table .text-center {
            text-align: center;
        }

        .report-table .text-nowrap {
            white-space: nowrap;
        }

        .report-table .text-end {
            text-align: right;
        }

        .text-left {
            text-align: left !important;
        }

        @media print {
            body {
                margin: 10mm;
            }

            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <button onclick="window.print()" class="btn-print" style="position:fixed; top:10px; right:10px; padding: 5px 10px; cursor:pointer;">Cetak Ulang</button>

    <div class="title">DAFTAR PENYERAHAN SK</div>
    <div class="subtitle">
        Tanggal <?= Html::encode(Yii::$app->formatter->asDate($dari_tanggal ?? '1970-01-01', 'php:d-m-Y')) ?>
        s/d
        <?= Html::encode(Yii::$app->formatter->asDate($sampai_tanggal ?? 'now', 'php:d-m-Y')) ?>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Pendaftaran</th>
                <th>Nama Pemohon</th>
                <th>Nama Usaha</th>
                <th>Jenis Izin</th>
                <th>Retribusi</th>
                <th>Nomor SK</th>
                <th>Tanggal SK</th>
                <th>Tanggal Habis Berlaku</th>
                <th>Tanggal Diserahkan</th>
                <th>Diterima Oleh</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($models)): ?>
                <tr>
                    <td colspan="11" class="text-center">Data tidak ditemukan.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($models as $index => $model): ?>
                    <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td><?= Html::encode($model['nomor_daftar'] ?? '-') ?></td>
                        <td><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
                        <td><?= Html::encode($model['nama_usaha'] ?? '-') ?></td>
                        <td><?= Html::encode($model['nama_izin'] ?? '-') ?></td>
                        <td class="text-end"><?= 'Rp ' . Yii::$app->formatter->asDecimal($model['retribusi'] ?? 0, 0) ?></td>
                        <td><?= Html::encode($model['nomor_sk'] ?? '-') ?></td>
                        <td class="text-center text-nowrap"><?= !empty($model['tanggal_sk']) ? Yii::$app->formatter->asDate($model['tanggal_sk'], 'php:d M Y') : '-' ?></td>
                        <td class="text-center text-nowrap"><?= !empty($model['tanggal_habis_berlaku']) ? Yii::$app->formatter->asDate($model['tanggal_habis_berlaku'], 'php:d M Y') : '-' ?></td>
                        <td class="text-center text-nowrap"><?= !empty($model['tanggal_diserahkan']) ? Yii::$app->formatter->asDate($model['tanggal_diserahkan'], 'php:d M Y') : '-' ?></td>
                        <td><?= Html::encode($model['diterima_oleh'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>