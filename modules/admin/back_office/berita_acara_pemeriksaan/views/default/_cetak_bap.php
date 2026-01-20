<?php

/**
 * View Partial untuk Cetak BAP
 * @var yii\web\View $this
 * @var array $model Data Pendaftaran
 * @var array $bapData Data BAP
 */

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/images/logo-pemalang.png">
    <title>Berita Acara Pemeriksaan - <?= Html::encode($model['nomor_daftar'] ?? '-') ?></title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11pt;
            margin: 40px;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
            font-size: 14pt;
        }

        .nomor-bap {
            text-align: center;
            margin-bottom: 30px;
        }

        .paragraf {
            text-indent: 30px;
            text-align: justify;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .tabel-data {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .tabel-data td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .tabel-data td:first-child {
            width: 30%;
            white-space: nowrap;
            font-weight: 500;
        }

        .tabel-data td:nth-child(2) {
            width: 1%;
            padding-right: 5px;
        }

        .penutup {
            margin-top: 30px;
        }

        .ttd-area {
            margin-top: 50px;
        }

        .ttd-kolom {
            width: 45%;
            float: left;
            text-align: center;
            line-height: 1.4;
        }

        .ttd-kanan {
            float: right;
        }

        .nama-ttd {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
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

            .table {
                font-size: 9pt;
            }

            .kop-surat,
            .judul,
            .nomor-bap,
            .paragraf,
            .tabel-data,
            .penutup,
            .ttd-area {
                page-break-inside: avoid;
            }

            .tabel-data td:first-child {
                width: 25%;
            }

        }
    </style>
</head>

<body onload="window.print()">

    <button onclick="window.print()" class="btn-print" style="position:fixed; top:10px; right:10px; padding: 5px 10px; cursor:pointer;">Cetak Ulang</button>

    <div class="kop-surat">
        <h4>PEMERINTAH KABUPATEN XYZ</h4>
        <h3>DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</h3>
        <small>Alamat Kantor - Telp/Fax - Email - Website</small>
    </div>

    <div class="judul">BERITA ACARA PEMERIKSAAN</div>
    <div class="nomor-bap">Nomor: <?= Html::encode($bapData['nomor_bap'] ?? '............................') ?></div>

    <p class="paragraf">
        Pada hari ini, <?= Yii::$app->formatter->asDate($bapData['tanggal_lapangan'] ?? 'now', 'php:l') ?>,
        tanggal <?= Yii::$app->formatter->asDate($bapData['tanggal_lapangan'] ?? 'now', 'php:d') ?>
        bulan <?= Yii::$app->formatter->asDate($bapData['tanggal_lapangan'] ?? 'now', 'php:F') ?>
        tahun <?= Yii::$app->formatter->asDate($bapData['tanggal_lapangan'] ?? 'now', 'php:Y') ?>,
        kami yang bertanda tangan di bawah ini Tim Pemeriksa dari Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten XYZ, berdasarkan Surat Perintah Tugas Nomor ..... tanggal ..... , telah melakukan pemeriksaan lapangan terhadap permohonan izin:
    </p>

    <table class="tabel-data">
        <tr>
            <td>Nama Pemohon</td>
            <td>:</td>
            <td><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Nama Usaha</td>
            <td>:</td>
            <td><?= Html::encode($model['nama_usaha'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Jenis Izin</td>
            <td>:</td>
            <td><?= Html::encode($model['nama_izin'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Jenis Permohonan</td>
            <td>:</td>
            <td><?= Html::encode($model['jenis_permohonan'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Lokasi Pemeriksaan</td>
            <td>:</td>
            <td><?= Html::encode($model['lokasi_usaha'] ?? '-') ?>, Kel. <?= Html::encode($model['kelurahan'] ?? '-') ?>, Kec. <?= Html::encode($model['kecamatan'] ?? '-') ?></td>
        </tr>
    </table>

    <p>Hasil Pemeriksaan:</p>
    <ol style="margin-left: 30px; padding-left: 0; text-align: justify; line-height: 1.5;">
        <li>Kondisi lapangan: (Jelaskan hasil temuan di lapangan secara detail. Misalnya: Bangunan sesuai dengan gambar, terdapat X unit reklame terpasang, dll.)</li>
        <li>Kesesuaian dengan permohonan: (Jelaskan kesesuaian/ketidaksesuaian data di lapangan dengan berkas permohonan. Misalnya: Sesuai / Tidak Sesuai karena luas bangunan berbeda / Sesuai dengan catatan bahwa perlu melengkapi dokumen X.)</li>
        <li>Rekomendasi Tim Pemeriksa: (Berikan rekomendasi yang jelas. Misalnya: Setuju untuk diterbitkan izinnya / Ditolak karena tidak memenuhi syarat teknis / Disetujui dengan syarat pemohon melengkapi X paling lambat tanggal Y.)</li>
    </ol>

    <div class="penutup">
        <p class="paragraf">
            Demikian Berita Acara Pemeriksaan ini dibuat dengan sebenarnya dalam rangkap [...] untuk dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <div class="ttd-area">
        <div class="ttd-kolom">
            Yang diperiksa,<br>
            Pemohon / Perwakilan Perusahaan
            <br><br><br><br><br> <span class="nama-ttd"><?= Html::encode(strtoupper($model['nama_pemohon'] ?? '(.........................)')) ?></span>
        </div>
        <div class="ttd-kolom ttd-kanan">
            Klaten, <?= Yii::$app->formatter->asDate($bapData['tanggal_bap'] ?? 'now', 'php:d F Y') ?> <br> Tim Pemeriksa,
            <br><br><br><br><br> <span class="nama-ttd">(.........................)</span><br> <span>NIP. .........................</span><br>
            <br> <span class="nama-ttd">(.........................)</span><br> <span>NIP. .........................</span>
        </div>
        <div class="clear"></div>
    </div>

</body>

</html>