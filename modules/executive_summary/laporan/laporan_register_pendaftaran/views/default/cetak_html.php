<?php

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Register Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            padding: 20px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        /* Tabel style register biasanya padat */
        table {
            border-collapse: collapse;
            width: 100%;
            color: #000;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
        }

        /* Hilangkan tombol saat print */
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

    <div class="text-center mb-4">
        <h5 style="font-weight: bold; margin-bottom: 5px;">BUKU REGISTER</h5>
        <div style="font-weight: bold; text-transform: uppercase;">
            TANGGAL: <?= date('d F Y', strtotime($params['dari_tanggal'] ?? date('Y-m-01'))) ?>
            S/D <?= date('d F Y', strtotime($params['sampai_tanggal'] ?? date('Y-m-d'))) ?>
        </div>
    </div>

    <div class="table-wrap">
        <table class="table-bordered">
            <thead class="text-center" style="background-color: #fff; font-weight: bold;">
                <tr>
                    <th width="3%">No</th>
                    <th width="15%">Pemohon/Perusahaan</th>
                    <th width="15%">Alamat Pemohon/Lokasi</th>
                    <th width="8%">Biaya</th>
                    <th width="10%">No Izin</th>
                    <th width="10%">Nama Pengambil</th>
                    <th width="8%">Tanggal Pengambil</th>
                    <th width="8%">Ttd Pengambil</th>
                    <th width="8%">Ttd Petugas</th>
                    <th width="10%">Permohonan</th>
                    <th width="5%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($dataProvider->totalCount > 0): ?>
                    <?php foreach ($dataProvider->getModels() as $index => $row): ?>
                        <tr>
                            <td class="text-center"><?= $index + 1 ?></td>
                            <td><?= Html::encode($row['pemohon']) ?></td>
                            <td><?= Html::encode($row['alamat']) ?></td>
                            <td class="text-end">Rp <?= number_format($row['biaya'], 0, ',', '.') ?></td>
                            <td class="text-center"><?= Html::encode($row['no_izin']) ?></td>
                            <td><?= Html::encode($row['nama_pengambil']) ?></td>
                            <td class="text-center"><?= date('d-m-Y', strtotime($row['tgl_pengambil'])) ?></td>
                            <td></td>
                            <td></td>
                            <td><?= Html::encode($row['permohonan']) ?></td>
                            <td><?= Html::encode($row['keterangan']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center py-4">Data tidak ditemukan pada periode ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>