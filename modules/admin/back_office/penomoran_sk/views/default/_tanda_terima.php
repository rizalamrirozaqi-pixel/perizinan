<?php

/**
 * View Partial untuk Cetak Tanda Terima
 * @var yii\web\View $this
 * @var array $model Data Pendaftaran
 */

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Tanda Terima - <?= Html::encode($model['nomor_daftar'] ?? '-') ?></title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 10pt;
            line-height: 1.4;
            margin: 20mm;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-decoration: underline;
            margin-bottom: 30px;
        }

        .content {
            width: 100%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .data-table td {
            vertical-align: top;
            padding: 2px 0;
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
            width: 45%;
            float: right;
            /* Rata kanan */
            text-align: left;
        }

        .ttd-nama {
            margin-top: 60px;
        }

        .footer-notes {
            margin-top: 50px;
            font-size: 9pt;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        .clear {
            clear: both;
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
    <div class="header">TANDA TERIMA</div>
    <div class="content">
        <p>Telah terima berkas permohonan Izin:</p>
        <table class="data-table">
            <tr>
                <td>Nomor Pendaftaran</td>
                <td>:</td>
                <td><?= Html::encode($model['nomor_daftar'] ?? '-') ?> (<?= Html::encode($model['nama_izin'] ?? '-') ?>) [<?= Html::encode($model['jenis_permohonan'] ?? '-') ?>]</td>
            </tr>
            <tr>
                <td>Nama Pemohon</td>
                <td>:</td>
                <td><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Nomor Identitas / NPWP</td>
                <td>:</td>
                <td><?= Html::encode($model['no_ktp_npwp'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Alamat Pemohon</td>
                <td>:</td>
                <td><?= Html::encode($model['alamat'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Nama Usaha</td>
                <td>:</td>
                <td><?= Html::encode($model['nama_usaha'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Alamat Usaha / Bangunan</td>
                <td>:</td>
                <td><?= Html::encode($model['lokasi_usaha'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Kelurahan</td>
                <td>:</td>
                <td><?= Html::encode($model['kelurahan'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>:</td>
                <td><?= Html::encode($model['kecamatan'] ?? '-') ?></td>
            </tr>
        </table>
        <div class="ttd-section">
            <div class="ttd-kolom">
                <!-- Ganti tanggal & nama petugas -->
                <?= Yii::$app->formatter->asDate('now', 'php:l, d F Y') ?><br>
                Petugas Penerima
                <br><br><br><br> <!-- Jarak TTD -->
                <span class="ttd-nama">( Nama Petugas )</span>
            </div>
            <div class="clear"></div>
        </div>
        <div class="footer-notes">
            <p>Keterangan: <br> Contact Person (pada Jam Kerja): (Nomor CP Anda)</p>
            <p>
                * BUKTI TANDA PENDAFTARAN IZIN INI BUKAN MERUPAKAN TANDA BUKTI IZIN <br>
                * NOMOR ... (dst) <br>
                untuk aduan/info/saran: ketik lapor (spasi) ... (dst)
            </p>
        </div>
    </div>
</body>

</html>