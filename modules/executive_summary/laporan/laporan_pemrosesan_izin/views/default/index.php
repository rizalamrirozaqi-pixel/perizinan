<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

// Judul Halaman
$this->title = 'Laporan Pemrosesan Izin';
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

            <!-- <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Filter Data</h5>

            <div class="mb-4">
                <?= Html::beginForm(['index'], 'get', [
                    'class' => 'row g-3 align-items-end'
                ]) ?>

                <div class="row mb-3 mt-3">
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
                    <div class="col-md-12 d-flex align-items-end justify-content-end">
                        <label class="form-label d-block small mb-1">&nbsp;</label>
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            Cari
                        </button>
                    </div>
                </div>

                <?= Html::endForm() ?>
            </div> -->

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">

                        <thead class="table-light text-center text-uppercase align-middle">
                            <tr>
                                <th rowspan="2" width="5%" class="align-middle">No</th>
                                <th rowspan="2" class="align-middle">Blok Sistem</th>
                                <th colspan="2" class="border-bottom-0">Jumlah Berkas</th>
                            </tr>
                            <tr>
                                <th width="20%">Berkas Diterima</th>
                                <th width="20%">Berkas Diproses</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $totalDiterima = 0;
                            $totalDiproses = 0;
                            ?>
                            <?php if ($dataProvider->totalCount > 0): ?>
                                <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                    <?php
                                    $totalDiterima += $model['diterima'];
                                    $totalDiproses += $model['diproses'];
                                    ?>
                                    <tr>
                                        <td class="text-center text-secondary">
                                            <?= $index + 1 ?>
                                        </td>

                                        <td class="">
                                            <?= Html::encode($model['nama']) ?>
                                        </td>

                                        <td class="text-center">
                                            <?= number_format($model['diterima'], 0, ',', '.') ?>
                                        </td>

                                        <td class="text-center">
                                            <?= number_format($model['diproses'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <tr class="fw-bold">
                                    <td colspan="2" class="text-end text-uppercase">Total</td>
                                    <td class="text-center text-primary"><?= number_format($totalDiterima, 0, ',', '.') ?></td>
                                    <td class="text-center text-primary"><?= number_format($totalDiproses, 0, ',', '.') ?></td>
                                </tr>

                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="text-muted small">
                        Menampilkan <?= $dataProvider->getCount() ?> data
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>