<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Laporan Bulanan';
$tahun = $params['tahun'] ?? date('Y');
$monthsShort = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'];

function renderTableRows($dataGroup, &$no, &$grandTotal)
{
    foreach ($dataGroup as $row) {
        $rowTotal = 0;
        echo "<tr>";
        echo "<td class='text-center'>{$no}</td>";
        echo "<td>" . Html::encode($row['nama']) . "</td>";
        foreach ($row['data'] as $idx => $val) {
            echo "<td class='text-center'>" . ($val == 0 ? '0' : number_format($val, 0, ',', '.')) . "</td>";
            $rowTotal += $val;
            $grandTotal[$idx] += $val;
        }
        echo "<td class='text-center fw-bold'>" . ($rowTotal == 0 ? '0' : number_format($rowTotal, 0, ',', '.')) . "</td>";
        $grandTotal[12] += $rowTotal;
        echo "</tr>";
        $no++;
    }
}
?>

<div class="main-content-container overflow-hidden">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/executive_summary/dashboard/default/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="material-symbols-outlined fs-18 text-primary me-1">home</i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active"><span class="fw-medium">Laporan</span></li>
                <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Filter & Export</h5>

            <?= Html::beginForm(['index'], 'get', ['class' => 'row g-3 align-items-end']) ?>

            <div class="row mb-2">
                <div class="col-md-6">
                    <label class="form-label small mb-1">Tahun Anggaran</label>
                    <?= Html::dropDownList('tahun', $tahun, array_combine(range(date('Y'), 2020), range(date('Y'), 2020)), ['class' => 'form-select form-select-sm form-control form-control-sm']) ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label small mb-1">Tanggal Cetak</label>
                    <input type="date" name="tgl_cetak" class="form-control form-control-sm" value="<?= $params['tgl_cetak'] ?? date('Y-m-d') ?>">
                </div>
            </div>

            <div class="col-md-8 d-flex align-items-end gap-2">

                <button type="submit"
                    formaction="<?= Url::to(['cetak-html']) ?>"
                    formtarget="_blank"
                    class="btn hover-white px-3 py-2 btn-outline-dark d-flex align-items-center gap-1">
                    <i class="material-symbols-outlined fs-16">print</i> versi cetak
                </button>

                <button type="button" class="btn hover-white px-3 py-2 btn-outline-success d-flex align-items-center gap-1">
                    <i class="material-symbols-outlined fs-16">table_view</i> versi excel
                </button>
                <button type="button" class="btn hover-white px-3 py-2 btn-outline-primary d-flex align-items-center gap-1">
                    <i class="material-symbols-outlined fs-16">description</i> versi word
                </button>

                <button type="submit" class="btn hover-white px-3 py-2 btn-primary">
                    <i class="material-symbols-outlined fs-16">search</i> Tampilkan
                </button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <div class="text-center mb-4 text-uppercase fw-bold">REKAPITULASI IZIN TERBIT</div>
            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="text-center fw-bold align-middle bg-white">
                            <tr>
                                <th rowspan="2" width="3%">No</th>
                                <th rowspan="2">JENIS IZIN</th>
                                <th colspan="12">TAHUN <?= $tahun ?></th>
                                <th rowspan="2" width="5%">JUMLAH</th>
                            </tr>
                            <tr>
                                <?php foreach ($monthsShort as $mon): ?>
                                    <th width="4%"><?= $mon ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = array_fill(0, 13, 0);
                            $no = 1;
                            ?>
                            <tr class="fw-bold ">
                                <td></td>
                                <td colspan="14">A. PERIZINAN TERSTRUKTUR</td>
                            </tr>
                            <?php renderTableRows($groupA, $no, $grandTotal); ?>

                            <tr class="fw-bold ">
                                <td></td>
                                <td colspan="14">B. PERIZINAN TIDAK TERSTRUKTUR</td>
                            </tr>
                            <?php $no = 1;
                            renderTableRows($groupB, $no, $grandTotal); ?>
                        </tbody>
                        <tfoot class="fw-bold">
                            <tr>
                                <td colspan="2" class="text-center">Jumlah</td>
                                <?php foreach ($grandTotal as $val): ?><td class="text-center"><?= number_format($val, 0, ',', '.') ?></td><?php endforeach; ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>