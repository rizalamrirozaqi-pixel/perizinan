<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var bool $isSearch
 * @var array $rekapData
 * @var string $tahun
 * @var string $tanggal_cetak
 * @var array $tahunItems
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Laporan Bulanan';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = $this->title;

$bulanHeaders = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'];
?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium"><?= Html::encode($this->title) ?></span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4">
        <div class="card-body p-4">

            <?= Html::beginForm(['index'], 'get', [
                'class' => 'row g-3 align-items-end' 
            ]) ?>

            <div class="col-md-6">
                <?= Html::label('Tahun Anggaran', 'tahun', ['class' => 'form-label']) ?>
                <?= Html::dropDownList('tahun', $tahun, $tahunItems, [
                    'class' => 'form-select form-control h-55',
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= Html::label('Tanggal Cetak', 'tanggal_cetak', ['class' => 'form-label']) ?>
                <?= Html::textInput('tanggal_cetak', $tanggal_cetak, [
                    'class' => 'form-control',
                    'type' => 'date',
                    'required' => true
                ]) ?>
            </div>


            <div class="col-12 d-flex align-items-center gap-2 mt-3">
                <span class="form-label mb-0 me-2">Export:</span>
                <?= Html::submitButton('Tampilkan', [
                    'class' => 'btn btn-outline-primary py-2 px-2 fw-medium rounded-3 d-flex align-items-center justify-content-center hover-bg hover-white',
                    'name' => 'submit_btn',
                    'value' => 'cari'
                ]) ?>

                <?= Html::a('Versi Cetak', [
                    'cetak',
                    'tahun' => $tahun,
                    'tanggal_cetak' => $tanggal_cetak,
                ], [
                    'class' => 'btn btn-outline-info py-2 px-2 px-sm-4 fw-medium rounded-3 hover-bg-info d-flex align-items-center',
                    'onmouseover' => "this.style.color='#fff';",
                    'onmouseout' => "this.style.color='';",
                    'target' => '_blank',
                    'style' => $isSearch ? '' : 'display:none;'
                ]) ?>

                <?= Html::submitButton('Versi Excel', [
                    'class' => 'btn btn-outline-success py-2 px-2 px-sm-4 fw-medium rounded-3 hover-bg-success d-flex align-items-center',
                    'onmouseover' => "this.style.color='#fff';",
                    'onmouseout' => "this.style.color='';",
                    'name' => 'submit_btn',
                    'value' => 'excel',
                    'target' => '_blank',
                    'style' => $isSearch ? '' : 'display:none;'
                ]) ?>

                <?= Html::submitButton('Versi Word', [
                    'class' => 'btn btn-outline-info py-2 px-2 px-sm-4 fw-medium rounded-3 hover-bg-info d-flex align-items-center',
                    'onmouseover' => "this.style.color='#fff';",
                    'onmouseout' => "this.style.color='';",
                    'name' => 'submit_btn',
                    'value' => 'word',
                    'target' => '_blank',
                    'style' => $isSearch ? '' : 'display:none;'
                ]) ?>
            </div>

            <?= Html::endForm() ?>

        </div>
    </div>
    <?php if ($isSearch): ?>
        <div class="card bg-white border-0 rounded-3 mb-4" id="laporan-hasil">
            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <h5 class="mb-1 fw-bold fs-18">REKAPITULASI IZIN TERBIT</h5>
                </div>

                <div class="default-table-area all-products">
                    <div class="table-responsive">
                        <table class="table align-middle">

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

                                        <tr class="fw-bold ">
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
                                                        $bulan_ke = $bln_idx + 1;
                                                        if ($count > 0) {
                                                            echo Html::a(
                                                                $count,
                                                                ['detail', 'jenis_izin' => $itemData['kode'], 'tahun' => $tahun, 'bulan' => $bulan_ke],
                                                                ['target' => '_blank']
                                                            );
                                                        } else {
                                                            echo 0;
                                                        }
                                                        ?>
                                                    </td>
                                                <?php endforeach; ?>

                                                <td class="text-center fw-bold"><?= Html::encode($itemData['jumlah']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>

                            <tfoot class="fw-bold text-center">
                                <tr class="bg-body-tertiary">
                                    <td colspan="2">Jumlah</td>
                                    <?php if (!empty($rekapData['total'])): ?>
                                        <?php foreach ($rekapData['total']['bulanan'] as $bln_idx => $countTotal): ?>
                                            <td class="text-center">
                                                <?php
                                                $bulan_ke = $bln_idx + 1;
                                                if ($countTotal > 0) {
                                                    echo Html::a(
                                                        $countTotal,
                                                        ['detail', 'jenis_izin' => 'SEMUA', 'tahun' => $tahun, 'bulan' => $bulan_ke],
                                                        ['target' => '_blank']
                                                    );
                                                } else {
                                                    echo 0;
                                                }
                                                ?>
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
                </div>

            </div>
        </div>
    <?php endif; ?>

</div>


<?php

$flashes = Yii::$app->session->getAllFlashes(true);
if (!empty($flashes)) {
    $jsCode = '';
    foreach ($flashes as $key => $message) {

        if (is_array($message)) {
            $title = $message['title'] ?? 'Notifikasi';
            $text = $message['text'] ?? '...';
            $icon = $key;
        } else {
            $title = ucwords($key);
            $text = (string)$message;
            $icon = $key;
        }
        if (!in_array($icon, ['success', 'error', 'warning', 'info'])) {
            $icon = 'info';
        }
        $title = addslashes($title);
        $text = addslashes($text);
        $jsCode .= "Swal.fire({ title: '{$title}', text: '{$text}', icon: '{$icon}' });\n";
    }
    $this->registerJs($jsCode, \yii\web\View::POS_READY, 'my-sweetalert-flashes');
}
?>

<style>
    /* GANTI 'body.dark-mode' jika nama class-nya beda (cek F12) */

    /* Ini untuk baris grup di TBODY */
    body.dark-mode .table>tbody>tr.bg-body-tertiary {
        background-color: #2b3035 !important;
        color: #f8f9fa !important;
    }

    /* (FIX) INI UNTUK BARIS TFOOT ABANG */
    body.dark-mode .table>tfoot>tr.bg-body-tertiary {
        background-color: #2b3035 !important;
        color: #f8f9fa !important;
    }
</style>