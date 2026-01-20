<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var bool $isSearch
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var array $models
 * @var yii\data\Pagination $pagination
 * @var string $tahun
 * @var string $tanggal_cetak
 * @var array $tahunItems
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;

$this->title = 'Laporan Penyerahan SK';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Back Office</span></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium"><?= Html::encode($this->title) ?></span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <?= Html::beginForm(['index'], 'get', [
                'class' => 'row g-3 align-items-end'
            ]) ?>

            <div class="col-md-6">
                <?= Html::label('Tahun Anggaran (Berdasarkan Tgl Diserahkan)', 'tahun', ['class' => 'form-label']) ?>
                <?= Html::dropDownList('tahun', $tahun, $tahunItems, [
                    'class' => 'form-select form-control', 
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= Html::label('Tanggal Cetak (Hari ini)', 'tanggal_cetak', ['class' => 'form-label']) ?>
                <?= Html::textInput('tanggal_cetak', $tanggal_cetak, [
                    'class' => 'form-control',
                    'type' => 'date',
                    'required' => true
                ]) ?>
            </div>

            <div class="col-12 d-flex align-items-center gap-2 mt-3">
                <?= Html::submitButton('Tampilkan', [
                    'class' => 'btn btn-outline-primary py-2 px-2 fw-medium rounded-3 d-flex align-items-center justify-content-center hover-bg hover-white',
                    'name' => 'submit_btn',
                    'value' => 'cari'
                ]) ?>

                <?= Html::a('Versi Cetak', [
                    'cetak', // Arahkan ke actionCetak
                    'tahun' => $tahun,
                    'tanggal_cetak' => $tanggal_cetak,
                    // 'status_pendaftaran' => $status_pendaftaran ?? null,
                ], [
                    'class' => 'btn btn-outline-info py-2 px-2 px-sm-4 fw-medium rounded-3 hover-bg-info d-flex align-items-center',
                    'onmouseover' => "this.style.color='#fff';",
                    'onmouseout' => "this.style.color='';",
                    'target' => '_blank', // Buka di tab baru
                    'style' => $isSearch ? '' : 'display:none;' // Sembunyikan jika belum search
                ]) ?>

                <?= Html::submitButton('Versi Excel', [
                    'class' => 'btn btn-outline-success py-2 px-2 px-sm-4 fw-medium rounded-3 hover-bg-success d-flex align-items-center',
                    'onmouseover' => "this.style.color='#fff';",
                    'onmouseout' => "this.style.color='';",
                    'name' => 'submit_btn',
                    'value' => 'excel',
                    'style' => $isSearch ? '' : 'display:none;' // Sembunyikan jika belum search
                ]) ?>
            </div>

            <?= Html::endForm() ?>

        </div>
    </div>

    <?php if ($isSearch && Yii::$app->request->get('submit_btn') === 'cari'): ?>
        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm" id="laporan-hasil">
            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <h5 class="mb-1 fw-bold fs-18">DAFTAR PENYERAHAN SK</h5>
                    <h6 class="mb-0 fw-bold">TAHUN <?= Html::encode($tahun) ?></h6>
                </div>

                <div class="default-table-area all-products">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">No</th>
                                    <th class="text-nowrap">Nomor Pendaftaran</th>
                                    <th class="text-nowrap">Nama Pemohon</th>
                                    <th class="text-nowrap">Nama Usaha</th>
                                    <th class="text-nowrap">Jenis Izin</th>
                                    <th class="text-nowrap">Retribusi</th>
                                    <th class="text-nowrap">Nomor SK</th>
                                    <th class="text-nowrap">Tanggal SK</th>
                                    <th class="text-nowrap">Tanggal Habis Berlaku</th>
                                    <th class="text-nowrap">Tanggal Diserahkan</th>
                                    <th class="text-nowrap">Diterima Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($models)): ?>
                                    <tr>
                                        <td colspan="11" class="text-center text-muted fst-italic">Data tidak ditemukan untuk tahun <?= Html::encode($tahun) ?>.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($models as $index => $model): ?>
                                        <tr>
                                            <td class="text-center"><?= $index + 1 ?></td>
                                            <td><?= Html::encode($model['nomor_daftar'] ?? '-') ?></td>
                                            <td><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
                                            <td><?= Html::encode($model['nama_usaha'] ?? '-') ?></td>
                                            <td><?= Html::encode($model['nama_izin'] ?? '-') ?></td>
                                            <td class="text-end"><?= 'Rp ' . Yii::$app->formatter->asDecimal($model['retribusi'] ?? 0, 0) ?></td>
                                            <td><?= Html::encode($model['nomor_sk'] ?? '-') ?></td>
                                            <td class="text-center text-nowrap"><?= !empty($model['tanggal_sk']) ? Yii::$app->formatter->asDate($model['tanggal_sk'], 'php:d M Y') : '-' ?></td>
                                            <td class="text-center text-nowrap"><?= !empty($model['tanggal_habis_berlaku']) ? Yii::$app->formatter->asDate($model['tanggal_habis_berlaku'], 'php:d M Y') : '-' ?></td>
                                            <td class="text-center text-nowrap"><?= !empty($model['tanggal_diserahkan']) ? Yii::$app->formatter->asDate($model['tanggal_diserahkan'], 'php:d M Y') : '-' ?></td>
                                            <td><?= Html::encode($model['diterima_oleh'] ?? '-') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>

</div>
