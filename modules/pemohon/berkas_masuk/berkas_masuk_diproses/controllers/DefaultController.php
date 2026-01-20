<?php

namespace app\modules\pemohon\berkas_masuk\berkas_masuk_diproses\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;

class DefaultController extends Controller
{

    // DATA DUMMY KHUSUS 'DIPROSES'
    const DUMMY_DATA = [
        [
            'id' => 1,
            'nomor_daftar' => '030004',
            'nama_izin' => 'Izin Reklame',
            'jenis_permohonan' => 'BARU',
            'nama_pemohon' => 'Budi Santoso',
            'nama_usaha' => 'Toko Berkah',
            'dari' => 'Pengambilan',
            'tanggal_sampai' => '2025-11-17 14:28:14',
            'status' => 'DIPROSES',
        ],
        [
            'id' => 3,
            'nomor_daftar' => '050006',
            'nama_izin' => 'Izin Apotek',
            'jenis_permohonan' => 'BARU',
            'nama_pemohon' => 'Andi Wijaya',
            'nama_usaha' => 'Apotek Waras',
            'dari' => 'Back Office',
            'tanggal_sampai' => '2025-11-17 08:51:20',
            'status' => 'DIPROSES',
        ],
        [
            'id' => 4,
            'nomor_daftar' => '060007',
            'nama_izin' => 'Izin Usaha',
            'jenis_permohonan' => 'DAFTAR ULANG',
            'nama_pemohon' => 'Rina K',
            'nama_usaha' => 'Warung Makan',
            'dari' => 'Pengambilan',
            'tanggal_sampai' => '2025-11-13 14:27:00',
            'status' => 'DIPROSES',
        ],
    ];

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'search-diproses' => ['GET'],
                    'upload-foto' => ['POST'],
                    'routing' => ['GET'],
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

    public function actionSearchDiproses($term = null)
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
                        'value' => $item['nomor_daftar'],
                    ];
                }
            }
        }
        return array_slice($results, 0, 10);
    }

    public function actionUploadFoto($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $file = UploadedFile::getInstanceByName('foto');
        if (!$file) {
            return ['success' => false, 'message' => 'Tidak ada file yang dikirim.'];
        }

        // Validasi format
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower($file->extension);
        if (!in_array($ext, $allowed, true)) {
            return ['success' => false, 'message' => 'Format harus JPG atau PNG.'];
        }

        // Validasi ukuran (max 2MB)
        if ($file->size > 2 * 1024 * 1024) {
            return ['success' => false, 'message' => 'Ukuran file maksimal 2MB.'];
        }

        // Pastikan folder ada
        $uploadDir = Yii::getAlias('@webroot/uploads/foto');
        FileHelper::createDirectory($uploadDir);

        $filename = $id . '.' . $ext;
        $path = $uploadDir . DIRECTORY_SEPARATOR . $filename;

        if ($file->saveAs($path)) {
            $url = Yii::getAlias('@web/uploads/foto/' . $filename);
            return [
                'success' => true,
                'message' => 'Upload berhasil.',
                'url' => $url,
            ];
        }

        return ['success' => false, 'message' => 'Gagal menyimpan file.'];
    }

    public function actionRouting($id)
    {
        // Dummy
        Yii::$app->session->setFlash('info', "Berkas ID {$id} berhasil dirouting (simulasi).");
        return $this->redirect(['index']);
    }
}
