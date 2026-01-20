<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Data Izin Terbit (SK)';
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="<?= Url::to(['/executive_summary/dashboard/default/index']) ?>" class="d-flex align-items-center text-decoration-none">
                        <i class="material-symbols-outlined fs-18 text-primary me-1">home</i>
                        <span class="text-secondary fw-medium hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active"><span class="fw-medium">Izin Terbit (SK)</span></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4 border-bottom pb-2">Filter Data Izin</h5>

            <?= Html::beginForm(['index'], 'get', ['class' => 'row g-3']) ?>

            <div class="col-md-6">
                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Nomor Daftar</label>
                    <div class="col-sm-8">
                        <?= Html::textInput('no_daftar', $params['no_daftar'] ?? '', ['class' => 'form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Jenis Izin</label>
                    <div class="col-sm-8">
                        <?= Html::dropDownList('jenis_izin', $params['jenis_izin'] ?? '', ['' => '-- Pilih Jenis Izin --', 'SIUP' => 'SIUP', 'IMB' => 'IMB'], ['class' => 'form-select form-select-sm form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Jenis Permohonan</label>
                    <div class="col-sm-8">
                        <?= Html::dropDownList('jenis_permohonan', $params['jenis_permohonan'] ?? '', ['' => '-- Pilih Jenis Permohonan --', 'Baru' => 'Baru', 'Perpanjangan' => 'Perpanjangan'], ['class' => 'form-select form-select-sm form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Nama Pemohon</label>
                    <div class="col-sm-8">
                        <?= Html::textInput('nama_pemohon', $params['nama_pemohon'] ?? '', ['class' => 'form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Nama Usaha</label>
                    <div class="col-sm-8">
                        <?= Html::textInput('nama_usaha', $params['nama_usaha'] ?? '', ['class' => 'form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Nomor KTP</label>
                    <div class="col-sm-8">
                        <?= Html::textInput('no_ktp', $params['no_ktp'] ?? '', ['class' => 'form-control form-control-sm']) ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Alamat</label>
                    <div class="col-sm-8">
                        <?= Html::textarea('alamat', $params['alamat'] ?? '', ['class' => 'form-control form-control-sm', 'rows' => 1]) ?>
                    </div>
                </div>

                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Kecamatan</label>
                    <div class="col-sm-8">
                        <?= Html::dropDownList('kecamatan', $params['kecamatan'] ?? '', ['' => '-- Pilih Kecamatan --', 'Pemalang' => 'Pemalang', 'Taman' => 'Taman'], ['class' => 'form-select form-select-sm form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Kelurahan</label>
                    <div class="col-sm-8">
                        <?= Html::dropDownList('kelurahan', $params['kelurahan'] ?? '', ['' => '-- Pilih Kelurahan --'], ['class' => 'form-select form-select-sm form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Status Pendaftaran</label>
                    <div class="col-sm-8">
                        <?= Html::dropDownList('status', $params['status'] ?? 'OFFLINE', ['OFFLINE' => 'OFFLINE', 'ONLINE' => 'ONLINE'], ['class' => 'form-select form-select-sm form-control form-control-sm']) ?>
                    </div>
                </div>

                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Tgl Cetak (Dari)</label>
                    <div class="col-sm-8">
                        <input type="date" name="dari_tanggal" class="form-control form-control-sm" value="<?= $params['dari_tanggal'] ?? '' ?>">
                    </div>
                </div>

                <div class="mb-2 row align-items-center">
                    <label class="col-sm-4 col-form-label text-secondary small fw-medium">Tgl Cetak (Sampai)</label>
                    <div class="col-sm-8">
                        <input type="date" name="sampai_tanggal" class="form-control form-control-sm" value="<?= $params['sampai_tanggal'] ?? '' ?>">
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3 text-end border-top pt-3">
                <button type="submit" class="btn btn-primary px-4 d-inline-flex align-items-center gap-2">
                    <i class="material-symbols-outlined fs-18">search</i> Cari
                </button>
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-uppercase">DAFTAR REKAPITULASI DATA IZIN TERBIT SK</h6>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="text-center fw-bold align-middle">
                            <tr>
                                <th>No.</th>
                                <th>Nomor Pendaftaran</th>
                                <th>Tgl Pendaftaran</th>
                                <th>Nama Pemohon</th>
                                <th>Nama Usaha</th>
                                <th>Alamat Pemohon</th>
                                <th>Nama Izin</th>
                                <th>Nama Permohonan</th>
                                <th>Lokasi</th>
                                <th>Kecamatan/Kelurahan</th>
                                <th>Nomor SK</th>
                                <th>Retribusi</th>
                                <th>Tgl. Pengesahan</th>
                                <th>Tgl. Berlaku SK</th>
                                <th>Tgl. Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($dataProvider->totalCount > 0): ?>
                                <?php foreach ($dataProvider->getModels() as $index => $row): ?>
                                    <tr>
                                        <td class="text-center"><?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?></td>
                                        <td><?= Html::encode($row['no_pendaftaran']) ?></td>
                                        <td class="text-center"><?= Html::encode($row['tgl_pendaftaran']) ?></td>
                                        <td class="fw-medium text-primary"><?= Html::encode($row['nama_pemohon']) ?></td>
                                        <td><?= Html::encode($row['nama_usaha']) ?></td>
                                        <td><?= Html::encode($row['alamat_pemohon']) ?></td>
                                        <td><?= Html::encode($row['nama_izin']) ?></td>
                                        <td class="text-center"><?= Html::encode($row['nama_permohonan']) ?></td>
                                        <td><?= Html::encode($row['lokasi']) ?></td>
                                        <td><?= Html::encode($row['kecamatan_kelurahan']) ?></td>
                                        <td class="fw-bold"><?= Html::encode($row['nomor_sk']) ?></td>
                                        <td class="text-end">Rp <?= number_format($row['retribusi'], 0, ',', '.') ?></td>
                                        <td class="text-center"><?= $row['tgl_pengesahan'] ?></td>
                                        <td class="text-center"><?= $row['tgl_berlaku'] ?></td>
                                        <td class="text-center"><?= $row['tgl_selesai'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="15" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
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