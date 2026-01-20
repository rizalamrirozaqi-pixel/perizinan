<?php

/**
 * @var yii\web\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var array $models
 * @var yii\data\Pagination $pagination
 * @var array $params (parameter dari URL)
 * @var string $namaBulan (e.g., 'SEPTEMBER')
 * @var string $tahun
 */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

AppAsset::register($this);


$this->title = 'Daftar Penerbitan Surat Izin';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Rekapitulasi Izin Terbit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// $jenisIzin = $params['jenis_izin'] ?? 'Semua Izin';
// $subJudul = "Bulan $namaBulan Tahun $tahun (Filter: Izin $jenisIzin)";
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
        <button type="button" class="btn btn-primary" onclick="window.print();">
            <i class="material-symbols-outlined fs-18 me-1" style="vertical-align: middle;">print</i>
            Cetak Laporan
        </button>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4" id="laporan-hasil">
        <div class="card-body p-4">

            <div class="text-center mb-4">
                <h5 class="mb-1 fw-bold">DAFTAR PENERBITAN SURAT IZIN</h5>
                <h6 class="mb-0 fw-bold">DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU KABUPATEN</h6>
                <h6 class="mb-0 fw-bold">BULAN <?= Html::encode($namaBulan) ?> TAHUN <?= Html::encode($tahun) ?></h6>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered">
                        <thead class="text-center align-middle">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Pemohon/Perusahaan</th>
                                <th>Alamat Pemohon/Lokasi</th>
                                <th>No Izin</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($models)): ?>
                                <tr>
                                    <td colspan="5" class="text-center fst-italic text-secondary">Data detail tidak ditemukan untuk filter ini.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($models as $index => $model): ?>
                                    <tr>
                                        <td class="text-center"><?= $pagination->page * $pagination->pageSize + $index + 1 ?></td>
                                        <td><?= Html::encode($model['pemohon_perusahaan']) ?></td>
                                        <td><?= Html::encode($model['alamat']) ?></td>
                                        <td><?= Html::encode($model['no_izin']) ?></td>
                                        <td><?= Html::encode($model['keterangan']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 mt-4">
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
</div>

<?php $this->endBody() ?>
</body>
</html>
    <?php $this->endPage() ?>