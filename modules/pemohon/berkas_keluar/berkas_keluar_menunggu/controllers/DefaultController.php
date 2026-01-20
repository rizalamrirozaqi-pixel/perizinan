<?php

namespace app\modules\pemohon\berkas_keluar\berkas_keluar_menunggu\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\Response;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{

    const DUMMY_DATA = [
        ['id' => 1, 'nomor_daftar' => '030001', 'nama_izin' => 'Izin Gangguan / HO', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Budi Santoso', 'kirim_ke' => 'Back Office', 'tanggal_kirim' => '2025-01-06 09:29:57'],
        ['id' => 2, 'nomor_daftar' => '030002', 'nama_izin' => 'Surat Izin Usaha Perdagangan (SIUP)', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Siti Aminah', 'kirim_ke' => 'Back Office', 'tanggal_kirim' => '2025-01-07 10:15:30'],
        ['id' => 3, 'nomor_daftar' => '030003', 'nama_izin' => 'Izin Penyelenggaraan Reklame', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Andi Wijaya', 'kirim_ke' => 'Pengambilan', 'tanggal_kirim' => '2025-01-08 08:20:00'],
        ['id' => 4, 'nomor_daftar' => '030004', 'nama_izin' => 'Izin Apotek', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Rina Kartika', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-09 13:45:10'],
        ['id' => 5, 'nomor_daftar' => '030005', 'nama_izin' => 'Izin Usaha Mikro Kecil', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Dedi Pratama', 'kirim_ke' => 'Back Office', 'tanggal_kirim' => '2025-01-10 09:05:40'],
        ['id' => 6, 'nomor_daftar' => '030006', 'nama_izin' => 'Izin Tanda Daftar Perusahaan', 'nama_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Lina Marlina', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-11 11:22:33'],
        ['id' => 7, 'nomor_daftar' => '030007', 'nama_izin' => 'Izin Depot Air Minum', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Febri Aulia', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-11 14:18:10'],
        ['id' => 8, 'nomor_daftar' => '030008', 'nama_izin' => 'Izin Klinik Kesehatan', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Heri Gunawan', 'kirim_ke' => 'Back Office', 'tanggal_kirim' => '2025-01-12 09:14:22'],
        ['id' => 9, 'nomor_daftar' => '030009', 'nama_izin' => 'Izin Pembangunan Reklame', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Novi Rahmawati', 'kirim_ke' => 'Front Office', 'tanggal_kirim' => '2025-01-12 16:30:42'],
        ['id' => 10, 'nomor_daftar' => '030010', 'nama_izin' => 'Izin Rumah Makan', 'nama_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Agus Wijaya', 'kirim_ke' => 'Pengambilan', 'tanggal_kirim' => '2025-01-13 08:00:00'],
    ];


    // Angka di tab (bisa kamu ambil dari DB nanti)
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
                    'search-menunggu' => ['GET'],
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

    public function actionSearchMenunggu($term = null)
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
