<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var array $modelPendaftaran Data Pendaftaran
 * @var array $modelPengambilan Data Pengambilan
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Pencabutan Izin';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => 'Pengambilan SK', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Back Office</span></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="<?= Url::to(['index']) ?>" class="text-decoration-none"><span class="text-secondary fw-medium hover">Pengambilan SK</span></a></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3">
                Pencabutan Izin sdr/i: <?= Html::encode($modelPendaftaran['nama_pemohon'] ?? 'N/A') ?>
            </h5>

            <?= Html::beginForm(['simpan-pencabutan', 'id' => $modelPengambilan['pengambilan_id']], 'post') ?>

            <div class="row mb-3">
                <div class="col">
                    <?= Html::label('Dicabut pada tanggal', 'tanggal_pencabutan', ['class' => 'form-label']) ?>
                    <?= Html::textInput('tanggal_pencabutan', date('Y-m-d'), ['class' => 'form-control form-control-sm', 'type' => 'date']) ?>
                    <small class="form-text text-muted">(Format: dd-mm-yyyy)</small>
                </div>
            </div>
            <div class="row ">
                <div class="col">
                    <?= Html::label('Keterangan', 'keterangan_pencabutan', ['class' => 'form-label']) ?>
                    <?= Html::textarea('keterangan_pencabutan', '', ['class' => 'form-control form-control-sm', 'rows' => 3, 'placeholder' => 'Alasan pencabutan...']) ?>
                </div>
            </div>

            <div class="d-flex justify-content-start gap-2 mt-3 pt-3 border-top">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Batal', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>
            <?= Html::endForm() ?>

        </div>
    </div>
</div>