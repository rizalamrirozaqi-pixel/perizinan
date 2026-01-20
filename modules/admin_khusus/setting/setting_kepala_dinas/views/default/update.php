<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Edit Kepala Dinas';
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
                <li class="breadcrumb-item text-secondary fw-medium">Setting</li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium"><?= Html::encode($this->title) ?></span>
                </li>
            </ol>
        </nav>
    </div>

    <!-- <div class="mb-0">
        <ul class="nav nav-tabs border-0" style="margin-bottom: -1px;">
            <li class="nav-item">
                <a class="nav-link active bg-primary text-white rounded-top-2 fw-medium px-4 py-2" href="#">
                    Setting Kepala Dinas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link bg-light text-secondary rounded-top-2 fw-medium px-4 py-2 mx-1 hover-primary" href="<?= Url::to(['/admin_khusus/setting/setting_sektor']) ?>">
                    Setting Sektor
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link bg-light text-secondary rounded-top-2 fw-medium px-4 py-2 hover-primary" href="<?= Url::to(['/admin_khusus/setting/setting_jenis_izin']) ?>">
                    Setting Jenis Izin
                </a>
            </li>
        </ul>
        <div class="bg-primary w-100" style="height: 4px; border-radius: 0 4px 4px 4px;"></div>
    </div> -->

    <div class="card bg-white border-0 rounded-bottom-3 rounded-end-3 mb-4 shadow-sm" style="margin-top: 0px; border-top-left-radius: 0 !important;">
        <div class="card-body p-4">

            <h5 class="card-title fw-bold mb-4 border-bottom pb-3">EDIT KEPALA DINAS</h5>

            <?= Html::beginForm(['update', 'id' => $model['id']], 'post', ['enctype' => 'multipart/form-data']) ?>

            <div class="row mb-3 align-items-center">
                <label class="col-sm-2 col-form-label fw-medium text-secondary">NIK</label>
                <div class="col-sm-1 text-center d-none d-sm-block text-secondary">:</div>
                <div class="col-sm-9">
                    <?= Html::textInput('nik', $model['nik'], ['class' => 'form-control text-dark', 'readonly' => true]) ?>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <label class="col-sm-2 col-form-label fw-medium text-secondary">NIP</label>
                <div class="col-sm-1 text-center d-none d-sm-block text-secondary">:</div>
                <div class="col-sm-9">
                    <?= Html::textInput('nip', $model['nip'], ['class' => 'form-control text-dark', 'readonly' => true]) ?>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <label class="col-sm-2 col-form-label fw-medium text-secondary">Nama</label>
                <div class="col-sm-1 text-center d-none d-sm-block text-secondary">:</div>
                <div class="col-sm-9">
                    <?= Html::textInput('nama', $model['nama'], ['class' => 'form-control text-dark', 'readonly' => true]) ?>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <label class="col-sm-2 col-form-label fw-medium text-secondary">Jabatan</label>
                <div class="col-sm-1 text-center d-none d-sm-block text-secondary">:</div>
                <div class="col-sm-9">
                    <?= Html::textInput('jabatan', $model['jabatan'], ['class' => 'form-control']) ?>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <label class="col-sm-2 col-form-label fw-medium text-secondary">Eselon</label>
                <div class="col-sm-1 text-center d-none d-sm-block text-secondary">:</div>
                <div class="col-sm-9">
                    <?= Html::textInput('eselon', $model['eselon'], ['class' => 'form-control']) ?>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <label class="col-sm-2 col-form-label fw-medium text-secondary">Ditampilkan</label>
                <div class="col-sm-1 text-center d-none d-sm-block text-secondary">:</div>
                <div class="col-sm-9">
                    <?= Html::dropDownList('ditampilkan', $model['ditampilkan'], ['Ya' => 'Ya', 'Tidak' => 'Tidak'], ['class' => 'form-select form-control']) ?>
                </div>
            </div>

            <div class="row mb-4 align-items-center">
                <label class="col-sm-2 col-form-label fw-medium text-secondary">Upload Logo TTE</label>
                <div class="col-sm-1 text-center d-none d-sm-block text-secondary">:</div>
                <div class="col-sm-9">
                    <div class="input-group">
                        <?= Html::fileInput('logo_tte', null, ['class' => 'form-control', 'id' => 'inputGroupFile02']) ?>
                    </div>
                    <?php if (!empty($model['file'])): ?>
                        <div class="mt-2">
                            <a href="#" class="d-inline-flex align-items-center text-primary text-decoration-none bg-primary-subtle px-3 py-1 rounded-pill small">
                                <i class="material-symbols-outlined fs-16 me-1">visibility</i> Lihat File Saat Ini
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-12"></div>
                <div class="col-sm-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-danger text-white py-2 d-flex align-items-center gap-2 shadow-sm me-3" onclick="window.location.href='<?= Url::to(['index']) ?>'">
                        <span>Batal</span>
                    </button>
                    <button type="submit" class="btn btn-primary py-2 d-flex align-items-center gap-2 shadow-sm">
                        <span>Simpan</span>
                    </button>
                </div>
            </div>

            <?= Html::endForm() ?>

        </div>
    </div>
</div>
