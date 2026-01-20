<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER (actionCetak)
 * @var yii\web\View $this
 * @var array $rekapData
 * @var string $tahun
 * @var string $tanggal_cetak
 */

use yii\helpers\Url;
use yii\helpers\Html;

$bulanHeaders = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'];

// Daftarkan Asset
\app\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/images/logo-pemalang.png">
    <title>Perizinan Pemalang</title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="container-fluid" id="laporan-hasil">
        <div class="card-body p-4">

            <div class="text-center mb-4">
                <h5 class="mb-1 fw-bold">REKAPITULASI IZIN TERBIT</h5>
                <h6 class="mb-0 fw-bold">DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU KABUPATEN</h6>
                <h6 class="mb-0 fw-bold">TAHUN <?= Html::encode($tahun) ?></h6>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" style="font-size: 0.9em;">

                        <thead class="text-center">
                            <tr>
                                <th scope="col" rowspan="2" class="align-middle">No</th>
                                <th scope="col" rowspan="2" class="align-middle" style="width: 25%;">Jenis Izin</th>
                                <th scope="col" colspan="12">TAHUN <?= Html::encode($tahun) ?></th>
                                <th scope="col" rowspan="2" class="align-middle">JUMLAH</th>
                            </tr>
                            <tr>
                                <?php foreach ($bulanHeaders as $bln): ?>
                                    <th scope="col" style="width: 5%;"><?= $bln ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($rekapData)): ?>
                                <tr>
                                    <td colspan="15" class="text-center fst-italic text-secondary">Data tidak ditemukan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($rekapData as $grupKode => $grupData): ?>
                                    <?php if ($grupKode === 'total') continue;  ?>

                                    <tr class="fw-bold bg-light">
                                        <td class="text-start"><?= $grupKode ?>.</td>
                                        <td colspan="14"><?= Html::encode($grupData['nama']) ?></td>
                                    </tr>

                                    <?php foreach ($grupData['items'] as $itemNo => $itemData): ?>
                                        <tr>
                                            <td class="text-center"><?= $itemNo ?>.</td>
                                            <td><?= Html::encode($itemData['nama']) ?></td>

                                            <?php foreach ($itemData['bulanan'] as $bln_idx => $count): ?>
                                                <td class="text-center">
                                                    <?php
                                                    // Di halaman cetak, kita hanya tampilkan angka, tidak perlu link
                                                    echo ($count > 0) ? $count : 0;
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>

                                            <td class="text-center fw-bold"><?= Html::encode($itemData['jumlah']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>

                        <tfoot class="fw-bold text-center bg-light">
                            <tr>
                                <td colspan="2">Jumlah</td>
                                <?php if (!empty($rekapData['total'])): ?>
                                    <?php foreach ($rekapData['total']['bulanan'] as $bln_idx => $countTotal): ?>
                                        <td class="text-center">
                                            <?= ($countTotal > 0) ? $countTotal : 0 ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td class="text-center"><?= Html::encode($rekapData['total']['jumlah']) ?></td>
                                <?php else: ?>
                                    <td colspan="13"></td>
                                <?php endif; ?>
                            </tr>
                        </tfoot>

                    </table>
                </div>

                <div class="row justify-content-end" style="margin-top: 50px; font-size: 0.9em; page-break-inside: avoid;">
                    <div class="col-md-4 text-center">
                        <p class="mb-0">Pemalang, <?= Yii::$app->formatter->asDate($tanggal_cetak, 'php:d F Y') ?></p>
                        <p>Mengetahui,</p>
                        <p class="fw-bold" style="margin-top: 70px; text-decoration: underline;">NAMA KEPALA DINAS</p>
                        <p>NIP. XXXXXXXXXXXXXXXXXX</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
    // (FIX) CSS @media print dipindahkan ke sini
    $css = <<<CSS
@media print {
    body, html {
        margin: 0 !important;
        padding: 0 !important;
        background-color: #fff;
    }

    body > *:not(#laporan-hasil) {
        display: none !important;
    }
    
    #laporan-hasil {
        display: block !important;
        box-shadow: none !important;
        border: none !important;
        margin: 0 !important;
        width: 100% !important;
        padding: 10px !important;
    }
    
    #laporan-hasil .card-body {
       padding: 0 !important;
    }

    .table-responsive {
        overflow: visible !important;
    }
    
    .table {
        font-size: 7pt; 
        width: 100% !important;
        border-collapse: collapse !important;
    }

    .table thead {
       display: table-header-group;
    }
    
    .table th, .table td {
        border: 1px solid #dee2e6 !important; 
        padding: 0.2rem 0.2rem;
        color: #000; /* Pastikan teks cetak hitam */
    }

    tr, td, th {
       page-break-inside: avoid !important;
    }
    
    h5 { font-size: 12pt !important; color: #000; }
    h6 { font-size: 11pt !important; color: #000; }
    
    a {
        text-decoration: none;
        color: inherit;
    }
}
CSS;
    $this->registerCss($css);


    // (FIX) JS autoPrint dipindahkan ke sini
    $js = <<<JS
    setTimeout(function() {
        window.print();
    }, 500);
JS;
    $this->registerJs($js, \yii\web\View::POS_READY);
    ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>