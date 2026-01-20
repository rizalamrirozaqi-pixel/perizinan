<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var array $models
 * @var yii\data\Pagination $pagination
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Pendaftaran';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = $this->title;
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
                    <span class="fw-medium"><?= Html::encode($this->title) ?></span>
                </li>
            </ol>
        </nav>

    </div>

    <div class="card bg-white border-0 rounded-3 mb-4">
        <div class="card-body p-4">

            <ul class="nav nav-tabs border-0 gap-3 mb-lg-4 mb-3 seller-tabs d-none" id="myTab" role="tablist">
            </ul>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">

                <?= Html::beginForm(['index'], 'get', [
                    'id' => 'form-search-pendaftaran', 
                    'class' => 'table-src-form align-items-center'
                ]) ?>
                <div class="col-md-5 position-relative">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y" style="z-index: 10; color: #6c757d;">search</i>
                    <div id="autocomplete-container" class="position-relative" style="width: 400px;">

                        <?= Html::textInput('search', Yii::$app->request->get('search'), [
                            'id' => 'search_pendaftaran', 
                            'name' => 'search',
                            'class' => 'form-control',
                            'style' => 'padding-left: 3rem; width: 400px;',
                            'placeholder' => 'Ketikkan Nomor Pendaftaran atau Nama Pemohon',
                            'autocomplete' => 'off'
                        ]) ?>

                        <div id="autocomplete-results"
                            class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete">
                        </div>

                    </div>
                </div>
                <?= Html::endForm() ?>
                <a href="<?= Url::to(['form-daftar']) ?>" class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg d-flex align-items-center">
                    <span class="py-sm-1 d-block d-flex align-items-center">
                        <i class="fs-18 material-symbols-outlined">add</i>
                        <span>Tambah Pendaftaran</span>
                    </span>
                </a>
            </div>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                    <div class="default-table-area all-products">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap" scope="col">No</th>
                                        <th class="text-nowrap" scope="col">Nomor Daftar</th>
                                        <th class="text-nowrap" scope="col">Nama Izin</th>
                                        <th class="text-nowrap" scope="col">Nama Permohonan</th>
                                        <th class="text-nowrap" scope="col">Nama Pemohon</th>
                                        <th class="text-nowrap" scope="col">Nama Usaha</th>
                                        <th class="text-nowrap" scope="col">Waktu</th>
                                        <th class="text-nowrap" scope="col">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (empty($models)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted fst-italic">
                                                Data tidak ditemukan.
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php foreach ($models as $index => $model): ?>
                                        <tr>
                                            <td class="text-secondary"><?= $pagination->page * $pagination->pageSize + $index + 1 ?></td>
                                            <td class="text-secondary"><?= Html::encode($model['nomor_daftar']) ?></td>
                                            <td class="text-secondary"><?= Html::encode($model['nama_izin']) ?></td>
                                            <td class="text-secondary"><?= Html::encode($model['nama_permohonan']) ?></td>
                                            <td class="text-secondary"><?= Html::encode($model['nama_pemohon']) ?></td>
                                            <td class="text-body"><?= Html::encode($model['nama_usaha']) ?></td>
                                            <td class="text-secondary text-nowrap">
                                                <span class="d-block"><?= Html::encode($model['tanggal']) ?></span>
                                                <span class="fs-12 text-body"><?= Html::encode($model['waktu']) ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="<?= Url::to(['cetak', 'id' => $model['id'] ?? '']) ?>" class="text-decoration-none" data-bs-toggle="tooltip" target="_blank" data-bs-title="Cetak Tanda Terima">
                                                        <i class="material-symbols-outlined fs-18 text-success">print</i>
                                                    </a>

                                                    <a href="<?= Url::to(['cetak', 'id' => $model['id'] ?? '']) ?>" class="text-decoration-none" data-bs-toggle="tooltip" target="_blank" data-bs-title="Cetak Monitoring">
                                                        <i class="material-symbols-outlined fs-18 text-info">print</i>
                                                    </a>

                                                    <a href="<?= Url::to(['update', 'id' => $model['id'] ?? '']) ?>" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-title="Edit Data">
                                                        <i class="material-symbols-outlined fs-18 text-primary">edit</i>
                                                    </a>
                                                    <a href="<?= Url::to(['copy', 'id' => $model['id'] ?? '']) ?>" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-title="Copy Data">
                                                        <i class="material-symbols-outlined fs-18 text-primary">content_copy</i>
                                                    </a>

                                                    <a href="<?= Url::to(['delete', 'id' => $model['id'] ?? '']) ?>" class="text-decoration-none btn-hapus-data" data-bs-toggle="tooltip" data-bs-title="Hapus Data">
                                                        <i class="material-symbols-outlined fs-18 text-danger">delete</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
                                ]) ?>
                            </div>
                        </div>
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
// Script untuk Tooltip DAN SweetAlert Hapus
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$jsDelete = <<<JS

// 1. Inisialisasi Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});

// 2. Handler untuk tombol hapus
$('.btn-hapus-data').on('click', function(event) {
    event.preventDefault(); 
    var deleteUrl = $(this).attr('href'); 

    Swal.fire({
        title: 'Anda Yakin?',
        text: "Data pendaftaran ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
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
JS;
$this->registerJs($jsDelete, \yii\web\View::POS_READY, 'sweetalert-delete-index');
?>

<?php
$autocompleteUrl = Url::to(['search-pendaftaran']);

$jsAutocomplete = <<<JS

const searchInput = document.getElementById('search_pendaftaran');
const resultsBox = document.getElementById('autocomplete-results');
const searchForm = document.getElementById('form-search-pendaftaran');
const autocompleteUrl = '{$autocompleteUrl}';

function escapeRegExp(string) {
    if (typeof string !== 'string') {
        return '';
    }
    // (FIX) Ini sudah aman untuk PHP HEREDOC
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
        console.error('Error fetching autocomplete:', error);
        if(resultsBox) resultsBox.innerHTML = '';
        if(resultsBox) resultsBox.classList.add('d-none');
    }
}

function displayResults(data, term) {
    if(!resultsBox) return; // Pastikan resultsBox ada
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

// Pastikan elemen ada sebelum menambah listener
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
$this->registerJs($jsAutocomplete, \yii\web\View::POS_READY, 'pendaftaran-autocomplete-handler');
?>