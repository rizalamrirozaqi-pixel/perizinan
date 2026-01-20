<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var array $model Data pendaftaran
 * @var array $lembarKendaliData Data untuk tabel Lembar Kendali
 */

use yii\helpers\Html;
use yii\helpers\Url;

// Memuat aset CSS Anda (Bootstrap, dll)
\app\assets\AppAsset::register($this);

$this->title = 'Lembar Kendali - ' . ($model['nomor_daftar'] ?? 'N/A');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/images/logo-pemalang.png">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
        @page {
            size: landscape;
            /* PAKSA LANDSCAPE */
            margin: 0.75rem;
        }

        /* Style untuk container utama */
        .print-container {
            width: 100%;
            margin: 0 auto;
            padding: 1.5rem;
            background: #fff;
            font-family: Arial, sans-serif;
            color: #000;
        }

        /* Garis ungu di atas */
        .header-bar {
            border-top: 4px solid #800080;
            /* Warna ungu */
            margin-bottom: 1.5rem;
        }

        /* Judul "Lembar Kendali" */
        .print-title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-decoration: underline;
        }

        /* Seksi Info (2 kolom) */
        .info-section {
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .info-section .row {
            margin-bottom: 0.15rem;
        }

        .info-label {
            font-weight: normal;
            padding-right: 0;
        }

        .info-divider {
            padding: 0 0.5rem 0 0.5rem;
            text-align: center;
        }

        .info-value {
            font-weight: normal;
        }

        /* Style untuk Tabel Log (meniru gambar) */
        .log-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
        }

        .log-table th,
        .log-table td {
            border: 1px solid #000;
            /* Garis hitam */
            padding: 4px 6px;
            vertical-align: middle;
            text-align: left;
        }

        .log-table thead th {
            background-color: #f0f0f0;
            /* Header abu-abu muda */
            text-align: center;
            font-weight: bold;
            vertical-align: middle;
            white-space: nowrap;
        }

        .log-table tbody td {
            vertical-align: top;
        }

        .log-table .text-center {
            text-align: center;
        }

        .log-table .text-nowrap {
            white-space: nowrap;
        }


        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                margin: 0;
                padding: 0;
            }

            .print-container {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none;
                font-size: 10pt;
            }

            .log-table {
                font-size: 8pt;
            }

            .info-section {
                font-size: 9pt;
            }

            .print-button-container {
                display: none !important;
            }
        }

        @media screen {
            body {
                background-color: #e9e9e9;
            }

            .print-container {
                margin-top: 2rem;
                margin-bottom: 2rem;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            }
        }
    </style>

</head>

<body>
    <?php $this->beginBody() ?>

    <div class="print-container">

        <div class="d-flex justify-content-end mb-3 print-button-container">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="ri-printer-line me-1"></i> Cetak Halaman
            </button>
        </div>

        <div class="header-bar"></div>
        <h3 class="print-title">Lembar Kendali</h3>

        <?php // --- Seksi Info Pemohon (Layout 2 Kolom) --- 
        ?>
        <div class="info-section">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-4 info-label">Nomor Pendaftaran</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode($model['nomor_daftar'] ?? '-') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4 info-label">Nama Izin</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode($model['nama_izin'] ?? '-') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4 info-label">Nama Pemohon</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode($model['nama_pemohon'] ?? '-') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4 info-label">Alamat Pemohon</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode($model['alamat'] ?? '-') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4 info-label">Nama Usaha</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode($model['nama_usaha'] ?? '-') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4 info-label">Lokasi / Usaha Bangunan</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode($model['lokasi_usaha'] ?? '-') ?></div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="row">
                        <div class="col-4 info-label">Tanggal</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode(Yii::$app->formatter->asDate($model['tanggal_daftar'] ?? null, 'php:d M Y')) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4 info-label">Nama Permohonan</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode($model['jenis_permohonan'] ?? '-') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4 info-label">Nomor Identitas</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode(explode(' / ', $model['no_ktp_npwp'] ?? '-')[0]) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4 info-label">Telepon</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode($model['telepon'] ?? '-') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4 info-label">Kecamatan</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode($model['kecamatan'] ?? '-') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4 info-label">Kelurahan</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode($model['kelurahan'] ?? '-') ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php // --- Akhir Seksi Info Pemohon --- 
        ?>


        <?php // --- Tabel Log (TANPA .table-responsive) --- 
        ?>
        <table class="log-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Petugas dan Kegiatan</th>
                    <th>Nama Pengguna</th>
                    <th>Waktu (Hari)</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Paraf</th>
                    <th>Catatan / Hasil Penelitian</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($lembarKendaliData)): ?>
                    <tr>
                        <td colspan="8" class="text-center" style="font-style: italic; color: #777;">Data Lembar Kendali tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($lembarKendaliData as $item): ?>
                    <tr>
                        <td class="text-center"><?= Html::encode($item['no'] ?? '-') ?></td>
                        <td><?= Html::encode($item['petugas_kegiatan'] ?? '-') ?></td>
                        <td><?= Html::encode($item['nama_pengguna'] ?? '-') ?></td>
                        <td class="text-center"><?= Html::encode($item['waktu_hari'] ?? '0') ?></td>
                        <td class="text-center text-nowrap"><?= Html::encode($item['tanggal_mulai'] ?? '-') ?></td>
                        <td class="text-center text-nowrap"><?= Html::encode($item['tanggal_selesai'] ?? '-') ?></td>
                        <td class="text-center"><?= Html::encode($item['paraf'] ?? '-') ?></td>
                        <td><?= Html::encode($item['catatan'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php // --- Akhir Tabel Log --- 
        ?>

    </div>

    <?php
    // Script untuk memicu dialog cetak secara otomatis
    $this->registerJs(
        "window.onload = function() { window.print(); };",
        \yii\web\View::POS_READY
    );
    ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>