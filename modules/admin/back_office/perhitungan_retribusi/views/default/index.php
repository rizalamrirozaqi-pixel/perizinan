<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var string|null $search
 * @var array|null $model Data Pendaftaran
 * @var bool $isSearch
 * @var yii\data\ArrayDataProvider $rincianProvider
 * @var array $dropdownData (berisi 'tarifItems', 'indeksItems', 'koefisienItems')
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

$this->title = 'Perhitungan Retribusi';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = 'Perhitungan Retribusi';

// Hitung total untuk footer (karena kita akan butuh di 2 tempat)
$totalRetribusi = array_sum(ArrayHelper::getColumn($rincianProvider->getModels(), 'nilai_retribusi'));
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Back Office</span></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Perhitungan Retribusi</span></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">

                <?= Html::beginForm(['index'], 'get', [
                    'id' => 'form-search-retribusi',
                    'class' => 'table-src-form position-relative me-0',
                    'style' => 'max-width: 100%;'
                ]) ?>
                <input type="text"
                    id="search-input"
                    class="form-control"
                    name="search"
                    value="<?= Html::encode(Yii::$app->request->get('search')) ?>"
                    style="width: 400px;"
                    autocomplete="off" placeholder="Ketikkan Nomor Pendaftaran atau Nama Pemohon">
                <i class="material-symbols-outlined position-absolute top-50 translate-middle-y">search</i>

                <div id="autocomplete-results"
                    class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete"
                    style="width: 400px;">
                </div>

                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <?php if ($isSearch && $model !== null): ?>

        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Info Berkas Izin</h5>
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
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row mb-0 definition-list-styled">
                            <dt class="col-sm-5">Alamat</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['alamat'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Nomor Telepon</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['telepon'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Lokasi Usaha / Bangunan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['lokasi_usaha'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Kecamatan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['kecamatan'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Kelurahan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($model['kelurahan'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Multi Daftar dengan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> -</dd>
                        </dl>
                    </div>
                </div>
                <div class="text-end mt-3 d-flex justify-content-end">
                    <?= Html::a(
                        '<i class="material-symbols-outlined fs-16 me-1">receipt_long</i> Tanda Terima',
                        ['log', 'id' => $model['id']],
                        ['class' => 'btn btn-outline-info hover-white d-flex align-items-center justify-content-center', 'style' => 'width: 150px;', 'target' => '_blank', 'data-bs-toggle' => 'tooltip', 'data-bs-title' => 'Cetak Tanda Terima']
                    )
                    ?>
                </div>
            </div>
        </div>

        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Form Perhitungan</h5>

                <?= Html::beginForm(['hitung', 'id' => $model['id']], 'post', ['id' => 'form-perhitungan']) ?>
                <div class="row g-3">

                    <div class="col-md-12">
                        <?= Html::label('Nama Gedung / Bangunan', 'nama_gedung', ['class' => 'form-label']) ?>
                        <?= Html::textInput('nama_gedung', null, ['class' => 'form-control', 'placeholder' => 'Misal: Gedung Utama, Garasi, Pos Satpam...']) ?>
                    </div>

                    <div class="col-md-6">
                        <?= Html::label('Luas Bangunan', 'luas_bangunan', ['class' => 'form-label']) ?>
                        <div class="input-group">
                            <?= Html::textInput('luas_bangunan', null, ['class' => 'form-control', 'type' => 'number', 'step' => '0.01', 'placeholder' => '0.00', 'required' => true]) ?>
                            <span class="input-group-text">m²</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?= Html::label('Jumlah Bangunan', 'jumlah_bangunan', ['class' => 'form-label']) ?>
                        <div class="input-group">
                            <?= Html::textInput('jumlah_bangunan', 1, ['class' => 'form-control', 'type' => 'number', 'step' => '1', 'required' => true]) ?>
                            <span class="input-group-text">Unit</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <?= Html::label('Tarif Retribusi', 'tarif_retribusi', ['class' => 'form-label']) ?>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <?= Html::textInput('tarif_retribusi', null, ['class' => 'form-control', 'type' => 'number', 'step' => '0.01', 'placeholder' => '...']) ?>
                            <?= Html::dropDownList('pilihan_tarif', null, $dropdownData['tarifItems'], ['prompt' => '== Pilih Tarif ==', 'class' => 'form-select form-control']) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?= Html::label('Indeks Harga Standar Bangunan', 'indeks_harga', ['class' => 'form-label']) ?>
                        <?= Html::dropDownList('indeks_harga', 1.0, $dropdownData['indeksItems'], ['prompt' => '== Silahkan Pilih ==', 'class' => 'form-select form-control']) ?>
                    </div>

                    <div class="col-md-6">
                        <?= Html::label('Koefisien Luas Bangunan', 'koefisien_luas', ['class' => 'form-label']) ?>
                        <?= Html::dropDownList('koefisien_luas', 1.0, $dropdownData['koefisienItems'], ['prompt' => '== Silahkan Pilih ==', 'class' => 'form-select form-control']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= Html::label('Koefisien Tingkat Bangunan', 'koefisien_tingkat', ['class' => 'form-label']) ?>
                        <?= Html::dropDownList('koefisien_tingkat', 1.0, $dropdownData['koefisienItems'], ['prompt' => '== Silahkan Pilih ==', 'class' => 'form-select form-control']) ?>
                    </div>

                    <div class="col-md-6">
                        <?= Html::label('Koefisien Guna Bangunan', 'koefisien_guna', ['class' => 'form-label']) ?>
                        <?= Html::dropDownList('koefisien_guna', 1.0, $dropdownData['koefisienItems'], ['prompt' => '== Silahkan Pilih ==', 'class' => 'form-select form-control']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= Html::label('Koefisien Finansial Kota/Wilayah', 'koefisien_finansial', ['class' => 'form-label']) ?>
                        <?= Html::dropDownList('koefisien_finansial', 1.0, $dropdownData['koefisienItems'], ['prompt' => '== Silahkan Pilih ==', 'class' => 'form-select form-control']) ?>
                    </div>

                    <div class="col-md-6">
                        <?= Html::label('Koefisien Jalan Menurut Fungsi dan Sistem Jaringan', 'koefisien_jalan', ['class' => 'form-label']) ?>
                        <?= Html::dropDownList('koefisien_jalan', 1.0, $dropdownData['koefisienItems'], ['prompt' => '== Silahkan Pilih ==', 'class' => 'form-select form-control']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= Html::label('Koefisien Kelas Bangunan', 'koefisien_kelas', ['class' => 'form-label']) ?>
                        <?= Html::dropDownList('koefisien_kelas', 1.0, $dropdownData['koefisienItems'], ['prompt' => '== Silahkan Pilih ==', 'class' => 'form-select form-control']) ?>
                    </div>

                </div>
                <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top">
                    <?= Html::submitButton('Hitung & Tambah Rincian', ['class' => 'btn btn-outline-primary hover-bg hover-white']) ?>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>

        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Rincian Perhitungan</h5>

                <div class="default-table-area">
                    <div class="table-responsive">
                        <table class="table align-middle">

                            <thead class="table-light text-center">
                                <tr>
                                    <th>Gedung</th>
                                    <th>Luas</th>
                                    <th>Jumlah</th>
                                    <th>Tarif Retribusi</th>
                                    <th>Indeks Harga</th>
                                    <th>Total Koefisien</th>
                                    <th>Nilai Retribusi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $rincianModels = $rincianProvider->getModels();
                                if (empty($rincianModels)):
                                ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted fst-italic">Belum ada rincian perhitungan.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($rincianModels as $index => $rincianModel): ?>
                                        <tr>
                                            <td class="text-left"><?= Html::encode($rincianModel['gedung'] ?? '-') ?></td>
                                            <td class="text-end"><?= Yii::$app->formatter->asDecimal($rincianModel['luas'] ?? 0, 2) ?></td>
                                            <td class="text-center"><?= Html::encode($rincianModel['jumlah_bangunan'] ?? '-') ?></td>
                                            <td class="text-end">
                                                <?= 'Rp ' . Yii::$app->formatter->asDecimal($rincianModel['tarif_retribusi'] ?? 0, 0) ?>
                                            </td>
                                            <td class="text-center"><?= Html::encode($rincianModel['indeks_harga'] ?? '-') ?></td>
                                            <td class="text-center"><?= Yii::$app->formatter->asDecimal($rincianModel['total_koefisien'] ?? 1.0, 3) ?></td>
                                            <td class="text-end fw-bold">
                                                <?= 'Rp ' . Yii::$app->formatter->asDecimal($rincianModel['nilai_retribusi'] ?? 0, 0) ?>
                                            </td>
                                            <td class="text-center">
                                                <?= Html::a('<i class="material-symbols-outlined fs-16">delete</i>', [
                                                    'delete-rincian',
                                                    'pendaftaranId' => $model['id'],
                                                    'rincianId' => $rincianModel['id'] ?? '#'
                                                ], [
                                                    'class' => 'text-danger btn-delete-sweetalert',
                                                    'data-bs-toggle' => 'tooltip',
                                                    'data-bs-title' => 'Hapus Rincian',
                                                    'data-method' => 'post',
                                                ]) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>

                            <tfoot class="fw-bold bg-light">
                                <tr>
                                    <td class="text-end" colspan="6">Total</td>
                                    <td class="text-end fw-bold">
                                        <?= 'Rp ' . Yii::$app->formatter->asDecimal($totalRetribusi, 0) ?>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <h5 class="text-end mt-3 fw-bold">
                    Total Jumlah Retribusi :
                    <span class="text-danger">
                        <?= 'Rp ' . Yii::$app->formatter->asDecimal($totalRetribusi, 0) ?>
                    </span>
                </h5>

            </div>
        </div>

    <?php endif; ?>
</div>

<style>
    /* ... (CSS Anda tidak berubah) ... */
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

    .form-perhitungan-table th {
        font-weight: 500;
        color: #5e5873;
        padding: 0.5rem 0.5rem 0.5rem 0;
        vertical-align: middle;
    }

    .form-perhitungan-table td {
        padding: 0.25rem 0.5rem;
        vertical-align: middle;
    }

    /* (FIX) CSS UNTUK GOOGLE AUTOCOMPLETE */
    .google-autocomplete {
        max-height: 250px;
        border-bottom-left-radius: var(--bs-border-radius);
        border-bottom-right-radius: var(--bs-border-radius);
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        /* border: 1px solid #dee2e6; */
        /* border-top: 0; */
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
// (FIX) Blok JS yang duplikat dihapus. Sekarang hanya ada 3 blok.

// 1. JS untuk Tooltip
$js = <<<JS
// Initialize Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'tooltip-handler');


// 2. SweetAlert untuk Flash Messages
$flashes = Yii::$app->session->getAllFlashes(true);
if (!empty($flashes)) {
    $jsCode = '';
    foreach ($flashes as $key => $message) {

        if (is_array($message)) {
            $title = $message['title'] ?? 'Notifikasi';
            $text = $message['text'] ?? '...';
            $icon = $key;
        } else {
            $title = ucwords($key);
            $text = (string)$message;
            $icon = $key;
        }
        if (!in_array($icon, ['success', 'error', 'warning', 'info'])) {
            $icon = 'info';
        }
        $title = addslashes($title);
        $text = addslashes($text);
        $jsCode .= "Swal.fire({ title: '{$title}', text: '{$text}', icon: '{$icon}' });\n";
    }
    $this->registerJs($jsCode, \yii\web\View::POS_READY, 'my-sweetalert-flashes');
}


// 3. JavaScript Handler untuk konfirmasi Hapus
// Menggunakan Nowdoc (kutip tunggal) untuk menghindari error PHP
$jsDelete = <<<'JS'
$('.btn-delete-sweetalert').on('click', function(e) {
    
    // --- INI PERBAIKANNYA ---
    // Hentikan yii.js agar tidak langsung men-submit POST
    e.stopImmediatePropagation(); 
    e.preventDefault(); // Tetap gunakan ini sebagai keamanan
    
    const $link = $(this); // Simpan link yang diklik
    
    Swal.fire({
        title: 'Anda Yakin?',
        text: "Data rincian ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', // Merah untuk tombol hapus
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus Saja!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika dikonfirmasi, panggil fungsi Yii secara manual
            // untuk menjalankan data-method="post"
            yii.handleAction($link);
        }
    });
});
JS;
$this->registerJs($jsDelete, \yii\web\View::POS_READY, 'delete-confirm-handler');

?>


<?php
// (FIX BARU) JAVASCRIPT AUTOCOMPLETE
$autocompleteUrl = Url::to(['search-pendaftaran']);

$jsAutocomplete = <<<JS

const searchInput = document.getElementById('search-input'); 
const resultsBox = document.getElementById('autocomplete-results');
const searchForm = document.getElementById('form-search-retribusi'); // ID form pencarian
const autocompleteUrl = '{$autocompleteUrl}';

// Fungsi untuk escape regex
function escapeRegExp(string) {
    if (typeof string !== 'string') {
        return '';
    }
    return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\$&');
}

// Fungsi untuk fetch hasil
async function fetchResults(term) {
    if (term.length < 2) { // Hanya cari jika minimal 2 karakter
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

// Fungsi untuk menampilkan hasil
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
        
        // Highlight bagian yang di-search
        const highlightedLabel = item.label.replace(regex, '<strong>$1</strong>');
        
        itemDiv.innerHTML = '<i class="material-symbols-outlined">search</i>' + 
                            '<span>' + highlightedLabel + '</span>';
        
        // Event listener saat item di-klik
        itemDiv.addEventListener('click', function(e) {
            e.preventDefault(); 
            if(searchInput) searchInput.value = item.value; // Set input dengan 'value' (Nomor Daftar)
            if(resultsBox) resultsBox.classList.add('d-none');
            if(searchForm) searchForm.submit(); // Submit form
        });
        
        resultsBox.appendChild(itemDiv);
    });
}

// Tambahkan event listener ke input
if(searchInput) {
    searchInput.addEventListener('input', function() {
        fetchResults(this.value);
    });
}

// Sembunyikan hasil jika klik di luar area
document.addEventListener('click', function(e) {
    if (searchInput && !searchInput.contains(e.target) && resultsBox && !resultsBox.contains(e.target)) {
        resultsBox.classList.add('d-none');
    }
});

JS;
$this->registerJs($jsAutocomplete, \yii\web\View::POS_READY, 'retribusi-autocomplete-handler');
?>