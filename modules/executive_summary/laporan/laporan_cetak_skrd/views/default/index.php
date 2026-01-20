<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;

// Judul Halaman
$this->title = 'Laporan Cetak SKRD';

// Breadcrumb logic manual sesuai template
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="<?= Url::to(['/executive_summary/dashboard/default/index']) ?>" class="d-flex align-items-center text-decoration-none">
                        <i class="material-symbols-outlined fs-18 text-primary me-1">home</i>
                        <span class="text-secondary fw-medium hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Laporan</span></li>
                <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Filter Data</h5>

            <div class="mb-4">
                <?= Html::beginForm(['index'], 'get', [
                    'class' => 'row g-3 align-items-end'
                ]) ?>

                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium text-secondary small mb-1">Jenis Izin</label>
                        <?= Html::dropDownList('jenis_izin', $params['jenis_izin'] ?? null, $listJenisIzin, [
                            'class' => 'form-select form-select-sm form-control form-control-sm',
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium text-secondary small mb-1">Jenis Permohonan</label>
                        <?= Html::dropDownList('jenis_permohonan', $params['jenis_permohonan'] ?? null, $listJenisPermohonan, [
                            'class' => 'form-select form-select-sm form-control form-control-sm',
                        ]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium text-secondary small mb-1">Dari Tanggal</label>
                        <?= Html::input('date', 'dari_tanggal', $params['dari_tanggal'] ?? date('Y-m-01'), [
                            'class' => 'form-control form-control-sm'
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium text-secondary small mb-1">Sampai Tanggal</label>
                        <?= Html::input('date', 'sampai_tanggal', $params['sampai_tanggal'] ?? date('Y-m-d'), [
                            'class' => 'form-control form-control-sm'
                        ]) ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-medium text-secondary small mb-1">Status</label>
                        <?= Html::dropDownList('status_pendaftaran', $params['status_pendaftaran'] ?? 'OFFLINE', ['' => 'Semua', 'OFFLINE' => 'OFFLINE', 'ONLINE' => 'ONLINE'], [
                            'class' => 'form-select form-select-sm form-control form-control-sm',
                        ]) ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12 d-flex align-items-end justify-content-end">
                        <label class="form-label d-block small mb-1">&nbsp;</label>
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            Cari
                        </button>
                    </div>
                </div>



                <?= Html::endForm() ?>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle" style="font-size: 0.9rem;">
                        <thead class="table-light text-center text-uppercase align-middle">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Nama Pemohon</th>
                                <th width="15%">Nama Usaha</th>
                                <th width="15%">Lokasi Izin</th>
                                <th width="10%">Jenis Izin</th>
                                <th width="10%">No. SKRD</th>
                                <th width="10%">Tgl SKRD</th>
                                <th width="10%">Total Retribusi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($dataProvider->totalCount > 0): ?>
                                <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                    <tr>
                                        <td class="text-center text-secondary">
                                            <?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?>
                                        </td>

                                        <td class="text-primary fw-medium">
                                            <?= Html::encode($model['nama_pemohon']) ?>
                                        </td>

                                        <td>
                                            <?= Html::encode($model['nama_usaha']) ?>
                                        </td>

                                        <td class="text-secondary small">
                                            <?= Html::encode($model['lokasi_izin']) ?>
                                        </td>

                                        <td class="text-center">
                                            <?= Html::encode($model['jenis_izin']) ?> <br>
                                            <span class="small text-muted"><?= Html::encode($model['jenis_permohonan']) ?></span>
                                        </td>

                                        <td class="text-center">
                                            <?= Html::encode($model['nomor_skrd'] ?: '-') ?>
                                        </td>

                                        <td class="text-center">
                                            <?= $model['tanggal_skrd'] ? date('d-m-Y', strtotime($model['tanggal_skrd'])) : '-' ?>
                                        </td>

                                        <td class="text-end fw-bold text-dark pe-3">
                                            <?= number_format($model['total_retribusi'] ?? 0, 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="text-muted small">
                        Menampilkan <?= $dataProvider->getCount() ?> dari <?= $dataProvider->getTotalCount() ?> data
                    </span>
                    <?= LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                        'options' => ['class' => 'pagination pagination-sm mb-0'],
                        'linkContainerOptions' => ['class' => 'page-item'],
                        'linkOptions' => ['class' => 'page-link'],
                        'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                        // Icon chevron manual jika library icon beda, sesuaikan
                        'prevPageLabel' => '&laquo;',
                        'nextPageLabel' => '&raquo;',
                    ]) ?>
                </div>
            </div>

        </div>
    </div>
</div>