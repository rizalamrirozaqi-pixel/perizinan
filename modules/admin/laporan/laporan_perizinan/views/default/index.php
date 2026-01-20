<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var bool $isSearch
 * @var array $rekapData
 * @var string $tahun
 * @var string $bulan (angka)
 * @var string $tanggal_cetak
 * @var array $tahunItems
 * @var array $bulanItems (1 => 'Januari', ...)
 * @var string $bulan_ini_nama (e.g., 'OKTOBER')
 * @var string $bulan_lalu_nama (e.g., 'SEPTEMBER')
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Laporan Rekapitulasi Perizinan';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = $this->title;
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

            <div class="row g-3">
                <div class="col-md-6">
                    <?= Html::label('Tahun Anggaran', 'tahun', ['class' => 'form-label']) ?>
                    <?= Html::dropDownList('tahun', $tahun, $tahunItems, [
                        'class' => 'form-select form-control h-55',
                    ]) ?>
                </div>

                <div class="col-md-6">
                    <?= Html::label('Bulan Anggaran', 'bulan', ['class' => 'form-label']) ?>
                    <?= Html::dropDownList('bulan', $bulan, $bulanItems, [
                        'class' => 'form-select form-control h-55',
                    ]) ?>
                </div>

            </div>
            <div class="row g-3 ">
                <div class="col-md-12">
                    <?= Html::label('Tanggal Cetak', 'tanggal_cetak', ['class' => 'form-label']) ?>
                    <?= Html::textInput('tanggal_cetak', $tanggal_cetak, [
                        'class' => 'form-control',
                        'type' => 'date',
                        'required' => true
                    ]) ?>
                </div>
            </div>

            <div class="row g-3 ">
                <div class="col-md-3 d-flex gap-2">
                    <?= Html::submitButton('Cari', [
                        'class' => 'btn btn-outline-primary py-2 px-2 px-sm-4 fw-medium rounded-3 hover-bg d-flex align-items-center text-nowrap',
                        'name' => 'submit_btn',
                        'value' => 'cari'
                    ]) ?>

                    <?php if ($isSearch): // Tampilkan tombol cetak HANYA jika sudah search 
                    ?>
                        <?= Html::a('Cetak HTML', [
                            'cetak', // (FIX) Arahkan ke actionCetak
                            // (FIX) Kirim parameter filter
                            'tahun' => $tahun,
                            'bulan' => $bulan,
                            'tanggal_cetak' => $tanggal_cetak,
                        ], [
                            'class' => 'btn btn-outline-info py-2 px-2 px-sm-4 fw-medium rounded-3 hover-bg-info d-flex align-items-center text-nowrap',
                            'onmouseover' => "this.style.color='#fff';",
                            'onmouseout' => "this.style.color='';",
                            'target' => '_blank'
                        ]) ?>

                        <?= Html::submitButton('Cetak Excel', [
                            'class' => 'btn btn-outline-success py-2 px-2 px-sm-4 fw-medium rounded-3 hover-bg-success d-flex align-items-center text-nowrap',
                            'onmouseover' => "this.style.color='#fff';",
                            'onmouseout' => "this.style.color='';",
                            'name' => 'submit_btn',
                            'value' => 'excel',
                            'formtarget' => '_blank'
                        ]) ?>
                    <?php endif; ?>
                </div>
            </div>

            <?= Html::endForm() ?>

        </div>
    </div>

    <?php if ($isSearch): // Tampilkan hasil HANYA jika sudah search 
    ?>
        <div class="card bg-white border-0 rounded-3 mb-4" id="laporan-hasil">
            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <h5 class="mb-1 fw-bold">LAPORAN PENYELENGGARAAN PELAYANAN PERIZINAN DI DPM-PTSP KABUPATEN</h5>
                    <h6 class="mb-0 fw-bold">KEADAAN BULAN <?= Html::encode($bulan_ini_nama) ?> <?= Html::encode($tahun) ?></h6>
                </div>

                <div class="default-table-area all-products">
                    <div class="table-responsive">
                        <table class="table align-middle">

                            <thead class="text-center">
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
                                    $bulan_lalu = ($bulan == 1) ? 12 : ($bulan - 1);
                                    $tahun_lalu = ($bulan == 1) ? ($tahun - 1) : $tahun;

                                    $params_prev = ['tahun' => $tahun_lalu, 'sd_bulan' => $bulan_lalu];
                                    $params_current = ['tahun' => $tahun, 'bulan' => $bulan];
                                    $params_total = ['tahun' => $tahun, 'sd_bulan' => $bulan];
                                    ?>

                                    <?php foreach ($rekapData as $grupKode => $grupData): ?>
                                        <?php if ($grupKode === 'total') continue;
                                        ?>

                                        <tr class="fw-bold">
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

                            <tfoot class="fw-bold text-center">
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
                </div>

            </div>
        </div>
    <?php endif; ?>
</div>


<?php
// (FIX) CSS Media Print dan JS AutoPrint DIHAPUS dari sini

// Script untuk SweetAlert biarkan saja
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