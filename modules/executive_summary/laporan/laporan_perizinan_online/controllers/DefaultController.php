<?php

namespace app\modules\executive_summary\laporan\laporan_perizinan_online\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $params = $request->get();

        // Data Dummy Group A: Perizinan Terstruktur (Sesuai Gambar 2)
        $groupA = [
            ['nama' => 'Izin Lokasi', 'lalu' => [0, 0, 0, 0], 'ini' => [0, 0, 0, 0]],
            ['nama' => 'Surat Terdaftar Pengobatan Tradisional (STPT)', 'lalu' => [6, 5, 1, 0], 'ini' => [2, 0, 2, 0]],
            ['nama' => 'Sertifikat Laik Hygiene Sanitasi Jasa Boga', 'lalu' => [2, 2, 0, 0], 'ini' => [24, 24, 0, 0]],
            ['nama' => 'Izin Trayek Otobus Angkutan Kota', 'lalu' => [28, 28, 0, 0], 'ini' => [1, 0, 1, 0]],
            ['nama' => 'Surat Izin Praktik Apoteker (SIPA)', 'lalu' => [0, 0, 0, 0], 'ini' => [0, 0, 0, 0]],
            ['nama' => 'Izin Operasional Penyelenggaraan Satuan Pendidikan', 'lalu' => [5, 2, 3, 0], 'ini' => [0, 0, 0, 0]],
            ['nama' => 'Surat Izin Praktik Dokter Hewan (SIP DRH)', 'lalu' => [1, 1, 0, 0], 'ini' => [0, 0, 0, 0]],
            ['nama' => 'Pencabutan Izin', 'lalu' => [125, 92, 33, 0], 'ini' => [69, 52, 17, 0]],
        ];

        // Data Dummy Group B: Perizinan Tidak Terstruktur (Sesuai Gambar 1 - Angka Besar)
        $groupB = [
            ['nama' => 'Izin Penyelenggaraan Reklame', 'lalu' => [360, 344, 16, 0], 'ini' => [33, 30, 3, 0]],
            ['nama' => 'Rekomendasi Izin Reklame', 'lalu' => [9, 7, 2, 0], 'ini' => [1, 1, 0, 0]],
            ['nama' => 'Izin Pemakaman', 'lalu' => [18, 18, 0, 0], 'ini' => [1, 1, 0, 0]],
            ['nama' => 'Izin Pengabuan Mayat', 'lalu' => [14, 14, 0, 0], 'ini' => [0, 0, 0, 0]],
            ['nama' => 'Izin Pembelian BBM Solar Bersubsidi Untuk Usaha Mikro', 'lalu' => [10131, 9925, 204, 2], 'ini' => [754, 736, 18, 0]], // Angka ribuan sesuai gambar
            ['nama' => 'Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (PKKPR)', 'lalu' => [64, 63, 1, 0], 'ini' => [10, 0, 10, 0]],
        ];

        // Logic Hitung Otomatis (Kolom 3 = Kolom 1 + Kolom 2)
        $processData = function ($data) {
            $result = [];
            foreach ($data as $row) {
                $total = [];
                for ($i = 0; $i < 4; $i++) {
                    $total[$i] = $row['lalu'][$i] + $row['ini'][$i];
                }
                $row['total'] = $total;
                $result[] = $row;
            }
            return $result;
        };

        return $this->render('index', [
            'dataGroupA' => $processData($groupA),
            'dataGroupB' => $processData($groupB),
            'params' => $params,
        ]);
    }
}
