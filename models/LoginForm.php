<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username; // Untuk Pemohon
    public $email;    // Untuk Admin
    public $password;
    public $rememberMe = true;
    public $dummy_check;

    private $_user = false;

    public function rules()
    {
        return [
            ['password', 'required'],
            [['username', 'email', 'dummy_check'], 'safe'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Email/NIK atau password salah.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            if (!empty($this->email)) {
                $this->_user = User::findByEmail($this->email);
            } elseif (!empty($this->username)) {
                $this->_user = User::findByUsername($this->username);
            }
        }
        return $this->_user;
    }
}
