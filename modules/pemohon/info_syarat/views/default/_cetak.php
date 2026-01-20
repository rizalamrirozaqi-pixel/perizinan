<?php

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Persyaratan</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            padding: 40px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }

        .header h2 {
            margin: 0 0 5px 0;
        }

        .header h4 {
            margin: 0;
            font-weight: normal;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
            vertical-align: top;
        }

        .syarat-list {
            margin-top: 10px;
        }

        .syarat-item {
            margin-bottom: 8px;
            padding-left: 25px;
            position: relative;
        }

        /* Kotak checkbox tiruan untuk cetak */
        .syarat-item::before {
            content: "";
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            position: absolute;
            left: 0;
            top: 2px;
        }

        @media print {
            @page {
                margin: 2cm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>DAFTAR PERSYARATAN IZIN</h2>
        <h4>Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu</h4>
    </div>

    <table class="info-table">
        <tr>
            <td width="150"><strong>Jenis Izin</strong></td>
            <td width="10">:</td>
            <td><?= Html::encode($namaIzin) ?></td>
        </tr>
        <tr>
            <td><strong>Jenis Permohonan</strong></td>
            <td>:</td>
            <td><?= Html::encode($namaPermohonan) ?></td>
        </tr>
    </table>

    <h3>Kelengkapan Dokumen:</h3>

    <?php if (!empty($syarat)): ?>
        <div class="syarat-list">
            <?php foreach ($syarat as $item): ?>
                <div class="syarat-item">
                    <?= Html::encode($item) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p><i>Tidak ada persyaratan khusus.</i></p>
    <?php endif; ?>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>