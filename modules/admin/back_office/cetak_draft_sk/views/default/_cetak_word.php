<?php

/**
 * View Partial untuk Cetak Lembar Kendali
 * @var yii\web\View $this
 * @var array $model Data pendaftaran
 * @var array $logData Data untuk tabel Log
 */

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Lembar Kendali - <?= Html::encode($model['nomor_daftar'] ?? 'N/A') ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
        }

        .header-line {
            border-top: 2px solid purple;
            margin-bottom: 10px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            font-size: 9pt;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .info-table td {
            vertical-align: top;
            padding: 2px 5px;
        }

        .info-table td:nth-child(1) {
            width: 20%;
            white-space: nowrap;
        }

        .info-table td:nth-child(2) {
            width: 1%;
        }

        .info-table td:nth-child(4) {
            width: 20%;
            white-space: nowrap;
        }

        .info-table td:nth-child(5) {
            width: 1%;
        }

        .log-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }

        .log-table th,
        .log-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            vertical-align: middle;
        }

        .log-table th {
            background-color: #f2f2f2;
            white-space: nowrap;
        }

        .log-table td {
            text-align: left;
        }

        .log-table .text-center {
            text-align: center;
        }

        .log-table .text-nowrap {
            white-space: nowrap;
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

            .header-line,
            .title,
            .info-table,
            .log-table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <button onclick="window.print()" class="btn-print" style="position:fixed; top:10px; right:10px; padding: 5px 10px; cursor:pointer;">Cetak Ulang</button>
    <div class="header-line"></div>
    <div class="title">Lembar Kendali</div>
    <!-- Info Ringkas -->
    <table class="info-table">
        <tr>
            <td>Nomor Pendaftaran</td>
            <td>:</td>
            <td><?= Html::encode($model['nomor_daftar'] ?? '-') ?></td>
            <td>Tanggal</td>
            <td>:</td>
            <td><?= Html::encode(Yii::$app->formatter->asDatetime($model['tanggal_daftar'] ?? 'now', 'php:Y-m-d H:i:s')) ?></td>
        </tr>
        <tr>
            <td>Nama Izin</td>
            <td>:</td>
            <td><?= Html::encode($model['nama_izin'] ?? '-') ?></td>
            <td>Nama Permohonan</td>
            <td>:</td>
            <td><?= Html::encode($model['jenis_permohonan'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Nama Pemohon</td>
            <td>:</td>
            <td><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
            <td>Nomor Identitas</td>
            <td>:</td>
            <td><?= Html::encode(explode(' / ', $model['no_ktp_npwp'] ?? '-')[0]) ?></td>
        </tr>
        <tr>
            <td>Alamat Pemohon</td>
            <td>:</td>
            <td><?= Html::encode($model['alamat'] ?? '-') ?></td>
            <td>Telepon</td>
            <td>:</td>
            <td><?= Html::encode($model['telepon'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Nama Usaha</td>
            <td>:</td>
            <td><?= Html::encode($model['nama_usaha'] ?? '-') ?></td>
            <td>Kecamatan</td>
            <td>:</td>
            <td><?= Html::encode($model['kecamatan'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Lokasi / Usaha Bangunan</td>
            <td>:</td>
            <td><?= Html::encode($model['lokasi_usaha'] ?? '-') ?></td>
            <td>Kelurahan</td>
            <td>:</td>
            <td><?= Html::encode($model['kelurahan'] ?? '-') ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Verifikator</td>
            <td>:</td>
            <td>(Data Verifikator jika ada)</td>
        </tr>
    </table>
    <!-- Tabel Log Detail -->
    <table class="log-table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th colspan="2">Tanggal Mulai</th>
                <th rowspan="2">Dari</th>
                <th rowspan="2">Nama Pengguna</th>
                <th rowspan="2">Proses</th>
                <th colspan="2">Tanggal Selesai</th>
                <th rowspan="2">Kirim Ke</th>
                <th colspan="2">Berkas Tolak/<br>Dikirim</th>
                <th rowspan="2">Catatan</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Tanggal<br>Terima/Tolak</th>
                <th colspan="3">Lambat</th>
            </tr>
            <tr>
                <th>Entry</th>
                <th>System</th>
                <th>Entry</th>
                <th>System</th>
                <th>Entry</th>
                <th>System</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Menit</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($logData)): ?>
                <tr>
                    <td colspan="17" class="text-center">Data Log tidak ditemukan.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($logData as $item): ?>
                    <tr>
                        <td class="text-center"><?= Html::encode($item['pos'] ?? '-') ?></td>
                        <td class="text-center text-nowrap"><?= !empty($item['tanggal_mulai_entry']) ? Html::encode(Yii::$app->formatter->asDate($item['tanggal_mulai_entry'], 'php:Y-m-d')) : '-' ?></td>
                        <td class="text-center text-nowrap"><?= !empty($item['tanggal_mulai_system']) ? Html::encode(Yii::$app->formatter->asDatetime($item['tanggal_mulai_system'], 'php:Y-m-d H:i:s')) : '-' ?></td>
                        <td class="text-left"><?= Html::encode($item['dari'] ?? '-') ?></td>
                        <td class="text-left"><?= Html::encode($item['nama_pengguna'] ?? '-') ?></td>
                        <td class="text-left"><?= Html::encode($item['proses'] ?? '-') ?></td>
                        <td class="text-center text-nowrap"><?= !empty($item['tanggal_selesai_entry']) ? Html::encode(Yii::$app->formatter->asDate($item['tanggal_selesai_entry'], 'php:Y-m-d')) : '-' ?></td>
                        <td class="text-center text-nowrap"><?= !empty($item['tanggal_selesai_system']) ? Html::encode(Yii::$app->formatter->asDatetime($item['tanggal_selesai_system'], 'php:Y-m-d H:i:s')) : '-' ?></td>
                        <td class="text-left"><?= Html::encode($item['kirim_ke'] ?? '-') ?></td>
                        <td class="text-center text-nowrap"><?= !empty($item['berkas_tolak_kirim_entry']) ? Html::encode(Yii::$app->formatter->asDate($item['berkas_tolak_kirim_entry'], 'php:Y-m-d')) : '-' ?></td>
                        <td class="text-center text-nowrap"><?= !empty($item['berkas_tolak_kirim_system']) ? Html::encode(Yii::$app->formatter->asDatetime($item['berkas_tolak_kirim_system'], 'php:Y-m-d H:i:s')) : '-' ?></td>
                        <td class="text-left"><?= Html::encode($item['catatan'] ?? '-') ?></td>
                        <td class="text-left"><?= Html::encode($item['status'] ?? '-') ?></td>
                        <td class="text-center text-nowrap"><?= !empty($item['tanggal_terima_tolak']) ? Html::encode(Yii::$app->formatter->asDate($item['tanggal_terima_tolak'], 'php:Y-m-d')) : '-' ?></td>
                        <td class="text-center"><?= Html::encode($item['lambat_hari'] ?? '0') ?></td>
                        <td class="text-center"><?= Html::encode($item['lambat_jam'] ?? '0') ?></td>
                        <td class="text-center"><?= Html::encode($item['lambat_menit'] ?? '0') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>