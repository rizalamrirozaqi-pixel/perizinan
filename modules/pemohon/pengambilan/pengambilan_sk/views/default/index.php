<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var string|null $search_pendaftaran
 * @var string|null $filter_data
 * @var array|null $modelPendaftaran Data Pendaftaran
 * @var array|null $modelPengambilan Data Pengambilan (bisa null)
 * @var bool $isSearch (true jika $modelPendaftaran ada)
 * @var yii\data\ArrayDataProvider $dataProvider (untuk grid bawah)
 * @var array $models
 * @var yii\data\Pagination $pagination
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;

$this->title = 'Pengambilan SK';
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
                <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
            </ol>
        </nav>
    </div>

    <!-- Card Search Pendaftaran -->
    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Pencarian Cepat</h5>
            <?= Html::beginForm(['index'], 'get', [
                'id' => 'form-search-pendaftaran',
                'class' => 'table-src-form position-relative me-0'
            ]) ?>
            <?= Html::hiddenInput('filter_data', $filter_data) ?>
            <div class="col-md-5 position-relative">
                <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                <?= Html::textInput('search_pendaftaran', $search_pendaftaran, [
                    'id' => 'search_pendaftaran',
                    'class' => 'form-control ',
                    'style' => 'width: 450px;',
                    'placeholder' => 'Ketikkan Nomor Pendaftaran atau Nama Pemohon/Usaha',
                    'aria-label' => 'Pencarian Pendaftaran',
                    'autocomplete' => 'off', 
                ]) ?>
                <div id="autocomplete-results-pendaftaran"
                    class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete"
                    style="width: 450px;">
                </div>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>

    <!-- Tampilkan hanya jika pencarian pendaftaran berhasil -->
    <?php if ($isSearch && $modelPendaftaran !== null): ?>

        <!-- Card Menu Penyerahan SK (Form Entry) -->
        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Menu Penyerahan SK</h5>

                <?= Html::beginForm(['simpan-penyerahan', 'pendaftaran_id' => $modelPendaftaran['id']], 'post', ['id' => 'form-penyerahan']) ?>

                <!-- Info Berkas Izin (Read Only) -->
                <div class="row gx-5 mb-3">
                    <div class="col-md-6">
                        <dl class="row mb-0 definition-list-styled">
                            <dt class="col-sm-5">Nomor Pendaftaran</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span>
                                <?= Html::a(Html::encode($modelPendaftaran['nomor_daftar'] ?? '-'), ['tanda-terima', 'pendaftaran_id' => $modelPendaftaran['id'] ?? '#'], [
                                    'class' => 'text-primary text-decoration-none',
                                    'target' => '_blank',
                                    'data-bs-toggle' => 'tooltip',
                                    'data-bs-title' => 'Cetak Tanda Terima'
                                ]) ?>
                                <?= Html::a(
                                    '<i class="material-symbols-outlined fs-18">history</i>',
                                    ['log', 'pendaftaran_id' => $modelPendaftaran['id'] ?? '#'],
                                    ['class' => 'ms-2 fw-bold text-secondary', 'target' => '_blank', 'data-bs-toggle' => 'tooltip', 'data-bs-title' => 'Lihat Lembar Kendali']
                                ) ?>
                            </dd>
                            <dt class="col-sm-5">Jenis Izin</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['nama_izin'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Nama Pemohon</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['nama_pemohon'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Nama Usaha</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['nama_usaha'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Nomor KTP/NPWP</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['no_ktp_npwp'] ?? '-') ?></dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row mb-0 definition-list-styled">
                            <dt class="col-sm-5">Alamat</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['alamat'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Nomor Telepon</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['telepon'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Lokasi Usaha / Bangunan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['lokasi_usaha'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Kecamatan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['kecamatan'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Kelurahan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['kelurahan'] ?? '-') ?></dd>
                        </dl>
                    </div>
                </div>

                <!-- Form Input Penyerahan -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <?= Html::label('Penyerahan SK kepada sdr/i', 'nama_pengambil', ['class' => 'form-label']) ?>
                        <?= Html::textInput('nama_pengambil', $modelPengambilan['nama_pengambil'] ?? $modelPendaftaran['nama_pemohon'], ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-3">
                        <?= Html::label('Diambil pada tanggal', 'tanggal_diambil', ['class' => 'form-label']) ?>
                        <?= Html::textInput('tanggal_diambil', !empty($modelPengambilan['tanggal_diambil']) ? Yii::$app->formatter->asDate($modelPengambilan['tanggal_diambil'], 'php:Y-m-d') : date('Y-m-d'), ['class' => 'form-control form-control-sm', 'type' => 'date']) ?>
                    </div>
                    <div class="col-md-3">
                        <?= Html::label('Yang Menyerahkan (Petugas)', 'yang_menyerahkan', ['class' => 'form-label']) ?>
                        <?= Html::textInput('yang_menyerahkan', $modelPengambilan['yang_menyerahkan'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="d-flex justify-content-start gap-2 mt-3 pt-3 border-top">
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Batal', ['index'], ['class' => 'btn btn-secondary']) ?>
                </div>

                <?= Html::endForm() ?>
            </div>
        </div>

    <?php endif; ?> <!-- Tutup if ($isSearch && $modelPendaftaran !== null) -->


    <!-- Card Grid Laporan Penyerahan SK -->
    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Daftar Penyerahan SK</h5>

            <!-- Form Pencarian Laporan (Form Bawah) -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">
                <?= Html::beginForm(['index'], 'get', [
                    'id' => 'form-filter-laporan', // <-- (FIX) ID Form
                    'class' => 'table-src-form position-relative me-0',
                    'style' => 'max-width: 100%;',
                ]) ?>
                <?= Html::hiddenInput('search_pendaftaran', $search_pendaftaran) ?>

                <label for="filter_data" class="form-label mb-0 fw-medium me-2 d-none d-sm-inline-block">Filter Data:</label>
                <div class="position-relative d-inline-block">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                    <?= Html::textInput('filter_data', $filter_data, [
                        'id' => 'filter_data',
                        'class' => 'form-control ',
                        'style' => 'width: 400px;',
                        'placeholder' => 'Ketikkan Nomor Pendaftaran atau Nama Pemohon',
                        'aria-label' => 'Filter Data',
                        'autocomplete' => 'off', // <-- (FIX) Autocomplete off
                    ]) ?>
                    <!-- (FIX) Div untuk hasil -->
                    <div id="autocomplete-results-laporan"
                        class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete"
                        style="width: 400px;">
                    </div>
                </div>
                <?= Html::endForm() ?>
            </div>

            <!-- Tabel GridView (Manual) -->
            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="text-nowrap">No</th>
                                <th class="text-nowrap">Nomor Pendaftaran</th> <!-- PERBAIKAN -->
                                <th class="text-nowrap">Nama Pemohon</th>
                                <th class="text-nowrap">Nama Usaha</th>
                                <th class="text-nowrap">Jenis Izin</th> <!-- PERBAIKAN -->
                                <th class="text-nowrap">Nomor SK</th>
                                <th class="text-nowrap">Tanggal SK</th>
                                <th class="text-nowrap">Tanggal Habis Berlaku</th>
                                <th class="text-nowrap">Tanggal Diserahkan</th>
                                <th class="text-nowrap">Diterima Oleh</th>
                                <th class="text-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (empty($models)):
                            ?>
                                <tr>
                                    <td colspan="11" class="text-center text-muted fst-italic">Data Penyerahan tidak ditemukan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($models as $index => $model): ?>
                                    <tr>
                                        <td class="text-center"><?= $pagination->page * $pagination->pageSize + $index + 1 ?></td>

                                        <!-- (FIX) Bug fix: 'nomor_pendaftaran' diubah menjadi 'nomor_daftar' -->
                                        <td><?= Html::encode($model['nomor_daftar'] ?? '-') ?></td>

                                        <td><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['nama_usaha'] ?? '-') ?></td>

                                        <!-- (FIX) Bug fix: 'jenis_izin' diubah menjadi 'nama_izin' -->
                                        <td><?= Html::encode($model['nama_izin'] ?? '-') ?></td>

                                        <td><?= Html::encode($model['nomor_sk'] ?? '-') ?></td>
                                        <td class="text-center text-nowrap">
                                            <?= !empty($model['tanggal_sk']) ? Yii::$app->formatter->asDate($model['tanggal_sk'], 'php:d M Y') : '-' ?>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <?= !empty($model['tanggal_habis_berlaku']) ? Yii::$app->formatter->asDate($model['tanggal_habis_berlaku'], 'php:d M Y') : '-' ?>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <?= !empty($model['tanggal_diserahkan']) ? Yii::$app->formatter->asDate($model['tanggal_diserahkan'], 'php:d M Y') : '-' ?>
                                        </td>
                                        <td><?= Html::encode($model['diterima_oleh'] ?? '-') ?></td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <a href="<?= Url::to(['bukti-penerimaan', 'id' => $model['pengambilan_id'] ?? '#']) ?>"
                                                    class=""
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Cetak Bukti Penerimaan"
                                                    target="_blank">
                                                    <span class="material-symbols-outlined fs-18 text-info">print</span>
                                                </a>

                                                <a href="<?= Url::to(['pencabutan', 'id' => $model['pengambilan_id'] ?? '#']) ?>"
                                                    class=""
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Cabut Izin Ini">
                                                    <span class="material-symbols-outlined text-danger fs-18">block</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
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

<!-- (FIX) CSS Tambahan untuk Autocomplete -->
<style>
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
// JS untuk Tooltip
$js = <<<JS
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'tooltip-handler');
?>

<?php
// (FIX BARU) JAVASCRIPT UNTUK AUTOCOMPLETE PENDAFTARAN (FORM ATAS)
$autocompleteUrl1 = Url::to(['search-pendaftaran']);

$jsAutocomplete1 = <<<JS

// --- Blok Autocomplete 1: Pendaftaran (Form Atas) ---
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
// (FIX BARU) JAVASCRIPT UNTUK AUTOCOMPLETE LAPORAN (FORM BAWAH)
$autocompleteUrl2 = Url::to(['search-laporan']);

$jsAutocomplete2 = <<<JS

// --- Blok Autocomplete 2: Laporan (Form Bawah) ---
const searchInput2 = document.getElementById('filter_data'); 
const resultsBox2 = document.getElementById('autocomplete-results-laporan');
const searchForm2 = document.getElementById('form-filter-laporan');
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
$this->registerJs($jsAutocomplete2, \yii\web\View::POS_READY, 'laporan-autocomplete-handler');
?>