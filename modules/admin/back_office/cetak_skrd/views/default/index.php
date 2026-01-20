<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var string|null $search_pendaftaran
 * @var string|null $search_skrd
 * @var array|null $modelPendaftaran Data Pendaftaran
 * @var array|null $modelSkr Data SKR (bisa null)
 * @var bool $isSearch (true jika $modelPendaftaran ada)
 * @var yii\data\ArrayDataProvider $dataProvider (untuk grid bawah)
 * @var array $models
 * @var yii\data\Pagination $pagination
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;

$this->title = 'Cetak SKRD';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = 'Cetak SKRD';

$totalRetribusi = array_sum(ArrayHelper::getColumn($dataProvider->getModels(), 'total_retribusi'));
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Back Office</span></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Cetak SKRD</span></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <?= Html::beginForm(['index'], 'get', [
                'id' => 'form-search-pendaftaran',
                'class' => 'table-src-form position-relative me-0',
                'style' => 'max-width: 100%;',
            ]) ?>
            <?= Html::hiddenInput('search_skrd', $search_skrd) ?>

            <div class="col-md-5 position-relative">
                <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                <?= Html::textInput('search_pendaftaran', $search_pendaftaran, [
                    'id' => 'search_pendaftaran',
                    'class' => 'form-control',
                    'style' => 'width: 400px;',
                    'placeholder' => 'Ketikkan No Daftar atau Nama Pemohon/Usaha',
                    'aria-label' => 'Pencarian Pendaftaran',
                    'autocomplete' => 'off', 
                ]) ?>

                <div id="autocomplete-results-pendaftaran"
                    class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete"
                    style="width: 100%;">
                </div>
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>

    <?php if ($isSearch && $modelPendaftaran !== null): ?>

        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Info Berkas Izin</h5>
                <div class="row gx-5">
                    <div class="col-md-6">
                        <dl class="row mb-0 definition-list-styled">
                            <dt class="col-sm-5">Nomor Pendaftaran</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span>
                                <?= Html::a(Html::encode($modelPendaftaran['nomor_daftar'] ?? '-'), ['log', 'pendaftaran_id' => $modelPendaftaran['id']], [
                                    'class' => 'text-primary text-decoration-none',
                                    'target' => '_blank',
                                    'data-bs-toggle' => 'tooltip',
                                    'data-bs-title' => 'Klik untuk lihat Lembar Kendali (LOG)'
                                ]) ?>
                            </dd>
                            <dt class="col-sm-5">Jenis Izin</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['nama_izin'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Jenis Permohonan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['jenis_permohonan'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Nama Pemohon</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['nama_pemohon'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Nomor KTP/NPWP</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['no_ktp_npwp'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Alamat</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['alamat'] ?? '-') ?></dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row mb-0 definition-list-styled">
                            <dt class="col-sm-5">Nomor Telepon</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['telepon'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Lokasi Usaha / Bangunan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['lokasi_usaha'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Kecamatan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['kecamatan'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Kelurahan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['kelurahan'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Keterangan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['keterangan'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Multi Daftar dengan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> -</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Data SKRD</h5>
                <?= Html::beginForm(['simpan-skr', 'pendaftaran_id' => $modelPendaftaran['id']], 'post', ['id' => 'form-skr']) ?>
                <div class="row g-3">
                    <div class="col-md-4">
                        <?= Html::label('Nomor SKR', 'nomor_skr', ['class' => 'form-label']) ?>
                        <?= Html::textInput('nomor_skr', $modelSkr['nomor_skr'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Tanggal Jatuh Tempo', 'tanggal_jatuh_tempo', ['class' => 'form-label']) ?>
                        <?= Html::textInput('tanggal_jatuh_tempo', !empty($modelSkr['tanggal_jatuh_tempo']) ? Yii::$app->formatter->asDate($modelSkr['tanggal_jatuh_tempo'], 'php:Y-m-d') : null, ['class' => 'form-control form-control-sm', 'type' => 'date']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Tanggal SKR', 'tanggal_skr', ['class' => 'form-label']) ?>
                        <?= Html::textInput('tanggal_skr', !empty($modelSkr['tanggal_skr']) ? Yii::$app->formatter->asDate($modelSkr['tanggal_skr'], 'php:Y-m-d') : date('Y-m-d'), ['class' => 'form-control form-control-sm', 'type' => 'date']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('MASA', 'masa', ['class' => 'form-label']) ?>
                        <?= Html::textInput('masa', $modelSkr['masa'] ?? date('Y'), ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('NPWR', 'npwr', ['class' => 'form-label']) ?>
                        <?= Html::textInput('npwr', $modelSkr['npwr'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Nilai Retribusi', 'nilai_retribusi', ['class' => 'form-label']) ?>
                        <?= Html::textInput('nilai_retribusi', $modelSkr['nilai_retribusi'] ?? 0, ['class' => 'form-control form-control-sm', 'type' => 'number']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Denda', 'denda', ['class' => 'form-label']) ?>
                        <?= Html::textInput('denda', $modelSkr['denda'] ?? 0, ['class' => 'form-control form-control-sm', 'type' => 'number']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Nilai Pengurangan', 'nilai_pengurangan', ['class' => 'form-label']) ?>
                        <?= Html::textInput('nilai_pengurangan', $modelSkr['nilai_pengurangan'] ?? 0, ['class' => 'form-control form-control-sm', 'type' => 'number']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Nilai Pembulatan', 'nilai_pembulatan', ['class' => 'form-label']) ?>
                        <?= Html::textInput('nilai_pembulatan', $modelSkr['nilai_pembulatan'] ?? 0, ['class' => 'form-control form-control-sm', 'type' => 'number']) ?>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top">
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>

    <?php endif; ?> <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Laporan Cetak SKRD</h5>

            <?= Html::beginForm(['index'], 'get', [
                'id' => 'form-search-skrd',
                'class' => 'table-src-form position-relative me-0 mb-3',
                'style' => 'max-width: 100%;',
            ]) ?>
            <?= Html::hiddenInput('search_pendaftaran', $search_pendaftaran) ?>

            <div class="col-md-5 position-relative">
                <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                <?= Html::textInput('search_skrd', $search_skrd, [
                    'id' => 'search_skrd',
                    'class' => 'form-control',
                    'style' => 'width: 400px;',
                    'placeholder' => 'Ketikkan Nomor SKRD atau Nama Pemohon/Usaha',
                    'aria-label' => 'Pencarian SKRD',
                    'autocomplete' => 'off',
                ]) ?>

                <div id="autocomplete-results-skrd"
                    class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete"
                    style="width: 100%;">
                </div>
            </div>
            <?= Html::endForm() ?>


            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="text-nowrap">No</th>
                                <th class="text-nowrap">Nama Pemohon</th>
                                <th class="text-nowrap">Usaha/Bangunan</th>
                                <th class="text-nowrap">Lokasi Izin</th>
                                <th class="text-nowrap">Jenis Izin</th>
                                <th class="text-nowrap">Nomor SKRD</th>
                                <th class="text-nowrap">Tanggal SKRD</th>
                                <th class="text-nowrap">Nilai Retribusi</th>
                                <th class="text-nowrap">Denda</th>
                                <th class="text-nowrap">Pembulatan</th>
                                <th class="text-nowrap">Total Retribusi</th>
                                <th class="text-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $models = $dataProvider->getModels();
                            if (empty($models)):
                            ?>
                                <tr>
                                    <td colspan="12" class="text-center text-muted fst-italic">Data SKRD tidak ditemukan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($models as $index => $model): ?>
                                    <tr>
                                        <td class="text-center"><?= $pagination->page * $pagination->pageSize + $index + 1 ?></td>
                                        <td><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['nama_usaha_bangunan'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['lokasi_izin'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['jenis_izin'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['nomor_skrd'] ?? '-') ?></td>
                                        <td class="text-center text-nowrap">
                                            <?= !empty($model['tanggal_skrd']) ? Yii::$app->formatter->asDate($model['tanggal_skrd'], 'php:d M Y') : '-' ?>
                                        </td>
                                        <td class="text-end"><?= 'Rp ' . Yii::$app->formatter->asDecimal($model['nilai_retribusi'] ?? 0, 0) ?></td>
                                        <td class="text-end"><?= 'Rp ' . Yii::$app->formatter->asDecimal($model['denda'] ?? 0, 0) ?></td>
                                        <td class="text-end"><?= 'Rp ' . Yii::$app->formatter->asDecimal($model['pembulatan'] ?? 0, 0) ?></td>
                                        <td class="text-end fw-bold"><?= 'Rp ' . Yii::$app->formatter->asDecimal($model['total_retribusi'] ?? 0, 0) ?></td>
                                        <td class="text-center text-nowrap">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="<?= Url::to(['cetak', 'skrd_id' => $model['skrd_id'] ?? '#']) ?>"
                                                    class="text-decoration-none"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Cetak SKRD"
                                                    target="_blank">
                                                    <i class="material-symbols-outlined fs-18 text-info">print</i>
                                                </a>

                                                <a href="<?= Url::to(['cetak-word', 'skrd_id' => $model['skrd_id'] ?? '#']) ?>"
                                                    class="text-decoration-none"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Download Word">
                                                    <i class="material-symbols-outlined fs-18 text-primary">description</i>
                                                </a>

                                                <a href="<?= Url::to(['delete', 'skrd_id' => $model['skrd_id'] ?? '#']) ?>"
                                                    class="text-decoration-none btn-hapus-skrd" data-bs-toggle="tooltip"
                                                    data-bs-title="Hapus SKRD">
                                                    <i class="material-symbols-outlined fs-18 text-danger">delete</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="fw-bold bg-light">
                            <tr>
                                <td colspan="10" class="text-end">Total</td>
                                <td class="text-end">
                                    <?php
                                    $grandTotal = array_sum(ArrayHelper::getColumn($models, 'total_retribusi'));
                                    echo 'Rp ' . Yii::$app->formatter->asDecimal($grandTotal, 0);
                                    ?>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 ">
                    <span class="fs-13 fw-medium text-secondary">
                        Menampilkan <b><?= count($models) ?></b> dari <b><?= $pagination->totalCount ?></b> data
                    </span>
                    <div class="d-flex align-items-center py-3">
                        <?= LinkPager::widget([
                            'pagination' => $pagination,
                            'options' => ['class' => 'pagination mb-0 justify-content-center'],
                            'linkContainerOptions' => ['class' => 'page-item'],
                            'linkOptions' => ['class' => 'page-link'],
                            'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                            'activePageCssClass' => 'active',
                            'prevPageCssClass' => 'page-item fs-16',
                            'nextPageCssClass' => 'page-item fs-16',
                            'prevPageLabel' => '<i class="material-symbols-outlined fs-16">keyboard_arrow_left</i>',
                            'nextPageLabel' => '<i class="material-symbols-outlined fs-16">keyboard_arrow_right</i>',
                            'firstPageLabel' => '<i class="material-symbols-outlined fs-16">first_page</i>',
                            'lastPageLabel' => '<i class="material-symbols-outlined fs-16">last_page</i>',
                            'maxButtonCount' => 5,
                        ]) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* ... (CSS Anda yang sudah ada) ... */
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

    .definition-list-styled dd {
        padding-bottom: 0.8rem;
        word-break: break-word;
        vertical-align: top;
        color: #495057;
        padding-left: 0;
        display: flex;
        align-items: center;
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

    .table-sm th,
    .table-sm td {
        padding: 0.4rem 0.5rem;
        vertical-align: middle;
    }

    /* (FIX) CSS UNTUK GOOGLE AUTOCOMPLETE */
    .google-autocomplete {
        max-height: 250px;
        border-bottom-left-radius: var(--bs-border-radius);
        border-bottom-right-radius: var(--bs-border-radius);
        border: 1px solid #dee2e6;
        border-top: 0;
    }

    .autocomplete-item-google {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .autocomplete-item-google .material-symbols-outlined {
        font-size: 1.25rem;
        color: #6c757d;
        margin-right: 0.75rem;
    }

    .autocomplete-item-google:hover {
        background-color: #f8f9fa;
    }

    .autocomplete-item-google strong {
        font-weight: 600;
        color: #212529;
    }

    .autocomplete-item-google.no-result {
        color: #6c757d;
        font-style: italic;
        cursor: default;
    }

    .autocomplete-item-google.no-result:hover {
        background-color: #fff;
    }
</style>

<?php
// JavaScript untuk Tooltip dan SweetAlert Hapus (TETAP SAMA, KODE INI SUDAH BENAR)
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$js = <<<JS
// Inisialisasi Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Handler untuk tombol hapus SKRD
$('.btn-hapus-skrd').on('click', function(event) {
    event.preventDefault(); // <-- Ini yang akan mencegah link diklik
    var deleteUrl = $(this).attr('href'); 

    Swal.fire({
        title: 'Anda Yakin?',
        text: "Data SKRD ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Hanya jika dikonfirmasi, kirim form POST
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;
            var csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '{$csrfParam}';
            csrfInput.value = '{$csrfToken}';
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
        // Jika "Cancel" diklik, tidak terjadi apa-apa
    });
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'skrd-handler');
?>

<?php
// (FIX BARU) JAVASCRIPT UNTUK AUTOCOMPLETE PENDAFTARAN (FORM ATAS)
$autocompleteUrl1 = Url::to(['search-pendaftaran']);

$jsAutocomplete1 = <<<JS

// --- Blok Autocomplete 1: Pendaftaran ---
const searchInput1 = document.getElementById('search_pendaftaran'); 
const resultsBox1 = document.getElementById('autocomplete-results-pendaftaran');
const searchForm1 = document.getElementById('form-search-pendaftaran');
const autocompleteUrl1 = '{$autocompleteUrl1}';

function escapeRegExp1(string) {
    if (typeof string !== 'string') return '';
    return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\$&');
}

async function fetchResults1(term) {
    if (term.length < 2) {
        if(resultsBox1) { resultsBox1.innerHTML = ''; resultsBox1.classList.add('d-none'); }
        return;
    }
    try {
        const response = await fetch(autocompleteUrl1 + '?term=' + encodeURIComponent(term));
        if (!response.ok) throw new Error('Network error');
        const data = await response.json();
        displayResults1(data, term);
    } catch (error) {
        console.error('Error fetching autocomplete 1:', error);
        if(resultsBox1) { resultsBox1.innerHTML = ''; resultsBox1.classList.add('d-none'); }
    }
}

function displayResults1(data, term) {
    if(!resultsBox1) return; 
    resultsBox1.innerHTML = '';
    
    if (data.length === 0) {
        resultsBox1.classList.remove('d-none');
        resultsBox1.innerHTML = '<div class="autocomplete-item-google no-result">Data tidak ditemukan</div>';
        return;
    }

    resultsBox1.classList.remove('d-none');
    const safeTerm = escapeRegExp1(term);
    if (!safeTerm) return;
    const regex = new RegExp('(' + safeTerm + ')', 'gi');

    data.forEach(item => {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'autocomplete-item-google';
        const highlightedLabel = item.label.replace(regex, '<strong>$1</strong>');
        itemDiv.innerHTML = '<i class="material-symbols-outlined">search</i>' + '<span>' + highlightedLabel + '</span>';
        
        itemDiv.addEventListener('click', function(e) {
            e.preventDefault(); 
            if(searchInput1) searchInput1.value = item.value;
            if(resultsBox1) resultsBox1.classList.add('d-none');
            if(searchForm1) searchForm1.submit();
        });
        resultsBox1.appendChild(itemDiv);
    });
}

if(searchInput1) {
    searchInput1.addEventListener('input', function() {
        fetchResults1(this.value);
    });
}

document.addEventListener('click', function(e) {
    if (searchInput1 && !searchInput1.contains(e.target) && resultsBox1 && !resultsBox1.contains(e.target)) {
        resultsBox1.classList.add('d-none');
    }
});
JS;
$this->registerJs($jsAutocomplete1, \yii\web\View::POS_READY, 'pendaftaran-autocomplete-handler');
?>

<?php
// (FIX BARU) JAVASCRIPT UNTUK AUTOCOMPLETE SKRD (FORM BAWAH)
$autocompleteUrl2 = Url::to(['search-skrd']);

$jsAutocomplete2 = <<<JS

// --- Blok Autocomplete 2: SKRD ---
const searchInput2 = document.getElementById('search_skrd'); 
const resultsBox2 = document.getElementById('autocomplete-results-skrd');
const searchForm2 = document.getElementById('form-search-skrd');
const autocompleteUrl2 = '{$autocompleteUrl2}';

function escapeRegExp2(string) {
    if (typeof string !== 'string') return '';
    return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\$&');
}

async function fetchResults2(term) {
    if (term.length < 2) {
        if(resultsBox2) { resultsBox2.innerHTML = ''; resultsBox2.classList.add('d-none'); }
        return;
    }
    try {
        const response = await fetch(autocompleteUrl2 + '?term=' + encodeURIComponent(term));
        if (!response.ok) throw new Error('Network error');
        const data = await response.json();
        displayResults2(data, term);
    } catch (error) {
        console.error('Error fetching autocomplete 2:', error);
        if(resultsBox2) { resultsBox2.innerHTML = ''; resultsBox2.classList.add('d-none'); }
    }
}

function displayResults2(data, term) {
    if(!resultsBox2) return; 
    resultsBox2.innerHTML = '';
    
    if (data.length === 0) {
        resultsBox2.classList.remove('d-none');
        resultsBox2.innerHTML = '<div class="autocomplete-item-google no-result">Data tidak ditemukan</div>';
        return;
    }

    resultsBox2.classList.remove('d-none');
    const safeTerm = escapeRegExp2(term);
    if (!safeTerm) return;
    const regex = new RegExp('(' + safeTerm + ')', 'gi');

    data.forEach(item => {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'autocomplete-item-google';
        const highlightedLabel = item.label.replace(regex, '<strong>$1</strong>');
        itemDiv.innerHTML = '<i class="material-symbols-outlined">search</i>' + '<span>' + highlightedLabel + '</span>';
        
        itemDiv.addEventListener('click', function(e) {
            e.preventDefault(); 
            if(searchInput2) searchInput2.value = item.value;
            if(resultsBox2) resultsBox2.classList.add('d-none');
            if(searchForm2) searchForm2.submit();
        });
        resultsBox2.appendChild(itemDiv);
    });
}

if(searchInput2) {
    searchInput2.addEventListener('input', function() {
        fetchResults2(this.value);
    });
}

document.addEventListener('click', function(e) {
    if (searchInput2 && !searchInput2.contains(e.target) && resultsBox2 && !resultsBox2.contains(e.target)) {
        resultsBox2.classList.add('d-none');
    }
});
JS;
$this->registerJs($jsAutocomplete2, \yii\web\View::POS_READY, 'skrd-autocomplete-handler');
?>