<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER (actionCetak)
 * @var yii\web\View $this
 * @var array $rekapData
 * @var string $tahun
 * @var string $bulan (angka)
 * @var string $tanggal_cetak
 * @var string $bulan_ini_nama (e.g., 'OKTOBER')
 * @var string $bulan_lalu_nama (e.g., 'SEPTEMBER')
 */

use yii\helpers\Html;

// Mendaftarkan AppAsset agar mendapat styling dasar Bootstrap
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
                <h5 class="mb-1 fw-bold">LAPORAN PENYELENGGARAAN PELAYANAN PERIZINAN DI DPM-PTSP KABUPATEN</h5>
                <h6 class="mb-0 fw-bold">KEADAAN BULAN <?= Html::encode($bulan_ini_nama) ?> <?= Html::encode($tahun) ?></h6>
            </div>

            <div class="default-table-area all-products">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered">

                        <thead class="text-center" style="font-size: 0.9em;">
                            <tr>
                                <th scope="col" rowspan="2" class="align-middle">No</th>
                                <th scope="col" rowspan="2" class="align-middle">Jenis Izin</th>
                                <th scope="col" colspan="4">s/d Bulan <?= Html::encode($bulan_lalu_nama) ?></th>
                                <th scope="col" colspan="4">Bulan <?= Html::encode($bulan_ini_nama) ?></th>
                                <th scope="col" colspan="4">s/d Bulan <?= Html::encode($bulan_ini_nama) ?></th>
                            </tr>
                            <tr>
                                <th scope="col">Masuk</th>
                                <th scope="col">Terbit</th>
                                <th scope="col">Proses</th>
                                <th scope="col">Ditolak</th>
                                <th scope="col">Masuk</th>
                                <th scope="col">Terbit</th>
                                <th scope="col">Proses</th>
                                <th scope="col">Ditolak</th>
                                <th scope="col">Masuk</th>
                                <th scope="col">Terbit</th>
                                <th scope="col">Proses</th>
                                <th scope="col">Ditolak</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($rekapData)): ?>
                                <tr>
                                    <td colspan="14" class="text-center fst-italic text-secondary">Data tidak ditemukan.</td>
                                </tr>
                            <?php else: ?>
                                <?php
                                // Siapkan parameter untuk link
                                $bulan_lalu = ($bulan == 1) ? 12 : ($bulan - 1);
                                $tahun_lalu = ($bulan == 1) ? ($tahun - 1) : $tahun;

                                $params_prev = ['tahun' => $tahun_lalu, 'sd_bulan' => $bulan_lalu];
                                $params_current = ['tahun' => $tahun, 'bulan' => $bulan];
                                $params_total = ['tahun' => $tahun, 'sd_bulan' => $bulan];
                                ?>

                                <?php foreach ($rekapData as $grupKode => $grupData): ?>
                                    <?php if ($grupKode === 'total') continue; ?>

                                    <tr class="fw-bold bg-light">
                                        <td class="text-start"><?= $grupKode ?>.</td>
                                        <td colspan="13"><?= Html::encode($grupData['nama']) ?></td>
                                    </tr>

                                    <?php foreach ($grupData['items'] as $itemNo => $itemData): ?>
                                        <tr>
                                            <td class="text-center"><?= $itemNo ?>.</td>
                                            <td><?= Html::encode($itemData['nama']) ?></td>

                                            <?= $this->render('_cell', [
                                                'data' => $itemData['data']['prev'],
                                                'params' => $params_prev,
                                                'jenis_izin_kode' => $itemData['kode']
                                            ]) ?>

                                            <?= $this->render('_cell', [
                                                'data' => $itemData['data']['current'],
                                                'params' => $params_current,
                                                'jenis_izin_kode' => $itemData['kode']
                                            ]) ?>

                                            <?= $this->render('_cell', [
                                                'data' => $itemData['data']['total'],
                                                'params' => $params_total,
                                                'jenis_izin_kode' => $itemData['kode']
                                            ]) ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>

                        <tfoot class="fw-bold text-center bg-light">
                            <tr>
                                <td colspan="2">Total</td>
                                <?php if (!empty($rekapData['total'])): ?>
                                    <?= $this->render('_cell', [
                                        'data' => $rekapData['total']['prev'],
                                        'params' => $params_prev,
                                        'jenis_izin_kode' => 'SEMUA',
                                        'isTotal' => true
                                    ]) ?>

                                    <?= $this->render('_cell', [
                                        'data' => $rekapData['total']['current'],
                                        'params' => $params_current,
                                        'jenis_izin_kode' => 'SEMUA',
                                        'isTotal' => true
                                    ]) ?>

                                    <?= $this->render('_cell', [
                                        'data' => $rekapData['total']['total'],
                                        'params' => $params_total,
                                        'jenis_izin_kode' => 'SEMUA',
                                        'isTotal' => true
                                    ]) ?>
                                <?php else: ?>
                                    <td colspan="12"></td>
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
    // (FIX) CSS Media Print dipindahkan ke sini
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
        font-size: 8pt; 
        width: 100% !important;
        border-collapse: collapse !important;
    }

    .table thead {
       display: table-header-group;
    }
    
    .table th, .table td {
        border: 1px solid #dee2e6 !important; 
        padding: 0.25rem 0.25rem; 
        color: #000;
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


    // (FIX) JS AutoPrint dipindahkan ke sini
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