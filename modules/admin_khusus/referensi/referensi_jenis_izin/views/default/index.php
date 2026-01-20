<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var array $models */
/** @var yii\data\Pagination $pagination */
/** @var string $allDataJson */
/** @var array $sektorOptions */

$this->title = 'Referensi Jenis Izin';
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

                <?= Html::beginForm(['index'], 'get', ['id' => 'form-search-izin', 'class' => 'table-src-form align-items-center']) ?>
                <div class="col-md-5 position-relative">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y" style="z-index: 10; color: #6c757d;">search</i>
                    <div id="autocomplete-container" class="position-relative" style="width: 400px;">
                        <?= Html::textInput('search', Yii::$app->request->get('search'), [
                            'id' => 'search_izin',
                            'class' => 'form-control',
                            'style' => 'padding-left: 3rem; width: 400px;',
                            'placeholder' => 'Cari Nama Jenis Izin...',
                            'autocomplete' => 'off'
                        ]) ?>
                        <div id="autocomplete-results" class="position-absolute top-100 start-0 end-0 z-3 shadow-sm bg-white overflow-auto d-none google-autocomplete"></div>
                    </div>
                </div>
                <?= Html::endForm() ?>

                <button type="button" class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg d-flex align-items-center btn-add-modal">
                    <span class="py-sm-1 d-block d-flex align-items-center">
                        <i class="fs-18 material-symbols-outlined me-1">add</i>
                        <span>Tambah Jenis Izin</span>
                    </span>
                </button>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jenis Izin</th>
                                <th>Sektor</th>
                                <th>Lama Proses</th>
                                <th>Berbayar</th>
                                <th>Icon</th>
                                <th>Status</th>
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
                                    <td class="text-secondary"><?= Html::encode($model['nama_jenis_izin']) ?></td>

                                    <td>
                                        <span class="text-secondary">
                                            <?= Html::encode($model['sektor'] ?? '-') ?>
                                        </span>
                                    </td>

                                    <td class="text-secondary"><?= Html::encode($model['lama_proses']) ?> Hari</td>
                                    <td>
                                        <span class="text-seondary">
                                            <?= $model['berbayar'] == 'T' ? 'Ya' : 'Tidak' ?>
                                        </span>
                                    </td>
                                    <td class="text-secondary">
                                        <?php
                                        $iconName = $model['icon'] ?? '';
                                        $imgUrl = $iconName ? Yii::getAlias('@web/uploads/' . $iconName) : '';
                                        ?>
                                        <?php if ($iconName): ?>
                                            <img src="<?= $imgUrl ?>" alt="Icon" class="rounded" style="width: 32px; height: 32px; object-fit: contain; border: 1px solid #eee;" onerror="this.style.display='none'">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $model['is_aktif'] == 'T' ? 'success' : 'danger' ?> bg-opacity-10 text-<?= $model['is_aktif'] == 'T' ? 'success' : 'danger' ?> rounded-pill px-3">
                                            <?= $model['is_aktif'] == 'T' ? 'Aktif' : 'Non-Aktif' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="javascript:void(0);"
                                                class="text-decoration-none btn-edit-modal"
                                                data-id="<?= $model['id'] ?>"
                                                data-bs-toggle="tooltip"
                                                data-bs-title="Edit Data">
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

