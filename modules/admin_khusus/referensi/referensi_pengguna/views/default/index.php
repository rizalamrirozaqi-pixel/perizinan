<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var array $models */
/** @var yii\data\Pagination $pagination */
/** @var string $allDataJson */
/** @var array $blokSistemOptions */
/** @var array $privilegeOptions */

$this->title = 'Referensi Pengguna';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = 'Referensi';
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
                <li class="breadcrumb-item text-secondary fw-medium">Referensi</li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium"><?= Html::encode($this->title) ?></span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">
                <?= Html::beginForm(['index'], 'get', ['id' => 'form-search-pengguna', 'class' => 'table-src-form align-items-center']) ?>
                <div class="col-md-5 position-relative">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y" style="z-index: 10; color: #6c757d;">search</i>
                    <div id="autocomplete-container" class="position-relative" style="width: 400px;">
                        <?= Html::textInput('search', Yii::$app->request->get('search'), [
                            'id' => 'search_pengguna',
                            'class' => 'form-control',
                            'style' => 'padding-left: 3rem; width: 400px;',
                            'placeholder' => 'Cari Username, Nama atau NIP...',
                            'autocomplete' => 'off'
                        ]) ?>
                        <div id="autocomplete-results" class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete"></div>
                    </div>
                </div>
                <?= Html::endForm() ?>

                <button type="button" class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg d-flex align-items-center btn-add-modal">
                    <span class="py-sm-1 d-block d-flex align-items-center">
                        <i class="fs-18 material-symbols-outlined me-1">add</i>
                        <span>Tambah Pengguna</span>
                    </span>
                </button>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna User</th>
                                <th>Password</th>
                                <th>Nama Lengkap</th>
                                <th>NIP</th>
                                <th>Unit Kerja</th>
                                <th>Blok Sistem</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($models)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Data tidak ditemukan.</td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($models as $index => $model): ?>
                                <tr>
                                    <td class="text-secondary"><?= $pagination->page * $pagination->pageSize + $index + 1 ?></td>
                                    <td class="text-secondary"><?= Html::encode($model['username']) ?></td>
                                    <td class="text-muted">******</td>
                                    <td class="text-secondary"><?= Html::encode($model['nama_lengkap']) ?></td>
                                    <td class="text-secondary"><?= Html::encode($model['nip']) ?></td>
                                    <td class="text-secondary"><?= Html::encode($model['unit_kerja']) ?></td>
                                    <td>
                                        <span class="">
                                            <?= Html::encode($model['blok_sistem']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="javascript:void(0);"
                                                class="text-decoration-none btn-privilege-modal"
                                                data-id="<?= $model['id'] ?>"
                                                data-nama="<?= $model['nama_lengkap'] ?>"
                                                data-bs-toggle="tooltip"
                                                data-bs-title="Privilege Pengguna">
                                                <i class="material-symbols-outlined fs-18 text-info">vpn_key</i>
                                            </a>

                                            <a href="javascript:void(0);" class="text-decoration-none btn-edit-modal" data-id="<?= $model['id'] ?>" data-bs-toggle="tooltip" data-bs-title="Edit Data">
                                                <i class="material-symbols-outlined fs-18 text-primary">edit</i>
                                            </a>
                                            <a href="<?= Url::to(['delete', 'id' => $model['id']]) ?>" class="text-decoration-none btn-hapus-data" data-bs-toggle="tooltip" data-bs-title="Hapus Data">
                                                <i class="material-symbols-outlined fs-18 text-danger">delete</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 mt-4">
                    <span class="fs-13 fw-medium text-secondary">
                        Menampilkan <b><?= count($models) ?></b> dari <b><?= $pagination->totalCount ?></b> data
                    </span>
                    <?= LinkPager::widget([
                        'pagination' => $pagination,
                        'options' => ['class' => 'pagination mb-0 justify-content-center'],
                        'linkContainerOptions' => ['class' => 'page-item'],
                        'linkOptions' => ['class' => 'page-link'],
                        'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                        'activePageCssClass' => 'active',
                        'prevPageCssClass' => 'page-item',
                        'nextPageCssClass' => 'page-item',
                        'prevPageLabel' => '<i class="material-symbols-outlined fs-16">keyboard_arrow_left</i>',
                        'nextPageLabel' => '<i class="material-symbols-outlined fs-16">keyboard_arrow_right</i>',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormPengguna" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalLabel">Pengguna, Tambah catatan baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'action' => ['create'], 'method' => 'post']); ?>
            <div class="modal-body p-4">
                <div class="mb-3"><label class="form-label fw-medium text-secondary">Pengguna User</label><input type="text" name="DynamicModel[username]" id="inputUsername" class="form-control" required></div>
                <div class="mb-3"><label class="form-label fw-medium text-secondary">Password</label><input type="password" name="DynamicModel[password]" id="inputPassword" class="form-control" required></div>
                <div class="mb-3"><label class="form-label fw-medium text-secondary">Nama Lengkap</label><input type="text" name="DynamicModel[nama_lengkap]" id="inputNamaLengkap" class="form-control" required></div>
                <div class="mb-3"><label class="form-label fw-medium text-secondary">Nip</label><input type="text" name="DynamicModel[nip]" id="inputNip" class="form-control"></div>
                <div class="mb-3"><label class="form-label fw-medium text-secondary">Unitkerja</label><input type="text" name="DynamicModel[unit_kerja]" id="inputUnitKerja" class="form-control"></div>
                <div class="mb-3"><label class="form-label fw-medium text-secondary">Blok Sistem <span class="text-danger">*</span></label><select class="form-select form-control" name="DynamicModel[blok_sistem]" id="selectBlokSistem" required>
                        <option value="">Silahkan pilih</option><?php foreach ($blokSistemOptions as $value => $label): ?><option value="<?= $value ?>"><?= $label ?></option><?php endforeach; ?>
                    </select></div>
                <small class="text-danger">* Ruas yang diperlukan</small>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary ">Simpan</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPrivilege" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5">Tambah Jenis Izin (<span id="privilegeUserName">User</span>)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?php $formPriv = ActiveForm::begin(['action' => ['save-privilege'], 'method' => 'post']); ?>
            <input type="hidden" name="user_id" id="privilegeUserId">

            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label text-secondary small">Jenis Sektor</label>
                    <select class="form-select form-control" name="sektor">
                        <?php foreach ($privilegeOptions['sektor'] as $val => $label): ?>
                            <option value="<?= $val ?>"><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small">Jenis Izin / Bidang</label>
                    <select class="form-select form-control" name="bidang">
                        <?php foreach ($privilegeOptions['bidang'] as $val => $label): ?>
                            <option value="<?= $val ?>"><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small">Jenis Izin (Permohonan)</label>
                    <select class="form-select form-control" name="permohonan">
                        <option value="">== Silahkan Pilih Izin (Permohonan) ==</option>
                        <?php foreach ($privilegeOptions['permohonan'] as $val => $label): ?>
                            <option value="<?= $val ?>"><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary ">Simpan</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$urlCreate = Url::to(['create']);
$urlUpdate = Url::to(['update']);
$urlAutocomplete = Url::to(['search-pengguna']);
$jsonData = $allDataJson;
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$script = <<<JS

var myModal = new bootstrap.Modal(document.getElementById('modalFormPengguna'));
var privModal = new bootstrap.Modal(document.getElementById('modalPrivilege'));
var allData = {$jsonData};

// --- TAMBAH DATA ---
$('.btn-add-modal').on('click', function() {
    $('#modalLabel').text('Pengguna, Tambah catatan baru');
    $('#dynamic-form').attr('action', '{$urlCreate}');
    $('#dynamic-form')[0].reset();
    myModal.show();
});

// --- EDIT DATA ---
$('.btn-edit-modal').on('click', function() {
    var id = $(this).data('id');
    var item = allData.find(x => x.id == id);
    
    if(item) {
        $('#modalLabel').text('Edit Pengguna');
        var baseUrl = '{$urlUpdate}';
        var separator = baseUrl.indexOf('?') !== -1 ? '&' : '?';
        $('#dynamic-form').attr('action', baseUrl + separator + 'id=' + id);
        
        $('#inputUsername').val(item.username);
        $('#inputPassword').val(item.password);
        $('#inputNamaLengkap').val(item.nama_lengkap);
        $('#inputNip').val(item.nip);
        $('#inputUnitKerja').val(item.unit_kerja);
        $('#selectBlokSistem').val(item.blok_sistem);
        
        myModal.show();
    }
});

// --- PRIVILEGE BUTTON (BARU) ---
$('.btn-privilege-modal').on('click', function() {
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    
    // Set Nama di Title & ID di Hidden Input
    $('#privilegeUserName').text(nama);
    $('#privilegeUserId').val(id);
    
    privModal.show();
});

// --- HAPUS DATA ---
$('.btn-hapus-data').on('click', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    Swal.fire({
        title: 'Hapus Data?',
        text: "Data akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus'
    }).then((result) => {
        if (result.isConfirmed) {
            var form = $('<form action="' + url + '" method="post">' +
            '<input type="hidden" name="{$csrfParam}" value="{$csrfToken}" />' +
            '</form>');
            $('body').append(form);
            form.submit();
        }
    });
});

