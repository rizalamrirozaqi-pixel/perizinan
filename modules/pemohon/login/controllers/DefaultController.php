<?php

namespace app\modules\pemohon\login\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm; // Kita bisa reuse model login atau buat khusus
use yii\filters\VerbFilter;

class DefaultController extends Controller
{
    public $layout = false; // Tanpa layout (halaman penuh)

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        // Jika sudah login, redirect ke dashboard pemohon
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/pemohon/dashboard/default/index']);
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Login sukses -> Redirect ke dashboard pemohon
            return $this->redirect(['/pemohon/dashboard/default/index']);
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['index']);
    }
}
