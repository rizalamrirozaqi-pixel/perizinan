<?php

namespace app\modules\admin_khusus\referensi\referensi_kendali_alur\controllers;

use yii\web\Controller;

/**
 * Default controller for the `referensi_kendali_alur` module
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
