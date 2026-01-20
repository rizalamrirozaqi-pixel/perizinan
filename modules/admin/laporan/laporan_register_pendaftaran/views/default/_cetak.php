<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER (actionCetak)
 * @var yii\web\View $this
 * @var array $models
 * @var string $tanggal_awal
 * @var string $tanggal_akhir
 * @var string $status_pendaftaran
 */

use yii\helpers\Html;

// Mendaftarkan AppAsset untuk mendapatkan styling dasar Bootstrap
// (jika tidak ada, ganti dengan \yii\web\YiiAsset::register($this);)
\app\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/images/logo-pemalang.png">
    <title>Perizinan Pemalang</title>
    <?php $this->head() ?>

    <?php
    // CSS Khusus untuk Halaman Cetak (Desain Lembar Kendali)
    $css = <<<CSS
    
    /* Aturan @page untuk A4 Potrait */
    @page {
        size: A4 portrait;
        margin: 1.5cm 1.5cm;
    }

    /* Style untuk preview di layar (agar terlihat seperti kertas) */
    @media screen {
        body {
            background-color: #e0e0e0;
            font-family: 'Inter', sans-serif;
        }
        .lembar-kendali-container {
            width: 21cm; /* Lebar A4 */
            min-height: 29.7cm;
            padding: 1.5cm 1.5cm;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
    }
    
    /* Style untuk cetak */
    @media print {
        body, html {
            margin: 0;
            padding: 0;
            background-color: #fff; /* Pastikan background putih saat cetak */
            font-family: 'Times New Roman', Times, serif; /* Font formal untuk cetak */
        }
        
        /* Sembunyikan semua elemen selain konten laporan */
        body > *:not(.lembar-kendali-container) {
            display: none !important;
        }
        
        .lembar-kendali-container {
            width: 100% !important;
            min-height: 0;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }
    }
    
    /* Styling Umum (berlaku di layar dan cetak) */
    .lembar-kendali-container {
        color: #000; /* Teks hitam pekat */
    }

    .report-header {
        text-align: center;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 3px double #000;
    }
    .report-header h4 {
        font-weight: bold;
        font-size: 16pt;
        margin-bottom: 5px;
        color: #000;
    }
    .report-header p {
        font-size: 12pt;
        margin-bottom: 0;
        color: #000;
    }
    
    .table-laporan {
        width: 100%;
        border-collapse: collapse !important;
        font-size: 9pt; /* Ukuran font lebih kecil untuk laporan */
        margin-bottom: 20px;
    }
    
    .table-laporan thead {
        display: table-header-group; /* WAJIB agar header berulang di tiap halaman */
    }
    
    .table-laporan th,
    .table-laporan td {
        border: 1px solid #000 !important; /* Border hitam solid */
        padding: 5px 8px;
        vertical-align: top;
        color: #000;
    }
    
    .table-laporan th {
        text-align: center;
        font-weight: bold;
        background-color: #f0f0f0;
    }
    
    .table-laporan tbody tr,
    .table-laporan tbody td {
        page-break-inside: avoid !important; /* Mencegah baris terpotong */
    }
    
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    
    .signature-block {
        margin-top: 40px;
        font-size: 11pt;
        page-break-inside: avoid; /* Jangan pisahkan blok ttd */
    }
    .signature-block .signer {
        float: right;
        width: 45%;
        text-align: center;
    }
    .signature-block .signer-name {
        margin-top: 60px; /* Jarak untuk TTD */
        font-weight: bold;
        text-decoration: underline;
    }
    
    .clear {
        clear: both;
    }

CSS;
    $this->registerCss($css);
    ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="lembar-kendali-container">

        <div class="report-header">
            <h4 class="mb-1">BUKU REGISTER</h4>
            <p class="mb-0">TANGGAL: <?= Html::encode(Yii::$app->formatter->asDate($tanggal_awal, 'php:d F Y')) ?> S/D <?= Html::encode(Yii::$app->formatter->asDate($tanggal_akhir, 'php:d F Y')) ?></p>
            <p class="mb-0">STATUS: <?= Html::encode(strtoupper($status_pendaftaran)) ?></p>
        </div>

        <div class="default-table-area all-products">

            <table class="table-laporan align-middle">
                <thead>
                    <tr class="text-center">
                        <th scope="col" style="width: 5%;">No</th>
                        <th scope="col">Pemohon/Perusahaan</th>
                        <th scope="col">Alamat Pemohon/Lokasi</th>
                        <th scope="col">Biaya</th>
                        <th scope="col">No Izin</th>
                        <th scope="col">Nama Pengambil</th>
                        <th scope="col">Tanggal Pengambil</th>
                        <th scope="col">Ttd Pengambil</th>
                        <th scope="col">Ttd Petugas</th>
                        <th scope="col">Permohonan</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($models)): ?>
                        <tr>
                            <td colspan="11" class="text-center fst-italic">
                                Data tidak ditemukan untuk kriteria yang dipilih.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($models as $index => $model): ?>
                            <tr>
                                <td class="text-center"><?= $index + 1 ?></td>
                                <td><?= Html::encode($model['pemohon_perusahaan']) ?></td>
                                <td><?= Html::encode($model['alamat_pemohon_lokasi']) ?></td>
                                <td class="text-right"><?= Html::encode($model['biaya']) ?></td>
                                <td><?= Html::encode($model['no_izin']) ?></td>
                                <td><?= Html::encode($model['nama_pengambil']) ?></td>
                                <td class="text-center"><?= $model['tanggal_pengambil'] ? Yii::$app->formatter->asDate($model['tanggal_pengambil'], 'php:d-m-Y') : '' ?></td>
                                <td><?= Html::encode($model['ttd_pengambil']) ?></td>
                                <td><?= Html::encode($model['ttd_petugas']) ?></td>
                                <td><?= Html::encode($model['permohonan']) ?></td>
                                <td><?= Html::encode($model['keterangan']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>

        <div classs="signature-block">
            <div class="signer">
                Pemalang, <?= Yii::$app->formatter->asDate(date('Y-m-d'), 'php:d F Y') ?><br>
                Petugas Operator,

                <div class="signer-name" style="margin-top: 60px;">
                    ( .................................... )
                </div>
                <div class="signer-title">
                    NIP. ............................
                </div>
            </div>
            <div class="clear"></div>
        </div>

    </div>

    <?php
    // JS auto-print
    $js = <<<JS
    // Beri sedikit waktu agar content dan CSS termuat sempurna
    setTimeout(function() {
        window.print();
    }, 700);
JS;
    $this->registerJs($js, \yii\web\View::POS_READY);
    ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>