<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Berkas Keluar Arsip';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Berkas Keluar', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Berkas Keluar</span></li>
                <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <!-- SEARCH -->
            <div class="d-flex justify-content-start align-items-center flex-wrap gap-2 mb-4">
                <?= Html::beginForm(['index'], 'get', [
                    'id' => 'form-search-keluar-arsip',
                    'class' => 'table-src-form align-items-center w-100'
                ]) ?>

                <div class="col-md-5 position-relative">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y"
                        style="padding-left: 12px; z-index: 10; color: #6c757d;">
                        search
                    </i>

                    <div id="autocomplete-container" class="position-relative" style="width: 400px;">

                        <?= Html::textInput('search', $search, [
                            'id' => 'search_keluar_arsip',
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

            <!-- TABEL -->
            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle" style="font-size: 0.9rem;">
                        <thead class="table-light text-center text-uppercase align-middle">
                            <tr>
                                <th width="5%">No</th>
                                <th width="5%">Log</th>
                                <th>Nomor Daftar</th>
                                <th>Nama Izin</th>
                                <th>Nama Permohonan</th>
                                <th>Nama Pemohon</th>
                                <th>Kirim Ke</th>
                                <th>Tanggal Kirim</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($dataProvider->totalCount > 0): ?>
                                <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                    <tr>
                                        <td class="text-center text-secondary">
                                            <?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?>
                                        </td>

                                        <td class="text-center">
                                            <a href="#"
                                                data-bs-toggle="tooltip"
                                                data-bs-title="Lihat Log Berkas">
                                                <i class="material-symbols-outlined fs-18 text-info text-primary">history</i>
                                            </a>
                                        </td>

                                        <td class="text-center text-primary">
                                            <?= Html::encode($model['nomor_daftar']) ?>
                                        </td>

                                        <td><?= Html::encode($model['nama_izin'] ?? '') ?></td>
                                        <td><?= Html::encode($model['nama_permohonan'] ?? '') ?></td>
                                        <td><?= Html::encode($model['nama_pemohon'] ?? '') ?></td>
                                        <td><?= Html::encode($model['kirim_ke'] ?? '') ?></td>
                                        <td class="text-center"><?= Html::encode($model['tanggal_kirim'] ?? '') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        Data tidak ditemukan.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

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
            </div>

        </div>
    </div>
</div>

<style>
    .google-autocomplete {
        max-height: 250px;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 0.375rem 0.375rem;
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
</style>

<?php
$autocompleteUrl = Url::to(['search-arsip']);

$js = <<<JS
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});

const searchInput = document.getElementById('search_keluar_arsip');
const resultsBox  = document.getElementById('autocomplete-results');
const searchForm  = document.getElementById('form-search-keluar-arsip');
const autocompleteUrl = '{$autocompleteUrl}';

function escapeRegExp(string) {
    if (typeof string !== 'string') return '';
    return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\$&');
}

async function fetchResults(term) {
    if (term.length < 2) {
        resultsBox.innerHTML = '';
        resultsBox.classList.add('d-none');
        return;
    }
    try {
        const response = await fetch(autocompleteUrl + '?term=' + encodeURIComponent(term));
        if (!response.ok) throw new Error('Network error');
        const data = await response.json();
        displayResults(data, term);
    } catch (error) {
        console.error('Error:', error);
        resultsBox.classList.add('d-none');
    }
}

function displayResults(data, term) {
    resultsBox.innerHTML = '';
    if (data.length === 0) {
        resultsBox.classList.remove('d-none');
        resultsBox.innerHTML =
            '<div class="autocomplete-item-google text-muted fst-italic">Data tidak ditemukan</div>';
        return;
    }
    resultsBox.classList.remove('d-none');
    const regex = new RegExp('(' + escapeRegExp(term) + ')', 'gi');
    data.forEach(item => {
        const div = document.createElement('div');
        div.className = 'autocomplete-item-google';
        div.innerHTML = item.label.replace(regex, '<strong class="text-primary">$1</strong>');
        div.addEventListener('click', function() {
            searchInput.value = item.value;
            resultsBox.classList.add('d-none');
            searchForm.submit();
        });
        resultsBox.appendChild(div);
    });
}

if (searchInput) {
    searchInput.addEventListener('input', function() {
        fetchResults(this.value);
    });
}

document.addEventListener('click', function(e) {
    if (searchInput && !searchInput.contains(e.target) &&
        resultsBox && !resultsBox.contains(e.target)) {
        resultsBox.classList.add('d-none');
    }
});
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
?>