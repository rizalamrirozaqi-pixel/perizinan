<?php

namespace app\modules\executive_summary\laporan\laporan_pemrosesan_izin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;

        // Parameter Filter
        $dariTanggal = $request->get('dari_tanggal');
        $sampaiTanggal = $request->get('sampai_tanggal');

        // DATA DUMMY (Sesuai Screenshot)
        $rawData = [
            ['nama' => 'Sub Koordinator Pelayanan', 'diterima' => 3, 'diproses' => 0],
            ['nama' => 'Back Office', 'diterima' => 1550, 'diproses' => 566],
            ['nama' => 'Front Office', 'diterima' => 0, 'diproses' => 0],
            ['nama' => 'Kepala DPMPTSP Pemalang', 'diterima' => 11, 'diproses' => 0],
            ['nama' => 'Kasir', 'diterima' => 2, 'diproses' => 1],
            ['nama' => 'Kasi Perizinan', 'diterima' => 1, 'diproses' => 0],
            ['nama' => 'Pengambilan', 'diterima' => 78729, 'diproses' => 10985],
            ['nama' => 'Pemohon', 'diterima' => 8346, 'diproses' => 452],
            ['nama' => 'Koordinator Pelayanan Perizinan', 'diterima' => 6, 'diproses' => 0],
            ['nama' => 'Sekretaris DPMPTSP', 'diterima' => 0, 'diproses' => 0],
            ['nama' => 'OPD Teknis', 'diterima' => 0, 'diproses' => 1],
        ];

        // Provider (Tanpa pagination karena biasanya rekapitulasi ditampilkan semua)
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => false,
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'params' => $request->get(),
        ]);
    }
}
