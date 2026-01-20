<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ChangePasswordForm $model */

$this->title = 'Ganti Password';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/pemohon/dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Pengaturan Akun', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user->identity;

?>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center ">
                <li class="breadcrumb-item">
                    <a href="<?= Url::to(['/pemohon/dashboard/index']) ?>" class="d-flex align-items-center text-decoration-none">
                        <i class="material-symbols-outlined fs-18 text-primary">home</i>
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pengaturan Akun</li>
                <li class="breadcrumb-item active" aria-current="page">Ganti Password</li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
        <div class="card-body p-4">

            <!-- Title card mirip "Inbox ..." -->
            <h5 class="card-title fw-semibold mb-3 border-bottom pb-2 d-flex align-items-center gap-2">
                <i class="material-symbols-outlined fs-20 text-primary">lock_reset</i>
                <span>Form Ganti Password</span>
            </h5>

            <div class="row g-4">
                <div class="col">

                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show small" role="alert">
                            <?= Yii::$app->session->getFlash('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (Yii::$app->session->hasFlash('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                            <?= Yii::$app->session->getFlash('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php $form = ActiveForm::begin([
                        'id' => 'form-ganti-password',
                        'options' => ['class' => ''],
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label fw-semibold small text-secondary mb-1'],
                            'errorOptions' => ['class' => 'invalid-feedback d-block mt-1'],
                            'inputOptions' => ['class' => 'form-control h-55'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'currentPassword')
                        ->passwordInput([
                            'placeholder' => 'Masukkan password lama',
                            'autocomplete' => 'current-password',
                        ])
                        ->label('Password Lama') ?>

                    <?= $form->field($model, 'newPassword')
                        ->passwordInput([
                            'placeholder' => 'Masukkan password baru',
                            'autocomplete' => 'new-password',
                        ])
                        ->label('Password Baru') ?>

                    <?= $form->field($model, 'newPasswordRepeat')
                        ->passwordInput([
                            'placeholder' => 'Ketik ulang password baru',
                            'autocomplete' => 'new-password',
                        ])
                        ->label('Konfirmasi Password Baru') ?>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="<?= Url::to(['/pemohon/dashboard']) ?>"
                            class="btn btn-outline-secondary">
                            Batal
                        </a>

                        <?= Html::submitButton(
                            '<div class="d-flex align-items-center justify-content-center">
                                <span>Simpan Perubahan</span>
                            </div>',
                            ['class' => 'btn btn-primary px-3']
                        ) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

            </div>

        </div>
    </div>
</div>