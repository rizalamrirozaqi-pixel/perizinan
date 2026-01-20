<?php

namespace app\modules\admin_khusus\setting\setting_sektor\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        // Data Dummy Sesuai Screenshot
        $rawData = [
            ['id' => 1, 'nama_sektor' => 'Pertanian', 'status' => 'Aktif'],
            ['id' => 2, 'nama_sektor' => 'Lingkungan hidup dan kehutanan', 'status' => 'Aktif'],
            ['id' => 3, 'nama_sektor' => 'Energi dan sumber daya mineral', 'status' => 'Aktif'],
            ['id' => 4, 'nama_sektor' => 'Ketenaganukliran', 'status' => 'Aktif'],
            ['id' => 5, 'nama_sektor' => 'Perindustrian', 'status' => 'Aktif'],
            ['id' => 6, 'nama_sektor' => 'Perdagangan', 'status' => 'Aktif'],
            ['id' => 7, 'nama_sektor' => 'Pekerjaan umum dan perumahan rakyat', 'status' => 'Aktif'],
            ['id' => 8, 'nama_sektor' => 'Transportasi', 'status' => 'Aktif'],
            ['id' => 9, 'nama_sektor' => 'Kesehatan, obat dan makanan', 'status' => 'Aktif'],
            ['id' => 10, 'nama_sektor' => 'Pendidikan dan kebudayaan', 'status' => 'Aktif'],
            ['id' => 11, 'nama_sektor' => 'Pariwisata', 'status' => 'Aktif'],
            ['id' => 12, 'nama_sektor' => 'Keagamaan', 'status' => 'Tidak Aktif'],
        ];

        $dataProvider = new ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 10, 
            ],
            'sort' => [
                'attributes' => ['nama_sektor', 'status'],
            ],
        ]);

        // Jika ada post request (Simpan Data)
        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('success', 'Data Sektor berhasil disimpan.');
            return $this->refresh();
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}