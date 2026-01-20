<?php
use yii\helpers\Html;
/** @var array $model */
?>
<div style="border: 1px solid #000; padding: 20px; font-family: sans-serif;">
    <h1 style="text-align: center;">Lembar Monitoring</h1>
    <hr>
    <h3>Detail Pendaftaran</h3>
    <p><strong>Nomor Daftar:</strong> <?= Html::encode($model['nomor_daftar']) ?></p>
    <p><strong>Nama Pemohon:</strong> <?= Html::encode($model['nama_pemohon']) ?></p>
    <p><strong>Lokasi Usaha:</strong> <?= Html::encode($model['lokasi_usaha']) ?></p>
    <p><strong>Keterangan:</strong> <?= Html::encode($model['keterangan']) ?></p>
</div>