<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Info Syarat Perizinan';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-header bg-transparent border-bottom p-4">
            <h5 class="card-title mb-0 fw-semibold">Pilih Jenis Izin</h5>
        </div>

        <div class="card-body p-4">

            <div class="row mb-4 g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Jenis Izin</label>
                    <?= Html::dropDownList('jenis_izin', null, $listIzin, [
                        'id' => 'jenis_izin',
                        'prompt' => '-- Pilih Jenis Izin --',
                        'class' => 'form-select form-control',
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Jenis Permohonan</label>
                    <?= Html::dropDownList('jenis_permohonan', null, $listPermohonan, [
                        'id' => 'jenis_permohonan',
                        'prompt' => '-- Pilih Jenis Permohonan --',
                        'class' => 'form-select form-control',
                    ]) ?>
                </div>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-primary mb-0">Daftar Persyaratan</h6>

                    <a href="#" id="btn-cetak" class="btn btn-outline-primary btn-sm d-none p-2" target="_blank">
                        <i class="material-symbols-outlined fs-18 me-1" style="vertical-align: middle;">print</i> Cetak Syarat
                    </a>

                </div>

                <div id="syarat-container" class="p-4 rounded-3 border border-dashed">
                    <span class="text-muted fst-italic">(Silakan pilih opsi di atas untuk melihat syarat)</span>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
$urlGetSyarat = Url::to(['get-syarat']);
$urlCetakBase = Url::to(['cetak']); // URL dasar untuk cetak
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$js = <<<JS
    function loadSyarat() {
        var izinId = $('#jenis_izin').val();
        var permohonanId = $('#jenis_permohonan').val();
        var container = $('#syarat-container');
        var btnCetak = $('#btn-cetak');

        if(!izinId || !permohonanId) {
            container.html('<span class="text-muted fst-italic">(Pilih dulu Jenis Izin dan Jenis Permohonan)</span>');
            btnCetak.addClass('d-none');
            return;
        }

        container.html('<div class="text-center"><div class="spinner-border text-primary spinner-border-sm"></div> Memuat data...</div>');

        $.ajax({
            url: '{$urlGetSyarat}',
            type: 'POST',
            data: {
                izin_id: izinId,
                permohonan_id: permohonanId,
                "{$csrfParam}": "{$csrfToken}"
            },
            success: function(response) {
                container.html(response.html).hide().fadeIn(300);
                
                if(response.found) {
                    // (FIX) Update URL tombol cetak agar dinamis
                    var cetakUrl = '{$urlCetakBase}?izin_id=' + encodeURIComponent(izinId) + '&permohonan_id=' + encodeURIComponent(permohonanId);
                    btnCetak.attr('href', cetakUrl);
                    btnCetak.removeClass('d-none');
                } else {
                    btnCetak.addClass('d-none');
                }
            },
            error: function() {
                container.html('<div class="alert alert-danger">Gagal mengambil data. Silakan coba lagi.</div>');
            }
        });
    }

    $('#jenis_izin, #jenis_permohonan').on('change', function() {
        loadSyarat();
    });
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>