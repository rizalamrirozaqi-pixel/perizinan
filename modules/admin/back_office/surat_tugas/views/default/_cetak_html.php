<?php

/**
 * View Partial untuk Cetak HTML Surat Tugas
 * @var yii\web\View $this
 * @var array $model Data jadwal surat tugas
 * @var string $penandatanganNama Nama pejabat penandatangan
 */

use yii\helpers\Html;

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/images/logo-pemalang.png">
    <title>Surat Tugas - <?= Html::encode($model['nomor_surat_perintah'] ?? $model['id']) ?></title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            margin: 40px;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .kop-surat h3,
        .kop-surat h4 {
            margin: 0;
        }

        .nomor-surat {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .isi-surat {
            margin-bottom: 30px;
        }

        .isi-surat p {
            margin-bottom: 10px;
            text-align: justify;
        }

        .tabel-penugasan {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .tabel-penugasan th,
        .tabel-penugasan td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        .tabel-penugasan th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .penandatangan {
            margin-top: 50px;
            /* Jarak dari atas */
            width: 300px;
            /* Lebar area tanda tangan */
            margin-left: auto;
            /* Rata kanan */
            text-align: center;
        }

        .nama-penandatangan {
            margin-top: 60px;
            /* Jarak untuk TTD */
            font-weight: bold;
            text-decoration: underline;
        }

        /* Tambahkan style lain sesuai kebutuhan */
        @media print {
            body {
                margin: 20mm;
            }

            /* Margin cetak */
            .btn-print {
                display: none;
            }

            /* Sembunyikan tombol print saat dicetak */
        }
    </style>
</head>

<body onload="window.print()"> <!-- Otomatis buka dialog print -->

    <button onclick="window.print()" class="btn-print" style="position:fixed; top:10px; right:10px;">Cetak Ulang</button>

    <div class="kop-surat">
        <h4>PEMERINTAH KABUPATEN XYZ</h4>
        <h3>DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</h3>
        <small>Alamat Kantor - Telp/Fax - Email - Website</small>
    </div>

    <div class="nomor-surat">
        <u>SURAT PERINTAH TUGAS</u><br>
        Nomor: <?= Html::encode($model['nomor_surat_perintah'] ?? '......... / SPT / ...... / ' . date('Y')) ?>
    </div>

    <div class="isi-surat">
        <p>Dasar:</p>
        <ol style="margin-left: 20px; padding-left: 0;">
            <li>Peraturan Daerah Kabupaten XYZ Nomor ... Tahun ... tentang ...</li>
            <li>Peraturan Bupati XYZ Nomor ... Tahun ... tentang ...</li>
            <li>Disposisi Kepala Dinas tanggal ...</li>
            <!-- Tambahkan dasar hukum lain -->
        </ol>

        <p style="text-align: center; font-weight: bold; margin-top: 20px;">MEMBERI PERINTAH:</p>

        <p>Kepada:</p>
        <table class="tabel-penugasan">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama / NIP</th>
                    <th>Pangkat / Gol. Ruang</th>
                    <th>Jabatan</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ganti dengan data tim pemeriksa yang sebenarnya -->
                <tr>
                    <td class="text-center">1.</td>
                    <td>Andi Saputra / 198XXXXX XXXXXX X XXX</td>
                    <td>Penata Muda Tk. I / III/b</td>
                    <td>Staf Verifikator</td>
                </tr>
                <tr>
                    <td class="text-center">2.</td>
                    <td>Budi Cahyono / 198XXXXX XXXXXX X XXX</td>
                    <td>Penata Muda / III/a</td>
                    <td>Staf Verifikator</td>
                </tr>
                <!-- Loop data tim jika ada -->
            </tbody>
        </table>

        <p>Untuk:</p>
        <ol style="margin-left: 20px; padding-left: 0;">
            <li>Melaksanakan peninjauan lapangan / pemeriksaan teknis terhadap permohonan izin <strong><?= Html::encode($model['nama_izin'] ?? '...') ?></strong> atas nama <strong><?= Html::encode($model['nama_pemohon'] ?? '...') ?></strong>, lokasi di <strong><?= Html::encode($model['lokasi'] ?? '...') ?></strong>.</li>
            <li>Pemeriksaan dilaksanakan pada tanggal <strong><?= Yii::$app->formatter->asDate($model['tanggal_pemeriksaan_mulai'], 'php:d F Y') ?></strong> s/d <strong><?= Yii::$app->formatter->asDate($model['tanggal_pemeriksaan_selesai'], 'php:d F Y') ?></strong>.</li>
            <li>Membuat Berita Acara Pemeriksaan (BAP) hasil peninjauan/pemeriksaan.</li>
            <li>Melaporkan hasil pelaksanaan tugas kepada Kepala Dinas.</li>
        </ol>

        <p>Demikian Surat Perintah Tugas ini dibuat untuk dilaksanakan dengan sebaik-baiknya dan penuh tanggung jawab.</p>
    </div>

    <div class="penandatangan">
        Ditetapkan di : Klaten <br> <!-- Ganti Lokasi -->
        Pada tanggal : <?= Yii::$app->formatter->asDate($model['tanggal_cetak'] ?? date('Y-m-d'), 'php:d F Y') ?> <br>
        <br>
        <b><?= Html::encode(strtoupper($penandatanganNama)) // Jabatan penandatangan
            ?></b>,
        <br><br><br><br> <!-- Jarak untuk TTD -->
        <span class="nama-penandatangan"><?= Html::encode('NAMA PEJABAT') // Ganti Nama Pejabat
                                            ?></span><br>
        <span>Pangkat / Golongan</span><br> <!-- Ganti Pangkat -->
        <span>NIP. <?= Html::encode('NIP PEJABAT') // Ganti NIP
                    ?></span>
    </div>

</body>

</html>