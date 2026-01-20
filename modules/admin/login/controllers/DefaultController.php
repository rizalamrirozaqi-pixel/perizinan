<?php

namespace app\modules\admin\login\controllers;

use Yii;
use app\models\LoginForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Default controller for the admin login module.
 * Handles user login and logout for the admin area.
 */
class DefaultController extends Controller
{
    /**
     * @var bool|string Use false for no layout.
     */
    public $layout = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->isGuest && $action->id === 'index') {
                        return $this->redirect(['/admin/dashboard/default/index']);
                    }
                    if (!Yii::$app->user->isGuest) {
                        throw new ForbiddenHttpException('You are not allowed to perform this action.');
                    }
                }
            ],
        ];
    }

    /**
     * Displays login page and handles login attempts.
     * @return string|Response
     */
    public function actionIndex(): string|Response
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/admin/dashboard/default/index']);
        }

        $model = new LoginForm();
        $request = Yii::$app->request;

        if ($request->isPost) {
            $postData = $request->post();

            if (empty($postData['dummy_check'])) {
                Yii::$app->session->setFlash('error', 'Please complete the CAPTCHA verification.');
                return $this->render('index', ['model' => $model]);
            }

        if ($model->load($postData) && $model->login()) {
                return $this->redirect(['/admin/dashboard/default/index']);
            } else {
                $model->password = '';
                if ($model->hasErrors()) {
                    $errors = $model->getFirstErrors();
                    $errorMessage = reset($errors);
                } else {
                    $errorMessage = 'Incorrect email or password.';
                }
                Yii::$app->session->setFlash('error', $errorMessage);
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->redirect(['index']);
    }
}
