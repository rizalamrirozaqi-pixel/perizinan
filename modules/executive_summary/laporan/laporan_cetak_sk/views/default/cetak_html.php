<?php

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Cetak SK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            padding: 20px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            white-space: nowrap;
        }

        /* Hilangkan tombol saat diprint */
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
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="bi bi-printer"></i> Cetak Dokumen
            </button>
            <button onclick="window.close()" class="btn btn-secondary btn-sm">
                Tutup
            </button>
        </div>
    <?php endif; ?>

    <div class="text-center mb-4">
        <h5 style="margin-bottom:0; font-weight:bold;">REKAPITULASI SK IZIN USAHA JASA KONSTRUKSI (IUJK)</h5>
        <h5 style="margin-bottom:0; font-weight:bold;">UNTUK PERMOHONAN <?= strtoupper($params['jenis_permohonan'] ?: 'SEMUA') ?></h5>
        <div>Dari Tanggal <?= date('d-m-Y', strtotime($params['dari_tanggal'] ?? date('Y-m-01'))) ?> s/d <?= date('d-m-Y', strtotime($params['sampai_tanggal'] ?? date('Y-m-d'))) ?></div>
    </div>

    <div class="table-wrap">
        <table class="table table-bordered table-sm table-striped border-dark">
            <thead class="text-center align-middle" style="background-color: #f0f0f0; font-weight: bold;">
                <tr>
                    <th>No</th>
                    <th>Nama Pemohon</th>
                    <th>Nama Usaha</th>
                    <th>Lokasi Izin</th>
                    <th>Kelurahan</th>
                    <th>Kecamatan</th>
                    <th>Asosiasi</th>
                    <th>Kualifikasi</th>
                    <th>Kegiatan Usaha</th>
                    <th>Klasifikasi Usaha</th>
                    <th>Tgl Penetapan</th>
                    <th>Tgl Berlaku</th>
                    <th>Jns Permohonan</th>
                    <th>Penanggung Jawab</th>
                    <th>Alamat Tenaga</th>
                    <th>Kualifikasi Tenaga</th>
                    <th>No SK</th>
                    <th>Telp</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($dataProvider->totalCount > 0): ?>
                    <?php foreach ($dataProvider->getModels() as $index => $row): ?>
                        <tr>
                            <td class="text-center"><?= $index + 1 ?></td>
                            <td><?= $row['nama_pemohon'] ?></td>
                            <td><?= $row['nama_usaha'] ?></td>
                            <td><?= $row['lokasi_izin'] ?></td>
                            <td><?= $row['kelurahan'] ?></td>
                            <td><?= $row['kecamatan'] ?></td>
                            <td><?= $row['asosiasi'] ?></td>
                            <td><?= $row['kualifikasi'] ?></td>
                            <td><?= $row['kegiatan_usaha'] ?></td>
                            <td><?= $row['klasifikasi_usaha'] ?></td>
                            <td class="text-center"><?= $row['tgl_penetapan'] ?></td>
                            <td><?= $row['tgl_berlaku'] ?></td>
                            <td><?= $row['jenis_permohonan'] ?></td>
                            <td><?= $row['penanggung_jawab'] ?></td>
                            <td><?= $row['alamat_tenaga'] ?></td>
                            <td><?= $row['kualifikasi_tenaga'] ?></td>
                            <td><?= $row['no_sk'] ?></td>
                            <td><?= $row['telp'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="18" class="text-center">Data tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>