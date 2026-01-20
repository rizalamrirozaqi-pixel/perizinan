<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager; // Penting: Load Widget Pagination

$this->title = 'Setting Kepala Dinas';
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

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-semibold mb-0">Daftar Kepala Dinas</h5>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="text-center text-uppercase align-middle fw-bold">
                            <tr>
                                <th width="5%" class="bg-light-primary">No</th>
                                <th width="15%">NIK</th>
                                <th width="15%">NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th width="10%">Eselon</th>
                                <th width="10%">Tampil</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($dataProvider->totalCount > 0): ?>
                                <?php foreach ($dataProvider->getModels() as $index => $row): ?>
                                    <tr>
                                        <td class="text-center text-secondary">
                                            <?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?>
                                        </td>

                                        <td class="text-secondary">
                                            <?= Html::encode($row['nik']) ?>
                                        </td>

                                        <td class="text-secondary">
                                            <?= Html::encode($row['nip']) ?>
                                        </td>

                                        <td class="text-secondary">
                                            <?= Html::encode($row['nama']) ?>
                                        </td>

                                        <td>
                                            <?= Html::encode($row['jabatan']) ?>
                                        </td>

                                        <td class="text-center">
                                            <?= Html::encode($row['eselon']) ?>
                                        </td>

                                        <td class="text-center">
                                            <?php if ($row['ditampilkan'] == 'Ya'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2">Ya</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2">Tidak</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="#" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-title="Lihat File">
                                                    <i class="material-symbols-outlined fs-18 text-info">visibility</i>
                                                </a>

                                                <a href="<?= Url::to(['update', 'id' => $row['id']]) ?>" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-title="Edit Data">
                                                    <i class="material-symbols-outlined fs-18 text-warning">edit_square</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="material-symbols-outlined fs-48 text-light mb-2" style="font-size: 3rem;">folder_off</i>
                                        <p class="mb-0">Data belum tersedia.</p>
                                    </td>
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
                        'firstPageLabel' => '<i class="material-symbols-outlined fs-14">first_page</i>',
                        'lastPageLabel'  => '<i class="material-symbols-outlined fs-14">last_page</i>',
                    ]) ?>
                </div>

            </div>

        </div>
    </div>
</div>