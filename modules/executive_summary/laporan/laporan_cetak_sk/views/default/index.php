<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Laporan Cetak SK';
?>

<div class="main-content-container overflow-hidden">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="#" class="d-flex align-items-center text-decoration-none"><i class="material-symbols-outlined fs-18 text-primary me-1">home</i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active"><span class="fw-medium">Laporan</span></li>
                <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Filter Data</h5>

            <div class="mb-4">
                <?= Html::beginForm(['index'], 'get', ['class' => 'row g-3 align-items-end']) ?>

                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label small mb-1">Jenis Izin</label>
                        <?= Html::dropDownList('jenis_izin', $params['jenis_izin'] ?? null, $listJenisIzin, ['class' => 'form-select form-select-sm  form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small mb-1">Jenis Permohonan</label>
                        <?= Html::dropDownList('jenis_permohonan', $params['jenis_permohonan'] ?? null, $listJenisPermohonan, ['class' => 'form-select form-select-sm form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label small mb-1">Dari Tanggal</label>
                        <?= Html::input('date', 'dari_tanggal', $params['dari_tanggal'] ?? date('Y-m-01'), ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small mb-1">Sampai Tanggal</label>
                        <?= Html::input('date', 'sampai_tanggal', $params['sampai_tanggal'] ?? date('Y-m-d'), ['class' => 'form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label small mb-1">Status Pendaftaran</label>
                        <?= Html::dropDownList('status_pendaftaran', $params['status_pendaftaran'] ?? 'OFFLINE', ['OFFLINE' => 'OFFLINE', 'ONLINE' => 'ONLINE'], ['class' => 'form-select form-select-sm form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12 d-flex align-items-end justify-content-end gap-2">

                        <button type="submit"
                            formaction="<?= Url::to(['cetak-html']) ?>"
                            formtarget="_blank"
                            class="btn btn-outline-primary px-3 py-2 d-flex align-items-center gap-2 hover-white">
                            <i class="material-symbols-outlined fs-18">table_view</i> Cari (Cetak HTML)
                        </button>

                        <button type="submit"
                            formaction="<?= Url::to(['export-excel']) ?>"
                            formtarget="_self"
                            class="btn btn-outline-success px-3 py-2 d-flex align-items-center gap-2 hover-white">
                            <i class="material-symbols-outlined fs-18">download</i> Cari (Cetak EXCEL)
                        </button>

                    </div>
                </div>

                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>