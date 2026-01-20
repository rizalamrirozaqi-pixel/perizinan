<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var array $model Data Pendaftaran (read-only)
 * @var array $bapDefaults Data default/existing untuk form BAP
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Edit Berita Acara - ' . ($model['nomor_daftar'] ?? 'N/A');
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => 'Berita Acara Pemeriksaan', 'url' => ['index', 'search' => $model['nomor_daftar'] ?? null]];
// $this->params['breadcrumbs'][] = 'Edit';
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0">Edit Berita Acara Pemeriksaan</h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Back Office</span></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="<?= Url::to(['index', 'search' => $model['nomor_daftar'] ?? null]) ?>" class="text-decoration-none"><span class="text-secondary fw-medium hover">Berita Acara Pemeriksaan</span></a></li>
                <!-- <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Edit</span></li> -->
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Detail Pendaftaran (Read Only)</h5>
            <div class="row gx-5">
                <div class="col-md-6">
                    <dl class="row mb-0 definition-list-styled">
                        <dt class="col-sm-5">Nomor Pendaftaran</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['nomor_daftar'] ?? '-') ?></dd>
                        <dt class="col-sm-5">Jenis Izin</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['nama_izin'] ?? '-') ?></dd>
                        <dt class="col-sm-5">Jenis Permohonan</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['jenis_permohonan'] ?? '-') ?></dd>
                        <dt class="col-sm-5">Nama Pemohon</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['nama_pemohon'] ?? '-') ?></dd>
                        <dt class="col-sm-5">Nama Usaha</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['nama_usaha'] ?? '-') ?></dd>
                        <dt class="col-sm-5">Nomor KTP/NPWP</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['no_ktp_npwp'] ?? '-') ?></dd>
                        <dt class="col-sm-5">Alamat</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['alamat'] ?? '-') ?></dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row mb-0 definition-list-styled">
                        <dt class="col-sm-5">Nomor Telepon</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['telepon'] ?? '-') ?></dd>
                        <dt class="col-sm-5">Lokasi Usaha / Bangunan</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['lokasi_usaha'] ?? '-') ?></dd>
                        <dt class="col-sm-5">Kecamatan</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['kecamatan'] ?? '-') ?></dd>
                        <dt class="col-sm-5">Kelurahan</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['kelurahan'] ?? '-') ?></dd>
                        <dt class="col-sm-5">Keterangan</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['keterangan'] ?? '-') ?></dd>
                        <dt class="col-sm-5">Multi Daftar dengan</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> [Rekomendasi Izin Reklame]</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>


    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Edit Berita Acara</h5>

            <?= Html::beginForm(['update', 'id' => $model['id']], 'post', [
                'id' => 'form-bap-update',
                'class' => 'needs-validation',
                'novalidate' => true
            ]) ?>

            <div class="row g-3">
                <div class="col-md-4">
                    <?= Html::label('Nomor BAP', 'nomor_bap', ['class' => 'form-label']) ?>
                    <?= Html::textInput('nomor_bap', $bapDefaults['nomor_bap'], [
                        'class' => 'form-control',
                        'required' => true,
                    ]) ?>
                    <div class="invalid-feedback">Nomor BAP tidak boleh kosong.</div>
                </div>
                <div class="col-md-4">
                    <?= Html::label('Tanggal BAP', 'tanggal_bap', ['class' => 'form-label']) ?>
                    <?= Html::textInput('tanggal_bap', $bapDefaults['tanggal_bap'], [
                        'class' => 'form-control',
                        'type' => 'date',
                        'required' => true,
                    ]) ?>
                    <div class="invalid-feedback">Tanggal BAP tidak boleh kosong.</div>
                    <small class="form-text text-muted">(Format: dd-mm-yyyy)</small>
                </div>
                <div class="col-md-4">
                    <?= Html::label('Tanggal Pemeriksaan Lapangan', 'tanggal_lapangan', ['class' => 'form-label']) ?>
                    <?= Html::textInput('tanggal_lapangan', $bapDefaults['tanggal_lapangan'], [
                        'class' => 'form-control',
                        'type' => 'date',
                        'required' => true,
                    ]) ?>
                    <div class="invalid-feedback">Tanggal Lapangan tidak boleh kosong.</div>
                    <small class="form-text text-muted">(Format: dd-mm-yyyy)</small>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <?= Html::a('Kembali', ['index', 'search' => $model['nomor_daftar'] ?? null], ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>

</div>

<style>
    /* Style untuk Definition List */
    .definition-list-styled dt {
        font-weight: 500;
        color: #495057;
        white-space: nowrap;
        padding-bottom: 0.8rem;
        vertical-align: top;
        padding-right: 0;
        display: flex;
        align-items: flex-start;
    }

    .definition-list-styled dd {
        padding-bottom: 0.8rem;
        word-break: break-word;
        vertical-align: top;
        color: #495057;
        padding-left: 0;
        display: flex;
        align-items: flex-start;
    }

    .definition-list-styled .definition-divider {
        display: inline-block;
        width: 1rem;
        text-align: right;
        margin-right: 0.5rem;
        font-weight: 500;
        vertical-align: top;
        padding-top: 0.05rem;
    }

    .card-body {
        font-size: 0.875rem;
    }

    .form-label {
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #5e5873;
    }
</style>