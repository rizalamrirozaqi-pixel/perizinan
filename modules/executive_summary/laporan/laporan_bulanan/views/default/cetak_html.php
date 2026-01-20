<?php

use yii\helpers\Html;

$tahun = $params['tahun'] ?? date('Y');
$monthsShort = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'];

// Re-declare helper function karena scope beda file
function renderPrintRows($dataGroup, &$no, &$grandTotal)
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
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Bulanan - Cetak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            white-space: nowrap;
        }

        table th,
        table td {
            border: 1px solid #000 !important;
            padding: 4px;
        }

        .fw-bold {
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            @page {
                size: landscape;
                margin: 5mm;
            }
        }
    </style>
</head>

<body>
    <div class="mb-3 no-print">
        <button onclick="window.print()" class="btn btn-primary btn-sm">Cetak Dokumen</button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm">Tutup</button>
    </div>

    <div class="text-center mb-3">
        <h5 class="fw-bold mb-0">REKAPITULASI IZIN TERBIT</h5>
        <div class="fw-bold">TAHUN <?= $tahun ?></div>
    </div>

    <table class="table table-sm">
        <thead class="text-center fw-bold align-middle">
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
            <tr class="fw-bold bg-light">
                <td></td>
                <td colspan="14">A. PERIZINAN TERSTRUKTUR</td>
            </tr>
            <?php renderPrintRows($groupA, $no, $grandTotal); ?>

            <tr class="fw-bold bg-light">
                <td></td>
                <td colspan="14">B. PERIZINAN TIDAK TERSTRUKTUR</td>
            </tr>
            <?php $no = 1;
            renderPrintRows($groupB, $no, $grandTotal); ?>
        </tbody>
        <tfoot class="fw-bold">
            <tr>
                <td colspan="2" class="text-center">Jumlah</td>
                <?php foreach ($grandTotal as $val): ?><td class="text-center"><?= number_format($val, 0, ',', '.') ?></td><?php endforeach; ?>
            </tr>
        </tfoot>
    </table>
</body>

</html>