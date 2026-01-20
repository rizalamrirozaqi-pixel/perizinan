<?php

namespace app\modules\pemohon\pencarian\pencarian_routing\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\Response;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'search-routing' => ['GET'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $search = Yii::$app->request->get('search');

        // (FIX) Awalnya kosong dulu
        $filteredData = [];

        // (FIX) Jika ada pencarian, baru ambil dan filter data
        if (!empty($search)) {
            $allData = $this->getDummyData(); // Ambil data dummy hanya jika perlu
            $term = strtolower($search);
            $filteredData = array_filter($allData, function ($item) use ($term) {
                return stripos($item['nomor_daftar'], $term) !== false ||
                    stripos($item['nama_pemohon'], $term) !== false ||
                    stripos($item['nama_usaha'], $term) !== false;
            });
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'pagination' => ['pageSize' => 5],
            'sort' => [
                'attributes' => ['nomor_daftar', 'nama_pemohon', 'waktu_daftar'],
                'defaultOrder' => ['waktu_daftar' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'search' => $search,
            // (FIX) Kirim flag apakah sedang mencari atau tidak
            'isSearch' => !empty($search),
        ]);
    }


    // API Autocomplete
    public function actionSearchRouting($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $results = [];

        if (!empty($term)) {
            $term = strtolower($term);
            $allData = $this->getDummyData();

            foreach ($allData as $item) {
                if (
                    stripos($item['nomor_daftar'], $term) !== false ||
                    stripos($item['nama_pemohon'], $term) !== false ||
                    stripos($item['nama_usaha'], $term) !== false
                ) {
                    $label = "{$item['nomor_daftar']} - {$item['nama_pemohon']}";
                    $results[] = [
                        'label' => $label,
                        'value' => $item['nomor_daftar'],
                    ];
                }
            }
        }
        return array_slice($results, 0, 10); // Batasi 10 hasil saja
    }

    // DATA DUMMY BANYAK (20 Data)
    protected function getDummyData()
    {
        $data = [];
        $names = ['Budi Santoso', 'Siti Aminah', 'Andi Wijaya', 'Rina Kusuma', 'Joko Susilo', 'Dewi Lestari', 'Agus Setiawan', 'Lestari Wulandari', 'Cahyo Utomo', 'Indah Permata', 'Eko Prasetyo', 'Fajar Nugroho', 'Gita Gutawa', 'Hendra Gunawan', 'Iwan Fals', 'Julia Perez', 'Kartika Putri', 'Luna Maya', 'Maudy Ayunda', 'Nia Ramadhani'];
        $businesses = ['Toko Kelontong', 'Klinik Sehat', 'Apotek Segar', 'Warung Makan', 'Bengkel Motor', 'Salon Cantik', 'Toko Bangunan', 'Florist', 'Jasa Komputer', 'Butik Baju', 'Katering', 'Percetakan', 'Studio Foto', 'Cuci Mobil', 'Laundry', 'Toko Sepatu', 'Kedai Kopi', 'Toko Buku', 'Bimbingan Belajar', 'Toko Mainan'];

        for ($i = 1; $i <= 20; $i++) {
            $nomor = sprintf("03%04d", $i);
            $date = date('Y-m-d', strtotime("-{$i} days"));

            $data[] = [
                'id' => $i,
                'nomor_daftar' => $nomor,
                'nama_izin' => ($i % 2 == 0) ? 'Izin Usaha Perdagangan' : 'Izin Mendirikan Bangunan',
                'jenis_permohonan' => ($i % 3 == 0) ? 'PERPANJANGAN' : 'BARU',
                'nama_pemohon' => $names[$i - 1],
                'nama_usaha' => $businesses[$i - 1],
                'alamat' => 'Jl. Pemuda No. ' . $i,
                'lokasi_usaha' => 'Kecamatan Pemalang',
                'waktu_daftar' => $date . ' 10:00:00',
                'status_posisi' => ($i % 4 == 0) ? 'Selesai' : (($i % 3 == 0) ? 'Verifikasi Teknis' : 'Front Office'),
                'keterangan' => '-',
            ];
        }
        return $data;
    }
}
