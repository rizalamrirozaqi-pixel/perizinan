<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use app\assets\AppAsset;

$this->title = 'Login Admin - Perizinan';
AppAsset::register($this);

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/images/favicon-0.png">
</head>

<body class="bg-white" style="overflow-y: hidden;">
    <?php $this->beginBody() ?>

    <div class="container-fluid p-0">
        <div class="row g-0 vh-100">

            <!-- Bagian Kiri (Gambar/Info) -->
            <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center align-items-center left-panel text-white position-relative" style="background-image: url(<?= Yii::getAlias('@web') ?>/images/login.jpg);">
                <div class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-50"></div>
                <div class="position-relative z-1 text-center px-5">
                    <img src="<?= Yii::getAlias('@web') ?>/images/favicon-0.png" alt="Logo" width="100" class="mb-4">
                    <h2 class="fw-bold mb-3 text-white">Selamat Datang di Panel Admin</h2>
                    <p class="fs-18">Kelola layanan perizinan dengan mudah, cepat, dan terintegrasi.</p>
                </div>
            </div>

            <!-- Bagian Kanan (Form Login) -->
            <div class="col-lg-6 d-flex justify-content-center p-4 p-md-5 vh-100 overflow-auto">
                <div class="mw-480 w-100 h-100">

                    <div class="text-center mb-4">
                        <img src="<?= Yii::getAlias('@web') ?>/images/diginet.png" class="w-25 mb-3" alt="Logo">
                        <h3 class="fs-24 fw-bold">Login Admin</h3>
                        <p class="text-muted">Silakan masukkan kredensial untuk masuk ke sistem.</p>
                    </div>

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form-admin',
                        'action' => Url::to(['default/index']),
                        'method' => 'post',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label fw-medium'],
                            'inputOptions' => ['class' => 'form-control h-55'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'email')
                        ->textInput([
                            'placeholder' => 'Masukkan Email',
                            'required' => true,
                            'autofocus' => true,
                        ])->label('Email') ?>

                    <?= $form->field($model, 'password')
                        ->passwordInput([
                            'placeholder' => 'Masukkan Password',
                            'required' => true,
                        ])->label('Password') ?>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Verifikasi Keamanan</label>
                        <div class="d-flex gap-2 mb-2">
                            <div id="captcha-box-admin" class="bg-light border rounded py-2 px-4 fw-bold fs-20 text-secondary text-decoration-line-through user-select-none" style="letter-spacing: 5px;">
                            </div>
                            <button type="button" class="btn btn-outline-secondary" id="reload-captcha-admin" title="Refresh Captcha">
                                <i class="material-symbols-outlined">refresh</i>
                            </button>
                        </div>
                        <input type="text" id="captcha-input-admin" name="dummy_check" class="form-control h-55" placeholder="Ketik kode di atas" required>
                        <div id="captcha-error-admin" class="text-danger fs-12 mt-1 d-none">Kode verifikasi salah!</div>
                    </div>

                    <div class="form-group mb-4">
                        <?= Html::submitButton(
                            '<div class="d-flex align-items-center justify-content-center py-1">
                                <i class="material-symbols-outlined text-white fs-20 me-2">login</i>
                                <span>Login Admin</span>
                            </div>',
                            [
                                'class' => 'btn btn-primary fw-medium py-2 px-3 w-100',
                                'id' => 'btn-submit-admin'
                            ]
                        ) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <div class="position-relative text-center my-4">
                        <p class="mb-0 fs-14 px-3 d-inline-block bg-white z-1 position-relative text-secondary">Atau masuk sebagai</p>
                        <span class="border-bottom w-100 position-absolute top-50 start-50 translate-middle z-n1"></span>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= Url::to(['/admin_khusus/login']) ?>" class="btn btn-outline-primary fw-medium py-2 px-3 w-100 d-flex align-items-center justify-content-center hover-bg mb-3">
                                <i class="material-symbols-outlined fs-20 me-2">admin_panel_settings</i>
                                <span>Admin Khusus</span>
                            </a>
                        </div>
                        <div class="col-md-12">
                            <a href="<?= Url::to(['/pemohon/login']) ?>" class="w-100 mb-3 btn btn-outline-primary fw-medium py-2 px-3 w-100 d-flex align-items-center justify-content-center hover-bg">
                                <i class="material-symbols-outlined fs-20 me-2">person</i>
                                <span>Pemohon</span>
                            </a>
                        </div>
                        <div class="col-md-12">
                            <a href="<?= Url::to(['/executive_summary/login']) ?>" class="w-100 mb-3 btn btn-outline-primary fw-medium py-2 px-3 w-100 d-flex align-items-center justify-content-center hover-bg">
                                <i class="material-symbols-outlined fs-20 me-2">person</i>
                                <span>Executive Summary</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const captchaBox = document.getElementById('captcha-box-admin');
            const reloadBtn = document.getElementById('reload-captcha-admin');
            const input = document.getElementById('captcha-input-admin');
            const form = document.getElementById('login-form-admin');

            // Kalau elemen tidak ketemu, jangan apa-apakan (biar nggak error JS)
            if (!captchaBox || !reloadBtn || !input || !form) {
                return;
            }

            let code = '';

            function generateCaptcha() {
                const chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                let result = '';
                for (let i = 0; i < 5; i++) {
                    result += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                code = result;
                captchaBox.innerText = code;
                input.value = '';
                input.classList.remove('is-invalid');
            }

            reloadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                generateCaptcha();
            });

            generateCaptcha();

            function handleSubmit(e) {
                const userInput = input.value.trim().toUpperCase();

                // CAPTCHA kosong
                if (userInput === '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'CAPTCHA Kosong!',
                        text: 'Silakan masukkan kode yang tersedia.',
                    });
                    return;
                }

                if (userInput !== code) {
                    e.preventDefault();
                    input.classList.add('is-invalid');
                    Swal.fire({
                        icon: 'error',
                        title: 'CAPTCHA Salah!',
                        text: 'Silakan coba kembali.',
                    }).then(() => {
                        generateCaptcha();
                    });
                    return;
                }

                e.preventDefault();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Sedang memproses login...',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    form.removeEventListener('submit', handleSubmit);
                    form.submit();
                });
            }

            form.addEventListener('submit', handleSubmit);
        });
    </script>


    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>