// --- AUTOCOMPLETE ---
const searchInput = document.getElementById('search_pengguna');
const resultsBox = document.getElementById('autocomplete-results');
const searchForm = document.getElementById('form-search-pengguna');

function escapeRegExp(string) { return string.replace(/[.*+?^$\${}()|[\\]\\\\]/g, '\\$&'); }

async function fetchResults(term) {
    if (term.length < 2) {
        if(resultsBox) { resultsBox.innerHTML = ''; resultsBox.classList.add('d-none'); }
        return;
    }
    try {
        var acUrl = '{$urlAutocomplete}';
        var sep = acUrl.indexOf('?') !== -1 ? '&' : '?';
        const response = await fetch(acUrl + sep + 'term=' + encodeURIComponent(term));
        const data = await response.json();
        
        if(!resultsBox) return;
        resultsBox.innerHTML = '';
        if (data.length === 0) {
            resultsBox.classList.remove('d-none');
            resultsBox.innerHTML = '<div class="autocomplete-item-google no-result">Tidak ditemukan</div>';
            return;
        }
        resultsBox.classList.remove('d-none');
        const regex = new RegExp('(' + escapeRegExp(term) + ')', 'gi');
        data.forEach(item => {
            const div = document.createElement('div');
            div.className = 'autocomplete-item-google';
            div.innerHTML = '<i class="material-symbols-outlined">person</i><span>' + item.label.replace(regex, '<strong>$1</strong>') + '</span>';
            div.addEventListener('click', function() {
                searchInput.value = item.value;
                resultsBox.classList.add('d-none');
                searchForm.submit();
            });
            resultsBox.appendChild(div);
        });
    } catch (e) { console.error(e); }
}

if(searchInput) {
    searchInput.addEventListener('input', function() { fetchResults(this.value); });
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && resultsBox && !resultsBox.contains(e.target)) {
            resultsBox.classList.add('d-none');
        }
    });
}

// Tooltip Bootstrap
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>