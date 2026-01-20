<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var array $model Data pendaftaran yang akan divalidasi
 * @var string $previewUrl URL ke dokumen preview (BARU: Anda harus mengirim ini dari controller)
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Validasi Draft SK - ' . ($model['nomor_daftar'] ?? 'N/A');
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => 'Verifikasi Draft SK', 'url' => ['index']];
?>

<div class="main-content-container overflow-hidden">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0">Info Berkas Izin</h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium">Back Office</span>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= Url::to(['index']) ?>" class="text-decoration-none">
                        <span class="text-secondary fw-medium hover">Verifikasi Draft SK</span>
                    </a>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <?= Html::beginForm(['do-validasi', 'id' => $model['id']], 'post', ['id' => 'form-validasi']) ?>

            <div class="row gx-5">
                <div class="col-md-6">
                    <dl class="row mb-0 definition-list-styled">
                        <dt class="col-sm-5">Nomor Pendaftaran</dt>
                        <dd class="col-sm-7">
                            <span class="definition-divider">:</span>
                            <td class="text-secondary">
                                <?= Html::a(Html::encode($model['nomor_daftar']), ['view', 'id' => $model['id']], ['class' => 'text-primary text-decoration-none', 'target' => '_blank']) ?>
                            </td>
                        </dd>

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

                        <dt class="col-sm-5">Lokasi Usaha / Bangunan</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['lokasi_usaha'] ?? '-') ?></dd>

                        <dt class="col-sm-5">Kecamatan</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['kecamatan'] ?? '-') ?></dd>

                        <dt class="col-sm-5">Kelurahan</dt>
                        <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['kelurahan'] ?? '-') ?></dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <h5 class="mb-3">Preview Draft SK</h5>

                    <div class="preview-container border rounded-3" style="height: 600px; overflow: hidden;">
                        <iframe src="<?= Yii::getAlias('@web') ?>/docs/pdf/preview_draft_sk.pdf" width="100%" height="600px" title="Tampilan PDF">
                        Browser Anda tidak mendukung iframe.
                        </iframe>
                    </div>
                </div>
            </div>


            <div class="row d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <div class="col-12 d-flex flex-column">
                    <div class="row">
                        <dl>
                            <dt class="col-sm-5 align-self-start pt-1">Catatan :</dt>
                            <dd><?= Html::textarea('catatan_revisi', '', [
                                    'class' => 'form-control form-control-sm d-inline-block',
                                    'rows' => 3,
                                    'style' => 'margin-left: 0.4rem; vertical-align: top; width: calc(100% - 1rem);',
                                    'placeholder' => 'Isikan alasan revisi/penolakan...',
                                    'id' => 'catatan-revisi-input'
                                ]) ?>
                            </dd>
                        </dl>
                    </div>
                    <div class="d-flex flex-row gap-2 justify-content-end">
                        <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-dark'])
                        ?>
                        <?= Html::button('Revisi', [
                            'class' => 'btn btn-warning btn-revisi-data text-white',
                            'data-url' => Url::to(['revisi', 'id' => $model['id']])
                        ]) ?>

                        <?= Html::submitButton('Validasi', [
                            'class' => 'btn btn-primary ',
                            'name' => 'action', 
                            'value' => 'validasi' 
                        ]) ?>
                    </div>
                </div>
            </div>

            <?= Html::endForm() ?>

        </div>
    </div>
</div>

<style>
    /* Style untuk Definition List Baru */
    .definition-list-styled dt {
        font-weight: 500;
        color: #495057;
        white-space: nowrap;
        padding-bottom: 0.9rem;
        vertical-align: top;
        padding-right: 0;
        display: flex;
        align-items: flex-start;
    }

    .definition-list-styled dd {
        padding-bottom: 0.9rem;
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

    .definition-list-styled dd:has(input.form-control),
    .definition-list-styled dd:has(textarea.form-control) {
        align-items: flex-start;
    }

    .definition-list-styled dd:has(input.form-control) .definition-divider,
    .definition-list-styled dd:has(textarea.form-control) .definition-divider {
        padding-top: 0.15rem;
    }

    .definition-list-styled dd input.form-control,
    .definition-list-styled dd textarea.form-control {
        margin-left: 0;
        width: calc(100% - 1.5rem);
        display: inline-block;
        vertical-align: top;
    }

    .definition-list-styled dd textarea.form-control {
        min-height: calc(1.5em + 0.5rem + 2px);
    }

    /* Ukuran Font */
    .card-body,
    .definition-list-styled dt,
    .definition-list-styled dd {
        font-size: 0.875rem;
    }
</style>

<?php
// JavaScript untuk Tooltip dan Konfirmasi Revisi (Tetap Sama)
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;
$revisiConfirmText = "ANDA YAKIN MENOLAK INBOX INI?";
$revisiConfirmTitle = "Konfirmasi Revisi";

$js = <<<JS
// Handler untuk tombol REVISI
$('.btn-revisi-data').on('click', function(event) {
    event.preventDefault();
    var revisiUrl = $(this).data('url');
    var catatanRevisi = $('#catatan-revisi-input').val();

    Swal.fire({
        title: '{$revisiConfirmTitle}',
        text: '{$revisiConfirmText}',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = revisiUrl;

            var csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '{$csrfParam}';
            csrfInput.value = '{$csrfToken}';
            form.appendChild(csrfInput);

            var catatanInput = document.createElement('input');
            catatanInput.type = 'hidden';
            catatanInput.name = 'catatan_revisi'; // Sesuaikan jika perlu
            catatanInput.value = catatanRevisi;
            form.appendChild(catatanInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'validasi-revisi-handler');
?>