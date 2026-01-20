<?php

namespace app\modules\pemohon\berkas_keluar\berkas_keluar_sukses\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\Response;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{

    const DUMMY_DATA = [
        ['id' => 1, 'nomor_daftar' => '050001', 'nama_izin' => 'Izin Rumah Makan', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Putri Laras', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-20 10:12:43'],
        ['id' => 2, 'nomor_daftar' => '050002', 'nama_izin' => 'Izin Reklame', 'nama_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Prasetyo Adi', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-20 09:21:44'],
        ['id' => 3, 'nomor_daftar' => '050003', 'nama_izin' => 'Izin Apotek', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Dewi Rahmadhani', 'kirim_ke' => 'Back Office', 'tanggal_kirim' => '2025-01-19 11:54:10'],
        ['id' => 4, 'nomor_daftar' => '050004', 'nama_izin' => 'SIUP', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Rahman Noor', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-18 08:31:55'],
        ['id' => 5, 'nomor_daftar' => '050005', 'nama_izin' => 'Izin Gangguan / HO', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Citra Nanda', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-18 15:05:11'],
        ['id' => 6, 'nomor_daftar' => '050006', 'nama_izin' => 'Izin Klinik', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Naufal Rahman', 'kirim_ke' => 'Back Office', 'tanggal_kirim' => '2025-01-17 14:11:02'],
        ['id' => 7, 'nomor_daftar' => '050007', 'nama_izin' => 'Pembuatan Reklame', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Fauzan Akbar', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-17 09:44:20'],
        ['id' => 8, 'nomor_daftar' => '050008', 'nama_izin' => 'Usaha Mikro', 'nama_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Aulia Mansur', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-16 13:28:55'],
        ['id' => 9, 'nomor_daftar' => '050009', 'nama_izin' => 'Apotek', 'nama_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Galang Firmansyah', 'kirim_ke' => 'Back Office', 'tanggal_kirim' => '2025-01-16 07:10:34'],
        ['id' => 10, 'nomor_daftar' => '050010', 'nama_izin' => 'SPBU', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Fajar Irawan', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-15 15:15:00'],
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
                    'search-sukses' => ['GET'],
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

    public function actionSearchSukses($term = null)
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
