<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var array $models
 * @var yii\data\Pagination $pagination
 * @var array $timPemeriksaItems
 * @var array $penandatanganItems
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Form Penjadwalan Surat Tugas';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = 'Surat Tugas';
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
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium">Back Office</span>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium">Surat Tugas</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Form Penjadwalan</h5>

            <?= Html::beginForm(['tambah-jadwal'], 'post', [
                'class' => 'needs-validation',
                'novalidate' => true
            ]) ?>

            <div class="row g-3 mb-3 align-items-end">
                <div class="col-md-6">
                    <?= Html::label('Nomor Surat Tugas', 'nomor_surat', ['class' => 'form-label']) ?>
                    <?= Html::textInput('nomor_surat', '', ['class' => 'form-control', 'placeholder' => 'Contoh: 820 / ... / 2025']) ?>
                </div>
                <div class="col-md-6">
                    <?= Html::label('Pemohon Izin', 'ijin_search', ['class' => 'form-label']) ?>
                    <?= Html::textInput('ijin_search', null, [
                        'class' => 'form-control',
                        'placeholder' => '(Ketikkan Nomor Pendaftaran/ No.Permohonan /Nama Pemohon...)',
                    ]) ?>
                </div>
            </div>

            <div class="row g-3 mb-3 align-items-end">
                <div class="col-md-6">
                    <?= Html::label('Tim Pemeriksa', 'tim_pemeriksa', ['class' => 'form-label']) ?>
                    <?= Html::dropDownList('tim_pemeriksa', null, $timPemeriksaItems, [
                        'prompt' => '-- Pilih Tim --',
                        'class' => 'form-select form-control',
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= Html::label('Ditandatangani Oleh', 'penandatangan', ['class' => 'form-label']) ?>
                    <?= Html::dropDownList('penandatangan', null, $penandatanganItems, [
                        'prompt' => '-- Pilih Pejabat --',
                        'class' => 'form-select form-control',
                    ]) ?>
                </div>
            </div>

            <div class="row g-3 mb-4 align-items-end">
                <div class="col-md-6">
                    <?= Html::label('Tgl Tinju Lapangan', 'tgl_mulai', ['class' => 'form-label']) ?>
                    <div class="input-group">
                        <?= Html::textInput('tgl_mulai', null, ['class' => 'form-control', 'type' => 'date']) ?>
                        <span class="input-group-text">s/d</span>
                        <?= Html::textInput('tgl_selesai', null, ['class' => 'form-control', 'type' => 'date']) ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <?= Html::label('Tgl Cetak', 'tgl_cetak', ['class' => 'form-label']) ?>
                    <?= Html::textInput('tgl_cetak', date('Y-m-d'), ['class' => 'form-control', 'type' => 'date']) ?>
                </div>
                <div class="col-md-12 text-end">
                    <?= Html::submitButton('Tambah Jadwal', ['class' => 'btn btn-outline-primary hover-bg hover-white']) ?>
                </div>
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Jadwal Pemeriksaan</h5>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">
                <?= Html::beginForm(['index'], 'get', [
                    'id' => 'form-search-jadwal',
                    'class' => 'table-src-form align-items-center'
                ]) ?>
                <div class="col-md-5 position-relative">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y" style="z-index: 10; color: #6c757d;">search</i>
                    <div id="autocomplete-container-jadwal" class="position-relative" style="width: 400px;">

                        <?= Html::textInput('search', Yii::$app->request->get('search'), [
                            'id' => 'search_jadwal_input',
                            'name' => 'search',
                            'class' => 'form-control',
                            'style' => 'padding-left: 3rem; width: 400px;',
                            'placeholder' => 'Ketikkan Nomor Surat, Lokasi, atau Tim',
                            'autocomplete' => 'off'
                        ]) ?>

                        <div id="autocomplete-results-jadwal"
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
                                <th scope="col" class="text-nowrap">No</th>
                                <th scope="col" class="text-nowrap">Tanggal Pemeriksaan</th>
                                <th scope="col" class="text-nowrap">Nomor Surat Perintah</th>
                                <th scope="col" class="text-nowrap">Lokasi</th>
                                <th scope="col" class="text-nowrap">Tim Peninjau</th>
                                <th scope="col" class="text-nowrap">Keterangan</th>
                                <th scope="col" class="text-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($models)): ?>
                                <tr>
                                    <td colspan="7" class="text-center fst-italic text-secondary">Belum ada jadwal ditambahkan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($models as $index => $model): ?>
                                    <tr>
                                        <td class="text-center text-secondary"><?= $pagination->page * $pagination->pageSize + $index + 1 ?></td>
                                        <td class="text-nowrap text-secondary">
                                            <?= !empty($model['tanggal_pemeriksaan_mulai']) ? Yii::$app->formatter->asDate($model['tanggal_pemeriksaan_mulai'], 'php:d M Y') : '-' ?>
                                            s/d
                                            <?= !empty($model['tanggal_pemeriksaan_selesai']) ? Yii::$app->formatter->asDate($model['tanggal_pemeriksaan_selesai'], 'php:d M Y') : '-' ?>
                                        </td>
                                        <td class="text-secondary"><?= Html::encode($model['nomor_surat_perintah'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['lokasi'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['tim_peninjau'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['keterangan'] ?? '-') ?></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="<?= Url::to(['cetak-html', 'id' => $model['id'] ?? '#']) ?>"
                                                    class="text-decoration-none"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Cetak Surat Tugas (HTML)"
                                                    target="_blank">
                                                    <i class="material-symbols-outlined fs-18 text-success">print</i>
                                                </a>
                                                <a href="<?= Url::to(['cetak-word', 'id' => $model['id'] ?? '#']) ?>"
                                                    class="text-decoration-none"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Cetak Surat Tugas (Word)"
                                                    target="_blank">
                                                    <i class="material-symbols-outlined fs-18 text-primary">description</i>
                                                </a>
                                                <a href="<?= Url::to(['delete-jadwal', 'id' => $model['id'] ?? '#']) ?>"
                                                    class="text-decoration-none btn-hapus-jadwal"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Hapus Jadwal Ini">
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

                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 mt-4"> <span class="fs-13 fw-medium text-secondary">
                        Menampilkan <b><?= count($models) ?></b> dari <b><?= $pagination->totalCount ?></b> data
                    </span>

                    <div class="d-flex align-items-center">
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
// JavaScript for Tooltip and SweetAlert Delete Confirmation
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;
$deleteConfirmText = "Anda yakin ingin menghapus jadwal ini?";
$deleteConfirmTitle = "Konfirmasi Hapus";

$js = <<<JS

// Initialize Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Handler for delete button
$('.btn-hapus-jadwal').on('click', function(event) {
    event.preventDefault();
    var deleteUrl = $(this).attr('href');

    Swal.fire({
        title: '{$deleteConfirmTitle}',
        text: '{$deleteConfirmText}',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545', // Danger color
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create dynamic form for POST request
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
JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'surat-tugas-handler');
?>


<?php
// (FIX) JAVASCRIPT AUTOCOMPLETE BARU UNTUK GRID BAWAH
$autocompleteUrl = Url::to(['search-jadwal']);

$jsAutocomplete = <<<JS

// (FIX) Variabel unik untuk search box jadwal
const searchInputJadwal = document.getElementById('search_jadwal_input');
const resultsBoxJadwal = document.getElementById('autocomplete-results-jadwal');
const searchFormJadwal = document.getElementById('form-search-jadwal');
const autocompleteUrlJadwal = '{$autocompleteUrl}';

function escapeRegExpJadwal(string) {
    if (typeof string !== 'string') {
        return '';
    }
    return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\$&');
}

async function fetchResultsJadwal(term) {
    if (term.length < 2) {
        if(resultsBoxJadwal) resultsBoxJadwal.innerHTML = '';
        if(resultsBoxJadwal) resultsBoxJadwal.classList.add('d-none');
        return;
    }
    
    try {
        const response = await fetch(autocompleteUrlJadwal + '?term=' + encodeURIComponent(term));
        if (!response.ok) throw new Error('Network error');
        const data = await response.json();
        displayResultsJadwal(data, term);
    } catch (error) {
        console.error('Error fetching autocomplete (jadwal):', error);
        if(resultsBoxJadwal) resultsBoxJadwal.innerHTML = '';
        if(resultsBoxJadwal) resultsBoxJadwal.classList.add('d-none');
    }
}

function displayResultsJadwal(data, term) {
    if(!resultsBoxJadwal) return; 
    resultsBoxJadwal.innerHTML = '';
    
    if (data.length === 0) {
        resultsBoxJadwal.classList.remove('d-none');
        resultsBoxJadwal.innerHTML = '<div class="autocomplete-item-google no-result">Data tidak ditemukan</div>';
        return;
    }

    resultsBoxJadwal.classList.remove('d-none');
    
    const safeTerm = escapeRegExpJadwal(term);
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
            if(searchInputJadwal) searchInputJadwal.value = item.value;
            if(resultsBoxJadwal) resultsBoxJadwal.classList.add('d-none');
            if(searchFormJadwal) searchFormJadwal.submit();
        });
        
        resultsBoxJadwal.appendChild(itemDiv);
    });
}

if(searchInputJadwal) {
    searchInputJadwal.addEventListener('input', function() {
        fetchResultsJadwal(this.value);
    });
}

document.addEventListener('click', function(e) {
    if (searchInputJadwal && !searchInputJadwal.contains(e.target) && resultsBoxJadwal && !resultsBoxJadwal.contains(e.target)) {
        resultsBoxJadwal.classList.add('d-none');
    }
});

JS;
$this->registerJs($jsAutocomplete, \yii\web\View::POS_READY, 'surat-tugas-autocomplete-handler');
?>