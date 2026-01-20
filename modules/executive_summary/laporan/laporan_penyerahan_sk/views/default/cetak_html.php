<?php

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penyerahan SK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11px;
            padding: 20px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            color: #000;
            white-space: nowrap;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: middle;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            @page {
                size: landscape;
                margin: 10mm;
            }
        }
    </style>
</head>

<body>

    <?php if (!$isExcel): ?>
        <div class="mb-3 no-print">
            <button onclick="window.print()" class="btn btn-primary btn-sm">Cetak</button>
            <button onclick="window.close()" class="btn btn-secondary btn-sm">Tutup</button>
        </div>
    <?php endif; ?>

    <div class="text-center mb-2">
        <h5 style="font-weight: bold; margin-bottom: 5px;">DAFTAR PENYERAHAN SK</h5>
        <div style="font-weight: bold;">
            Tanggal <?= date('d-m-Y', strtotime($params['dari_tanggal'] ?? date('Y-m-01'))) ?>
            s/d <?= date('d-m-Y', strtotime($params['sampai_tanggal'] ?? date('Y-m-d'))) ?>
        </div>
    </div>

    <div class="table-wrap">
        <table class="table-bordered">
            <thead class="text-center fw-bold" style="background-color: #fff;">
                <tr>
                    <th>No</th>
                    <th>Nomor Pendaftaran</th>
                    <th>Nama Pemohon</th>
                    <th>Nama Usaha</th>
                    <th>Jenis Izin</th>
                    <th>Retribusi</th>
                    <th>Nomor SK</th>
                    <th>Tanggal SK</th>
                    <th>Tanggal Habis Berlaku</th>
                    <th>Tanggal Diserahkan</th>
                    <th>Diterima Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($dataProvider->totalCount > 0): ?>
                    <?php foreach ($dataProvider->getModels() as $index => $row): ?>
                        <tr>
                            <td class="text-center"><?= $index + 1 ?></td>
                            <td><?= Html::encode($row['no_pendaftaran']) ?></td>
                            <td><?= Html::encode($row['nama_pemohon']) ?></td>
                            <td><?= Html::encode($row['nama_usaha']) ?></td>
                            <td><?= Html::encode($row['jenis_izin']) ?></td>
                            <td class="text-end">Rp <?= number_format($row['retribusi'], 0, ',', '.') ?></td>
                            <td><?= Html::encode($row['nomor_sk']) ?></td>
                            <td class="text-center"><?= $row['tgl_sk'] ?></td>
                            <td class="text-center"><?= $row['tgl_habis'] ?></td>
                            <td class="text-center"><?= $row['tgl_diserahkan'] ?></td>
                            <td><?= Html::encode($row['diterima_oleh']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center py-4">Data tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>