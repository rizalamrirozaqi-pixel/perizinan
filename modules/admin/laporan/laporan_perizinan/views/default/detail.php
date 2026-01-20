<?php

/**
 * @var yii\web\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var array $models
 * @var yii\data\Pagination $pagination
 * @var array $params (parameter dari URL)
 */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\LinkPager;

AppAsset::register($this);


$this->title = 'Laporan Detail Perizinan';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Laporan Bulanan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// --- (FIX) KONTEN JUDUL DIPERBARUI SESUAI PERMINTAAN ---
$jenisIzin = $params['jenis_izin'] ?? 'Semua Izin';
$status = $params['status'] ?? 'Semua Status';
$tahun = $params['tahun'] ?? '';
$bulan = $params['bulan'] ?? null;
$sd_bulan = $params['sd_bulan'] ?? null;

// Ambil daftar bulan dari controller
$bulanItems = (new \app\modules\admin\laporan\laporan_perizinan\controllers\DefaultController('laporan_perizinan', $this->context->module))->getBulanItems();

$judulPeriode = '';
if ($sd_bulan) {
    $namaBulan = $bulanItems[$sd_bulan] ?? '...';
    $judulPeriode = "S/D BULAN " . strtoupper($namaBulan) . " TAHUN $tahun";
} elseif ($bulan) {
    $namaBulan = $bulanItems[$bulan] ?? '...';
    $judulPeriode = "BULAN " . strtoupper($namaBulan) . " TAHUN $tahun";
} else {
    $judulPeriode = "TAHUN $tahun";
}

$subJudul = "Jenis: $jenisIzin | Status: $status | Tahun: $tahun";
if ($bulan) $subJudul .= " | Bulan: $bulan";
if ($sd_bulan) $subJudul .= " | s/d Bulan: $sd_bulan";
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>

</head>

<body class="bg-white">
<?php $this->beginBody() ?>
<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-end align-items-center flex-wrap gap-2 p-4">
        <!-- Tombol Cetak -->
        <button type="button" class="btn btn-primary" onclick="window.print();">
            <i class="material-symbols-outlined fs-18 me-1" style="vertical-align: middle;">print</i>
            Cetak Laporan
        </button>
        <!-- Akhir Tombol Cetak -->

    </div>

    <div class="card bg-white border-0 rounded-3 mb-4" id="laporan-hasil">
        <div class="card-body p-4">

            <!-- Judul Laporan menggunakan variabel baru -->
            <div class="text-center mb-4">
                <h5 class="mb-1 fw-bold">LAPORAN PENYELENGGARAAN PELAYANAN PERIZINAN</h5>
                <h6 class="mb-0 fw-bold">IZIN <?= Html::encode(strtoupper($status)) ?> <?= Html::encode($judulPeriode) ?></h6>
                <p><small class="text-muted">(Filter: <?= Html::encode($subJudul) ?>)</small></p>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" style="font-size: 0.9em;">
                        <thead class="text-center align-middle">
                            <tr>
                                <th>No</th>
                                <th>Nomor Daftar</th>
                                <th>Nama Pemohon</th>
                                <th>Alamat Pemohon</th>
                                <th>Nama Usaha</th>
                                <th>Lokasi Izin</th>
                                <th>Waktu Daftar</th>
                                <th>Tanggal Seharusnya Terbit</th>
                                <th>Tanggal Terbit</th>
                                <th>Status SOP</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($models)): ?>
                                <tr>
                                    <td colspan="11" class="text-center fst-italic text-secondary">Data detail tidak ditemukan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($models as $index => $model): ?>
                                    <tr>
                                        <td class="text-center"><?= $pagination->page * $pagination->pageSize + $index + 1 ?></td>
                                        <td class="text-center"><?= Html::encode($model['nomor_daftar']) ?></td>
                                        <td><?= Html::encode($model['nama_pemohon']) ?></td>
                                        <td><?= Html::encode($model['alamat_pemohon']) ?></td>
                                        <td><?= Html::encode($model['nama_usaha']) ?></td>
                                        <td><?= Html::encode($model['lokasi_izin']) ?></td>
                                        <td class="text-center"><?= Html::encode($model['waktu_daftar']) ?></td>
                                        <td class="text-center"><?= Html::encode($model['tgl_seharusnya']) ?></td>
                                        <td class="text-center"><?= Html::encode($model['tgl_terbit']) ?></td>
                                        <td class="text-center">
                                            <?php
                                            $badgeClass = $model['status_sop'] === 'Sesuai' ? 'bg-success' : 'bg-danger';
                                            echo Html::tag('span', $model['status_sop'], ['class' => "badge $badgeClass"]);
                                            ?>
                                        </td>
                                        <td class="text-center"><?= Html::encode($model['keterangan']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                    <span class="fs-13 fw-medium text-secondary">
                        Menampilkan <b><?= count($models) ?></b> dari <b><?= $pagination->totalCount ?></b> data
                    </span>
                    <div class="d-flex align-items-center">
                        <?= LinkPager::widget([
                            'pagination' => $pagination,
                            'options' => ['class' => 'pagination mb-0 justify-content-center'],
                            'linkContainerOptions' => ['class' => 'page-item'],
                            'linkOptions' => ['class' => 'page-link'],
                            'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                        ]) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>


<!-- STYLE UNTUK HALAMAN CETAK -->
<style>
    @media print {

        /* 1. Sembunyikan semua elemen yang tidak perlu dicetak */
        body .main-header,
        body .sidebar,
        .d-flex.justify-content-between,
        /* Sembunyikan header h3 dan tombol cetak */
        .breadcrumb,
        /* Sembunyikan breadcrumb (jika ada) */
        #laporan-hasil .showing-wrap,
        /* Sembunyikan pagination */
        #laporan-hasil .text-center p small {
            /* Sembunyikan sub-judul filter */
            display: none;
        }

        /* 2. Atur ulang layout utama agar penuh */
        body,
        .main-content-container {
            background-color: #ffffff !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* 3. Hapus style card (shadow, border, dll) */
        .card#laporan-hasil {
            box-shadow: none !important;
            border: none !important;
            background: none !important;
        }

        .card-body {
            padding: 0 !important;
        }

        /* 4. Atur font dan warna standar (hitam putih) */
        body,
        table,
        th,
        td,
        h5,
        h6 {
            font-family: 'Times New Roman', Times, serif;
            color: #000000 !important;
            font-size: 11pt;
            /* Ukuran font standar untuk cetak */
        }

        h5 {
            font-size: 14pt;
        }

        h6 {
            font-size: 12pt;
        }

        /* 5. Pastikan tabel terlihat rapi */
        .table-responsive {
            overflow: visible !important;
            /* Tampilkan semua kolom, jangan di-scroll */
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000000 !important;
            /* Border hitam solid */
        }

        .table {
            page-break-inside: auto;
            /* Izinkan tabel terpotong antar halaman jika perlu */
        }

        tr {
            page-break-inside: avoid;
            /* Hindari memotong 1 baris di tengah */
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
            /* (PENTING) Ulangi header tabel di setiap halaman */
        }

        /* 6. Ubah badge (bg-success/bg-danger) menjadi teks biasa */
        .badge {
            background-color: transparent !important;
            border: none !important;
            color: #000000 !important;
            font-weight: normal;
            font-size: 11pt;
            padding: 0;
        }
    }
</style>
</html>
    <?php $this->endPage() ?>