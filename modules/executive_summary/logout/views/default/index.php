<?php

use yii\helpers\Url; 
?>

<!DOCTYPE html>
<html lang="zxx">

<body class="boxed-size bg-white">
    <div class="preloader" id="preloader">
        <div class="preloader">
            <div class="waviy position-relative">
                <span class="d-inline-block">T</span>
                <span class="d-inline-block">R</span>
                <span class="d-inline-block">E</span>
                <span class="d-inline-block">Z</span>
                <span class="d-inline-block">O</span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="main-content d-flex flex-column p-0">
            <div class="m-auto m-1230">
                <div class="row align-items-center">
                    <div class="col-lg-6 d-none d-lg-block">
                        {/* Diubah */}
                        <img src="<?= Yii::getAlias('@web') ?>/images/logout.jpg" class="rounded-3" alt="logout">
                    </div>
                    <div class="col-lg-6">
                        <div class="mw-480 ms-lg-auto">
                            <div class="d-inline-block mb-4">
                                {/* Diubah */}
                                <img src="<?= Yii::getAlias('@web') ?>/images/logo.svg" class="rounded-3 for-light-logo" alt="login">
                                {/* Diubah */}
                                <img src="<?= Yii::getAlias('@web') ?>/images/white-logo.svg" class="rounded-3 for-dark-logo" alt="login">
                            </div>
                            <h3 class="fs-28 mb-2">Welcome back to Trezo!</h3>
                            <p class="fw-medium fs-16 mb-4">You Are Logged out</p>
                            <div class="d-flex align-items-center mb-4">
                                {/* Diubah */}
                                <img src="<?= Yii::getAlias('@web') ?>/images/administrator.jpg" class="rounded-circle" style="border: 2px solid #C2CDFF;" alt="administrator">
                                <span class="fw-semibold ms-2 ps-1 text-secondary">Olivia John</span>
                            </div>
                            {/* Arahkan ke route login yang benar */}
                            <a href="<?= Url::to(['/admin/login']) ?>" class="btn btn-primary fw-medium py-2 px-3 w-100">
                                <div class="d-flex align-items-center justify-content-center py-1">
                                    <i class="material-symbols-outlined text-white fs-20 me-2">autorenew</i>
                                    <span>Login</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/* ... (Sisa kode HTML: Tombol Settings, Offcanvas, dll. tetap sama) ... */}
    <button class="theme-settings-btn p-0 border-0 bg-transparent position-absolute" style="right: 30px; bottom: 30px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
        <i class="material-symbols-outlined bg-primary wh-35 lh-35 text-white rounded-1" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Click On Theme Settings">settings</i>
    </button>

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

    <button class="switch-toggle settings-btn dark-btn p-0 bg-transparent position-absolute top-0 d-none" id="switch-toggle">
        <span class="dark"><i class="material-symbols-outlined">light_mode</i></span>
        <span class="light"><i class="material-symbols-outlined">dark_mode</i></span>
    </button>

</body>

</html>