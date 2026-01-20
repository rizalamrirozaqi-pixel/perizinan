<?php

namespace app\modules\pemohon\berkas_keluar\berkas_keluar_dikembalikan\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\Response;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{

    const DUMMY_DATA = [
        ['id' => 1, 'nomor_daftar' => '060001', 'nama_izin' => 'SIUP', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Rendi Febrian', 'kirim_ke' => 'Back Office', 'tanggal_ditolak' => '2025-01-21 08:30:11', 'kategori' => 'Administrasi', 'keterangan' => 'Dokumen kurang tanda tangan.'],
        ['id' => 2, 'nomor_daftar' => '060002', 'nama_izin' => 'Reklame', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Cindy Tasya', 'kirim_ke' => 'Front Office', 'tanggal_ditolak' => '2025-01-21 11:11:15', 'kategori' => 'Teknis', 'keterangan' => 'Ukuran tidak sesuai.'],
        ['id' => 3, 'nomor_daftar' => '060003', 'nama_izin' => 'Rumah Makan', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Doni Alfat', 'kirim_ke' => 'Pengambilan', 'tanggal_ditolak' => '2025-01-20 15:16:20', 'kategori' => 'Verifikasi', 'keterangan' => 'Foto lokasi tidak jelas.'],
        ['id' => 4, 'nomor_daftar' => '060004', 'nama_izin' => 'Apotek', 'nama_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Salsa Widya', 'kirim_ke' => 'Back Office', 'tanggal_ditolak' => '2025-01-20 10:05:12', 'kategori' => 'Legalitas', 'keterangan' => 'Surat izin kadaluarsa.'],
        ['id' => 5, 'nomor_daftar' => '060005', 'nama_izin' => 'Klinik', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Dimas Hakim', 'kirim_ke' => 'Pengambilan', 'tanggal_ditolak' => '2025-01-19 09:22:01', 'kategori' => 'Administrasi', 'keterangan' => 'Dokumen tidak lengkap.'],
        ['id' => 6, 'nomor_daftar' => '060006', 'nama_izin' => 'Air Minum Isi Ulang', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Mira Ayu', 'kirim_ke' => 'Front Office', 'tanggal_ditolak' => '2025-01-18 14:44:00', 'kategori' => 'Teknis', 'keterangan' => 'Gambar denah salah.'],
        ['id' => 7, 'nomor_daftar' => '060007', 'nama_izin' => 'SPBU', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Farhan Alwi', 'kirim_ke' => 'Back Office', 'tanggal_ditolak' => '2025-01-18 07:19:52', 'kategori' => 'Verifikasi', 'keterangan' => 'Format dokumen salah.'],
        ['id' => 8, 'nomor_daftar' => '060008', 'nama_izin' => 'Reklame', 'nama_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Latifa Zahra', 'kirim_ke' => 'Front Office', 'tanggal_ditolak' => '2025-01-17 17:05:35', 'kategori' => 'Teknis', 'keterangan' => 'Backdrop tidak legal.'],
        ['id' => 9, 'nomor_daftar' => '060009', 'nama_izin' => 'Rumah Makan', 'nama_permohonan' => 'DAFTAR ULANG', 'nama_pemohon' => 'Tri Hardiansyah', 'kirim_ke' => 'Pengambilan', 'tanggal_ditolak' => '2025-01-17 11:59:59', 'kategori' => 'Administrasi', 'keterangan' => 'Scan tidak jelas.'],
        ['id' => 10, 'nomor_daftar' => '060010', 'nama_izin' => 'Salon', 'nama_permohonan' => 'BARU', 'nama_pemohon' => 'Bella Wijaya', 'kirim_ke' => 'Front Office', 'tanggal_ditolak' => '2025-01-16 08:13:45', 'kategori' => 'Legalitas', 'keterangan' => 'Alamat tidak match.'],
    ];


    // Angka di tab (bisa disesuaikan dari DB nanti)
    const TOTAL_MENUNGGU    = 3;
    const TOTAL_SUKSES      = 102434;
    const TOTAL_DIKEMBALIKAN = 2;     // sesuai DUMMY_DATA
    const TOTAL_ARSIP       = 102437;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'search-dikembalikan' => ['GET'],
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
            $term = mb_strtolower($search);
            $filteredData = array_filter($allData, function ($item) use ($term) {
                return stripos($item['nomor_daftar'], $term) !== false
                    || stripos($item['nama_pemohon'], $term) !== false;
            });
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => array_values($filteredData),
            'pagination' => ['pageSize' => 5],
            'sort' => [
                'attributes' => ['nomor_daftar', 'nama_pemohon', 'tanggal_ditolak'],
                'defaultOrder' => ['tanggal_ditolak' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'dataProvider'        => $dataProvider,
            'search'              => $search,
            'totalMenunggu'       => self::TOTAL_MENUNGGU,
            'totalSukses'         => self::TOTAL_SUKSES,
            'totalDikembalikan'   => self::TOTAL_DIKEMBALIKAN,
            'totalArsip'          => self::TOTAL_ARSIP,
        ]);
    }

    public function actionSearchDikembalikan($term = null)
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
