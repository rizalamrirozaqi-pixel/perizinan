<?php

namespace app\modules\pemohon\berkas_keluar\berkas_keluar_arsip\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\Response;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{

    const DUMMY_DATA = [
        ['id' => 1, 'nomor_daftar' => '070001', 'nama_izin' => 'SIUP', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Budi Santoso', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-21 12:38:47'],
        ['id' => 2, 'nomor_daftar' => '070002', 'nama_izin' => 'SPBU', 'nama_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Siti Aminah', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-21 10:57:30'],
        ['id' => 3, 'nomor_daftar' => '070003', 'nama_izin' => 'Reklame', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Andi Wijaya', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-21 10:51:55'],
        ['id' => 4, 'nomor_daftar' => '070004', 'nama_izin' => 'Air Minum', 'nama_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Rina K', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-21 10:48:17'],
        ['id' => 5, 'nomor_daftar' => '070005', 'nama_izin' => 'Apotek', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Dedi Putra', 'kirim_ke' => 'Back Office', 'tanggal_kirim' => '2025-01-21 10:47:49'],
        ['id' => 6, 'nomor_daftar' => '070006', 'nama_izin' => 'Rumah Makan', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Lina Rahmi', 'kirim_ke' => 'Back Office', 'tanggal_kirim' => '2025-01-21 10:47:00'],
        ['id' => 7, 'nomor_daftar' => '070007', 'nama_izin' => 'Klinik', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Febri H', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-21 10:45:16'],
        ['id' => 8, 'nomor_daftar' => '070008', 'nama_izin' => 'Reklame', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Heri Gunawan', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-21 10:33:56'],
        ['id' => 9, 'nomor_daftar' => '070009', 'nama_izin' => 'Salon', 'nama_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Novi Rahma', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-21 10:25:24'],
        ['id' => 10, 'nomor_daftar' => '070010', 'nama_izin' => 'Perdagangan', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Agus W', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-21 10:23:24'],
    ];


    const TOTAL_MENUNGGU     = 3;
    const TOTAL_SUKSES       = 102434;
    const TOTAL_DIKEMBALIKAN = 0;
    const TOTAL_ARSIP        = 102437;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'search-arsip' => ['GET'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $search   = Yii::$app->request->get('search');
        $allData  = self::DUMMY_DATA;
        $filtered = $allData;

        if (!empty($search)) {
            $term    = mb_strtolower($search);
            $filtered = array_filter($allData, function ($item) use ($term) {
                return stripos($item['nomor_daftar'], $term) !== false
                    || stripos($item['nama_pemohon'], $term) !== false;
            });
        }

        $dataProvider = new ArrayDataProvider([
            'allModels'  => array_values($filtered),
            'pagination' => ['pageSize' => 5],
            'sort'       => [
                'attributes'   => ['nomor_daftar', 'nama_pemohon', 'tanggal_kirim'],
                'defaultOrder' => ['tanggal_kirim' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'dataProvider'      => $dataProvider,
            'search'            => $search,
            'totalMenunggu'     => self::TOTAL_MENUNGGU,
            'totalSukses'       => self::TOTAL_SUKSES,
            'totalDikembalikan' => self::TOTAL_DIKEMBALIKAN,
            'totalArsip'        => self::TOTAL_ARSIP,
        ]);
    }

    public function actionSearchArsip($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $results = [];
        if (!empty($term)) {
            $term = mb_strtolower($term);
            foreach (self::DUMMY_DATA as $item) {
                if (
                    stripos($item['nomor_daftar'], $term) !== false
                    || stripos($item['nama_pemohon'], $term) !== false
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
}
