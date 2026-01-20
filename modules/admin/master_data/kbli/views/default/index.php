<?php

/**
 * DEKLARASI VARIABEL DARI CONTROLLER
 * @var yii\web\View $this
 * @var string|null $search_pendaftaran
 * @var string|null $search_skrd
 * @var array|null $modelPendaftaran Data Pendaftaran
 * @var array|null $modelSkr Data SKR (bisa null)
 * @var bool $isSearch (true jika $modelPendaftaran ada)
 * @var array $models
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;

$this->title = 'Form KBLI';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Master Data', 'url' => '#'];
$this->params['breadcrumbs'][] = 'Form KBLI';

?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item"><a href="<?= Url::to(['/admin/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none"><i class="ri-home-4-line fs-18 text-primary me-1"></i> <span class="text-secondary fw-medium hover">Dashboard</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Master Data</span></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="fw-medium">Form KBLI</span></li>
            </ol>
        </nav>
    </div>

    <!-- Card Grid Laporan SKRD -->
    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2">Form KBLI</h5>

            <?= Html::beginForm(['index'], 'get', [
                'class' => 'table-src-form position-relative me-0 mb-3',
                'style' => 'max-width: 100%;',
            ]) ?>

            <div class="col-md-5 position-relative">
                <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                <input type="text" class="form-control" placeholder="Ketikkan Nomor Pendaftaran atau Nama Pemohon atau Nama Usaha" style="width: 510px;">
            </div>
        </div>
    </div>
                