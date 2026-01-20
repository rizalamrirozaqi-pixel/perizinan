<?php

/**
 * @var yii\web\View $this
 * @var array $searchParams
 * @var array $dropdowns
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var array $models
 * @var bool $isSearch
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Pencarian Pendaftaran';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/pemohon/dashboard/index']];
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
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Pencarian</span></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium"><?= Html::encode($this->title) ?></span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-header bg-transparent border-bottom p-4">
            <h5 class="card-title mb-0 fw-bold text-primary">FORM PENCARIAN</h5>
        </div>
        <div class="card-body p-4">

            <?= Html::beginForm(['index'], 'get', ['class' => 'row g-3']) ?>

            <div class="col-md-12">
                <label class="form-label fw-medium">Nomor Pendaftaran</label>
                <div id="autocomplete-container" class="position-relative">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary" style="z-index: 5;">search</i>
                    <?= Html::textInput('Search[nomor_daftar]', $searchParams['nomor_daftar'] ?? '', [
                        'id' => 'search_nomor',
                        'class' => 'form-control ps-5', // Padding left biar gak nabrak ikon
                        'placeholder' => 'Ketik Nomor Pendaftaran...',
                        'autocomplete' => 'off'
                    ]) ?>
                    <div id="autocomplete-results" class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete"></div>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium">Jenis Izin</label>
                <?= Html::dropDownList('Search[jenis_izin]', $searchParams['jenis_izin'] ?? '', $dropdowns['jenis_izin'], ['class' => 'form-select form-control', 'prompt' => '-- Pilih Jenis Izin --']) ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">Jenis Permohonan</label>
                <?= Html::dropDownList('Search[jenis_permohonan]', $searchParams['jenis_permohonan'] ?? '', $dropdowns['jenis_permohonan'], ['class' => 'form-select form-control', 'prompt' => '-- Pilih Jenis Permohonan --']) ?>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium">Nama Pemohon</label>
                <?= Html::textInput('Search[nama_pemohon]', $searchParams['nama_pemohon'] ?? '', ['class' => 'form-control']) ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">Nama Usaha</label>
                <?= Html::textInput('Search[nama_usaha]', $searchParams['nama_usaha'] ?? '', ['class' => 'form-control']) ?>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium">Nomor KTP/NPWP</label>
                <?= Html::textInput('Search[no_ktp_npwp]', $searchParams['no_ktp_npwp'] ?? '', ['class' => 'form-control']) ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">Nomor Telepon</label>
                <?= Html::textInput('Search[telepon]', $searchParams['telepon'] ?? '', ['class' => 'form-control']) ?>
            </div>

            <div class="col-12">
                <label class="form-label fw-medium">Alamat</label>
                <?= Html::textarea('Search[alamat]', $searchParams['alamat'] ?? '', ['class' => 'form-control', 'rows' => 2]) ?>
            </div>

            <div class="col-12">
                <label class="form-label fw-medium">Lokasi / Usaha / Bangunan</label>
                <?= Html::textInput('Search[lokasi_usaha]', $searchParams['lokasi_usaha'] ?? '', ['class' => 'form-control']) ?>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium">Kecamatan</label>
                <?= Html::dropDownList('Search[kecamatan]', $searchParams['kecamatan'] ?? '', $dropdowns['kecamatan'], ['class' => 'form-select form-control', 'prompt' => '-- Pilih Kecamatan --']) ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">Kelurahan</label>
                <?= Html::dropDownList('Search[kelurahan]', $searchParams['kelurahan'] ?? '', $dropdowns['kelurahan'], ['class' => 'form-select form-control', 'prompt' => '-- Pilih Kelurahan --']) ?>
            </div>

            <div class="col-12">
                <label class="form-label fw-medium">Keterangan</label>
                <?= Html::textarea('Search[keterangan]', $searchParams['keterangan'] ?? '', ['class' => 'form-control', 'rows' => 2]) ?>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium">Dari Tanggal</label>
                <?= Html::input('date', 'Search[tgl_awal]', $searchParams['tgl_awal'] ?? '', ['class' => 'form-control']) ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">Sampai Tanggal</label>
                <?= Html::input('date', 'Search[tgl_akhir]', $searchParams['tgl_akhir'] ?? '', ['class' => 'form-control']) ?>
            </div>

            <div class="col-12 mt-4 d-flex gap-2">
                <?= Html::submitButton('<i class="material-symbols-outlined fs-18 me-1">search</i> Cari', ['class' => 'btn btn-primary px-4 d-flex align-items-center']) ?>
                <a href="<?= Url::to(['index']) ?>" class="btn btn-outline-secondary px-4">Reset</a>
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>

    <?php if ($isSearch): ?>
        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm animate__animated animate__fadeIn">
            <div class="card-header bg-transparent border-bottom p-4">
                <h5 class="card-title mb-0 fw-bold text-primary">HASIL PENCARIAN PENDAFTARAN</h5>
            </div>
            <div class="card-body p-4">

                <div class="default-table-area all-products">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="12%">Nomor Daftar</th>
                                    <th>Nama Izin</th>
                                    <th>Nama Permohonan</th>
                                    <th>Nama Pemohon</th>
                                    <th>Nama Usaha</th>
                                    <th>Lokasi</th>
                                    <th>Kecamatan</th>
                                    <th>Kelurahan</th>
                                    <th width="15%">Waktu Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($dataProvider->totalCount > 0): ?>
                                    <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                        <tr>
                                            <td class=""><?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?></td>
                                            <td class=""><?= Html::encode($model['nomor_daftar']) ?></td>
                                            <td><?= Html::encode($model['nama_izin']) ?></td>
                                            <td class=""><span class=""><?= Html::encode($model['jenis_permohonan']) ?></span></td>
                                            <td><?= Html::encode($model['nama_pemohon']) ?></td>
                                            <td><?= Html::encode($model['nama_usaha']) ?></td>
                                            <td><?= Html::encode($model['lokasi_usaha']) ?></td>
                                            <td class=""><?= Html::encode($dropdowns['kecamatan'][$model['kecamatan']] ?? $model['kecamatan']) ?></td>
                                            <td class=""><?= Html::encode($dropdowns['kelurahan'][$model['kelurahan']] ?? $model['kelurahan']) ?></td>
                                            <td class=""><?= Html::encode($model['waktu_daftar']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-4 text-muted">Data tidak ditemukan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if ($dataProvider->totalCount > 0): ?>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-muted small">Menampilkan <?= $dataProvider->getCount() ?> dari <?= $dataProvider->getTotalCount() ?> data</span>

                        <?= LinkPager::widget([
                            'pagination' => $dataProvider->pagination, // <-- Gunakan dataProvider->pagination
                            'options' => ['class' => 'pagination pagination-sm mb-0'],
                            'linkContainerOptions' => ['class' => 'page-item'],
                            'linkOptions' => ['class' => 'page-link'],
                            'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                        ]) ?>

                    </div>
                <?php endif; ?>

            </div>
        </div>
    <?php endif; ?>

</div>

<style>
    .google-autocomplete {
        max-height: 250px;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 0.375rem 0.375rem;
    }

    .autocomplete-item-google {
        padding: 8px 15px;
        cursor: pointer;
        border-bottom: 1px solid #f1f1f1;
        font-size: 0.9rem;
    }

    .autocomplete-item-google:hover {
        background-color: #f8f9fa;
    }
</style>

<?php
// JS Autocomplete (Khusus field Nomor Pendaftaran)
$autocompleteUrl = Url::to(['search-autocomplete']);

$js = <<<JS
const searchInput = document.getElementById('search_nomor');
const resultsBox = document.getElementById('autocomplete-results');
const autocompleteUrl = '{$autocompleteUrl}';

function escapeRegExp(string) {
    if (typeof string !== 'string') return '';
    return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\$&');
}

async function fetchResults(term) {
    if (term.length < 2) { resultsBox.innerHTML = ''; resultsBox.classList.add('d-none'); return; }
    try {
        const response = await fetch(autocompleteUrl + '?term=' + encodeURIComponent(term));
        const data = await response.json();
        
        resultsBox.innerHTML = '';
        if (data.length === 0) { 
            resultsBox.classList.add('d-none'); 
        } else {
            resultsBox.classList.remove('d-none');
            
            const regex = new RegExp('(' + escapeRegExp(term) + ')', 'gi');

            data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'autocomplete-item-google';
                
                // Highlight text
                const label = item.label.replace(regex, '<strong class="text-primary">$1</strong>');
                div.innerHTML = label;

                div.addEventListener('click', function() {
                    searchInput.value = item.value;
                    resultsBox.classList.add('d-none');
                });
                resultsBox.appendChild(div);
            });
        }
    } catch (error) { resultsBox.classList.add('d-none'); }
}

if(searchInput) {
    searchInput.addEventListener('input', function() { fetchResults(this.value); });
}
document.addEventListener('click', function(e) {
    if (searchInput && !searchInput.contains(e.target) && resultsBox && !resultsBox.contains(e.target)) {
        resultsBox.classList.add('d-none');
    }
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>