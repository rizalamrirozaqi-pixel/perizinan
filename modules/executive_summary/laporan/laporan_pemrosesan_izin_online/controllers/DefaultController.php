<?php

namespace app\modules\executive_summary\laporan\laporan_pemrosesan_izin_online\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $params = $request->get();

        // DATA DUMMY (Sesuai Screenshot Laporan Online)
        $rawData = [
            ['nama' => 'Sub Koordinator Pelayanan', 'diterima' => 0, 'diproses' => 0],
            ['nama' => 'Back Office', 'diterima' => 0, 'diproses' => 0],
            ['nama' => 'Front Office', 'diterima' => 0, 'diproses' => 0],
            ['nama' => 'Kepala DPMPTSP Pemalang', 'diterima' => 0, 'diproses' => 0],
            ['nama' => 'Kasir', 'diterima' => 0, 'diproses' => 0],
            ['nama' => 'Kasi Perizinan', 'diterima' => 0, 'diproses' => 0],
            ['nama' => 'Pengambilan', 'diterima' => 7, 'diproses' => 9], // Data dari gambar
            ['nama' => 'Pemohon', 'diterima' => 6, 'diproses' => 0], // Data dari gambar
            ['nama' => 'Koordinator Pelayanan Perizinan', 'diterima' => 0, 'diproses' => 0],
            ['nama' => 'Sekretaris DPMPTSP', 'diterima' => 0, 'diproses' => 0],
            ['nama' => 'OPD Teknis', 'diterima' => 0, 'diproses' => 0],
        ];

        $dataProvider = new ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => false,
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }
}
