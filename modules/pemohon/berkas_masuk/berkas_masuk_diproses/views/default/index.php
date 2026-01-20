<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Berkas Masuk Diproses';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Berkas Masuk', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Berkas Masuk</span></li>
                <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Inbox Diproses</h5>

            <!-- SEARCH -->
            <div class="d-flex justify-content-start align-items-center flex-wrap gap-2 mb-4">
                <?= Html::beginForm(['index'], 'get', [
                    'id' => 'form-search-diproses',
                    'class' => 'table-src-form align-items-center w-100'
                ]) ?>

                <div class="col-md-5 position-relative">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y"
                        style="padding-left: 12px; z-index: 10; color: #6c757d;">
                        search
                    </i>

                    <div id="autocomplete-container" class="position-relative" style="width: 400px;">

                        <?= Html::textInput('search', $search, [
                            'id' => 'search_diproses',
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
                    <table class="table align-middle">
                        <thead class="table-light text-center text-uppercase align-middle">
                            <tr>
                                <th width="5%">No</th>
                                <th width="5%">Log</th>
                                <th>Nomor Daftar</th>
                                <th>Nama Izin</th>
                                <th>Jenis Permohonan</th>
                                <th>Nama Pemohon</th>
                                <th>Nama Usaha</th>
                                <th>Dari</th>
                                <th>Tanggal Sampai</th>
                                <th width="15%">Foto Pemohon</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($dataProvider->totalCount > 0): ?>
                                <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                    <?php
                                    // Cek apakah sudah punya foto (jpg/jpeg/png)
                                    $fotoUrl = null;
                                    foreach (['jpg', 'jpeg', 'png'] as $ext) {
                                        $relative = "uploads/foto/{$model['id']}.$ext";
                                        if (file_exists(Yii::getAlias('@webroot/' . $relative))) {
                                            $fotoUrl = Yii::getAlias('@web/' . $relative);
                                            break;
                                        }
                                    }
                                    $hasFoto = $fotoUrl !== null;
                                    ?>
                                    <tr>
                                        <td class="text-center text-secondary">
                                            <?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?>
                                        </td>

                                        <td class="text-center">
                                            <a href="#" data-bs-toggle="tooltip" data-bs-title="Lihat Log Berkas">
                                                <i class="material-symbols-outlined fs-18 text-info text-primary">history</i>
                                            </a>
                                        </td>

                                        <td class="text-center text-primary">
                                            <?= Html::encode($model['nomor_daftar']) ?>
                                        </td>

                                        <td><?= Html::encode($model['nama_izin']) ?></td>

                                        <td class="text-center">
                                            <span><?= Html::encode($model['jenis_permohonan']) ?></span>
                                        </td>

                                        <td><?= Html::encode($model['nama_pemohon']) ?></td>
                                        <td><?= Html::encode($model['nama_usaha']) ?></td>
                                        <td><?= Html::encode($model['dari']) ?></td>
                                        <td class="text-center"><?= Html::encode($model['tanggal_sampai']) ?></td>

                                        <!-- FOTO + STATUS -->
                                        <td class="text-center">
                                            <div class="mb-2">
                                                <?php if ($hasFoto): ?>
                                                    <span class="badge bg-success bg-opacity-10 text-success d-inline-flex align-items-center gap-1">
                                                        <i class="material-symbols-outlined fs-16">check_circle</i>
                                                        Sudah upload
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary d-inline-flex align-items-center gap-1">
                                                        <i class="material-symbols-outlined fs-16">info</i>
                                                        Belum upload
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <?php if ($hasFoto): ?>
                                                <div class="mb-2">
                                                    <img src="<?= $fotoUrl ?>"
                                                        alt="Foto <?= Html::encode($model['nama_pemohon']) ?>"
                                                        class="rounded"
                                                        style="width:40px;height:40px;object-fit:cover;border:1px solid #dee2e6;">
                                                </div>
                                            <?php else: ?>
                                                <div class="mb-2 text-muted">
                                                    <i class="material-symbols-outlined">image_not_supported</i>
                                                </div>
                                            <?php endif; ?>

                                            <button type="button"
                                                class="btn btn-sm <?= $hasFoto ? 'btn-outline-success' : 'btn-outline-secondary' ?> d-inline-flex align-items-center gap-1 btn-upload-foto"
                                                data-id="<?= $model['id'] ?>"
                                                data-nomor="<?= Html::encode($model['nomor_daftar']) ?>"
                                                data-nama="<?= Html::encode($model['nama_pemohon']) ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalUploadFoto">
                                                <i class="material-symbols-outlined fs-18">
                                                    <?= $hasFoto ? 'edit' : 'upload' ?>
                                                </i>
                                                <span><?= $hasFoto ? 'Ganti Foto' : 'Upload Foto' ?></span>
                                            </button>
                                        </td>

                                        <!-- AKSI -->
                                        <td class="text-center">
                                            <a href="<?= Url::to(['routing', 'id' => $model['id']]) ?>"
                                                class="text-decoration-none"
                                                data-bs-toggle="tooltip"
                                                data-bs-title="Routing Berkas">
                                                <i class="material-symbols-outlined fs-18 text-info text-primary">
                                                    account_tree
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Legend status -->
                <div class="mt-2 text-muted small d-flex align-items-center gap-3">
                    <span>
                        <span class="badge bg-success bg-opacity-10 text-success align-middle me-1">
                            <i class="material-symbols-outlined fs-16 align-middle">check_circle</i>
                        </span>
                        Sudah upload foto
                    </span>
                    <span>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary align-middle me-1">
                            <i class="material-symbols-outlined fs-16 align-middle">info</i>
                        </span>
                        Belum upload foto
                    </span>
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

<!-- MODAL UPLOAD -->
<div class="modal fade" id="modalUploadFoto" tabindex="-1" aria-labelledby="modalUploadFotoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-3">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="modalUploadFotoLabel">Upload Foto Pemohon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3 text-muted small">
                    Nomor Daftar:
                    <span class="fw-semibold text-primary" id="modal-nomor-daftar">-</span><br>
                    Nama Pemohon:
                    <span class="fw-semibold" id="modal-nama-pemohon">-</span>
                </p>

                <form id="form-upload-foto" enctype="multipart/form-data">
                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

                    <!-- Drop zone -->
                    <div id="drop-zone"
                        class="border border-secondary border-opacity-25 rounded p-4 text-center mb-3"
                        style="cursor:pointer;">
                        <i class="material-symbols-outlined fs-1 text-secondary">cloud_upload</i>
                        <p class="mb-0 text-muted">Klik atau drag & drop foto di sini</p>
                    </div>

                    <!-- Preview -->
                    <div class="text-center mb-3 d-none" id="preview-wrapper">
                        <img id="preview-image"
                            style="width:120px;height:120px;object-fit:cover;border-radius:10px;border:1px solid #dee2e6;">
                        <div class="small text-muted mt-1">Preview sebelum upload</div>
                    </div>

                    <input type="file" name="foto" id="input-foto" class="d-none" accept=".jpg,.jpeg,.png">

                    <!-- Progress -->
                    <div class="progress d-none mb-3" id="upload-progress">
                        <div class="progress-bar" style="width:0%">0%</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Upload
                        </button>
                    </div>
                </form>
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
$autocompleteUrl = Url::to(['search-diproses']);
$uploadFotoBaseUrl = Url::to(['upload-foto']);

$js = <<<JS
// Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});

// Autocomplete
const searchInput = document.getElementById('search_diproses');
const resultsBox = document.getElementById('autocomplete-results');
const searchForm = document.getElementById('form-search-diproses');
const autocompleteUrl = '{$autocompleteUrl}';

function escapeRegExp(string) {
    if (typeof string !== 'string') return '';
    return string.replace(/[.*+?^$\${}()|[\\\\]\\\\]/g, '\$&');
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
        resultsBox.innerHTML = '<div class="autocomplete-item-google text-muted fst-italic">Data tidak ditemukan</div>';
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

// Modal upload
const modalUploadFoto = document.getElementById('modalUploadFoto');
const uploadFotoBaseUrl = '{$uploadFotoBaseUrl}';
const formUpload = document.getElementById('form-upload-foto');
const inputFile = document.getElementById('input-foto');
const dropZone = document.getElementById('drop-zone');
const previewWrapper = document.getElementById('preview-wrapper');
const previewImage = document.getElementById('preview-image');
const progressContainer = document.getElementById('upload-progress');
const progressBar = progressContainer ? progressContainer.querySelector('.progress-bar') : null;

if (modalUploadFoto) {
    modalUploadFoto.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return;

        const id = button.getAttribute('data-id');
        const nomor = button.getAttribute('data-nomor') || '-';
        const nama = button.getAttribute('data-nama') || '-';

        modalUploadFoto.querySelector('#modal-nomor-daftar').textContent = nomor;
        modalUploadFoto.querySelector('#modal-nama-pemohon').textContent = nama;

        if (formUpload) {
            formUpload.action = uploadFotoBaseUrl + '?id=' + encodeURIComponent(id);
        }
        if (inputFile) {
            inputFile.value = '';
        }
        if (previewWrapper) {
            previewWrapper.classList.add('d-none');
        }
        if (progressContainer && progressBar) {
            progressContainer.classList.add('d-none');
            progressBar.style.width = '0%';
            progressBar.textContent = '0%';
            progressBar.classList.remove('bg-success', 'bg-danger');
        }
    });
}

// Drag & drop + klik
if (dropZone && inputFile) {
    dropZone.addEventListener('click', function() {
        inputFile.click();
    });

    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('bg-light');
    });

    dropZone.addEventListener('dragleave', function() {
        dropZone.classList.remove('bg-light');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('bg-light');
        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            inputFile.files = e.dataTransfer.files;
            updatePreview();
        }
    });

    inputFile.addEventListener('change', updatePreview);
}

