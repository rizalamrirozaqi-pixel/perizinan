<?php

/**
 * Partial view for printing registration details.
 *
 * @var yii\web\View $this
 * @var array $modelData Data pendaftaran
 * @var string $namaKecamatan
 * @var string $namaKelurahan
 * @var string $tanggalFormatted
 * @var string $waktuFormatted
 */

use yii\helpers\Html;

$syaratItems = [
    'syarat_1' => 'Surat Permohonan',
    'syarat_2' => 'Foto Copy KTP Pemilik Usaha',
    'syarat_3' => 'Gambar Tulisan Reklame atau Contoh Bentuk Reklamenya',
];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/images/logo-pemalang.png">
    <title>Bukti Pendaftaran - <?= Html::encode($modelData['nomor_daftar'] ?? 'N/A') ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 25px;
            border-radius: 5px;
        }

        h1,
        h2 {
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 1.2em;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px 12px;
            text-align: left;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }

        th {
            width: 35%;
            /* Adjust width as needed */
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .section-title {
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        li {
            margin-bottom: 5px;
        }

        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        @media print {

            .print-button,
            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
            }

            .container {
                border: none;
                box-shadow: none;
                max-width: 100%;
                padding: 0;
            }
        }
    </style>
</head>
<div class="container">
    <h1>Bukti Pendaftaran Perizinan</h1>

    <table>
        <tr>
            <th>Nomor Pendaftaran</th>
            <td><?= Html::encode($modelData['nomor_daftar'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <th>Tanggal Daftar</th>
            <td><?= Html::encode($tanggalFormatted) ?> Jam <?= Html::encode($waktuFormatted) ?></td>
        </tr>
        <tr>
            <th>Jenis Izin</th>
            <td><?= Html::encode($modelData['nama_izin'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <th>Jenis Permohonan</th>
            <td><?= Html::encode($modelData['nama_permohonan'] ?? 'N/A') ?></td>
        </tr>
    </table>

    <h2>Data Pemohon</h2>
    <table>
        <tr>
            <th>Nama Pemohon</th>
            <td><?= Html::encode($modelData['nama_pemohon'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <th>No. KTP</th>
            <td><?= Html::encode($modelData['no_ktp'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <th>No. NPWP</th>
            <td><?= Html::encode($modelData['no_npwp'] ?? '-') ?></td>
        </tr>
        <tr>
            <th>Alamat Pemohon</th>
            <td><?= nl2br(Html::encode($modelData['alamat'] ?? 'N/A')) ?></td>
        </tr>
        <tr>
            <th>No. HP</th>
            <td><?= Html::encode($modelData['no_hp'] ?? 'N/A') ?></td>
        </tr>
    </table>

    <h2>Data Usaha / Lokasi</h2>
    <table>
        <tr>
            <th>Nama Usaha</th>
            <td><?= Html::encode($modelData['nama_usaha'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <th>Bidang Usaha</th>
            <td><?= Html::encode($modelData['bidang_usaha'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <th>Lokasi Usaha / Bangunan</th>
            <td><?= nl2br(Html::encode($modelData['lokasi_usaha'] ?? 'N/A')) ?></td>
        </tr>
        <tr>
            <th>Kecamatan</th>
            <td><?= Html::encode($namaKecamatan) ?></td>
        </tr>
        <tr>
            <th>Kelurahan/Kalurahan</th>
            <td><?= Html::encode($namaKelurahan) ?></td>
        </tr>
        <tr>
            <th>Keterangan Tambahan</th>
            <td><?= !empty($modelData['keterangan']) ? nl2br(Html::encode($modelData['keterangan'])) : '-' ?></td>
        </tr>
    </table>

    <div class="section-title">Syarat yang Telah Dipenuhi (Berdasarkan Input):</div>
    <ul>
        <?php
        $submittedSyarat = $modelData['syarat'] ?? [];
        if (empty($submittedSyarat)) {
            echo "<li>Tidak ada syarat yang ditandai terpenuhi.</li>";
        } else {
            foreach ($submittedSyarat as $syaratKey) {
                echo "<li>" . Html::encode($syaratItems[$syaratKey] ?? $syaratKey) . "</li>";
            }
        }
        ?>
    </ul>

    <div style="margin-top: 30px; text-align: right; font-size: 0.9em;">
        Dicetak pada: <?= Yii::$app->formatter->asDatetime(time(), 'php:d M Y H:i:s') ?>
    </div>

    <button onclick="window.print();" class="print-button">Cetak Halaman Ini</button>
    <p class="no-print" style="text-align:center; font-style: italic;">Gunakan fungsi print browser (Ctrl+P atau Cmd+P) untuk mencetak.</p>

</div>