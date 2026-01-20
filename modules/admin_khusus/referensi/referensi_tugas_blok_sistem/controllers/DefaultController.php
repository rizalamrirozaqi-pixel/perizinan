<?php

namespace app\modules\admin_khusus\referensi\referensi_tugas_blok_sistem\controllers;

use yii\web\Controller;

/**
 * Default controller for the `referensi_tugas_blok__sistem` module
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
