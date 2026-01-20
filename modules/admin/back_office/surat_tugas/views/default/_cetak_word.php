<?php

/**
 * View Partial untuk Konten Cetak Word Surat Tugas
 * @var yii\web\View $this
 * @var array $model Data jadwal surat tugas
 * @var string $penandatanganNama Nama pejabat penandatangan
 */

use yii\helpers\Html;
?>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/images/logo-pemalang.png">
    <title>Surat Tugas - <?= Html::encode($model['nomor_surat_perintah'] ?? $model['id']) ?></title>
    <!-- Minimal styling untuk struktur dasar -->
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 1px solid black;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .nomor-surat {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .tabel-penugasan {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 10px;
            border: 1px solid black;
        }

        .tabel-penugasan th,
        .tabel-penugasan td {
            border: 1px solid black;
            padding: 3px;
            font-size: 11pt;
        }

        .tabel-penugasan th {
            text-align: center;
        }

        .penandatangan {
            margin-top: 40px;
            width: 50%;
            margin-left: 50%;
            text-align: center;
        }

        .nama-penandatangan {
            margin-top: 50px;
            font-weight: bold;
            text-decoration: underline;
        }

        ol {
            margin-left: 30px;
            padding-left: 0;
        }

        p {
            margin-bottom: 8px;
        }
    </style>
</head>

<body>

    <div class="kop-surat">
        <p style="font-weight: bold; margin:0;">PEMERINTAH KABUPATEN XYZ</p>
        <p style="font-weight: bold; margin:0; font-size: 14pt;">DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</p>
        <p style="font-size: 10pt; margin:0;">Alamat Kantor - Telp/Fax - Email - Website</p>
    </div>

    <div class="nomor-surat">
        <u>SURAT PERINTAH TUGAS</u><br>
        Nomor: <?= Html::encode($model['nomor_surat_perintah'] ?? '......... / SPT / ...... / ' . date('Y')) ?>
    </div>

    <div class="isi-surat">
        <p>Dasar:</p>
        <ol>
            <li>Peraturan Daerah Kabupaten XYZ Nomor ... Tahun ... tentang ...</li>
            <li>Peraturan Bupati XYZ Nomor ... Tahun ... tentang ...</li>
            <li>Disposisi Kepala Dinas tanggal ...</li>
        </ol>

        <p style="text-align: center; font-weight: bold; margin-top: 15px;">MEMBERI PERINTAH:</p>

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
                    <td style="text-align:center;">1.</td>
                    <td>Andi Saputra / 198XXXXX XXXXXX X XXX</td>
                    <td>Penata Muda Tk. I / III/b</td>
                    <td>Staf Verifikator</td>
                </tr>
                <tr>
                    <td style="text-align:center;">2.</td>
                    <td>Budi Cahyono / 198XXXXX XXXXXX X XXX</td>
                    <td>Penata Muda / III/a</td>
                    <td>Staf Verifikator</td>
                </tr>
            </tbody>
        </table>

        <p>Untuk:</p>
        <ol>
            <li>Melaksanakan peninjauan lapangan / pemeriksaan teknis terhadap permohonan izin <strong><?= Html::encode($model['nama_izin'] ?? '...') ?></strong> atas nama <strong><?= Html::encode($model['nama_pemohon'] ?? '...') ?></strong>, lokasi di <strong><?= Html::encode($model['lokasi'] ?? '...') ?></strong>.</li>
            <li>Pemeriksaan dilaksanakan pada tanggal <strong><?= Yii::$app->formatter->asDate($model['tanggal_pemeriksaan_mulai'], 'php:d F Y') ?></strong> s/d <strong><?= Yii::$app->formatter->asDate($model['tanggal_pemeriksaan_selesai'], 'php:d F Y') ?></strong>.</li>
            <li>Membuat Berita Acara Pemeriksaan (BAP) hasil peninjauan/pemeriksaan.</li>
            <li>Melaporkan hasil pelaksanaan tugas kepada Kepala Dinas.</li>
        </ol>

        <p>Demikian Surat Perintah Tugas ini dibuat untuk dilaksanakan dengan sebaik-baiknya dan penuh tanggung jawab.</p>
    </div>

    <div class="penandatangan">
        Ditetapkan di : Klaten <br>
        Pada tanggal : <?= Yii::$app->formatter->asDate($model['tanggal_cetak'] ?? date('Y-m-d'), 'php:d F Y') ?> <br>
        <br>
        <b><?= Html::encode(strtoupper($penandatanganNama)) ?></b>,
        <br><br><br><br> <!-- Jarak TTD -->
        <span class="nama-penandatangan"><?= Html::encode('NAMA PEJABAT') ?></span><br>
        <span>Pangkat / Golongan</span><br>
        <span>NIP. <?= Html::encode('NIP PEJABAT') ?></span>
    </div>

</body>

</html>