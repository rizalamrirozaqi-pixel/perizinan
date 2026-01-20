<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Laporan Perizinan';

// Helper nama bulan
$bulanList = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];

$selectedBulan = $params['bulan'] ?? date('m');
$namaBulan = $bulanList[$selectedBulan] ?? 'Bulan Ini';
// Nama bulan lalu (simple logic)
$prevBulanIndex = str_pad((int)$selectedBulan - 1, 2, '0', STR_PAD_LEFT);
$namaBulanLalu = $bulanList[$prevBulanIndex] ?? 'Bulan Lalu';

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
                <li class="breadcrumb-item active"><span class="fw-medium">Laporan</span></li>
                <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Filter Laporan</h5>

            <?= Html::beginForm(['index'], 'get', ['class' => 'row g-3 align-items-end']) ?>

            <div class="col-md-12 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="formatExcel" checked>
                    <label class="form-check-label" for="formatExcel">
                        Format Cetakan : Excel
                    </label>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4">
                    <label class="form-label fw-medium text-secondary small mb-1">Tahun Anggaran</label>
                    <?= Html::dropDownList(
                        'tahun',
                        $params['tahun'] ?? date('Y'),
                        array_combine(range(date('Y'), 2020), range(date('Y'), 2020)),
                        ['class' => 'form-select form-select-sm form-control form-control-sm']
                    ) ?>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium text-secondary small mb-1">Bulan Anggaran</label>
                    <?= Html::dropDownList('bulan', $selectedBulan, $bulanList, ['class' => 'form-select form-select-sm form-control form-control-sm']) ?>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium text-secondary small mb-1">Tanggal Cetak</label>
                    <input type="date" name="tgl_cetak" class="form-control form-control-sm" value="<?= $params['tgl_cetak'] ?? date('Y-m-d') ?>">
                </div>
            </div>


            <div class="col-md-12 d-flex align-items-end justify-content-start gap-2">

                <button type="submit"
                    id="btn-cetak-laporan"
                    class="btn btn-primary btn-sm px-4 py-2 d-flex align-items-center gap-2 hover-white">
                    Cetak
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <div class="text-center mb-4 text-uppercase fw-bold">
                LAPORAN PENYELENGGARAAN PELAYANAN PERIJINAN DI DPM-PTSP PEMALANG<br>
                KEADAAN BULAN <?= strtoupper($namaBulan) ?> <?= $params['tahun'] ?? date('Y') ?>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle ">

                        <thead class="text-center fw-bold align-middle">
                            <tr>
                                <th rowspan="2" width="3%">No</th>
                                <th rowspan="2">Jenis Izin</th>
                                <th colspan="4">s/d Bulan <?= $namaBulanLalu ?></th>
                                <th colspan="4">Bulan <?= $namaBulan ?></th>
                                <th colspan="4">s/d Bulan <?= $namaBulan ?></th>
                            </tr>
                            <tr>
                                <?php for ($i = 0; $i < 3; $i++): ?>
                                    <th width="5%">Masuk</th>
                                    <th width="5%">Terbit</th>
                                    <th width="5%">Proses</th>
                                    <th width="5%">Ditolak</th>
                                <?php endfor; ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $grandTotal = array_fill(0, 12, 0);
                            $no = 1;
                            ?>

                            <tr class="fw-bold ">
                                <td></td>
                                <td colspan="13">A. Perizinan Terstruktur</td>
                            </tr>
                            <?php foreach ($dataGroupA as $row): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= Html::encode($row['nama']) ?></td>

                                    <?php
                                    $allCols = array_merge($row['lalu'], $row['ini'], $row['total']);
                                    foreach ($allCols as $idx => $val) {
                                        $grandTotal[$idx] += $val;
                                        echo "<td class='text-center'>" . ($val == 0 ? '0' : number_format($val, 0, ',', '.')) . "</td>";
                                    }
                                    ?>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="fw-bold ">
                                <td></td>
                                <td colspan="13">B. Perizinan Tidak Terstruktur</td>
                            </tr>
                            <?php
                            $no = 1; // Reset nomor untuk group B
                            foreach ($dataGroupB as $row):
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= Html::encode($row['nama']) ?></td>
                                    <?php
                                    $allCols = array_merge($row['lalu'], $row['ini'], $row['total']);
                                    foreach ($allCols as $idx => $val) {
                                        $grandTotal[$idx] += $val;
                                        echo "<td class='text-center'>" . ($val == 0 ? '0' : number_format($val, 0, ',', '.')) . "</td>";
                                    }
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <tfoot class="fw-bold">
                            <tr>
                                <td colspan="2" class="text-center">Total</td>
                                <?php foreach ($grandTotal as $val): ?>
                                    <td class="text-center"><?= number_format($val, 0, ',', '.') ?></td>
                                <?php endforeach; ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>