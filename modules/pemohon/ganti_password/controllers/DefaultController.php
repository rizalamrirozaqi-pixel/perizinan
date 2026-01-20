<?php

namespace app\modules\pemohon\ganti_password\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\ChangePasswordForm;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // harus login dulu
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->change()) {
            Yii::$app->session->setFlash('success', 'Password berhasil diubah.');
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
