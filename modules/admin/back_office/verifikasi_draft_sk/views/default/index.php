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
use yii\widgets\LinkPager; // Untuk pagination

$this->title = 'Verifikasi Draft SK';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Back Office', 'url' => '#'];
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
                    <span class="fw-medium">Back Office</span>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium"><?= Html::encode($this->title) ?></span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">
                
                <?= Html::beginForm(['index'], 'get', [
                    'id' => 'form-search-pendaftaran', // (FIX 1) ID Form diubah agar cocok dengan JS
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

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="text-nowrap" scope="col">No</th>
                                <th class="text-nowrap" scope="col">Log</th>
                                <th class="text-nowrap" scope="col">No Daftar</th>
                                <th class="text-nowrap" scope="col">Nama Izin</th>
                                <th class="text-nowrap" scope="col">Jenis Permohonan</th>
                                <th class="text-nowrap" scope="col">Nama Pemohon</th>
                                <th class="text-nowrap" scope="col">Nama Usaha</th>
                                <th class="text-nowrap" scope="col">Dari</th>
                                <th class="text-nowrap" scope="col">Keterangan</th>
                                <th class="text-nowrap" scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($models)): ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted fst-italic">
                                        Data tidak ditemukan.
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($models as $index => $model): ?>
                                <tr>
                                    <td class="text-secondary"><?= $pagination->page * $pagination->pageSize + $index + 1 ?></td>
                                    <td>
                                        <!-- Tautan Log yang aman -->
                                        <a href="<?= Url::to(['log', 'id' => $model['id'] ?? '#']) ?>" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-title="Lihat Log Proses" target="_blank">
                                            <i class="material-symbols-outlined fs-18 text-secondary">history</i>
                                        </a>
                                    </td>
                                    <td class="text-secondary">
                                        <!-- Tautan View yang aman (teks dan parameter) -->
                                        <?= Html::a(
                                            Html::encode($model['nomor_daftar'] ?? '-'), 
                                            ['view', 'id' => $model['id'] ?? '#'],
                                            ['class' => 'text-primary text-decoration-none', 'target' => '_blank']
                                        ) ?>
                                    </td>
                                    <td class="text-secondary"><?= Html::encode($model['nama_izin'] ?? '-') ?></td>
                                    <td class="text-secondary"><?= Html::encode($model['jenis_permohonan'] ?? '-') ?></td>
                                    <td class="text-secondary"><?= Html::encode($model['nama_pemohon'] ?? '-') ?></td>
                                    <td class="text-body"><?= Html::encode($model['nama_usaha'] ?? '-') ?></td>
                                    <td class="text-secondary"><?= Html::encode($model['dari'] ?? '-') ?></td>
                                    <td class="text-secondary"><?= Html::encode($model['keterangan'] ?? '-') ?></td>
                                    <td>
                                        <!-- Tautan Validasi yang aman -->
                                        <a href="<?= Url::to(['validasi', 'id' => $model['id'] ?? '#']) ?>" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-title="Validasi">
                                            <i class="material-symbols-outlined fs-18 text-primary">check_circle</i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-3">
                    <span class="fs-13 fw-medium text-secondary">
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
// JavaScript untuk Tooltip dan Konfirmasi Validasi (SweetAlert)
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$js = <<<JS

// Inisialisasi Tooltip Bootstrap
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Handler untuk tombol validasi dengan class 'btn-validasi-data'
$('.btn-validasi-data').on('click', function(event) {
    event.preventDefault(); // Mencegah link default
    var validasiUrl = $(this).attr('href'); // Ambil URL dari href

    Swal.fire({
        title: 'Anda Yakin?',
        text: "Anda akan memvalidasi draft SK ini.",
        icon: 'question', // Ikon pertanyaan
        showCancelButton: true,
        confirmButtonColor: '#28a745', // Warna hijau success
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Validasi!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Buat form dinamis untuk mengirim request POST
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = validasiUrl; // Arahkan ke action validasi

            // Tambahkan CSRF token
            var csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '{$csrfParam}';
            csrfInput.value = '{$csrfToken}';
            form.appendChild(csrfInput);

            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    });
});

// Hapus JS untuk '.btn-hapus-data' jika tidak ada tombol hapus di halaman ini
// $('.btn-hapus-data').on('click', function(event) { ... });

JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'tooltip-validasi-handler');
?>

<?php
// Cek flash messages dan tampilkan sebagai SweetAlert
$flashMessages = Yii::$app->session->getAllFlashes();
if (!empty($flashMessages)) {
    foreach ($flashMessages as $key => $message) {
        // Tentukan ikon berdasarkan key flash message
        $icon = 'info'; // Default icon
        if ($key === 'success') {
            $icon = 'success';
        } elseif ($key === 'error' || $key === 'danger') {
            $icon = 'error';
        } elseif ($key === 'warning') {
            $icon = 'warning';
        } elseif ($key === 'info') {
            $icon = 'info';
        }

        // Encode message untuk keamanan di JavaScript
        $encodedMessage = \yii\helpers\Json::encode($message);

        // Buat script SweetAlert
        $js = <<<JS
            Swal.fire({
                icon: '{$icon}',
                title: {$encodedMessage}, // Pesan dari flash message
                toast: true, // Tampilkan sebagai toast kecil
                position: 'top-end', // Posisi di kanan atas
                showConfirmButton: false, // Sembunyikan tombol OK
                timer: 3000, // Durasi tampil (3 detik)
                timerProgressBar: true, // Tampilkan progress bar
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        JS;
        // Daftarkan script
        $this->registerJs($js, \yii\web\View::POS_READY, 'flash-sweetalert-' . $key);
    }
}
?>


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