<?php

namespace app\modules\admin_khusus\referensi\referensi_persyaratan\controllers;

use yii\web\Controller;

/**
 * Default controller for the `referensi_persyaratan` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