<div class="modal fade" id="modalFormIzin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalLabel">Tambah Jenis Izin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'dynamic-form',
                'action' => ['create'],
                'method' => 'post',
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>

            <div class="modal-body p-4">

                <div class="mb-3">
                    <label class="form-label fw-medium text-secondary">Sektor <span class="text-danger">*</span></label>
                    <select class="form-select form-control" name="DynamicModel[sektor]" id="selectSektor" required>
                        <option value="">Silahkan pilih</option>
                        <?php foreach ($sektorOptions as $value => $label): ?>
                            <option value="<?= $value ?>"><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-secondary">Nama Jenis Izin</label>
                    <input type="text" name="DynamicModel[nama_jenis_izin]" id="inputNama" class="form-control" required placeholder="Contoh: Izin Usaha...">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-secondary">Lama Proses (Hari)</label>
                    <input type="number" name="DynamicModel[lama_proses]" id="inputLama" class="form-control" required placeholder="0">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-secondary">Icon (Gambar)</label>
                    <div class="input-group">
                        <input type="file" name="DynamicModel[icon]" id="inputIconFile" class="form-control" accept="image/*">
                    </div>
                    <small class="text-muted d-block mt-1 fst-italic" id="currentIconText"></small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-secondary d-block">Berbayar?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="DynamicModel[berbayar]" id="radioBayarT" value="T">
                        <label class="form-check-label" for="radioBayarT">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="DynamicModel[berbayar]" id="radioBayarF" value="F" checked>
                        <label class="form-check-label" for="radioBayarF">Tidak</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-secondary d-block">Terstruktur?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="DynamicModel[terstruktur]" id="terstrukturT" value="T">
                        <label class="form-check-label" for="terstrukturT">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="DynamicModel[terstruktur]" id="terstrukturF" value="F" checked>
                        <label class="form-check-label" for="terstrukturF">Tidak</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-secondary d-block">Status?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="DynamicModel[is_aktif]" id="statusT" value="T">
                        <label class="form-check-label" for="statusT">Aktif</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="DynamicModel[is_aktif]" id="statusF" value="F" checked>
                        <label class="form-check-label" for="statusF">Tidak Aktif</label>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary text-white">Simpan</button>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$urlCreate = Url::to(['create']);
$urlUpdate = Url::to(['update']);
$urlAutocomplete = Url::to(['search-izin']);
$jsonData = $allDataJson;
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$script = <<<JS

var myModal = new bootstrap.Modal(document.getElementById('modalFormIzin'));
var allData = {$jsonData};

// --- TAMBAH DATA ---
$('.btn-add-modal').on('click', function() {
    $('#modalLabel').text('Tambah Jenis Izin');
    $('#dynamic-form').attr('action', '{$urlCreate}');
    $('#dynamic-form')[0].reset();
    $('#currentIconText').text('');
    
    // Default Values
    $('#radioBayarF').prop('checked', true);
    $('#terstrukturT').prop('checked', true);
    $('#statusT').prop('checked', true); 
    $('#selectSektor').val(''); // Reset Sektor
    
    myModal.show();
});

// --- EDIT DATA ---
$('.btn-edit-modal').on('click', function() {
    var id = $(this).data('id');
    var item = allData.find(x => x.id == id);
    
    if(item) {
        $('#modalLabel').text('Edit Jenis Izin');
        
        var baseUrl = '{$urlUpdate}';
        var separator = baseUrl.indexOf('?') !== -1 ? '&' : '?';
        $('#dynamic-form').attr('action', baseUrl + separator + 'id=' + id);
        
        // Isi Form
        $('#selectSektor').val(item.sektor); // Set Sektor
        $('#inputNama').val(item.nama_jenis_izin);
        $('#inputLama').val(item.lama_proses);
        
        // Info File
        var iconName = item.icon ? item.icon : 'Belum ada file';
        $('#currentIconText').text('File saat ini: ' + iconName);
        $('#inputIconFile').val(''); 
        
        // Radio Buttons
        if(item.berbayar === 'T') $('#radioBayarT').prop('checked', true);
        else $('#radioBayarF').prop('checked', true);
        
        if(item.terstruktur === 'T') $('#terstrukturT').prop('checked', true);
        else $('#terstrukturF').prop('checked', true);

        if(item.is_aktif === 'T') $('#statusT').prop('checked', true);
        else $('#statusF').prop('checked', true);
        
        myModal.show();
    } else {
        alert('Data tidak ditemukan di session browser.');
    }
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
const searchInput = document.getElementById('search_izin');
const resultsBox = document.getElementById('autocomplete-results');
const searchForm = document.getElementById('form-search-izin');

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
            div.innerHTML = '<i class="material-symbols-outlined">search</i><span>' + item.label.replace(regex, '<strong>$1</strong>') + '</span>';
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

// Init Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>