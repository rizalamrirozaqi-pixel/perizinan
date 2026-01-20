<?php

/**
 * View Partial untuk Cetak Laporan Excel
 * @var yii\web\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var array $models
 * @var string $dari_tanggal
 * @var string $sampai_tanggal
 */

use yii\helpers\Html;
?>

<table>
    <thead>
        <tr>
            <th colspan="11" style="font-size: 14pt; text-align: center; font-weight: bold;">DAFTAR PENYERAHAN SK</th>
        </tr>
        <tr>
            <th colspan="11" style="text-align: center;">
                Tanggal <?= Html::encode(Yii::$app->formatter->asDate($dari_tanggal ?? '1970-01-01', 'php:d-m-Y')) ?>
                s/d
                <?= Html::encode(Yii::$app->formatter->asDate($sampai_tanggal ?? 'now', 'php:d-m-Y')) ?>
            </th>
        </tr>
        <tr>
            <th style="background-color: #f2f2f2; text-align: center;">No</th>
            <th style="background-color: #f2f2f2; text-align: center;">Nomor Pendaftaran</th>
            <th style="background-color: #f2f2f2; text-align: center;">Nama Pemohon</th>
            <th style="background-color: #f2f2f2; text-align: center;">Nama Usaha</th>
            <th style="background-color: #f2f2f2; text-align: center;">Jenis Izin</th>
            <th style="background-color: #f2f2f2; text-align: center;">Retribusi</th>
            <th style="background-color: #f2f2f2; text-align: center;">Nomor SK</th>
            <th style="background-color: #f2f2f2; text-align: center;">Tanggal SK</th>
            <th style="background-color: #f2f2f2; text-align: center;">Tanggal Habis Berlaku</th>
            <th style="background-color: #f2f2f2; text-align: center;">Tanggal Diserahkan</th>
            <th style="background-color: #f2f2f2; text-align: center;">Diterima Oleh</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($models)): ?>
            <tr>
                <td colspan="11" style="text-align: center;">Data tidak ditemukan.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($models as $index => $model): ?>
                <tr>
                    <td style="text-align: center;"><?= $index + 1 ?></td>
                    <td>'<?= Html::encode($model['nomor_daftar'] ?? '-') ?></td>
                    <td><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
                    <td><?= Html::encode($model['nama_usaha'] ?? '-') ?></td>
                    <td><?= Html::encode($model['nama_izin'] ?? '-') ?></td>
                    <td style="text-align: right;"><?= $model['retribusi'] ?? 0 ?></td>
                    <td>'<?= Html::encode($model['nomor_sk'] ?? '-') ?></td>
                    <td style="text-align: center;"><?= !empty($model['tanggal_sk']) ? Yii::$app->formatter->asDate($model['tanggal_sk'], 'php:d-m-Y') : '-' ?></td>
                    <td style="text-align: center;"><?= !empty($model['tanggal_habis_berlaku']) ? Yii::$app->formatter->asDate($model['tanggal_habis_berlaku'], 'php:d-m-Y') : '-' ?></td>
                    <td style="text-align: center;"><?= !empty($model['tanggal_diserahkan']) ? Yii::$app->formatter->asDate($model['tanggal_diserahkan'], 'php:d-m-Y') : '-' ?></td>
                    <td><?= Html::encode($model['diterima_oleh'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>