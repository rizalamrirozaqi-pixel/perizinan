<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var array $model Data Pendaftaran
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Edit Data Pendaftaran - ' . ($model['nomor_daftar'] ?? 'N/A');
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => 'Cetak Draft SK', 'url' => ['index', 'search' => $model['nomor_daftar']]];
$this->params['breadcrumbs'][] = 'Edit Data Primer';
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0">Edit Data Pendaftaran</h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Back Office</span></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="<?= Url::to(['index', 'search' => $model['nomor_daftar']]) ?>" class="text-decoration-none"><span class="text-secondary fw-medium hover">Cetak Draft SK</span></a></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <!-- Form Edit Data Primer -->
            <?= Html::beginForm(['edit-data-primer', 'pendaftaran_id' => $model['id']], 'post', ['id' => 'form-edit-primer']) ?>

            <!-- Layout Definition List (RAPI) -->
            <dl class="row mb-0 definition-list-styled">

                <dt class="col-sm-3">Jenis Izin</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::dropDownList('nama_izin', $model['nama_izin'] ?? null, [$model['nama_izin'] => $model['nama_izin']], ['class' => 'form-select form-control']) ?>
                </dd>

                <dt class="col-sm-3">Jenis Permohonan</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::dropDownList('jenis_permohonan', $model['jenis_permohonan'] ?? null, [$model['jenis_permohonan'] => $model['jenis_permohonan']], ['class' => 'form-select form-control']) ?>
                </dd>

                <dt class="col-sm-3">Nama Pemohon</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::textInput('nama_pemohon', $model['nama_pemohon'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                </dd>

                <dt class="col-sm-3">Nama Usaha</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::textInput('nama_usaha', $model['nama_usaha'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                </dd>

                <dt class="col-sm-3">Bidang Usaha</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::textInput('bidang_usaha', $model['keterangan'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                </dd>

                <dt class="col-sm-3">No KTP</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::textInput('no_ktp', $model['no_ktp_npwp'] ? explode(' / ', $model['no_ktp_npwp'])[0] : null, ['class' => 'form-control form-control-sm']) ?>
                </dd>

                <dt class="col-sm-3">NPWP</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::textInput('npwp', $model['no_ktp_npwp'] ? (explode(' / ', $model['no_ktp_npwp'])[1] ?? null) : null, ['class' => 'form-control form-control-sm']) ?>
                </dd>

                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::textarea('alamat', $model['alamat'] ?? null, ['class' => 'form-control form-control-sm', 'rows' => 3]) ?>
                </dd>

                <dt class="col-sm-3">Nomor Telepon</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::textInput('telepon', $model['telepon'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                </dd>

                <dt class="col-sm-3">Lokasi / Usaha / Bangunan</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::textarea('lokasi_usaha', $model['lokasi_usaha'] ?? null, ['class' => 'form-control form-control-sm', 'rows' => 3]) ?>
                </dd>

                <dt class="col-sm-3">Kecamatan</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::dropDownList('kecamatan', $model['kecamatan'] ?? null, [$model['kecamatan'] => $model['kecamatan']], ['class' => 'form-select form-control']) ?>
                </dd>

                <dt class="col-sm-3">Kelurahan / Desa</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::dropDownList('kelurahan', $model['kelurahan'] ?? null, [$model['kelurahan'] => $model['kelurahan']], ['class' => 'form-select form-control']) ?>
                </dd>

                <dt class="col-sm-3">Keterangan</dt>
                <dd class="col-sm-9"><span class="definition-divider">:</span>
                    <?= Html::textInput('keterangan', $model['keterangan'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                </dd>

            </dl>

            <div class="d-flex justify-content-start gap-2 mt-3 pt-3 border-top">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Kembali', ['index', 'search' => $model['nomor_daftar']], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?= Html::endForm() ?>

        </div>
    </div>
</div>

<!-- CSS Tambahan -->
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
        align-items: center;
    }

    /* align-items: center */
    .definition-list-styled dd {
        padding-bottom: 0.8rem;
        word-break: break-word;
        vertical-align: top;
        color: #495057;
        padding-left: 0;
        display: flex;
        align-items: center;
    }

    /* align-items: center */
    .definition-list-styled dt.align-self-start,
    .definition-list-styled dd.align-self-start {
        align-items: flex-start !important;
        /* Khusus untuk textarea */
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

    .form-control-sm,
    .form-select-sm {
        font-size: 0.875rem;
    }
</style>