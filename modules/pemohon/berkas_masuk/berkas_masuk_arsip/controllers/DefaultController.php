<?php

namespace app\modules\pemohon\berkas_masuk\berkas_masuk_arsip\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\Response;

class DefaultController extends Controller
{

    // DATA DUMMY KHUSUS 'ARSIP'
    const DUMMY_DATA = [
        ['id' => 5, 'nomor_daftar' => '070008', 'nama_izin' => 'IMB', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Slamet R', 'nama_usaha' => 'Rumah Tinggal', 'dari' => 'Arsip', 'tanggal_sampai' => '2025-10-10 10:00:00', 'status' => 'ARSIP'],
        ['id' => 6, 'nomor_daftar' => '080009', 'nama_izin' => 'SIP Dokter', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Dr. Budi', 'nama_usaha' => 'Praktek', 'dari' => 'Arsip', 'tanggal_sampai' => '2025-09-01 09:00:00', 'status' => 'ARSIP'],
        ['id' => 7, 'nomor_daftar' => '090010', 'nama_izin' => 'Izin Usaha', 'jenis_permohonan' => 'PENCABUTAN', 'nama_pemohon' => 'CV. Maju', 'nama_usaha' => 'Toko Maju', 'dari' => 'Arsip', 'tanggal_sampai' => '2025-08-20 11:30:00', 'status' => 'ARSIP'],
    ];

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'search-arsip' => ['GET'], // Action Autocomplete Unik
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $search = Yii::$app->request->get('search');
        $allData = self::DUMMY_DATA;
        $filteredData = $allData;

        if (!empty($search)) {
            $term = strtolower($search);
            $filteredData = array_filter($allData, function ($item) use ($term) {
                return stripos($item['nomor_daftar'], $term) !== false ||
                    stripos($item['nama_pemohon'], $term) !== false;
            });
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'pagination' => ['pageSize' => 10],
            'sort' => [
                'attributes' => ['nomor_daftar', 'nama_pemohon', 'tanggal_sampai'],
                'defaultOrder' => ['tanggal_sampai' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'search' => $search,
        ]);
    }

    public function actionSearchArsip($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $results = [];
        if (!empty($term)) {
            $term = strtolower($term);
            foreach (self::DUMMY_DATA as $item) {
                if (stripos($item['nomor_daftar'], $term) !== false || stripos($item['nama_pemohon'], $term) !== false) {
                    $results[] = ['label' => "{$item['nomor_daftar']} - {$item['nama_pemohon']}", 'value' => $item['nomor_daftar']];
                }
            }
        }
        return array_slice($results, 0, 10);
    }
}
