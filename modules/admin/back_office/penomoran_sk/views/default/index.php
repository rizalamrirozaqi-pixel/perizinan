<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var string|null $search_pendaftaran
 * @var string|null $search_penomoran
 * @var array|null $modelPendaftaran Data Pendaftaran
 * @var array|null $modelPenomoran Data Penomoran (bisa null)
 * @var bool $isSearch (true jika $modelPendaftaran ada)
 * @var yii\data\ArrayDataProvider $dataProvider (untuk grid bawah)
 * @var array $models
 * @var yii\data\Pagination $pagination
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;

$this->title = 'Penomoran SK';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Back Office</span></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium"><?= Html::encode($this->title) ?></span></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <?= Html::beginForm(['index'], 'get', [
                'id' => 'form-search-pendaftaran',
                'class' => 'table-src-form align-items-center'
            ]) ?>
            <?= Html::hiddenInput('search_penomoran', $search_penomoran) ?>

            <div class="col-md-5 position-relative">
                <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y" style="z-index: 10; color: #6c757d;">search</i>

                <div id="autocomplete-container" class="position-relative" style="width: 400px;">

                    <?= Html::textInput('search_pendaftaran', $search_pendaftaran, [
                        'id' => 'search_pendaftaran',
                        'class' => 'form-control',
                        'style' => 'padding-left: 3rem; width: 400px;',
                        'placeholder' => 'Ketikkan No Daftar atau Nama Pemohon/Usaha',
                        'aria-label' => 'Pencarian Pendaftaran',
                        'autocomplete' => 'off'
                    ]) ?>

                    <div id="autocomplete-results"
                        class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete">
                    </div>

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
                                <?= Html::a(Html::encode($modelPendaftaran['nomor_daftar'] ?? '-'), ['tanda-terima', 'pendaftaran_id' => $modelPendaftaran['id']], [
                                    'class' => 'text-primary text-decoration-none',
                                    'target' => '_blank',
                                    'data-bs-toggle' => 'tooltip',
                                    'data-bs-title' => 'Klik untuk lihat Tanda Terima'
                                ]) ?>
                                <?= Html::a('<i class="material-symbols-outlined">history</i>', ['log', 'pendaftaran_id' => $modelPendaftaran['id']], ['class' => 'ms-2 fw-bold ', 'target' => '_blank', 'data-bs-toggle' => 'tooltip', 'data-bs-title' => 'Klik untuk lihat Lembar Kendali']) ?>
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
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Entry Data Penomoran SK</h5>

                <?= Html::beginForm(['simpan-penomoran', 'pendaftaran_id' => $modelPendaftaran['id']], 'post', ['id' => 'form-penomoran-sk']) ?>

                <div class="row g-3">
                    <div class="col-md-4">
                        <?= Html::label('Nomor SK', 'nomor_sk', ['class' => 'form-label']) ?>
                        <?= Html::textInput('nomor_sk', $modelPenomoran['nomor_sk'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Tanggal Pengesahan', 'tanggal_pengesahan', ['class' => 'form-label']) ?>
                        <?= Html::textInput('tanggal_pengesahan', !empty($modelPenomoran['tanggal_pengesahan']) ? Yii::$app->formatter->asDate($modelPenomoran['tanggal_pengesahan'], 'php:Y-m-d') : date('Y-m-d'), ['class' => 'form-control form-control-sm', 'type' => 'date']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Tanggal Berlaku', 'tanggal_berlaku', ['class' => 'form-label']) ?>
                        <?= Html::textInput('tanggal_berlaku', !empty($modelPenomoran['tanggal_berlaku']) ? Yii::$app->formatter->asDate($modelPenomoran['tanggal_berlaku'], 'php:Y-m-d') : null, ['class' => 'form-control form-control-sm', 'type' => 'date']) ?>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top">
                    <?= Html::submitButton('Simpan Penomoran', ['class' => 'btn btn-primary']) ?>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Laporan Penomoran: SK/TDP/IPPSBW</h5>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">
                <?= Html::beginForm(['index'], 'get', [
                    'id' => 'form-search-penomoran', // ID Form ini sudah benar
                    'class' => 'table-src-form align-items-center'
                ]) ?>
                <?= Html::hiddenInput('search_pendaftaran', $search_pendaftaran) ?>

                <div class="col-md-5 position-relative">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y" style="z-index: 10; color: #6c757d;">search</i>

                    <div id="autocomplete-container-penomoran" class="position-relative" style="width: 400px;">

                        <?= Html::textInput('search_penomoran', $search_penomoran, [
                            'id' => 'search_penomoran', // ID Input ini sudah benar
                            'class' => 'form-control',
                            'style' => 'padding-left: 3rem; width: 400px;',
                            'placeholder' => 'Ketikkan No SK, No Daftar, atau Nama Pemohon',
                            'aria-label' => 'Pencarian Penomoran',
                            'autocomplete' => 'off'
                        ]) ?>

                        <div id="autocomplete-results-penomoran"
                            class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete">
                        </div>

                    </div>
                </div>
                <?= Html::endForm() ?>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="text-nowrap">No</th>
                                <th class="text-nowrap">Jenis Izin</th>
                                <th class="text-nowrap">Nomor Pendaftaran</th>
                                <th class="text-nowrap">Nama Pemohon</th>
                                <th class="text-nowrap">Nama Usaha</th>
                                <th class="text-nowrap">Alamat Usaha</th>
                                <th class="text-nowrap">Nomor SK / TDP / IPPSBW</th>
                                <th class="text-nowrap">Tanggal Pengesahan</th>
                                <th class="text-nowrap">Tanggal Berlaku</th>
                                <th class="text-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (empty($models)):
                            ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted fst-italic">Data Laporan tidak ditemukan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($models as $index => $model): ?>
                                    <tr>
                                        <td class="text-center"><?= $pagination->page * $pagination->pageSize + $index + 1 ?></td>
                                        <td><?= Html::encode($model['nama_izin'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['nomor_daftar'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['nama_usaha'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['alamat_usaha'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['nomor_sk'] ?? '-') ?></td>
                                        <td class="text-center text-nowrap">
                                            <?= !empty($model['tanggal_pengesahan']) ? Yii::$app->formatter->asDate($model['tanggal_pengesahan'], 'php:d F Y') : '-' ?>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <?= !empty($model['tanggal_berlaku']) ? Yii::$app->formatter->asDate($model['tanggal_berlaku'], 'php:d F Y') : '-' ?>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="<?= Url::to(['delete', 'id' => $model['penomoran_id'] ?? '#']) ?>"
                                                    class="text-decoration-none btn-hapus-data"
                                                    data-bs-toggle="tooltip" data-bs-title="Hapus Penomoran">
                                                    <i class="material-symbols-outlined fs-18 text-danger">delete</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
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
    /* CSS untuk Definition List (Info Berkas Izin) */
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

    /* (FIX) CSS UNTUK GOOGLE AUTOCOMPLETE (Berlaku untuk kedua search box) */
    .google-autocomplete {
        max-height: 250px;
        border-bottom-left-radius: var(--bs-border-radius);
        border-bottom-right-radius: var(--bs-border-radius);
        border-top-left-radius: 0;
        border-top-right-radius: 0;
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
// JS untuk Tooltip dan SweetAlert Hapus
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$js = <<<JS

// ===========================================
// Handler Tombol Hapus (Ini kode Anda, sudah benar)
// ===========================================
$('.btn-hapus-data').on('click', function(event) {
    event.preventDefault();
    var deleteUrl = $(this).attr('href'); 

    Swal.fire({
        title: 'Anda Yakin?',
        text: "Data penomoran SK ini akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
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
    });
});

// ===========================================
// Inisialisasi Tooltip (Ini kode Anda, sudah benar)
// ===========================================
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'tooltip-dan-hapus-handler');
?>


<?php
// ===========================================
// (FIX) JAVASCRIPT UNTUK SEARCH BOX #1 (PENDAFTARAN)
// ===========================================
$autocompleteUrlPendaftaran = Url::to(['search-pendaftaran']);

$jsPendaftaran = <<<JS

const searchInput = document.getElementById('search_pendaftaran');
const resultsBox = document.getElementById('autocomplete-results');
const searchForm = document.getElementById('form-search-pendaftaran');
const autocompleteUrl = '{$autocompleteUrlPendaftaran}';

function escapeRegExp(string) {
    if (typeof string !== 'string') {
        return '';
    }
    return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\$&');
}

async function fetchResults(term) {
    if (term.length < 2) {
        if(resultsBox) resultsBox.innerHTML = '';
        if(resultsBox) resultsBox.classList.add('d-none'); 
        return;
    }
    
    try {
        const response = await fetch(autocompleteUrl + '?term=' + encodeURIComponent(term));
        if (!response.ok) throw new Error('Network error');
        const data = await response.json();
        displayResults(data, term); 
    } catch (error) {
        console.error('Error fetching autocomplete (pendaftaran):', error);
        if(resultsBox) resultsBox.innerHTML = '';
        if(resultsBox) resultsBox.classList.add('d-none'); 
    }
}

function displayResults(data, term) {
    if(!resultsBox) return;
    resultsBox.innerHTML = '';
    
    if (data.length === 0) {
        resultsBox.classList.remove('d-none'); 
        resultsBox.innerHTML = '<div class="autocomplete-item-google no-result">Data tidak ditemukan</div>';
        return;
    }

    resultsBox.classList.remove('d-none');
    
    const safeTerm = escapeRegExp(term);
    if (!safeTerm) return;
    
    const regex = new RegExp('(' + safeTerm + ')', 'gi');

    data.forEach(item => {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'autocomplete-item-google';
        
        const highlightedLabel = item.label.replace(regex, '<strong>$1</strong>');
        itemDiv.innerHTML = '<i class="material-symbols-outlined">search</i>' + 
                            '<span>' + highlightedLabel + '</span>';
        
        itemDiv.addEventListener('click', function(e) {
            e.preventDefault(); 
            if(searchInput) searchInput.value = item.value; 
            if(resultsBox) resultsBox.classList.add('d-none'); 
            if(searchForm) searchForm.submit(); 
        });
        
        resultsBox.appendChild(itemDiv);
    });
}

if(searchInput) {
    searchInput.addEventListener('input', function() {
        fetchResults(this.value);
    });
}

document.addEventListener('click', function(e) {
    if (searchInput && !searchInput.contains(e.target) && resultsBox && !resultsBox.contains(e.target)) {
        resultsBox.classList.add('d-none');
    }
});

JS;
$this->registerJs($jsPendaftaran, \yii\web\View::POS_READY, 'penomoran-sk-handler-google');
?>


<?php
// ===========================================
// (FIX) JAVASCRIPT BARU UNTUK SEARCH BOX #2 (LAPORAN PENOMORAN)
// ===========================================
$autocompleteUrlPenomoran = Url::to(['search-penomoran']); // <-- Panggil action baru

$jsPenomoran = <<<JS

// (FIX) Variabel baru dengan nama unik
const searchInputPenomoran = document.getElementById('search_penomoran');
const resultsBoxPenomoran = document.getElementById('autocomplete-results-penomoran');
const searchFormPenomoran = document.getElementById('form-search-penomoran');
const autocompleteUrlPenomoran = '{$autocompleteUrlPenomoran}';

// (FIX) Fungsi helper baru dengan nama unik
function escapeRegExpPenomoran(string) {
    if (typeof string !== 'string') {
        return '';
    }
    return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\$&');
}

async function fetchResultsPenomoran(term) {
    if (term.length < 2) {
        if(resultsBoxPenomoran) resultsBoxPenomoran.innerHTML = '';
        if(resultsBoxPenomoran) resultsBoxPenomoran.classList.add('d-none'); 
        return;
    }
    
    try {
        const response = await fetch(autocompleteUrlPenomoran + '?term=' + encodeURIComponent(term));
        if (!response.ok) throw new Error('Network error');
        const data = await response.json();
        displayResultsPenomoran(data, term);
    } catch (error) {
        console.error('Error fetching autocomplete (penomoran):', error);
        if(resultsBoxPenomoran) resultsBoxPenomoran.innerHTML = '';
        if(resultsBoxPenomoran) resultsBoxPenomoran.classList.add('d-none'); 
    }
}

function displayResultsPenomoran(data, term) {
    if(!resultsBoxPenomoran) return;
    resultsBoxPenomoran.innerHTML = '';
    
    if (data.length === 0) {
        resultsBoxPenomoran.classList.remove('d-none');
        resultsBoxPenomoran.innerHTML = '<div class="autocomplete-item-google no-result">Data tidak ditemukan</div>';
        return;
    }

    resultsBoxPenomoran.classList.remove('d-none');
    
    const safeTerm = escapeRegExpPenomoran(term);
    if (!safeTerm) return;
    
    const regex = new RegExp('(' + safeTerm + ')', 'gi');

    data.forEach(item => {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'autocomplete-item-google';
        
        const highlightedLabel = item.label.replace(regex, '<strong>$1</strong>');
        itemDiv.innerHTML = '<i class="material-symbols-outlined">search</i>' + 
                            '<span>' + highlightedLabel + '</span>';
        
        itemDiv.addEventListener('click', function(e) {
            e.preventDefault(); 
            if(searchInputPenomoran) searchInputPenomoran.value = item.value; // (FIX) Isi dengan No SK
            if(resultsBoxPenomoran) resultsBoxPenomoran.classList.add('d-none'); 
            if(searchFormPenomoran) searchFormPenomoran.submit(); 
        });
        
        resultsBoxPenomoran.appendChild(itemDiv);
    });
}

if(searchInputPenomoran) {
    searchInputPenomoran.addEventListener('input', function() {
        fetchResultsPenomoran(this.value);
    });
}

document.addEventListener('click', function(e) {
    // (FIX) Cek elemen yang unik
    if (searchInputPenomoran && !searchInputPenomoran.contains(e.target) && resultsBoxPenomoran && !resultsBoxPenomoran.contains(e.target)) {
        resultsBoxPenomoran.classList.add('d-none');
    }
});

JS;
// (FIX) Daftarkan dengan nama unik
$this->registerJs($jsPenomoran, \yii\web\View::POS_READY, 'penomoran-laporan-autocomplete-handler');
?>