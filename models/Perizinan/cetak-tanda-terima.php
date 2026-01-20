<?php
use yii\helpers\Html;
/** @var array $model */
?>
<div style="border: 1px solid #000; padding: 20px; font-family: sans-serif;">
    <h1 style="text-align: center;">Tanda Terima Pendaftaran</h1>
    <hr>
    <p>Telah diterima pendaftaran atas nama:</p>
    <table width="100%">
        <tr>
            <td width="30%">Nomor Pendaftaran</td>
            <td>: <strong><?= Html::encode($model['nomor_daftar']) ?></strong></td>
        </tr>
        <tr>
            <td>Nama Pemohon</td>
            <td>: <?= Html::encode($model['nama_pemohon']) ?></td>
        </tr>
        <tr>
            <td>Nama Usaha</td>
            <td>: <?= Html::encode($model['nama_usaha']) ?></td>
        </tr>
         <tr>
            <td>Waktu Pendaftaran</td>
            <td>: <?= Yii::$app->formatter->asDatetime($model['waktu'], 'long') ?></td>
        </tr>
    </table>
    <p style="margin-top: 40px;">Harap simpan tanda terima ini sebagai bukti pendaftaran.</p>
</div>