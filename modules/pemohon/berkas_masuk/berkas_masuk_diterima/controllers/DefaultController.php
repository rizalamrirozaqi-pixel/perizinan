<?php

namespace app\modules\pemohon\berkas_masuk\berkas_masuk_diterima\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\Response;

class DefaultController extends Controller
{

    // Data Dummy khusus Berkas Masuk Diterima
    const DUMMY_DATA = [
        ['id' => 1, 'nomor_daftar' => '030004', 'nama_izin' => 'Sertifikat Laik Hygiene Sanitasi Jasa Boga', 'jenis_permohonan' => 'SPPG', 'nama_pemohon' => 'Budi Santoso', 'nama_usaha' => 'Toko Berkah', 'dari' => 'Pengambilan', 'tanggal_sampai' => '2025-11-17 14:28:14', 'status' => 'DITERIMA'],
        ['id' => 2, 'nomor_daftar' => '040005', 'nama_izin' => 'Sertifikat Laik Hygiene Sanitasi Jasa Boga', 'jenis_permohonan' => 'SPPG', 'nama_pemohon' => 'Dr. Siti', 'nama_usaha' => 'Klinik Sehat', 'dari' => 'Pengambilan', 'tanggal_sampai' => '2025-11-17 14:21:17', 'status' => 'DITERIMA'],
        ['id' => 3, 'nomor_daftar' => '050006', 'nama_izin' => 'Sertifikat Laik Hygiene Sanitasi Jasa Boga', 'jenis_permohonan' => 'SPPG', 'nama_pemohon' => 'Andi Wijaya', 'nama_usaha' => 'Apotek Waras', 'dari' => 'Pengambilan', 'tanggal_sampai' => '2025-11-17 13:52:35', 'status' => 'DITERIMA'],
        ['id' => 4, 'nomor_daftar' => '060007', 'nama_izin' => 'Izin Pembelian BBM Solar', 'jenis_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Rina K', 'nama_usaha' => 'Warung Makan', 'dari' => 'Back Office', 'tanggal_sampai' => '2025-11-17 08:51:20', 'status' => 'DITERIMA'],
        ['id' => 5, 'nomor_daftar' => '070008', 'nama_izin' => 'Sertifikat Laik Hygiene Sanitasi Jasa Boga', 'jenis_permohonan' => 'SPPG', 'nama_pemohon' => 'Slamet R', 'nama_usaha' => 'Rumah Tinggal', 'dari' => 'Pengambilan', 'tanggal_sampai' => '2025-11-13 14:27:00', 'status' => 'DITERIMA'],
        ['id' => 6, 'nomor_daftar' => '070008', 'nama_izin' => 'Sertifikat Laik Hygiene Sanitasi Jasa Boga', 'jenis_permohonan' => 'SPPG', 'nama_pemohon' => 'Slamet R', 'nama_usaha' => 'Rumah Tinggal', 'dari' => 'Pengambilan', 'tanggal_sampai' => '2025-11-13 14:27:00', 'status' => 'DITERIMA'],
    ];

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'search-diterima' => ['GET'], // (FIX) Action Autocomplete
                    'terima' => ['POST'],
                    'tolak' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $search = Yii::$app->request->get('search');
        $allData = self::DUMMY_DATA;
        $filteredData = $allData; // Default tampilkan semua

        // Filter Pencarian
        if (!empty($search)) {
            $term = strtolower($search);
            $filteredData = array_filter($allData, function ($item) use ($term) {
                return stripos($item['nomor_daftar'], $term) !== false ||
                    stripos($item['nama_pemohon'], $term) !== false;
            });
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'pagination' => ['pageSize' => 5],
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

    // (FIX) Action Autocomplete API
    public function actionSearchDiterima($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $results = [];

        if (!empty($term)) {
            $term = strtolower($term);
            foreach (self::DUMMY_DATA as $item) {
                if (
                    stripos($item['nomor_daftar'], $term) !== false ||
                    stripos($item['nama_pemohon'], $term) !== false
                ) {
                    $results[] = [
                        'label' => "{$item['nomor_daftar']} - {$item['nama_pemohon']}",
                        'value' => $item['nomor_daftar'], // Value yang masuk ke input
                    ];
                }
            }
        }
        return array_slice($results, 0, 10);
    }

    public function actionTerima($id)
    {
        Yii::$app->session->setFlash('success', 'Berkas berhasil diterima.');
        return $this->redirect(['index']);
    }

    public function actionTolak($id)
    {
        Yii::$app->session->setFlash('warning', 'Berkas ditolak.');
        return $this->redirect(['index']);
    }
}
