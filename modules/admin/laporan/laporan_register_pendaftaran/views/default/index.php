<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER (actionIndex)
 * @var yii\web\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var array $models
 * @var bool $isSearch
 * @var string $tanggal_awal
 * @var string $tanggal_akhir
 * @var string $status_pendaftaran
 * @var array $statusItems
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Laporan Register Pendaftaran';
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
                    <?= Html::label('Dari Tanggal', 'tanggal_awal', ['class' => 'form-label']) ?>
                    <?= Html::textInput('tanggal_awal', $tanggal_awal, [
                        'class' => 'form-control',
                        'type' => 'date',
                        'required' => true
                    ]) ?>
                </div>

                <div class="col-md-6">
                    <?= Html::label('Sampai Tanggal', 'tanggal_akhir', ['class' => 'form-label']) ?>
                    <?= Html::textInput('tanggal_akhir', $tanggal_akhir, [
                        'class' => 'form-control',
                        'type' => 'date',
                        'required' => true
                    ]) ?>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-12">
                    <?= Html::label('Status Pendaftaran', 'status_pendaftaran', ['class' => 'form-label']) ?>
                    <?= Html::dropDownList('status_pendaftaran', $status_pendaftaran, $statusItems, [
                        'class' => 'form-select form-control h-55',
                    ]) ?>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-3 d-flex gap-2">

                    <?= Html::submitButton('Cari', [
                        'class' => 'btn btn-outline-primary px-2 px-sm-4 py-2 fw-medium rounded-3 hover-bg d-flex align-items-center text-nowrap',
                        'name' => 'submit_btn',
                        'value' => 'cari'
                    ]) ?>

                    <?php
                    if ($isSearch):
                    ?>
                        <?= Html::a('Cetak HTML', [
                            'cetak', // Action baru
                            'tanggal_awal' => $tanggal_awal,
                            'tanggal_akhir' => $tanggal_akhir,
                            'status_pendaftaran' => $status_pendaftaran
                        ], [
                            'class' => 'btn btn-outline-info px-2 px-sm-4 py-2 fw-medium rounded-3 hover-bg-info d-flex align-items-center text-nowrap',
                            'onmouseover' => "this.style.color='#fff';",
                            'onmouseout' => "this.style.color='';",
                            'target' => '_blank' // Buka di tab baru
                        ]) ?>

                        <?= Html::submitButton('Cetak Excel', [
                            'class' => 'btn btn-outline-success px-2 px-sm-4 py-2 fw-medium rounded-3 hover-bg-success d-flex align-items-center text-nowrap',
                            'onmouseover' => "this.style.color='#fff';",
                            'onmouseout' => "this.style.color='';",
                            'name' => 'submit_btn',
                            'value' => 'excel',
                            'formtarget' => '_blank' // Buka di tab baru
                        ]) ?>
                    <?php endif; ?>
                </div>
            </div>

            <?= Html::endForm() ?>

        </div>
    </div>

    <?php if ($isSearch): // Tampilkan tabel hanya jika $isSearch true 
    ?>
        <div class="card bg-white border-0 rounded-3 mb-4" id="laporan-hasil">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h4 class="mb-1">BUKU REGISTER</h4>
                    <p class="mb-0">TANGGAL: <?= Html::encode(Yii::$app->formatter->asDate($tanggal_awal, 'php:d F Y')) ?> S/D <?= Html::encode(Yii::$app->formatter->asDate($tanggal_akhir, 'php:d F Y')) ?></p>
                </div>

                <div class="default-table-area all-products">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">No</th>
                                    <th scope="col">Pemohon/Perusahaan</th>
                                    <th scope="col">Alamat Pemohon/Lokasi</th>
                                    <th scope="col">Biaya</th>
                                    <th scope="col">No Izin</th>
                                    <th scope="col">Nama Pengambil</th>
                                    <th scope="col">Tanggal Pengambil</th>
                                    <th scope="col">Ttd Pengambil</th>
                                    <th scope="col">Ttd Petugas</th>
                                    <th scope="col">Permohonan</th>
                                    <th scope="col">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($models)): ?>
                                    <tr>
                                        <td colspan="11" class="text-center text-secondary fst-italic">
                                            Data tidak ditemukan untuk kriteria pencarian ini.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($models as $index => $model): ?>
                                        <tr>
                                            <td class="text-center"><?= $index + 1 ?></td>
                                            <td><?= Html::encode($model['pemohon_perusahaan']) ?></td>
                                            <td><?= Html::encode($model['alamat_pemohon_lokasi']) ?></td>
                                            <td><?= Html::encode($model['biaya']) ?></td>
                                            <td><?= Html::encode($model['no_izin']) ?></td>
                                            <td><?= Html::encode($model['nama_pengambil']) ?></td>
                                            <td><?= $model['tanggal_pengambil'] ? Yii::$app->formatter->asDate($model['tanggal_pengambil'], 'php:d-m-Y') : '' ?></td>
                                            <td><?= Html::encode($model['ttd_pengambil']) ?></td>
                                            <td><?= Html::encode($model['ttd_petugas']) ?></td>
                                            <td><?= Html::encode($model['permohonan']) ?></td>
                                            <td><?= Html::encode($model['keterangan']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 ">
                    <span class="fs-13 fw-medium text-secondary">
                        Menampilkan <b><?= count($models) ?></b> dari <b><?= $pagination->totalCount ?></b> data
                    </span>
                    <div class="d-flex align-items-center py-3">
                        <?= LinkPager::widget([
                            'pagination' => $pagination,
                            'options' => ['class' => 'pagination mb-0 justify-content-center'],
                            'linkContainerOptions' => ['class' => 'page-item'],
                            'linkOptions' => ['class' => 'page-link'],
                            'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                            'activePageCssClass' => 'active',
                            'prevPageCssClass' => 'page-item fs-16',
                            'nextPageCssClass' => 'page-item fs-16',
                            'prevPageLabel' => '<i class="material-symbols-outlined fs-16">keyboard_arrow_left</i>',
                            'nextPageLabel' => '<i class="material-symbols-outlined fs-16">keyboard_arrow_right</i>',
                            'firstPageLabel' => '<i class="material-symbols-outlined fs-16">first_page</i>',
                            'lastPageLabel' => '<i class="material-symbols-outlined fs-16">last_page</i>',
                            'maxButtonCount' => 5,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>


<?php
// Script untuk SweetAlert (biarkan saja)
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