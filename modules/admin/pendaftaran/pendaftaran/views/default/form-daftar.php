<?php

/**
 *
 * @var yii\web\View $this The view object
 * @var array $jenisIzinItems Data untuk dropdown Jenis Izin
 * @var array $jenisPermohonanItems Data untuk dropdown Jenis Permohonan
 * @var array $kecamatanItems Data untuk dropdown Kecamatan
 * @var array $kelurahanItems Data untuk dropdown Kelurahan
 * @var array $modelData Data dari record (untuk update) atau [] (untuk create)
 * @var bool $isUpdate Status update (true/false)
 * @var array $defaultValues Nilai default untuk field form
 * @var array $syaratItems Daftar syarat-syarat
 */

use yii\helpers\Html;
use yii\helpers\Url;

// Logika $isUpdate, $this->title, $syaratItems, dan $defaultValues
// telah dipindah ke Controller untuk kebersihan kode.
// View ini sekarang menerima variabel-variabel tersebut dari action.

$this->title = $isUpdate ? 'Update Pendaftaran' : 'Formulir Pendaftaran';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Data Pendaftaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="main-content-container overflow-hidden">
    <div class="d-flex justify-content-between mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= Url::to(['index']) ?>" class="d-flex align-items-center text-decoration-none">
                        <span class="text-secondary fw-medium hover">Data Pendaftaran</span>
                    </a>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4">
        <div class="card-body p-4">

            <?= Html::beginForm($isUpdate ? ['update', 'id' => $modelData['id']] : ['create'], 'post', [
                'id' => 'pendaftaran-ui-form',
                'class' => 'needs-validation',
                'novalidate' => true
            ]) ?>

            <div class="col g-3">

                <div class="col-md-full">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <?= Html::label('Jenis Izin <span class="text-danger">*</span>', 'jenis_izin', ['class' => 'form-label']) ?>
                            <?= Html::dropDownList('jenis_izin', $defaultValues['jenis_izin'], $jenisIzinItems, [
                                'prompt' => '-- Pilih Jenis Izin --',
                                'class' => 'form-select form-control',
                                'id' => 'jenis_izin',
                                'required' => true,
                            ]) ?>
                            <div class="invalid-feedback">Jenis Izin wajib dipilih.</div>
                        </div>
                        <div class="col-sm-6">
                            <?= Html::label('Jenis Permohonan <span class="text-danger">*</span>', 'jenis_permohonan', ['class' => 'form-label']) ?>
                            <?= Html::dropDownList('jenis_permohonan', $defaultValues['jenis_permohonan'], $jenisPermohonanItems, [
                                'prompt' => '-- Pilih Jenis Permohonan --',
                                'class' => 'form-select form-control',
                                'id' => 'jenis_permohonan',
                                'required' => true,
                            ]) ?>
                            <div class="invalid-feedback">Jenis Permohonan wajib dipilih.</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <?= Html::label('Nama Usaha <span class="text-danger">*</span>', 'nama_usaha', ['class' => 'form-label']) ?>
                            <?= Html::textInput('nama_usaha', $defaultValues['nama_usaha'], [
                                'class' => 'form-control',
                                'id' => 'nama_usaha',
                                'required' => true,
                                'maxlength' => 255,
                            ]) ?>
                            <div class="invalid-feedback">Nama Usaha wajib diisi.</div>
                        </div>
                        <div class="col-sm-6">
                            <?= Html::label('Bidang Usaha <span class="text-danger">*</span>', 'bidang_usaha', ['class' => 'form-label']) ?>
                            <?= Html::textInput('bidang_usaha', $defaultValues['bidang_usaha'], [
                                'class' => 'form-control',
                                'id' => 'bidang_usaha',
                                'required' => true,
                                'maxlength' => 255,
                            ]) ?>
                            <div class="invalid-feedback">Bidang Usaha wajib diisi.</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <?= Html::label('Nama Pemohon <span class="text-danger">*</span>', 'nama_pemohon', ['class' => 'form-label']) ?>
                            <?= Html::textInput('nama_pemohon', $defaultValues['nama_pemohon'], [
                                'class' => 'form-control',
                                'id' => 'nama_pemohon',
                                'required' => true,
                                'maxlength' => 255,
                            ]) ?>
                            <div class="invalid-feedback">Nama Pemohon wajib diisi.</div>
                        </div>
                        <div class="col-sm-6">
                            <?= Html::label('Nomor KTP <span class="text-danger">*</span>', 'no_ktp', ['class' => 'form-label']) ?>
                            <?= Html::textInput('no_ktp', $defaultValues['no_ktp'], [
                                'class' => 'form-control',
                                'id' => 'no_ktp',
                                'pattern' => '\d{16}',
                                'title' => 'Masukkan 16 digit nomor KTP',
                                'required' => true,
                                'maxlength' => 16,
                                'inputmode' => 'numeric'
                            ]) ?>
                            <div class="invalid-feedback">Nomor KTP harus 16 digit angka.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= Html::label('Nomor NPWP', 'no_npwp', ['class' => 'form-label']) ?>
                        <?= Html::textInput('no_npwp', $defaultValues['no_npwp'], [
                            'class' => 'form-control',
                            'id' => 'no_npwp',
                            'pattern' => '\d{15,16}',
                            'title' => 'Masukkan 15 atau 16 digit nomor NPWP',
                            'maxlength' => 16,
                            'inputmode' => 'numeric'
                        ]) ?>
                        <div class="invalid-feedback">Nomor NPWP harus 15 atau 16 digit angka.</div>
                    </div>

                </div>

                <div class="col-md-full">

                    <div class="mb-3">
                        <?= Html::label('Alamat Pemohon <span class="text-danger">*</span>', 'alamat', ['class' => 'form-label']) ?>
                        <?= Html::textarea('alamat', $defaultValues['alamat'], [
                            'class' => 'form-control',
                            'rows' => 3,
                            'id' => 'alamat',
                            'required' => true,
                        ]) ?>
                        <div class="invalid-feedback">Alamat Pemohon wajib diisi.</div>
                    </div>

                    <div class="mb-3">
                        <?= Html::label('Nomor HP <span class="text-danger">*</span>', 'no_hp', ['class' => 'form-label']) ?>
                        <?= Html::textInput('no_hp', $defaultValues['no_hp'], [
                            'class' => 'form-control',
                            'id' => 'no_hp',
                            'type' => 'tel',
                            'required' => true,
                            'pattern' => '^\+?[0-9\s\-]{8,}$',
                            'title' => 'Masukkan nomor HP yang valid (minimal 8 digit)',
                            'maxlength' => 20,
                            'inputmode' => 'tel'
                        ]) ?>
                        <div class="invalid-feedback">Nomor HP wajib diisi (minimal 8 digit angka).</div>
                    </div>

                    <div class="mb-3">
                        <?= Html::label('Lokasi Usaha / Bangunan <span class="text-danger">*</span>', 'lokasi_usaha', ['class' => 'form-label']) ?>
                        <?= Html::textarea('lokasi_usaha', $defaultValues['lokasi_usaha'], [
                            'class' => 'form-control',
                            'rows' => 3,
                            'id' => 'lokasi_usaha',
                            'placeholder' => 'Isi jika berbeda dengan Alamat Pemohon',
                            'required' => true,
                        ]) ?>
                        <div class="invalid-feedback">Lokasi Usaha wajib diisi.</div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <?= Html::label('Kecamatan <span class="text-danger">*</span>', 'kecamatan', ['class' => 'form-label']) ?>
                            <?= Html::dropDownList('kecamatan', $defaultValues['kecamatan'], $kecamatanItems, [
                                'prompt' => '-- Pilih Kecamatan --',
                                'class' => 'form-select form-control',
                                'id' => 'kecamatan',
                                'required' => true,
                            ]) ?>
                            <div class="invalid-feedback">Kecamatan wajib dipilih.</div>
                        </div>
                        <div class="col-sm-6">
                            <?= Html::label('Kelurahan/Kalurahan <span class="text-danger">*</span>', 'kelurahan', ['class' => 'form-label']) ?>
                            <?= Html::dropDownList('kelurahan', $defaultValues['kelurahan'], $kelurahanItems, [
                                'prompt' => '-- Pilih Kelurahan --',
                                'class' => 'form-select form-control',
                                'id' => 'kelurahan',
                                'required' => true,
                            ]) ?>
                            <div class="invalid-feedback">Kelurahan wajib dipilih.</div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <?= Html::label('Keterangan Tambahan', 'keterangan', ['class' => 'form-label']) ?>
                        <?= Html::textarea('keterangan', $defaultValues['keterangan'], [
                            'class' => 'form-control',
                            'rows' => 3,
                            'id' => 'keterangan',
                            'placeholder' => 'Informasi tambahan jika ada',
                        ]) ?>
                    </div>

                </div>
            </div>

            <div class="my-4">
                <label class="form-label fw-bold d-block mb-2">Syarat-syarat <span class="text-danger">*</span></label>
                <div class="list-group list-group-flush border rounded-1 p-2" id="syarat-container" style="font-size: 0.9em;">
                    <?php foreach ($syaratItems as $key => $label) : ?>
                        <div class="form-check mb-1">
                            <?= Html::checkbox('syarat[]', in_array($key, $defaultValues['syarat']), [
                                'class' => 'form-check-input syarat-check',
                                'id' => $key,
                                'value' => $key,
                                'required' => true,
                            ]) ?>
                            <label class="form-check-label" for="<?= $key ?>">
                                <?= Html::encode($label) ?>
                            </label>
                            <div class="invalid-feedback">Anda harus menyetujui persyaratan ini.</div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="syarat-error" class="invalid-feedback d-block" style="display: none; margin-top: 0.25rem;">
                    Harap centang semua persyaratan.
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <?= Html::a('Batal', ['index'], ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton($isUpdate ? 'Update' : 'Simpan', [
                    'class' => 'btn btn-primary',
                    'id' => 'btn-simpan',
                    'disabled' => true,
                ]) ?>
            </div>

            <?= Html::endForm() ?>

        </div>
    </div>
</div>

<?php
$js = <<<JS
(function() {
    "use strict";

    const form = document.getElementById('pendaftaran-ui-form');
    const saveButton = document.getElementById('btn-simpan');
    const requiredFields = form.querySelectorAll('[required]'); 
    const syaratCheckboxes = form.querySelectorAll('.syarat-check');
    const syaratContainer = document.getElementById('syarat-container'); 
    const syaratError = document.getElementById('syarat-error');
    const totalSyarat = syaratCheckboxes.length;

    function validateForm() {
        let isFormValid = true;

        requiredFields.forEach(field => {
            let isValid = true;
            const formGroup = field.closest('.mb-3, .col-sm-6, .form-check'); 
            const fieldFeedback = formGroup?.querySelector('.invalid-feedback'); 

            if (field.type === 'checkbox' && field.classList.contains('syarat-check')) {
                 return;
            } else if (field.tagName === 'SELECT') {
                isValid = field.value !== '';
            } else {
                isValid = field.value.trim() !== '';
                if (isValid && field.pattern && !field.validity.valid) {
                     isValid = false;
                }
            }

            if (!isValid) {
                field.classList.add('is-invalid');
                isFormValid = false;
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid'); 
            }
        });

        let checkedCount = 0;
        syaratCheckboxes.forEach(checkbox => {
            const checkGroup = checkbox.closest('.form-check');
            if (checkbox.checked) {
                checkedCount++;
                 checkbox.classList.remove('is-invalid'); 
                 checkGroup?.classList.remove('is-invalid'); 
                 checkGroup?.querySelector('.invalid-feedback')?.style.display = 'none'; 
            } else {
                 checkbox.classList.add('is-invalid');
                 checkGroup?.classList.add('is-invalid'); 
                 // checkGroup?.querySelector('.invalid-feedback')?.style.display = 'block'; 
            }
        });

        const allSyaratChecked = (checkedCount === totalSyarat);
        if (!allSyaratChecked) {
            isFormValid = false; 
        }

        syaratError.style.display = allSyaratChecked ? 'none' : 'block';
         if (!allSyaratChecked) {
             syaratContainer.classList.add('is-invalid');
         } else {
              syaratContainer.classList.remove('is-invalid');
         }

        saveButton.disabled = !isFormValid;
    }

    form.addEventListener('input', validateForm, false);
    form.addEventListener('change', validateForm, false); 
    validateForm();

    form.addEventListener('submit', function(event) {
        validateForm(); 
        
        if (saveButton.disabled) {
            event.preventDefault(); 
            event.stopPropagation();

             const firstInvalid = form.querySelector('.is-invalid:not(#syarat-container)') || form.querySelector('.syarat-check:not(:checked)'); 
             if (firstInvalid) {
                 firstInvalid.focus();
                 firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
             }
        } 
        form.classList.add('was-validated'); 

    }, false);

})();
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>

<style>
    #syarat-container.is-invalid {
        border-color: var(--bs-form-invalid-border-color);
    }

    .form-check.is-invalid .form-check-label {
        color: var(--bs-form-invalid-color);
    }

    .form-check .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: .25rem;
        font-size: .875em;
        color: var(--bs-form-invalid-color);
    }

    .was-validated .form-check:has(input[required]:invalid) .invalid-feedback {
        display: block;
    }
</style>