<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

class User extends \yii\base\BaseObject implements IdentityInterface
{
    public $id;
    public $username;
    public $email;
    public $password_hash;
    public $role; // 'admin' atau 'pemohon'

    // DATABASE DUMMY
    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'Admin',
            'email' => 'admin@example.com', 
            'password_hash' => 'admin',    
            'role' => 'admin',
        ],
        '101' => [
            'id' => '101',
            'username' => 'Pemohon', 
            'email' => 'pemohon@example.com',
            'password_hash' => 'pemohon',   
            'role' => 'pemohon',
        ],
    ];

    // (WAJIB ADA UNTUK ADMIN)
    public static function findByEmail($email)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['email'], $email) === 0) {
                return new static($user);
            }
        }
        return null;
    }

    // (WAJIB ADA UNTUK PEMOHON)
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }
        return null;
    }

    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return 'testKey';
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password_hash === $password;
    }
}