function updatePreview() {
    if (!inputFile || !previewImage || !previewWrapper) return;
    const file = inputFile.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        previewImage.src = e.target.result;
        previewWrapper.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
}

// AJAX upload
if (formUpload) {
    formUpload.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!inputFile || !inputFile.files || inputFile.files.length === 0) {
            alert('Silakan pilih file foto terlebih dahulu.');
            return;
        }

        const formData = new FormData(formUpload);

        if (progressContainer && progressBar) {
            progressContainer.classList.remove('d-none');
            progressBar.style.width = '0%';
            progressBar.textContent = '0%';
            progressBar.classList.remove('bg-success', 'bg-danger');
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', formUpload.action, true);

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable && progressBar) {
                var percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                progressBar.textContent = percent + '%';
            }
        };

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                try {
                    var res = JSON.parse(xhr.responseText);
                    if (res.success) {
                        if (progressBar) {
                            progressBar.classList.add('bg-success');
                            progressBar.style.width = '100%';
                            progressBar.textContent = '100%';
                        }
                        setTimeout(function() {
                            var modalInstance = bootstrap.Modal.getInstance(modalUploadFoto);
                            if (modalInstance) modalInstance.hide();
                            window.location.reload();
                        }, 600);
                    } else {
                        if (progressBar) {
                            progressBar.classList.add('bg-danger');
                        }
                        alert(res.message || 'Upload gagal.');
                    }
                } catch (err) {
                    console.error(err);
                    if (progressBar) {
                        progressBar.classList.add('bg-danger');
                    }
                    alert('Terjadi kesalahan saat upload.');
                }
            }
        };

        xhr.send(formData);
    });
}
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
?>