<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;

    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'string', 'min' => 4],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Konfirmasi password tidak sama.'],
            ['currentPassword', 'validateCurrentPassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'currentPassword'   => 'Password Lama',
            'newPassword'       => 'Password Baru',
            'newPasswordRepeat' => 'Konfirmasi Password Baru',
        ];
    }

    public function validateCurrentPassword($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }

        /** @var User|null $user */
        $user = Yii::$app->user->identity;

        if (!$user || !$user->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Password lama tidak sesuai.');
        }
    }

    /**
     * Jalankan proses ganti password.
     * Untuk saat ini hanya update ke object User dummy.
     * Nanti kalau sudah pakai database/ActiveRecord, bagian ini tinggal disesuaikan.
     */
    public function change()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User|null $user */
        $user = Yii::$app->user->identity;

        if (!$user) {
            $this->addError('currentPassword', 'User tidak ditemukan.');
            return false;
        }

        // Karena di dummy User password masih plain text:
        $user->password_hash = $this->newPassword;

        // Kalau nanti User sudah pakai ActiveRecord, idealnya:
        // $user->setPassword($this->newPassword);
        // return $user->save(false);

        // Dengan dummy array, perubahan ini cuma bertahan di request sekarang (tidak persist).
        return true;
    }
}
