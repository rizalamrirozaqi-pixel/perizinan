<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var array $model Data pendaftaran
 * @var array $logData Data untuk tabel Log/Lembar Kendali
 */

use yii\helpers\Html;
use yii\helpers\Url;

// Memuat aset CSS Anda (Bootstrap, dll) agar halaman cetak tetap rapi
// Ganti 'app\assets\AppAsset' dengan AssetBundle yang Anda gunakan
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
            /* <= TAMBAHKAN INI */
            margin: 0.75rem;
            /* Opsional: Atur margin kertas */
        }

        /* Style untuk container utama */
        .print-container {
            width: 100%;
            max-width: 1400px;
            /* Lebar agar tabel tidak terlalu sempit */
            margin: 0 auto;
            padding: 1.5rem;
            background: #fff;
            font-family: Arial, sans-serif;
            /* Font standar untuk cetak */
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
            /* Font lebih kecil */
            margin-bottom: 1.5rem;
        }

        .info-section .row {
            margin-bottom: 0.15rem;
            /* Jarak antar baris info sangat rapat */
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
            /* Garis jadi satu */
            font-size: 0.75rem;
            /* Font sangat kecil untuk memuat banyak data */
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
            /* Data di sel mulai dari atas */
        }

        .log-table .text-center {
            text-align: center;
        }

        .log-table .text-nowrap {
            white-space: nowrap;
        }


        /* Style untuk media print */
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

        /* Style untuk tombol di layar (sebelum cetak) */
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
                    <div class="row">
                        <div class="col-4 info-label">Verifikator</div>
                        <div class="col-1 info-divider">:</div>
                        <div class="col-7 info-value"><?= Html::encode($model['verifikator'] ?? '-') ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php // --- Akhir Seksi Info Pemohon --- 
        ?>


        <?php // --- Tabel Log (SUDAH DIHAPUS .table-responsive) --- 
        ?>
        <table class="log-table">
            <thead>
                <tr>
                    <th rowspan="2">Pos</th>
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
                    <th rowspan="2">Penilaian<br>Kepatuhan</th>
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
                        <td colspan="18" class="text-center" style="font-style: italic; color: #777;">Data Log tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($logData as $item): ?>
                    <tr>
                        <td class="text-center"><?= Html::encode($item['pos'] ?? '-') ?></td>

                        <!-- Tanggal Mulai -->
                        <td class="text-center text-nowrap">
                            <?= !empty($item['tanggal_mulai_entry']) ? Html::encode(Yii::$app->formatter->asDate($item['tanggal_mulai_entry'], 'php:Y-m-d')) : '-' ?>
                        </td>
                        <td class="text-center text-nowrap">
                            <?= !empty($item['tanggal_mulai_system']) ? Html::encode(Yii::$app->formatter->asDatetime($item['tanggal_mulai_system'], 'php:Y-m-d H:i:s')) : '-' ?>
                        </td>

                        <td class="text-left"><?= Html::encode($item['dari'] ?? '-') ?></td>
                        <td class="text-left"><?= Html::encode($item['nama_pengguna'] ?? '-') ?></td>
                        <td class="text-left"><?= Html::encode($item['proses'] ?? '-') ?></td>

                        <!-- Tanggal Selesai -->
                        <td class="text-center text-nowrap">
                            <?= !empty($item['tanggal_selesai_entry']) ? Html::encode(Yii::$app->formatter->asDate($item['tanggal_selesai_entry'], 'php:Y-m-d')) : '-' ?>
                        </td>
                        <td class="text-center text-nowrap">
                            <?= !empty($item['tanggal_selesai_system']) ? Html::encode(Yii::$app->formatter->asDatetime($item['tanggal_selesai_system'], 'php:Y-m-d H:i:s')) : '-' ?>
                        </td>

                        <td class="text-left"><?= Html::encode($item['kirim_ke'] ?? '-') ?></td>

                        <!-- Berkas Tolak/Kirim -->
                        <td class="text-center text-nowrap">
                            <?= !empty($item['berkas_tolak_kirim_entry']) ? Html::encode(Yii::$app->formatter->asDate($item['berkas_tolak_kirim_entry'], 'php:Y-m-d')) : '-' ?>
                        </td>
                        <td class="text-center text-nowrap">
                            <?= !empty($item['berkas_tolak_kirim_system']) ? Html::encode(Yii::$app->formatter->asDatetime($item['berkas_tolak_kirim_system'], 'php:Y-m-d H:i:s')) : '-' ?>
                        </td>

                        <td class="text-left"><?= Html::encode($item['catatan'] ?? '-') ?></td>
                        <td class="text-left"><?= Html::encode($item['status'] ?? '-') ?></td>

                        <!-- Tanggal Terima/Tolak -->
                        <td class="text-center text-nowrap">
                            <?= !empty($item['tanggal_terima_tolak']) ? Html::encode(Yii::$app->formatter->asDate($item['tanggal_terima_tolak'], 'php:Y-m-d')) : '-' ?>
                        </td>

                        <td class="text-nowrap"><?= Html::encode($item['penilaian_kepatuhan'] ?? '-') ?></td>

                        <!-- Lambat (default 0) -->
                        <td class="text-center"><?= Html::encode($item['lambat_hari'] ?? '0') ?></td>
                        <td class="text-center"><?= Html::encode($item['lambat_jam'] ?? '0') ?></td>
                        <td class="text-center"><?= Html::encode($item['lambat_menit'] ?? '0') ?></td>
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