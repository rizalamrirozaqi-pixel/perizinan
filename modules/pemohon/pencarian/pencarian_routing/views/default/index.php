<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Pencarian Routing';
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
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Pencarian</span></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium"><?= Html::encode($this->title) ?></span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Cari Data Routing</h5>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">

                <?= Html::beginForm(['index'], 'get', [
                    'id' => 'form-search-routing',
                    'class' => 'table-src-form align-items-center w-100'
                ]) ?>

                <div class="col-md-5 position-relative">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y" style="padding-left: 12px; z-index: 10; color: #6c757d;">search</i>

                    <div id="autocomplete-container" class="position-relative" style="width: 400px;">

                        <?= Html::textInput('search', $search, [
                            'id' => 'search_routing',
                            'class' => 'form-control',
                            'style' => 'padding-left: 3rem;',
                            'placeholder' => 'Ketikkan Nomor Pendaftaran atau Nama Pemohon...',
                            'autocomplete' => 'off'
                        ]) ?>

                        <div id="autocomplete-results"
                            class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete">
                        </div>

                    </div>
                </div>

                <?= Html::endForm() ?>
            </div>

            <?php if ($isSearch): ?>
                <div class="default-table-area all-products mt-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Pendaftaran</th>
                                    <th>Nama Izin</th>
                                    <th>Jenis Permohonan</th>
                                    <th>Nama Pemohon</th>
                                    <th>Nama Usaha</th>
                                    <th>Lokasi Usaha</th>
                                    <th>Posisi Berkas</th>
                                    <th>Waktu Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody >
                                <?php if ($dataProvider->totalCount > 0): ?>
                                    <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                        <tr>
                                            <td><?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?></td>
                                            <td class=""><?= Html::encode($model['nomor_daftar']) ?></td>
                                            <td><?= Html::encode($model['nama_izin']) ?></td>
                                            <td><span class=""><?= Html::encode($model['jenis_permohonan']) ?></span></td>
                                            <td><?= Html::encode($model['nama_pemohon']) ?></td>
                                            <td><?= Html::encode($model['nama_usaha']) ?></td>
                                            <td><?= Html::encode($model['lokasi_usaha']) ?></td>
                                            <td>
                                                <span class="">
                                                    <?= Html::encode($model['status_posisi']) ?>
                                                </span>
                                            </td>
                                            <td><?= Html::encode(date('d/m/Y H:i', strtotime($model['waktu_daftar']))) ?></td>
                                            <td>
                                                <a href="#" class="text-primary fs-18" data-bs-toggle="tooltip" title="Lihat Detail">
                                                    <i class="material-symbols-outlined fs-16">visibility</i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-5 text-muted">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <i class="material-symbols-outlined fs-48 mb-2 text-secondary opacity-50">search_off</i>
                                                <span class="fw-medium">Data tidak ditemukan.</span>
                                                <span class="small">Coba gunakan kata kunci lain.</span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($dataProvider->totalCount > 0): ?>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-muted small">
                                Menampilkan <?= $dataProvider->getCount() ?> dari <?= $dataProvider->getTotalCount() ?> data
                            </span>
                            <?= LinkPager::widget([
                                'pagination' => $dataProvider->pagination,
                                'options' => ['class' => 'pagination pagination-sm mb-0'],
                                'linkContainerOptions' => ['class' => 'page-item'],
                                'linkOptions' => ['class' => 'page-link'],
                                'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                            ]) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<style>
    .google-autocomplete {
        max-height: 250px;
        border-bottom-left-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
        border: 1px solid #dee2e6;
        border-top: none;
    }

    .autocomplete-item-google {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid #f1f1f1;
        font-size: 0.9rem;
    }

    .autocomplete-item-google:last-child {
        border-bottom: none;
    }

    .autocomplete-item-google:hover {
        background-color: #f8f9fa;
    }

    /* (FIX) Pastikan lebar form konsisten dengan Pengambilan SK */
    .table-src-form .form-control {
        width: 100%;
    }
</style>

<?php
$autocompleteUrl = Url::to(['search-routing']);
$js = <<<JS
const searchInput = document.getElementById('search_routing');
const resultsBox = document.getElementById('autocomplete-results');
const searchForm = document.getElementById('form-search-routing');
const autocompleteUrl = '{$autocompleteUrl}';

function escapeRegExp(string) { if (typeof string !== 'string') return ''; return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\$&'); }
async function fetchResults(term) {
    if (term.length < 2) { resultsBox.innerHTML = ''; resultsBox.classList.add('d-none'); return; }
    try {
        const response = await fetch(autocompleteUrl + '?term=' + encodeURIComponent(term));
        if (!response.ok) throw new Error('Network error');
        const data = await response.json();
        displayResults(data, term);
    } catch (error) { console.error('Error:', error); resultsBox.classList.add('d-none'); }
}
function displayResults(data, term) {
    resultsBox.innerHTML = '';
    if (data.length === 0) { resultsBox.classList.remove('d-none'); resultsBox.innerHTML = '<div class="autocomplete-item-google text-muted fst-italic">Data tidak ditemukan</div>'; return; }
    resultsBox.classList.remove('d-none');
    const regex = new RegExp('(' + escapeRegExp(term) + ')', 'gi');
    data.forEach(item => {
        const div = document.createElement('div');
        div.className = 'autocomplete-item-google d-flex align-items-center';
        const label = item.label.replace(regex, '<strong class="text-primary">$1</strong>');
        div.innerHTML = '<i class="material-symbols-outlined fs-5 text-secondary me-2">description</i><span>' + label + '</span>';
        div.addEventListener('click', function() { searchInput.value = item.value; resultsBox.classList.add('d-none'); searchForm.submit(); });
        resultsBox.appendChild(div);
    });
}
if(searchInput) { searchInput.addEventListener('input', function() { fetchResults(this.value); }); }
document.addEventListener('click', function(e) { if (searchInput && !searchInput.contains(e.target) && resultsBox && !resultsBox.contains(e.target)) { resultsBox.classList.add('d-none'); } });
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>