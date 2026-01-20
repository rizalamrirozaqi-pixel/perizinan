<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var array $model Data Verifikasi
 * @var array|null $pendaftaranModel Data Pendaftaran terkait
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Upload File Rekomendasi - ' . ($pendaftaranModel['nomor_daftar'] ?? $model['id']);
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => 'Verifikasi Izin', 'url' => ['index']];
// $this->params['breadcrumbs'][] = 'Upload Rekomendasi';
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0">Upload File Rekomendasi</h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Back Office</span></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="<?= Url::to(['index']) ?>" class="text-decoration-none"><span class="text-secondary fw-medium hover">Verifikasi Izin</span></a></li>
                <!-- <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Upload Rekomendasi</span></li> -->
            </ol>
        </nav>
    </div>

    <?php if ($pendaftaranModel): ?>
        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Informasi Pendaftaran</h5>
                <dl class="row mb-0 definition-list-styled">
                    <dt class="col-sm-3">Nomor Pendaftaran</dt>
                    <dd class="col-sm-9"><span class="definition-divider">:</span> <?= Html::encode($pendaftaranModel['nomor_daftar'] ?? '-') ?></dd>
                    <dt class="col-sm-3">Nama Pemohon</dt>
                    <dd class="col-sm-9"><span class="definition-divider">:</span> <?= Html::encode($pendaftaranModel['nama_pemohon'] ?? '-') ?></dd>
                    <dt class="col-sm-3">Jenis Izin</dt>
                    <dd class="col-sm-9"><span class="definition-divider">:</span> <?= Html::encode($pendaftaranModel['nama_izin'] ?? '-') ?></dd>
                    <dt class="col-sm-3">Lokasi Usaha</dt>
                    <dd class="col-sm-9"><span class="definition-divider">:</span> <?= Html::encode($pendaftaranModel['lokasi_usaha'] ?? '-') ?></dd>
                </dl>
            </div>
        </div>
    <?php endif; ?>

    <!-- Card Upload Form -->
    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Upload File</h5>

            <?php if ($model['upload_rekom_status']): ?>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="material-symbols-outlined me-2">check_circle</i>
                    <div>
                        File rekomendasi (<span class="fw-bold"><?= Html::encode($model['upload_rekom_filename'] ?? 'Nama File Tidak Tersimpan') ?></span>) sudah pernah diupload. Mengupload file baru akan menggantikan file lama.
                    </div>
                </div>
            <?php endif; ?>

            <?= Html::beginForm(['upload-rekom', 'id' => $model['id']], 'post', [
                'enctype' => 'multipart/form-data', // Penting untuk file upload
                'class' => 'needs-validation', // Aktifkan validasi browser
                'novalidate' => true
            ]) ?>

            <div class="mb-3">
                <label for="rekomFile" class="form-label">Pilih File Rekomendasi (PDF, DOC, DOCX, JPG, PNG - Maks 2MB)</label>
                <?= Html::fileInput('rekomFile', null, [
                    'class' => 'form-control',
                    'id' => 'rekomFile',
                    'required' => true, // Wajib pilih file
                    'accept' => '.pdf,.doc,.docx,.jpg,.jpeg,.png'
                ]) ?>
                <div class="invalid-feedback">Silakan pilih file rekomendasi.</div>
                <!-- Menampilkan error upload dari controller jika ada -->
                <?php if (Yii::$app->session->hasFlash('error-upload')): ?>
                    <div class="text-danger mt-2" style="font-size: 0.875em;"><?= Yii::$app->session->getFlash('error-upload') ?></div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton('Upload File', ['class' => 'btn btn-primary']) ?>
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
</style>

<?php
// (Opsional) JavaScript untuk validasi client-side form upload jika 'required' saja tidak cukup
// $jsValidation = <<<JS ... JS;
// $this->registerJs($jsValidation);
?>