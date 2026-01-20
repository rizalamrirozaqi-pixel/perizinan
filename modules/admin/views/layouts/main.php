<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;


AppAsset::register($this);


$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Yii::getAlias('@web/images/favicon-0.png')]);

$fullName = Yii::$app->user->identity->username ?? 'Guest'; // Fallback jika belum login
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php $this->registerCsrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-row">
    <?php $this->beginBody() ?>
    <?php
    $currentRoute = trim(Yii::$app->controller->route);

    // --- Grup Pendaftaran ---
    $dashboardRoute = trim('admin/dashboard/default/index');
    $pendaftaranRoute = trim('admin/pendaftaran/pendaftaran/default/index');
    $pendaftaranMultiRoute = trim('admin/pendaftaran/pendaftaran_multi/default/index');
    $pendaftaranOnlineRoute = trim('admin/pendaftaran/pendaftaran_online/default/index');

    // --- Grup Laporan ---
    $laporanRegisterRoute = trim('admin/laporan/laporan_register_pendaftaran/default/index');
    $laporanPerizinanRoute = trim('admin/laporan/laporan_perizinan/default/index');
    $laporanBulananRoute = trim('admin/laporan/laporan_bulanan/default/index');

    // --- Grup Back Office ---
    $verifikasiDraftSKRoute = trim('admin/back_office/verifikasi_draft_sk/default/index');
    $suratTugasRoute = trim('admin/back_office/surat_tugas/default/index');
    $beritaAcaraRoute = trim('admin/back_office/berita_acara_pemeriksaan/default/index');
    $verifikasiIzinRoute = trim('admin/back_office/verifikasi_izin/default/index');
    $perhitunganRetribusiRoute = trim('admin/back_office/perhitungan_retribusi/default/index');
    $cetakSKRDRoute = trim('admin/back_office/cetak_skrd/default/index');
    $cetakDraftSKRoute = trim('admin/back_office/cetak_draft_sk/default/index');
    $PenomoranSKRoute = trim('admin/back_office/penomoran_sk/default/index');
    $pengambilanSKRoute = trim('admin/back_office/pengambilan_sk/default/index');
    $laporanPenyerahanSKRoute = trim('admin/back_office/laporan_penyerahan_sk/default/index');

    // --- Master Data ---
    $kbliRoute = trim('admin/master_data/kbli/default/index');

    // --- Logout ---
    $logoutRoute = trim('admin/logout');

    // --- Variabel Logika Section 'open' ---
    $isPendaftaranSection = str_starts_with($currentRoute, 'admin/pendaftaran/');
    $isLaporanSection = str_starts_with($currentRoute, 'admin/laporan/');
    $isBackOfficeSection = str_starts_with($currentRoute, 'admin/back_office/');
    $isMasterDataSection = str_starts_with($currentRoute, 'admin/master_data/');
    $isDashboardActive = ($currentRoute == $dashboardRoute);
    ?>

    <div class="sidebar-area" id="sidebar-area">
        <div class="logo position-relative">
            <a href="<?= Url::to(['/admin/dashboard']) ?>" class="d-block text-decoration-none position-relative px-4 py-2 d-flex align-items-center justify-content-center">
                <img src="<?= Yii::getAlias('@web') ?>/images/diginet.png" alt="logo-icon" class="for-light-logo">
                <img src="<?= Yii::getAlias('@web') ?>/images/diginet-dark.png" alt="logo-icon" class="for-dark-logo">
            </a>
            <button class="sidebar-burger-menu bg-transparent p-0 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y" id="sidebar-burger-menu">
                <i data-feather="x"></i>
            </button>
        </div>

        <aside id="layout-menu" class="overflow-y-auto layout-menu  menu-vertical menu active" data-simplebar>
            <ul class="menu-inner">

                <li class="menu-item">
                    <a href="<?= Url::to(["/admin/dashboard"]) ?>" class="menu-link <?= $isDashboardActive ? 'active' : '' ?>">
                        <span class="material-symbols-outlined menu-icon">dashboard</span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li class="menu-item <?= $isPendaftaranSection ? 'open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <span class="material-symbols-outlined menu-icon">app_registration</span>
                        <span class="title">Pendaftaran</span>
                        <span class="count">3</span>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/admin/pendaftaran/pendaftaran']) ?>" class="menu-link <?= ($currentRoute == $pendaftaranRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">how_to_reg</span>
                                <span class="title">Pendaftaran</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?= Url::to(['/admin/pendaftaran/pendaftaran_multi']) ?>" class="menu-link <?= ($currentRoute == $pendaftaranMultiRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">group_add</span>
                                <span class="title">Pendaftaran Multi</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?= Url::to(['/admin/pendaftaran/pendaftaran_online']) ?>" class="menu-link <?= ($currentRoute == $pendaftaranOnlineRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">cloud_upload</span>
                                <span class="title">Pendaftaran Online</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item <?= $isLaporanSection ? 'open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <span class="material-symbols-outlined menu-icon">assignment</span>
                        <span class="title">Laporan</span>
                        <span class="count">3</span>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/admin/laporan/laporan_register_pendaftaran']) ?>" class="menu-link <?= ($currentRoute == $laporanRegisterRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">description</span>
                                <span class="title">Register Pendaftaran</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?= Url::to(['/admin/laporan/laporan_perizinan']) ?>" class="menu-link <?= ($currentRoute == $laporanPerizinanRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">approval</span>
                                <span class="title">Perizinan</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?= Url::to(['/admin/laporan/laporan_bulanan']) ?>" class="menu-link <?= ($currentRoute == $laporanBulananRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">calendar_month</span>
                                <span class="title">Bulanan</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item <?= $isBackOfficeSection ? 'open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <span class="material-symbols-outlined menu-icon">corporate_fare</span>
                        <span class="title">Back Office</span>
                        <span class="count">8</span>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="<?= Url::to(['/admin/back_office/penomoran_sk']) ?>" class="menu-link <?= ($currentRoute == $PenomoranSKRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">format_list_numbered_rtl</span>
                                <span class="title">Penomoran SK</span>
                            </a>
                        </li>
                        <li class="menu-item mb-0">
                            <a href="<?= Url::to(['/admin/back_office/verifikasi_draft_sk']) ?>" class="menu-link <?= ($currentRoute == $verifikasiDraftSKRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">draft</span>
                                <span class="title">Verifikasi Draft SK</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?= Url::to(['/admin/back_office/cetak_draft_sk']) ?>" class="menu-link <?= ($currentRoute == $cetakDraftSKRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">print</span>
                                <span class="title">Cetak Draft SK</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?= Url::to(['/admin/back_office/surat_tugas']) ?>" class="menu-link <?= ($currentRoute == $suratTugasRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">approval</span>
                                <span class="title">Surat Tugas</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?= Url::to(['/admin/back_office/berita_acara_pemeriksaan']) ?>" class="menu-link <?= ($currentRoute == $beritaAcaraRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">plagiarism</span>
                                <span class="title">Berita Acara Pemeriksaan</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?= Url::to(['/admin/back_office/verifikasi_izin']) ?>" class="menu-link <?= ($currentRoute == $verifikasiIzinRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">verified</span>
                                <span class="title">Verifikasi Izin</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?= Url::to(['/admin/back_office/perhitungan_retribusi']) ?>" class="menu-link <?= ($currentRoute == $perhitunganRetribusiRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">calculate</span>
                                <span class="title">Perhitungan Retribusi</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?= Url::to(['/admin/back_office/cetak_skrd']) ?>" class="menu-link <?= ($currentRoute == $cetakSKRDRoute) ? 'active' : '' ?>">
                                <span class="material-symbols-outlined menu-icon">print</span>
                                <span class="title">Cetak SKRD</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item mb-0">
                    <a href="<?= Url::to(['/admin/master_data/kbli']) ?>" class="menu-link <?= ($currentRoute == $kbliRoute) ? 'active' : '' ?>">
                        <span class="material-symbols-outlined menu-icon">book</span> <span class="title">KBLI</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="<?= Url::to(["/admin/logout"]) ?>" class="menu-link <?= ($currentRoute == $logoutRoute) ? 'active' : '' ?>" data-method="post">
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
                        <ul class="d-flex align-items-center ps-0 mb-0 list-unstyled justify-content-center justify-content-sm-start">
                            <li>
                                <button class="header-burger-menu bg-transparent p-0 border-0" id="header-burger-menu">
                                    <span class="material-symbols-outlined">menu</span>
                                </button>
                            </li>
                            <li>
                                <form class="src-form position-relative">
                                    <input type="text" class="form-control" placeholder="Cari di sini.....">
                                    <button type="submit" class="src-btn position-absolute top-50 end-0 translate-middle-y bg-transparent p-0 border-0">
                                        <span class="material-symbols-outlined">search</span>
                                    </button>
                                </form>
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
                                <div class="dropdown notifications noti">
                                    <button class="btn btn-secondary border-0 p-0 position-relative badge" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-symbols-outlined">notifications</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-lg p-0 border-0 p-0 dropdown-menu-end">
                                        <div class="d-flex justify-content-between align-items-center title">
                                            <span class="fw-semibold fs-15 text-secondary">Notifications <span class="fw-normal text-body fs-14">(03)</span></span>
                                            <button class="p-0 m-0 bg-transparent border-0 fs-14 text-primary">Clear All</button>
                                        </div>

                                        <div class="max-h-217" data-simplebar>
                                            <div class="notification-menu">
                                                <a href="notification.html" class="dropdown-item">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-symbols-outlined text-primary">sms</i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <p>You have requested to <span class="fw-semibold">withdrawal</span></p>
                                                            <span class="fs-13">2 hrs ago</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <a href="notification.html" class="dropdown-item text-center text-primary d-block view-all fw-medium rounded-bottom-3">
                                            <span>See All Notifications </span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="header-right-item">
                                <div class="dropdown admin-profile">
                                    <div class="d-xxl-flex align-items-center bg-transparent border-0 text-start p-0 cursor dropdown-toggle" data-bs-toggle="dropdown">
                                        <div class="flex-shrink-0">
                                            <img class="rounded-circle wh-40 administrator" src="<?= Yii::getAlias('@web') ?>/images/administrator.jpg" alt="admin">
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-none d-xxl-block">
                                                    <div class="d-flex align-content-center">
                                                        <h3><?= Html::encode($fullName) ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dropdown-menu border-0 bg-white dropdown-menu-end">
                                        <div class="d-flex align-items-center info">
                                            <div class="flex-shrink-0">
                                                <img class="rounded-circle wh-30 administrator" src="<?= Yii::getAlias('@web') ?>/images/administrator.jpg" alt="admin">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h3 class="fw-medium"><?= Html::encode($fullName) ?></h3>
                                                <span class="fs-12">Marketing Manager</span>
                                            </div>
                                        </div>
                                        <ul class="admin-link ps-0 mb-0 list-unstyled">
                                            <li>
                                                <a class="dropdown-item admin-item-link d-flex align-items-center text-body" href="my-profile.html">
                                                    <i class="material-symbols-outlined">account_circle</i>
                                                    <span class="ms-2">My Profile</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="admin-link ps-0 mb-0 list-unstyled">
                                            <li>
                                                <a class="dropdown-item admin-item-link d-flex align-items-center text-body" href="settings.html">
                                                    <i class="material-symbols-outlined">settings </i>
                                                    <span class="ms-2">Settings</span>
                                                </a>
                                            </li>
                                            <li>
                                                <?= Html::a(
                                                    '<i class="material-symbols-outlined">logout</i><span class="ms-2">Logout</span>',
                                                    ['/admin/logout/default/index'],
                                                    [
                                                        'class' => 'dropdown-item admin-item-link d-flex align-items-center text-body',
                                                        'data-method' => 'post'
                                                    ]
                                                ) ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="header-right-item">
                                <button class="theme-settings-btn p-0 border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                                    <i class="material-symbols-outlined" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Click On Theme Settings">settings</i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Start Theme Setting Area -->
        <div class="offcanvas offcanvas-end bg-white" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <div class="offcanvas-header bg-body-bg py-3 px-4">
                <h5 class="offcanvas-title fs-18" id="offcanvasScrollingLabel">Theme Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-4">
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">RTL / LTR</h4>
                    <div class="settings-btn rtl-btn">
                        <label id="switch" class="switch">
                            <input type="checkbox" onchange="toggleTheme()" id="slider">
                            <span class="sliders round"></span>
                        </label>
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Container Style Fluid / Boxed</h4>
                    <button class="boxed-style settings-btn fluid-boxed-btn" id="boxed-style">
                        Click To <span class="fluid">Fluid</span> <span class="boxed">Boxed</span>
                    </button>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Sidebar Light / Dark</h4>
                    <button class="sidebar-light-dark settings-btn sidebar-dark-btn" id="sidebar-light-dark">
                        Click To <span class="dark1">Dark</span> <span class="light1">Light</span>
                    </button>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Header Light / Dark</h4>
                    <button class="header-light-dark settings-btn header-dark-btn" id="header-light-dark">
                        Click To <span class="dark2">Dark</span> <span class="light2">Light</span>
                    </button>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Footer Light / Dark</h4>
                    <button class="footer-light-dark settings-btn footer-dark-btn" id="footer-light-dark">
                        Click To <span class="dark3">Dark</span> <span class="light3">Light</span>
                    </button>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Card Style Radius / Square</h4>
                    <button class="card-radius-square settings-btn card-style-btn" id="card-radius-square">
                        Click To <span class="square">Square</span> <span class="radius">Radius</span>
                    </button>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Card Style BG White / Gray</h4>
                    <button class="card-bg settings-btn card-bg-style-btn" id="card-bg">
                        Click To <span class="white">White</span> <span class="gray">Gray</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- End Theme Setting Area -->

        <main id="main" class="flex-shrink-0" role="main" style="margin-top:0;">
            <div class="container-fluid p-0 min-vh-100 d-flex flex-column">

                <div class="preloader" id="preloader">
                    <div class="preloader">
                        <div class="waviy position-relative">
                            <span class="d-inline-block">P</span>
                            <span class="d-inline-block">E</span>
                            <span class="d-inline-block">R</span>
                            <span class="d-inline-block">I</span>
                            <span class="d-inline-block">Z</span>
                            <span class="d-inline-block">I</span>
                            <span class="d-inline-block">N</span>
                            <span class="d-inline-block">A</span>
                            <span class="d-inline-block">N</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-grow-1">
                    <?
                    //  Alert::widget()
                    ?>
                    <?= $content ?>

                </div>
                <footer class="footer-area bg-white text-center d-flex justify-content-center align-items-center rounded-top-7 w-100" id="footer" style="height: 60px;">
                    <p class="fs-14 mb-0">© <span class="text-primary-div">Diginet</span> is Proudly Owned by <a href="https://diginetmedia.co.id/" target="_blank" class="text-decoration-none text-primary">Diginet Media</a></p>
                </footer>
            </div>
        </main>

        <div class="offcanvas offcanvas-end bg-white" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
        </div>

        <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>