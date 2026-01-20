<?php

namespace app\modules\pemohon\logout\controllers;

use yii\web\Controller;
use Yii;

/**
 * Default controller for the `pemohon` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */

    public function actionIndex()
    {
        Yii::$app->user->logout();
        return $this->redirect(['/pemohon/login']);
    }
}

