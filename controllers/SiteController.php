<?php // <-- (FIX 1) TAMBAHKAN INI

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\PendaftaranForm; // Pastikan model ini ada jika kamu menggunakannya
use yii\filters\AccessControl;
use yii\filters\VerbFilter; // Sebaiknya tambahkan VerbFilter

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'], // Hanya user yang sudah login
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'], // Logout sebaiknya via POST
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['site/index']);
        }

        $model = new LoginForm();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            // Logika dummy_check Anda (saya asumsikan ini captcha)
            if (empty($post['dummy_check'])) {
                Yii::$app->session->setFlash('error', 'Isi Captcha Terlebih Dahulu.');
            } elseif ($model->load($post) && $model->login()) {
                return $this->redirect(['site/index']);
            } else {
                // Jangan sebut "Email atau password salah" jika validasi gagal
                // $model->login() sudah menangani error
                if (!$model->hasErrors()) {
                    Yii::$app->session->setFlash('error', 'Email atau password salah.');
                }
            }
        }

        // Penting: kirim model ke view agar error validasi tampil
        return $this->render('login', ['model' => $model]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
