<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Html;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);

$fullName = Yii::$app->user->identity->username ?? 'Executive User';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Executive Summary - <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-row">
    <?php $this->beginBody() ?>

    <?php
    $currentRoute = trim(Yii::$app->controller->route);

    // Dashboard
    $isDashboardActive = str_contains($currentRoute, 'executive_summary/dashboard');

    // Group Laporan 
    $isLaporanSection = str_contains($currentRoute, 'executive_summary/laporan/');
    $isLapCetakSKRD       = str_contains($currentRoute, 'laporan_cetak_skrd');
    $isLapCetakSK         = str_contains($currentRoute, 'laporan/laporan_cetak_sk') && !str_contains($currentRoute, 'laporan_cetak_skrd');
    $isLapProsesIzin      = str_contains($currentRoute, 'laporan_pemrosesan_izin') && !str_contains($currentRoute, 'laporan_pemrosesan_izin_online');
    $isLapProsesOL        = str_contains($currentRoute, 'laporan_pemrosesan_izin_online');
    $isLapRegister        = str_contains($currentRoute, 'laporan_register_pendaftaran');
    $isLapPerizinan       = str_contains($currentRoute, 'laporan/laporan_perizinan') && !str_contains($currentRoute, 'laporan_perizinan_online');
    $isLapPerizinanOL     = str_contains($currentRoute, 'laporan_perizinan_online');
    $isLapBulanan         = str_contains($currentRoute, 'laporan_bulanan');
    $isLapPenyerahan      = str_contains($currentRoute, 'laporan_penyerahan_sk');

    // Menu Lainnya
    $isIzinTerbit         = str_contains($currentRoute, 'executive_summary/izin_terbit_sk');
    $isVerifDraft         = str_contains($currentRoute, 'executive_summary/verifikasi_draft_sk');
    ?>

    <div class="sidebar-area" id="sidebar-area">
        <div class="logo position-relative">
            <a href="<?= Url::to(['/executive_summary/dashboard']) ?>" class="d-block text-decoration-none position-relative px-4 py-2 d-flex align-items-center justify-content-center">
                <img src="<?= Yii::getAlias('@web') ?>/images/diginet.png" alt="logo-icon" class="for-light-logo">
                <img src="<?= Yii::getAlias('@web') ?>/images/diginet-dark.png" alt="logo-icon" class="for-dark-logo">
            </a>
            <button class="sidebar-burger-menu bg-transparent p-0 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y" id="sidebar-burger-menu">
                <i data-feather="x"></i>
            </button>
        </div>

        <aside id="layout-menu" class="overflow-y-auto layout-menu menu-vertical menu active" data-simplebar>
            <ul class="menu-inner">
                
                <li class="menu-item">
                    <a href="<?= Url::to(["/executive_summary/dashboard"]) ?>" class="menu-link <?= $isDashboardActive ? 'active' : '' ?>">
                        <span class="material-symbols-outlined menu-icon">dashboard</span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li class="menu-item <?= $isLaporanSection ? 'open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <span class="material-symbols-outlined menu-icon">analytics</span>
                        <span class="title">Laporan</span>
                        <span class="count">9</span> 
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/executive_summary/laporan/laporan_cetak_skrd']) ?>" class="menu-link <?= $isLapCetakSKRD ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">print</span>
                                <span class="title">Cetak SKRD</span>
                            </a>
                        </li>
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/executive_summary/laporan/laporan_cetak_sk']) ?>" class="menu-link <?= $isLapCetakSK ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">print</span>
                                <span class="title">Cetak SK</span>
                            </a>
                        </li>
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/executive_summary/laporan/laporan_pemrosesan_izin']) ?>" class="menu-link <?= $isLapProsesIzin ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">pending</span>
                                <span class="title">Pemrosesan Izin</span>
                            </a>
                        </li>
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/executive_summary/laporan/laporan_pemrosesan_izin_online']) ?>" class="menu-link <?= $isLapProsesOL ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">wifi_protected_setup</span>
                                <span class="title">Proses Izin Online</span>
                            </a>
                        </li>
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/executive_summary/laporan/laporan_register_pendaftaran']) ?>" class="menu-link <?= $isLapRegister ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">app_registration</span>
                                <span class="title">Register Pendaftaran</span>
                            </a>
                        </li>
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/executive_summary/laporan/laporan_perizinan']) ?>" class="menu-link <?= $isLapPerizinan ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">assignment</span>
                                <span class="title">Laporan Perizinan</span>
                            </a>
                        </li>
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/executive_summary/laporan/laporan_perizinan_online']) ?>" class="menu-link <?= $isLapPerizinanOL ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">assignment_ind</span>
                                <span class="title">Lap. Izin Online</span>
                            </a>
                        </li>
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/executive_summary/laporan/laporan_bulanan']) ?>" class="menu-link <?= $isLapBulanan ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">calendar_month</span>
                                <span class="title">Laporan Bulanan</span>
                            </a>
                        </li>
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/executive_summary/laporan/laporan_penyerahan_sk']) ?>" class="menu-link <?= $isLapPenyerahan ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">handshake</span>
                                <span class="title">Penyerahan SK</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="<?= Url::to(["/executive_summary/izin_terbit_sk"]) ?>" class="menu-link <?= $isIzinTerbit ? 'active' : '' ?>">
                        <span class="material-symbols-outlined menu-icon">verified</span>
                        <span class="title">Izin Terbit (SK)</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="<?= Url::to(["/executive_summary/verifikasi_draft_sk"]) ?>" class="menu-link <?= $isVerifDraft ? 'active' : '' ?>">
                        <span class="material-symbols-outlined menu-icon">fact_check</span>
                        <span class="title">Verifikasi Draft SK</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="<?= Url::to(["/executive_summary/logout"]) ?>" class="menu-link" data-method="post">
                        <span class="material-symbols-outlined menu-icon">logout</span>
                        <span class="title">Logout</span>
                    </a>
                </li>

            </ul>
        </aside>
    </div>
    <div class="main-content d-flex flex-column">

        <header class="header-area bg-white mb-4 rounded-bottom-15" id="header-area">
            <div class="row align-items-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="left-header-content">
                        <ul class="d-flex align-items-center ps-0 mb-0 list-unstyled">
                            <li>
                                <button class="header-burger-menu bg-transparent p-0 border-0" id="header-burger-menu">
                                    <span class="material-symbols-outlined">menu</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8 col-sm-6">
                    <div class="right-header-content mt-2 mt-sm-0">
                        <ul class="d-flex align-items-center justify-content-center justify-content-sm-end ps-0 mb-0 list-unstyled">

                            <li class="header-right-item">
                                <div class="light-dark">
                                    <button class="switch-toggle settings-btn dark-btn p-0 bg-transparent" id="switch-toggle">
                                        <span class="dark"><i class="material-symbols-outlined">light_mode</i></span>
                                        <span class="light"><i class="material-symbols-outlined">dark_mode</i></span>
                                    </button>
                                </div>
                            </li>

                            <li class="header-right-item">
                                <button class="fullscreen-btn bg-transparent p-0 border-0" id="fullscreen-button">
                                    <i class="material-symbols-outlined text-body">fullscreen</i>
                                </button>
                            </li>

                            <li class="header-right-item">
                                <div class="dropdown pemohon-profile">
                                    <div class="d-xxl-flex align-items-center bg-transparent border-0 text-start p-0 cursor dropdown-toggle" data-bs-toggle="dropdown">
                                        <div class="flex-shrink-0">
                                            <img class="rounded-circle wh-40 administrator" src="<?= Yii::getAlias('@web') ?>/images/administrator.jpg" alt="user">
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-none d-xxl-block">
                                                    <div class="d-flex align-content-center">
                                                        <h6><?= Html::encode($fullName) ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dropdown-menu border-0 bg-white dropdown-menu-end">
                                        <div class="d-flex align-items-center info">
                                            <div class="flex-shrink-0">
                                                <img class="rounded-circle wh-30 administrator" src="<?= Yii::getAlias('@web') ?>/images/administrator.jpg" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h3 class="fw-medium"><?= Html::encode($fullName) ?></h3>
                                                <span class="fs-12">Executive Summary</span>
                                            </div>
                                        </div>
                                        <ul class="pemohon-link ps-0 mb-0 list-unstyled">
                                            <li>
                                                <?= Html::a(
                                                    '<i class="material-symbols-outlined">logout</i><span class="ms-2">Logout</span>',
                                                    ['/executive_summary/logout'],
                                                    [
                                                        'class' => 'dropdown-item pemohon-item-link d-flex align-items-center text-body',
                                                        'data-method' => 'post'
                                                    ]
                                                ) ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <main id="main" class="flex-shrink-0" role="main" style="margin-top:0;">
            <div class="container-fluid p-0 min-vh-100 d-flex flex-column">
                <div class="d-flex flex-column flex-grow-1">
                    <?= $content ?>
                </div>

                <footer class="footer-area bg-white text-center d-flex justify-content-center align-items-center rounded-top-7 w-100" id="footer" style="height: 60px;">
                    <p class="fs-14 mb-0">© <span class="text-primary-div">Sistem Perizinan</span> - Executive Summary Panel</p>
                </footer>
            </div>
        </main>

    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>