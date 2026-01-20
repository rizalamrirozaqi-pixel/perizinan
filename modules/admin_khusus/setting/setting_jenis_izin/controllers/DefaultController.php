<?php

namespace app\modules\admin_khusus\setting\setting_jenis_izin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $rawData = [
            ['id' => 1, 'nama_izin' => 'Izin Mendirikan Bangunan (IMB)', 'sektor' => 'Pekerjaan umum dan perumahan rakyat', 'status_online' => 'Tidak Aktif', 'status_izin' => 'Tidak Aktif'],
            ['id' => 2, 'nama_izin' => 'Izin Lokasi', 'sektor' => '-', 'status_online' => 'Tidak Aktif', 'status_izin' => 'Aktif'],
            ['id' => 3, 'nama_izin' => 'Izin Gangguan / HO', 'sektor' => '-', 'status_online' => 'Tidak Aktif', 'status_izin' => 'Tidak Aktif'],
            ['id' => 4, 'nama_izin' => 'Tanda Daftar Perusahaan (TDP)', 'sektor' => '-', 'status_online' => 'Tidak Aktif', 'status_izin' => 'Tidak Aktif'],
            ['id' => 5, 'nama_izin' => 'Izin Usaha Industri (IUI) 1', 'sektor' => 'Perindustrian', 'status_online' => 'Tidak Aktif', 'status_izin' => 'Tidak Aktif'],
            ['id' => 6, 'nama_izin' => 'Izin Usaha Industri (IUI)', 'sektor' => 'Perindustrian', 'status_online' => 'Tidak Aktif', 'status_izin' => 'Tidak Aktif'],
            ['id' => 7, 'nama_izin' => 'Surat Izin Usaha Perdagangan (SIUP)', 'sektor' => 'Perdagangan', 'status_online' => 'Tidak Aktif', 'status_izin' => 'Tidak Aktif'],
            ['id' => 8, 'nama_izin' => 'Izin Pengelolaan dan Pengusahaan Sarang Burung Walet', 'sektor' => 'Pertanian', 'status_online' => 'Tidak Aktif', 'status_izin' => 'Tidak Aktif'],
            ['id' => 9, 'nama_izin' => 'Persetujuan Tanda Daftar Usaha Pariwisata', 'sektor' => 'Pariwisata', 'status_online' => 'Tidak Aktif', 'status_izin' => 'Tidak Aktif'],
            ['id' => 10, 'nama_izin' => 'Izin Trayek', 'sektor' => 'Perhubungan', 'status_online' => 'Aktif', 'status_izin' => 'Aktif'],
        ];

        $dataProvider = new ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 10, 
            ],
            'sort' => [
                'attributes' => ['nama_izin', 'sektor'],
            ],
        ]);

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('success', 'Data Izin berhasil diperbarui.');
            return $this->refresh();
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}