<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var array $models
 * @var yii\data\Pagination $pagination
 * @var array $searchModel Params from search form
 * @var array $hasilItems Dropdown items for 'Hasil'
 * @var array $kasiItems Dropdown items for 'Kasi Perizinan'
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Verifikasi dan Validasi';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = 'Verifikasi Izin';
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Back Office</span></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Verifikasi Izin</span></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Verifikasi dan Validasi</h5>

            <?= Html::beginForm(['index'], 'get', ['id' => 'form-search-verifikasi']) ?>
            <?= Html::beginForm(['update'], 'post', ['id' => 'form-update-verifikasi']) ?>
            <?= Html::hiddenInput('verification_id', null, ['id' => 'edit-verification-id']) ?>
            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

            <div class="row g-3 mb-3 align-items-start">

                <div class="col-md-5">
                    <?= Html::label('Pencarian Canggih:', 'searchmodel-pencarian', [
                        'class' => 'form-label',
                        'id' => 'label-searchmodel-pencarian'
                    ]) ?>

                    <div id="autocomplete-container" class="position-relative">
                        <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y" style="padding-left: 12px; z-index: 10; color: #6c757d;">search</i>

                        <?= Html::textInput('SearchModel[pencarian]', $searchModel['pencarian'], [
                            'id' => 'searchmodel-pencarian',
                            'class' => 'form-control',
                            'style' => 'padding-left: 3rem;',
                            'placeholder' => '(Ketikkan No Daftar, Nama Pemohon, No Verifikasi)',
                            'form' => 'form-search-verifikasi',
                            'autocomplete' => 'off'
                        ]) ?>

                        <div id="autocomplete-results"
                            class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?= Html::label('Hasil', 'searchmodel-hasil', ['class' => 'form-label']) ?>
                    <?= Html::dropDownList('SearchModel[hasil]', $searchModel['hasil'], $hasilItems, [
                        'id' => 'searchmodel-hasil',
                        'prompt' => '-- Semua Hasil --',
                        'class' => 'form-select form-control',
                        'form' => 'form-search-verifikasi form-update-verifikasi',
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <?= Html::label('Kasi Perizinan', 'searchmodel-kasi_perizinan', ['class' => 'form-label']) ?>
                    <?= Html::dropDownList('SearchModel[kasi_perizinan]', $searchModel['kasi_perizinan'], $kasiItems, [
                        'id' => 'searchmodel-kasi_perizinan',
                        'prompt' => '-- Semua Kasi --',
                        'class' => 'form-select form-control',
                        'form' => 'form-search-verifikasi form-update-verifikasi',
                    ]) ?>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <?= Html::label('Keterangan/Catatan', 'searchmodel-keterangan', ['class' => 'form-label']) ?>
                    <?= Html::textarea('SearchModel[keterangan]', $searchModel['keterangan'] ?? null, [
                        'id' => 'searchmodel-keterangan',
                        'class' => 'form-control',
                        'rows' => 2,
                        'placeholder' => 'Isikan keterangan atau catatan verifikasi...',
                        // (FIX) 'form' diubah agar terikat ke form-search-verifikasi (GET) 
                        // dan form-update-verifikasi (POST)
                        'form' => 'form-search-verifikasi form-update-verifikasi',
                    ]) ?>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <?= Html::submitButton('Cari', ['class' => 'btn btn-outline-info hover-white hover-bg-info', 'form' => 'form-search-verifikasi']) ?>
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'id' => 'btn-simpan-edit', 'form' => 'form-update-verifikasi', 'style' => 'display: none;']) ?>
                <button type="button" class="btn btn-secondary" id="btn-cancel-edit" style="display: none;">Batal Edit</button>
            </div>
            <?= Html::endForm() ?>
            <?= Html::endForm() ?>
        </div>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Pencarian Hasil Verifikasi</h5>

            <?php
            // (FIX) Ambil parameter GET yang ada
            $existingParams = Yii::$app->request->get();
            // Hapus 'pencarian' dari parameter yang ada agar tidak duplikat dengan input di bawah
            if (isset($existingParams['SearchModel']['pencarian'])) {
                unset($existingParams['SearchModel']['pencarian']);
            }
            ?>
            <?= Html::beginForm(['index'], 'get', [
                'id' => 'form-search-autocomplete', // <-- ID Form unik
                'class' => 'table-src-form align-items-center'
            ] + $existingParams) // <-- (FIX) Gunakan parameter yang sudah bersih
            ?>
            <div class="col-md-5 position-relative">
                <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y" style="padding-left: 12px; z-index: 10; color: #6c757d;">search</i>
                <div id="autocomplete-container-2" class="position-relative" style="width: 400px;">

                    <?= Html::textInput('SearchModel[pencarian]', $searchModel['pencarian'], [
                        'id' => 'search-autocomplete-input', // <-- ID Input unik
                        'class' => 'form-control',
                        'style' => 'padding-left: 3rem;',
                        'placeholder' => 'Ketikkan No Daftar, Nama, atau No Verifikasi...',
                        'autocomplete' => 'off'
                    ]) ?>

                    <div id="autocomplete-results-2"
                        class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete">
                    </div>

                </div>
            </div>
            <?= Html::endForm() ?>
            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="text-nowrap">No</th>
                                <th class="text-nowrap">Nomor Verifikasi</th>
                                <th class="text-nowrap">Nama Pemohon</th>
                                <th class="text-nowrap">Jenis Izin</th>
                                <th class="text-nowrap">Jenis Permohonan</th>
                                <th class="text-nowrap">Hasil</th>
                                <th class="text-nowrap">Keterangan/Catatan</th>
                                <th class="text-nowrap">Kasi Perizinan</th>
                                <th class="text-nowrap">Tanggal Cetak</th>
                                <th class="text-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($models)): ?>
                                <tr>
                                    <td colspan="11" class="text-center text-muted fst-italic">Data tidak ditemukan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($models as $index => $model): ?>
                                    <tr data-verification-id="<?= $model['id'] ?? 'row-' . $index ?>">
                                        <td class="text-center text-secondary"><?= $pagination->page * $pagination->pageSize + $index + 1 ?></td>
                                        <td class="text-secondary"><?= Html::encode($model['nomor_verifikasi'] ?? '-') ?></td>
                                        <td class="text-secondary"><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['jenis_izin'] ?? '-') ?></td>
                                        <td><?= Html::encode($model['jenis_permohonan'] ?? '-') ?></td>
                                        <td class="text-center">
                                            <?php
                                            $hasil_id = $model['hasil_id'] ?? '';
                                            $hasilClass = 'bg-secondary bg-opacity-10 text-secondary';
                                            if ($hasil_id === 'Diterima') $hasilClass = 'bg-success bg-opacity-10 text-success';
                                            elseif ($hasil_id === 'Ditolak') $hasilClass = 'bg-danger bg-opacity-10 text-danger';
                                            elseif ($hasil_id === 'Direvisi') $hasilClass = 'bg-warning bg-opacity-10 text-warning';
                                            ?>
                                            <span class="badge <?= $hasilClass ?> p-2 fs-12 fw-normal"><?= Html::encode($model['hasil'] ?? '-') ?></span>
                                        </td>
                                        <td><?= Html::encode($model['keterangan'] ?? '-') ?></td>
                                        <td class="text-secondary"><?= Html::encode($model['kasi_perizinan'] ?? '-') ?></td>
                                        <td class="text-center text-secondary text-nowrap">
                                            <?= !empty($model['tanggal_cetak']) ? Html::encode(Yii::$app->formatter->asDate($model['tanggal_cetak'], 'php:d-m-Y')) : '-' ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <?php
                                                $status_upload = $model['upload_rekom_status'] ?? false;
                                                $id = $model['id'] ?? '#';
                                                $filename = $model['upload_rekom_filename'] ?? 'file';
                                                ?>

                                                <?= Html::a(
                                                    '<i class="material-symbols-outlined fs-18">upload_file</i>',
                                                    ['upload-rekom', 'id' => $id],
                                                    [
                                                        'class' => 'text-decoration-none ' . ($status_upload ? 'text-success' : 'text-secondary'),
                                                        'data-bs-toggle' => 'tooltip',
                                                        'data-bs-title' => $status_upload ? 'Upload Ulang (Ganti File)' : 'Upload File Rekom',
                                                    ]
                                                ) ?>

                                                <?php
                                                $downloadOptions = [
                                                    'class' => 'text-decoration-none',
                                                    'data-bs-toggle' => 'tooltip',
                                                ];
                                                if ($status_upload) {
                                                    $downloadHref = ['download-rekom', 'id' => $id];
                                                    $downloadOptions['class'] .= ' text-primary';
                                                    $downloadOptions['data-bs-title'] = 'Download: ' . Html::encode($filename);
                                                } else {
                                                    $downloadHref = '#';
                                                    $downloadOptions['class'] .= ' text-secondary disabled';
                                                    $downloadOptions['data-bs-title'] = 'File tidak tersedia';
                                                    $downloadOptions['aria-disabled'] = 'true';
                                                    $downloadOptions['tabindex'] = '-1';
                                                }
                                                echo Html::a(
                                                    '<i class="material-symbols-outlined fs-18">download</i>',
                                                    $downloadHref,
                                                    $downloadOptions
                                                );
                                                ?>

                                                <?= Html::a(
                                                    '<i class="material-symbols-outlined fs-16">edit</i>',
                                                    'javascript:void(0);',
                                                    [
                                                        'class' => 'text-primary btn-edit-verifikasi',
                                                        'data-bs-toggle' => 'tooltip',
                                                        'data-bs-title' => 'Edit Verifikasi',
                                                        'data-id' => $model['id'] ?? '',
                                                        'data-hasil' => Html::encode($model['hasil_id'] ?? ''),
                                                        'data-keterangan' => Html::encode($model['keterangan'] ?? ''),
                                                        'data-kasi' => Html::encode($model['kasi_perizinan_id'] ?? ''),
                                                        'data-nomor' => Html::encode($model['nomor_verifikasi'] ?? ''),
                                                        'data-search' => Html::encode($model['nomor_daftar'] ?? ''), // (FIX) Kirim nomor daftar
                                                    ]
                                                ) ?>
                                                <?= Html::a(
                                                    '<i class="material-symbols-outlined fs-16">visibility</i>',
                                                    ['detail', 'id' => $model['id'] ?? '#'],
                                                    ['class' => 'text-info', 'target' => '_blank', 'data-bs-toggle' => 'tooltip', 'data-bs-title' => 'Lihat Detail',]
                                                ) ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 mt-4">
                    <span class="fs-13 fw-medium text-secondary"> Menampilkan <b><?= count($models) ?></b> dari <b><?= $pagination->totalCount ?></b> data </span>
                    <div class="d-flex align-items-center">
                        <?= LinkPager::widget([
                            'pagination' => $pagination,
                            'options' => ['class' => 'pagination pagination-sm mb-0 justify-content-center'],
                            'linkContainerOptions' => ['class' => 'page-item'],
                            'linkOptions' => ['class' => 'page-link'],
                            'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                            'activePageCssClass' => 'active',
                            'prevPageCssClass' => 'page-item',
                            'nextPageCssClass' => 'page-item',
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

<?php
// (FIX) Modifikasi JavaScript Handler (Edit in-place)
$js = <<<JS
// Initialize Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) { return new bootstrap.Tooltip(tooltipTriggerEl); });

// Edit Button Handler
$('.btn-edit-verifikasi').on('click', function() {
    const btn = $(this);
    const id = btn.data('id');
    const hasil = btn.data('hasil');
    const keterangan = btn.data('keterangan');
    const kasi = btn.data('kasi');
    const nomor = btn.data('nomor');
    const searchVal = btn.data('search'); // (FIX) Ambil nomor daftar

    // Populate the form fields
    $('#edit-verification-id').val(id);
    $('#searchmodel-hasil').val(hasil).trigger('change');
    $('#searchmodel-keterangan').val(keterangan);
    $('#searchmodel-kasi_perizinan').val(kasi).trigger('change');

    // (FIX) Ubah label dan isi field pencarian
    $('#label-searchmodel-pencarian').text('Nomor Pendaftaran:'); // Ganti label
    $('#searchmodel-pencarian').val(searchVal).prop('disabled', true); // Isi value (No Daftar) dan disable

    // Adjust UI: Sembunyikan tombol Cari, tampilkan Simpan/Batal
    $('button[form="form-search-verifikasi"]').hide();
    $('#btn-simpan-edit').show();
    $('#btn-cancel-edit').show();

    // Scroll to top
    $('html, body').animate({ scrollTop: 0 }, 'fast');

    // Highlight row (optional)
    $('tr[data-verification-id]').removeClass('table-active');
    btn.closest('tr').addClass('table-active');
});

// Cancel Edit Button Handler
$('#btn-cancel-edit').on('click', function() {
    // Clear form
    $('#edit-verification-id').val('');
    $('#searchmodel-hasil').val('').trigger('change');
    $('#searchmodel-keterangan').val('');
    $('#searchmodel-kasi_perizinan').val('').trigger('change');

    // (FIX) Kembalikan label dan field pencarian ke kondisi semula
    $('#label-searchmodel-pencarian').text('Pencarian Canggih:'); // Kembalikan label
    // (FIX) Ambil nilai pencarian asli (jika ada) dari URL, atau kosongkan
    const originalSearch = new URLSearchParams(window.location.search).get('SearchModel[pencarian]') || '';
    $('#searchmodel-pencarian').val(originalSearch).prop('disabled', false); 

    // Adjust UI: Tampilkan tombol Cari, sembunyikan Simpan/Batal
    $('button[form="form-search-verifikasi"]').show();
    $('#btn-simpan-edit').hide();
    $('#btn-cancel-edit').hide();

    // Remove highlight
    $('tr[data-verification-id]').removeClass('table-active');
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'verifikasi-izin-edit-handler');
?>

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

    .badge {
        font-size: 0.75rem;
    }

    .table-active,
    .table-active>th,
    .table-active>td {
        background-color: #cfe2ff !important;
    }

    /* (FIX) CSS UNTUK GOOGLE AUTOCOMPLETE */
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

// (FIX) Ganti ID-nya agar sesuai HTML
const searchInput = document.getElementById('searchmodel-pencarian'); 
const resultsBox = document.getElementById('autocomplete-results');
const searchForm = document.getElementById('form-search-verifikasi'); // (FIX) Sesuaikan ID Form
const autocompleteUrl = '{$autocompleteUrl}';

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
    
    // (FIX) Jangan fetch jika input di-disable (mode edit)
    if(searchInput && searchInput.disabled) {
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
$this->registerJs($jsAutocomplete, \yii\web\View::POS_READY, 'bap-autocomplete-handler');
?>

<?php
// (FIX) Flash messages (toast) DITAMBAHKAN
$flashMessages = Yii::$app->session->getAllFlashes();
if (!empty($flashMessages)) {
    foreach ($flashMessages as $key => $message) {
        $icon = 'info';
        if ($key === 'success') $icon = 'success';
        elseif ($key === 'error' || $key === 'danger') $icon = 'error';
        elseif ($key === 'warning') $icon = 'warning';

        $encodedMessage = \yii\helpers\Json::encode($message);
        $js = <<<JS
            Swal.fire({
                icon: '{$icon}',
                title: {$encodedMessage},
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        JS;
        $this->registerJs($js, \yii\web\View::POS_READY, 'flash-sweetalert-' . $key);
    }
}
?>


<?php
// (FIX) JAVASCRIPT BARU UNTUK SEARCH BOX DI ATAS TABEL
$autocompleteUrl = Url::to(['search-pendaftaran']); // Kita pakai action yang sudah ada

$jsAutocompleteTable = <<<JS

// (FIX) ID elemen UNIK untuk search box baru
const searchInput2 = document.getElementById('search-autocomplete-input');
const resultsBox2 = document.getElementById('autocomplete-results-2');
const searchForm2 = document.getElementById('form-search-autocomplete');
const autocompleteUrl2 = '{$autocompleteUrl}';

// (FIX) Nama fungsi UNIK
function escapeRegExp2(string) {
    if (typeof string !== 'string') {
        return '';
    }
    return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\$&');
}

// (FIX) Nama fungsi UNIK
async function fetchResults2(term) {
    if (term.length < 2) {
        if(resultsBox2) resultsBox2.innerHTML = '';
        if(resultsBox2) resultsBox2.classList.add('d-none');
        return;
    }
    
    try {
        const response = await fetch(autocompleteUrl2 + '?term=' + encodeURIComponent(term));
        if (!response.ok) throw new Error('Network error');
        const data = await response.json();
        displayResults2(data, term);
    } catch (error) {
        console.error('Error fetching autocomplete 2:', error);
        if(resultsBox2) resultsBox2.innerHTML = '';
        if(resultsBox2) resultsBox2.classList.add('d-none');
    }
}

// (FIX) Nama fungsi UNIK
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
        
        itemDiv.innerHTML = '<i class="material-symbols-outlined">search</i>' + 
                            '<span>' + highlightedLabel + '</span>';
        
        itemDiv.addEventListener('click', function(e) {
            e.preventDefault(); 
            if(searchInput2) searchInput2.value = item.value; // Isi input
            if(resultsBox2) resultsBox2.classList.add('d-none');
            if(searchForm2) searchForm2.submit(); // Submit form
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
$this->registerJs($jsAutocompleteTable, \yii\web\View::POS_READY, 'table-autocomplete-handler');
?>

<?php
// (FIX) DUA BLOK JAVASCRIPT KOSONG/DUPLIKAT DI BAWAH INI TELAH DIHAPUS
// Blok 'verifikasi-izin-edit-handler' yang kosong telah dihapus
// Blok 'bap-autocomplete-handler' yang kosong telah dihapus
?>