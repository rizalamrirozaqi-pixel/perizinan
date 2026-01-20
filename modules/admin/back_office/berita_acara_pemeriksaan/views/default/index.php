<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var string|null $search
 * @var array|null $model Data Pendaftaran
 * @var array|null $bapData Data BAP
 * @var bool $isSearch
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Cetak Berita Acara Pemeriksaan';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = 'Berita Acara Pemeriksaan';
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
                    <span class="fw-medium">Berita Acara Pemeriksaan</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">

                <?= Html::beginForm(['index'], 'get', [
                    'id' => 'form-search-pendaftaran', 
                    'class' => 'table-src-form align-items-center'
                ]) ?>

                <div class="col-md-5 position-relative">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y" style="padding-left: 12px; z-index: 10; color: #6c757d;">search</i>

                    <div id="autocomplete-container" class="position-relative" style="width: 400px;">

                        <?= Html::textInput('search', Yii::$app->request->get('search'), [
                            'id' => 'search_pendaftaran', // ID Input
                            'name' => 'search', // Ini 'name' yang dibaca actionIndex
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

            </div>
        </div>
    </div>

    <?php if ($isSearch && $model !== null): ?>
        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Detail Pendaftaran</h5>
                <div class="row gx-5">
                    <div class="col-md-6">
                        <dl class="row mb-0 definition-list-styled">
                            <dt class="col-sm-5">Nomor Pendaftaran</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span>
                                <?= Html::a(Html::encode($model['nomor_daftar'] ?? '-'), ['log', 'pendaftaran_id' => $model['id'] ?? '#'], [
                                    'class' => 'text-primary text-decoration-none',
                                    'target' => '_blank',
                                    'data-bs-toggle' => 'tooltip',
                                    'data-bs-title' => 'Klik untuk lihat Tanda Terima'
                                ]) ?>

                                <?= Html::a(
                                    '<i class="material-symbols-outlined fs-18">history</i>',
                                    ['log', 'pendaftaran_id' => $model['id'] ?? '#'],
                                    ['class' => 'ms-2 fw-bold text-secondary', 'target' => '_blank', 'data-bs-toggle' => 'tooltip', 'data-bs-title' => 'Klik untuk lihat Lembar Kendali']
                                ) ?>
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
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row mb-0 definition-list-styled">
                            <dt class="col-sm-5">Nomor Telepon</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['telepon'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Lokasi Usaha / Bangunan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['lokasi_usaha'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Kecamatan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['kecamatan'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Kelurahan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['kelurahan'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Keterangan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['keterangan'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Multi Daftar dengan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> [Rekomendasi Izin Reklame]</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Berita Acara Pemeriksaan</h5>
                <?php if ($bapData !== null): ?>
                    <dl class="row mb-3 definition-list-styled">
                        <dt class="col-sm-3">Nomor Berita Acara</dt>
                        <dd class="col-sm-9"><span class="definition-divider">:</span> <?= Html::encode($bapData['nomor_bap'] ?? '-') ?></dd>
                        <dt class="col-sm-3">Tanggal BAP</dt>
                        <dd class="col-sm-9"><span class="definition-divider">:</span> <?= Html::encode(Yii::$app->formatter->asDate($bapData['tanggal_bap'], 'php:d-m-Y')) ?></dd>
                        <dt class="col-sm-3">Tanggal Realisasi Lapangan</dt>
                        <dd class="col-sm-9"><span class="definition-divider">:</span> <?= Html::encode(Yii::$app->formatter->asDate($bapData['tanggal_lapangan'], 'php:d F Y')) ?></dd>
                    </dl>
                <?php else: ?>
                    <p class="text-muted fst-italic">Belum ada data Berita Acara Pemeriksaan.</p>
                <?php endif; ?>

                <div class="d-flex justify-content-start gap-2">
                    <?= Html::a('Edit', ['update', 'id' => $model['id']], ['class' => 'btn btn-outline-primary hover-bg hover-white ']) ?>
                    <?= Html::a('Cetak', ['cetak', 'id' => $model['id']], [
                        'class' => 'btn btn-outline-info hover-bg-info hover-white',
                        'target' => '_blank'
                    ]) ?>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>

<style>
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

    /* CSS UNTUK GOOGLE AUTOCOMPLETE */
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
// (FIX) JAVASCRIPT AUTOCOMPLETE DITAMBAHKAN DI SINI
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
$this->registerJs($jsAutocomplete, \yii\web\View::POS_READY, 'bap-autocomplete-handler');
?>