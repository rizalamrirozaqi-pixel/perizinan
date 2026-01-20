<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Setting Referensi Izin';
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
                <li class="breadcrumb-item text-secondary fw-medium">Setting</li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium"><?= Html::encode($this->title) ?></span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title fw-bold mb-0">SETTING REFERENSI IZIN</h5>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="text-center text-uppercase align-middle fw-bold">
                            <tr>
                                <th width="5%" class="">No</th>
                                <th class=" text-start ps-3">Nama Izin</th>
                                <th width="25%" class="">Nama Sektor</th>
                                <th width="10%" class="">Status Online</th>
                                <th width="10%" class="">Status Izin</th>
                                <th width="10%" class="">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($dataProvider->totalCount > 0): ?>
                                <?php foreach ($dataProvider->getModels() as $index => $row): ?>
                                    <tr>
                                        <td class="text-center text-secondary">
                                            <?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?>
                                        </td>

                                        <td class="fw-medium text-dark ps-3">
                                            <?= Html::encode($row['nama_izin']) ?>
                                        </td>

                                        <td class="text-secondary">
                                            <?= ($row['sektor'] == '-') ? '<span class="text-muted fst-italic">-</span>' : Html::encode($row['sektor']) ?>
                                        </td>

                                        <td class="text-center">
                                            <?= $row['status_online'] ?>
                                        </td>

                                        <td class="text-center">
                                            <?= $row['status_izin'] ?>
                                        </td>

                                        <td class="text-center">
                                            <button
                                                class="border-none"
                                                style="font-size: 0.75rem; border: none; background: none; cursor: pointer;"
                                                onclick="openEditModal(
                                                        '<?= Html::encode($row['nama_izin']) ?>', 
                                                        '<?= Html::encode($row['sektor']) ?>', 
                                                        '<?= $row['status_online'] ?>', 
                                                        '<?= $row['status_izin'] ?>'
                                                    )"
                                                data-bs-toggle="tooltip" data-bs-title="Copy Data">
                                                <i class="material-symbols-outlined fs-18 text-primary">edit</i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Data belum tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <span class="text-muted small">
                        Menampilkan <b><?= $dataProvider->getCount() ?></b> dari <b><?= $dataProvider->getTotalCount() ?></b> data
                    </span>
                    <?= LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                        'options' => ['class' => 'pagination pagination-sm mb-0'],
                        'linkContainerOptions' => ['class' => 'page-item'],
                        'linkOptions' => ['class' => 'page-link'],
                        'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                        'prevPageLabel' => '<i class="material-symbols-outlined fs-14">chevron_left</i>',
                        'nextPageLabel' => '<i class="material-symbols-outlined fs-14">chevron_right</i>',
                    ]) ?>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalEditIzin" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">EDIT DATA IZIN</h5>
                <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
            </div>

            <?= Html::beginForm(['index'], 'post', ['id' => 'formEditIzin']) ?>
            <div class="modal-body p-4">

                <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Nama Izin</label>
                    <div class="col-sm-1 text-center d-none d-sm-block">:</div>
                    <div class="col-sm-8">
                        <input type="text" name="nama_izin" id="inputNamaIzin" class="form-control bg-light" readonly>
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Sektor</label>
                    <div class="col-sm-1 text-center d-none d-sm-block">:</div>
                    <div class="col-sm-8">
                        <select name="sektor" id="inputSektor" class="form-select form-control">
                            <option value="-">-- Pilih Sektor --</option>
                            <option value="Pekerjaan umum dan perumahan rakyat">Pekerjaan umum dan perumahan rakyat</option>
                            <option value="Perindustrian">Perindustrian</option>
                            <option value="Perdagangan">Perdagangan</option>
                            <option value="Pertanian">Pertanian</option>
                            <option value="Pariwisata">Pariwisata</option>
                            <option value="Perhubungan">Perhubungan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Status Online</label>
                    <div class="col-sm-1 text-center d-none d-sm-block">:</div>
                    <div class="col-sm-4">
                        <select name="status_online" id="inputStatusOnline" class="form-select form-control">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Status Izin</label>
                    <div class="col-sm-1 text-center d-none d-sm-block">:</div>
                    <div class="col-sm-4">
                        <select name="status_izin" id="inputStatusIzin" class="form-select form-control">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="modal-footer justify-content-end border-0 pb-4">
                <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary text-white">Simpan</button>
            </div>
            <?= Html::endForm() ?>

        </div>
    </div>
</div>

<style>
    .bg-light-primary {
        background-color: #e3f2fd !important;
    }

    /* Styling Header Modal Biru */
    .modal-header.bg-primary {
        background-color: #0d6efd !important;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .modal-title {
        font-size: 1rem;
        letter-spacing: 0.5px;
    }

    /* Tombol Edit Hijau */
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    /* Pagination Icon */
    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 32px;
        width: 32px;
        padding: 0;
        color: #6c757d;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
</style>

<script>
    let izinModal;

    document.addEventListener('DOMContentLoaded', function() {
        // Init Bootstrap Modal
        const modalElement = document.getElementById('modalEditIzin');
        izinModal = new bootstrap.Modal(modalElement);
    });

    // Fungsi Buka Modal Edit
    function openEditModal(nama, sektor, statusOnline, statusIzin) {
        document.getElementById('inputNamaIzin').value = nama;
        document.getElementById('inputSektor').value = (sektor === '-') ? '' : sektor;
        document.getElementById('inputStatusOnline').value = statusOnline;
        document.getElementById('inputStatusIzin').value = statusIzin;

        // Show Modal
        izinModal.show();
    }

    // Fungsi Tutup Modal Manual
    function closeModal() {
        izinModal.hide();
    }
</script>