<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var string|null $search
 * @var array|null $modelPendaftaran Data Pendaftaran
 * @var array|null $modelSk Data SK (bisa null)
 * @var bool $isSearch
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Cetak SK';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
$this->params['breadcrumbs'][] = 'Cetak Draft SK';
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Back Office</span></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Cetak Draft SK</span></li>
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
</div>
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
                                <?= Html::a(Html::encode($modelPendaftaran['nomor_daftar'] ?? '-'), ['log', 'pendaftaran_id' => $modelPendaftaran['id'] ?? '#'], [
                                    'class' => 'text-primary text-decoration-none',
                                    'target' => '_blank',
                                    'data-bs-toggle' => 'tooltip',
                                    'data-bs-title' => 'Klik untuk lihat Tanda Terima'
                                ]) ?>

                                <?= Html::a(
                                    '<i class="material-symbols-outlined fs-18">history</i>',
                                    ['log', 'pendaftaran_id' => $modelPendaftaran['id'] ?? '#'],
                                    ['class' => 'ms-2 fw-bold text-secondary', 'target' => '_blank', 'data-bs-toggle' => 'tooltip', 'data-bs-title' => 'Klik untuk lihat Lembar Kendali']
                                ) ?>
                            </dd>
                            <dt class="col-sm-5">Jenis Izin</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['nama_izin'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Jenis Permohonan</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['jenis_permohonan'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Nama Pemohon</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['nama_pemohon'] ?? '-') ?></dd>
                            <dt class="col-sm-5">Nama Usaha</dt>
                            <dd class="col-sm-7"><span class="definition-divider">:</span> <?= Html::encode($modelPendaftaran['nama_usaha'] ?? '-') ?></dd>
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
                <div class="row mt-3">
                    <div class="col-12">
                        <dl class="row mb-0 definition-list-styled">
                            <dt class="col-sm-5 col-md-2">Nilai Retribusi</dt>
                            <dd class="col-sm-7 col-md-10"><span class="definition-divider">:</span>
                                <?= 'Rp. ' . Yii::$app->formatter->asDecimal($modelPendaftaran['nilai_retribusi'] ?? 0, 0) ?>
                            </dd>

                            <dt class="col-sm-5 col-md-2">Terbilang</dt>
                            <dd class="col-sm-7 col-md-10"><span class="definition-divider">:</span>
                                <?php // PERBAIKAN: Dinonaktifkan karena butuh 'intl'
                                // echo Html::encode(Yii::$app->formatter->asSpellout($modelPendaftaran['nilai_retribusi'] ?? 0)) . ' rupiah';
                                ?>
                                <i>(Fitur terbilang memerlukan ekstensi PHP 'intl')</i>
                            </dd>
                        </dl>
                    </div>
                </div>

                <div class="text-start mt-3">
                    <?= Html::a('Edit Data Primer (Data Pendaftaran)', ['edit-data-primer', 'pendaftaran_id' => $modelPendaftaran['id'] ?? '#'], [
                        'class' => 'btn btn-sm btn-outline-primary',
                    ]) ?>
                </div>

            </div>
        </div>
        <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">
                    Entry Data Sekunder Cetak SK <?= Html::encode($modelPendaftaran['jenis_permohonan']) ?>
                    (<?= Html::encode($modelPendaftaran['nama_izin']) ?>)
                </h5>

                <?= Html::beginForm(['simpan-cetak', 'pendaftaran_id' => $modelPendaftaran['id']], 'post', ['id' => 'form-sk-simpan']) ?>

                <div class="row g-3">
                    <div class="col-md-4">
                        <?= Html::label('No SK', 'no_sk', ['class' => 'form-label']) ?>
                        <?= Html::textInput('no_sk', $modelSk['no_sk'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Tgl Mohon PU', 'tgl_mohon_pu', ['class' => 'form-label']) ?>
                        <?= Html::textInput('tgl_mohon_pu', !empty($modelSk['tgl_mohon_pu']) ? Yii::$app->formatter->asDate($modelSk['tgl_mohon_pu'], 'php:Y-m-d') : null, ['class' => 'form-control form-control-sm', 'type' => 'date']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Tgl Penetapan', 'tgl_penetapan', ['class' => 'form-label']) ?>
                        <?= Html::textInput('tgl_penetapan', !empty($modelSk['tgl_penetapan']) ? Yii::$app->formatter->asDate($modelSk['tgl_penetapan'], 'php:Y-m-d') : null, ['class' => 'form-control form-control-sm', 'type' => 'date']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Tgl Pemeriksaan', 'tgl_pemeriksaan', ['class' => 'form-label']) ?>
                        <?= Html::textInput('tgl_pemeriksaan', !empty($modelSk['tgl_pemeriksaan']) ? Yii::$app->formatter->asDate($modelSk['tgl_pemeriksaan'], 'php:Y-m-d') : null, ['class' => 'form-control form-control-sm', 'type' => 'date']) ?>
                    </div>
                    <div class="col-md-8">
                        <?= Html::label('Untuk Keperluan', 'untuk_keperluan', ['class' => 'form-label']) ?>
                        <?= Html::textInput('untuk_keperluan', $modelSk['untuk_keperluan'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>

                    <div class="col-md-4">
                        <?= Html::label('Pondasi', 'pondasi', ['class' => 'form-label']) ?>
                        <?= Html::textInput('pondasi', $modelSk['pondasi'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Rangka Bangunan', 'rangka_bangunan', ['class' => 'form-label']) ?>
                        <?= Html::textInput('rangka_bangunan', $modelSk['rangka_bangunan'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Dinding', 'dinding', ['class' => 'form-label']) ?>
                        <?= Html::textInput('dinding', $modelSk['dinding'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Rangka Atap', 'rangka_atap', ['class' => 'form-label']) ?>
                        <?= Html::textInput('rangka_atap', $modelSk['rangka_atap'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Penutup Atap', 'penutup_atap', ['class' => 'form-label']) ?>
                        <?= Html::textInput('penutup_atap', $modelSk['penutup_atap'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Lantai', 'lantai', ['class' => 'form-label']) ?>
                        <?= Html::textInput('lantai', $modelSk['lantai'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>

                    <div class="col-md-12">
                        <?= Html::label('Luas Bangunan', 'luas_bangunan', ['class' => 'form-label']) ?>
                        <?= Html::textarea('luas_bangunan', $modelSk['luas_bangunan'] ?? null, ['class' => 'form-control form-control-sm', 'rows' => 2]) ?>
                    </div>
                    <div class="col-md-12">
                        <?= Html::label('Status Tanah', 'status_tanah', ['class' => 'form-label']) ?>
                        <?= Html::textarea('status_tanah', $modelSk['status_tanah'] ?? null, ['class' => 'form-control form-control-sm', 'rows' => 2]) ?>
                    </div>

                    <div class="col-md-4">
                        <?= Html::label('Wilayah', 'wilayah', ['class' => 'form-label']) ?>
                        <?= Html::textInput('wilayah', $modelSk['wilayah'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('Pekerjaan Pemohon', 'pekerjaan_pemohon', ['class' => 'form-label']) ?>
                        <?= Html::textInput('pekerjaan_pemohon', $modelSk['pekerjaan_pemohon'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= Html::label('NOP', 'nop', ['class' => 'form-label']) ?>
                        <?= Html::textInput('nop', $modelSk['nop'] ?? null, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top">
                    <?= Html::submitButton('Simpan & Cetak SK (WORD)', ['class' => 'btn btn-primary']) ?>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>

    <?php endif; ?>
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

$autocompleteUrl = Url::to(['search-pendaftaran']);

$js = <<<JS

const searchInput = document.getElementById('search_pendaftaran');
const resultsBox = document.getElementById('autocomplete-results');
const searchForm = document.getElementById('form-search-pendaftaran');
const autocompleteUrl = '{$autocompleteUrl}';

function escapeRegExp(string) {
    if (typeof string !== 'string') {
        return '';
    }
    return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\$&');
}

/**
 * Fungsi untuk mengambil data (AJAX)
 */
async function fetchResults(term) {
    if (term.length < 2) {
        resultsBox.innerHTML = '';
        resultsBox.classList.add('d-none'); // Sembunyikan box
        return;
    }
    
    try {
        const response = await fetch(autocompleteUrl + '?term=' + encodeURIComponent(term));
        if (!response.ok) throw new Error('Network error');
        const data = await response.json();
        displayResults(data, term); // Kirim 'term' untuk highlighting
    } catch (error) {
        console.error('Error fetching autocomplete:', error);
        resultsBox.innerHTML = '';
        resultsBox.classList.add('d-none'); // Sembunyikan box
    }
}

/**
 * Fungsi untuk menampilkan hasil (DIMODIFIKASI)
 */
function displayResults(data, term) {
    // Kosongkan hasil
    resultsBox.innerHTML = '';
    
    if (data.length === 0) {
        // Tampilkan pesan 'tidak ditemukan'
        resultsBox.classList.remove('d-none'); // Tampilkan box
        resultsBox.innerHTML = '<div class="autocomplete-item-google no-result">Data tidak ditemukan</div>';
        return;
    }

    // Tampilkan box
    resultsBox.classList.remove('d-none');
    
    // Buat Regex untuk mencari term (case-insensitive)
    const safeTerm = escapeRegExp(term);
    if (!safeTerm) return; // Jangan lakukan replace jika term kosong setelah di-escape
    
    const regex = new RegExp('(' + safeTerm + ')', 'gi');

    data.forEach(item => {
        // Buat <div> baru dengan style kustom kita
        const itemDiv = document.createElement('div');
        itemDiv.className = 'autocomplete-item-google'; // <-- INI KELAS YANG BENAR
        
        // Ganti teks yang cocok dengan versi <strong>
        const highlightedLabel = item.label.replace(regex, '<strong>$1</strong>');
        
        // Masukkan ikon dan teks yang sudah di-highlight
        itemDiv.innerHTML = '<i class="material-symbols-outlined">search</i>' + 
                            '<span>' + highlightedLabel + '</span>';
        
        // Tambahkan event klik
        itemDiv.addEventListener('click', function(e) {
            e.preventDefault(); 
            searchInput.value = item.value; // Isi input dengan 'value' (misal: "030004")
            resultsBox.classList.add('d-none'); // Sembunyikan box
            searchForm.submit(); // Submit form
        });
        
        resultsBox.appendChild(itemDiv);
    });
}

// 4. Tambahkan event listener ke input box (TETAP SAMA)
searchInput.addEventListener('input', function() {
    fetchResults(this.value);
});

// 5. Sembunyikan hasil jika user klik di luar (TETAP SAMA)
document.addEventListener('click', function(e) {
    // Pastikan searchInput ada sebelum memanggil .contains
    if (searchInput && !searchInput.contains(e.target) && resultsBox && !resultsBox.contains(e.target)) {
        resultsBox.classList.add('d-none');
    }
});

JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'penomoran-sk-handler-google');
?>