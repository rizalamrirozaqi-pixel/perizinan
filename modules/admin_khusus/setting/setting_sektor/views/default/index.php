<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Setting Referensi Sektor';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                <h5 class="card-title fw-bold mb-0">SETTING REFERENSI SEKTOR</h5>

                <button type="button" class="btn btn-outline-primary py-2 px-4 hover-white text-primary fw-semibold d-flex align-items-center gap-2" onclick="openAddModal()">
                    <i class="material-symbols-outlined fs-20">add</i> Tambah
                </button>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="text-center text-uppercase align-middle">
                            <tr>
                                <th width="5%" class="">No</th>
                                <th class=" text-start ps-4">Nama Sektor</th>
                                <th width="15%" class="">Status</th>
                                <th width="15%" class="">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($dataProvider->totalCount > 0): ?>
                                <?php foreach ($dataProvider->getModels() as $index => $row): ?>
                                    <tr>
                                        <td class="text-center text-secondary">
                                            <?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?>
                                        </td>

                                        <td class=" text-dark ps-4">
                                            <?= Html::encode($row['nama_sektor']) ?>
                                        </td>

                                        <td class="text-center">
                                            <?php if ($row['status'] == 'Aktif'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="javascript:void(0)"
                                                    class="text-decoration-none"
                                                    onclick="openEditModal('<?= Html::encode($row['nama_sektor']) ?>', '<?= $row['status'] ?>')"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Edit Data">
                                                    <i class="material-symbols-outlined fs-20 text-warning">edit_square</i>
                                                </a>

                                                <a href="javascript:void(0)"
                                                    class="text-decoration-none"
                                                    onclick="confirmDelete(<?= $row['id'] ?>)"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Hapus Data">
                                                    <i class="material-symbols-outlined fs-20 text-danger">delete</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Data belum tersedia.</td>
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

<div class="modal fade" id="modalSektor" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTitle">Form Tambah Sektor</h1>
                <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
            </div>

            <?= Html::beginForm(['index'], 'post', ['id' => 'formSektor']) ?>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Nama Sektor</label>
                    <input type="text" name="nama_sektor" id="inputNamaSektor" class="form-control" placeholder="Masukkan nama sektor..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Status</label>
                    <select name="status" id="inputStatus" class="form-select form-control ">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger text-white" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-primary text-white">Simpan</button>
            </div>

            <?= Html::endForm() ?>

        </div>
    </div>
</div>


<script>
    // 1. Inisialisasi Variable Modal Global
    let sektorModal;

    document.addEventListener('DOMContentLoaded', function() {
        // Init Bootstrap Modal
        const modalElement = document.getElementById('modalSektor');
        // backdrop static agar tidak close saat klik luar (opsional, tapi bagus untuk form)
        sektorModal = new bootstrap.Modal(modalElement, {
            backdrop: 'static'
        });

        // Init Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });

    // 2. Fungsi Buka Modal Tambah
    function openAddModal() {
        // Reset Form
        document.getElementById('formSektor').reset();
        document.getElementById('modalTitle').innerText = 'Form Tambah Sektor';
        document.getElementById('inputStatus').value = 'Aktif'; // Default value

        // Show Modal
        sektorModal.show();
    }

    // 3. Fungsi Buka Modal Edit
    function openEditModal(nama, status) {
        document.getElementById('modalTitle').innerText = 'Form Edit Sektor';
        document.getElementById('inputNamaSektor').value = nama;
        document.getElementById('inputStatus').value = status;

        // Show Modal
        sektorModal.show();
    }

    // 4. Fungsi Tutup Modal Manual
    function closeModal() {
        sektorModal.hide();
    }

    // 5. Fungsi SweetAlert Delete
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data sektor ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Terhapus!',
                    'Data sektor berhasil dihapus.',
                    'success'
                ).then(() => {
                    location.reload();
                });
            }
        })
    }
</script>