<?php

namespace app\modules\executive_summary\laporan\laporan_bulanan\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    // Halaman Utama (Filter & Preview)
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $params = $request->get();

        $data = $this->getData($params['tahun'] ?? date('Y'));

        return $this->render('index', [
            'groupA' => $data['groupA'],
            'groupB' => $data['groupB'],
            'params' => $params,
        ]);
    }

    // Action Cetak HTML (Target Blank)
    public function actionCetakHtml()
    {
        $this->layout = false; // Tanpa layout dashboard
        $request = Yii::$app->request;
        $params = $request->get();

        $data = $this->getData($params['tahun'] ?? date('Y'));

        return $this->render('cetak_html', [
            'groupA' => $data['groupA'],
            'groupB' => $data['groupB'],
            'params' => $params,
        ]);
    }

    // Helper Data Dummy
    private function getData($tahun)
    {
        // Helper generate array 12 bulan
        $setBulan = function ($customValues = []) {
            $months = array_fill(0, 12, 0);
            foreach ($customValues as $index => $val) {
                if (isset($months[$index])) $months[$index] = $val;
            }
            return $months;
        };

        // Data Group A
        $groupA = [
            ['nama' => 'Izin Lokasi', 'data' => $setBulan()],
            ['nama' => 'Surat Terdaftar Pengobatan Tradisional (STPT)', 'data' => $setBulan([0 => 1, 1 => 1, 2 => 1, 5 => 1, 6 => 2])],
            ['nama' => 'Sertifikat Laik Hygiene Sanitasi Jasa Boga', 'data' => $setBulan([9 => 2, 10 => 24])],
            ['nama' => 'Izin Trayek Otobus Angkutan Kota / Pedesaan', 'data' => $setBulan([0 => 4, 1 => 3, 2 => 4, 3 => 2, 4 => 2, 5 => 3, 6 => 1, 7 => 6, 8 => 2, 9 => 1])],
            ['nama' => 'Surat Izin Praktik Dokter (SIP)', 'data' => $setBulan([8 => 1])],
            ['nama' => 'Izin Operasional Penyelenggaraan Pendidikan NonFormal', 'data' => $setBulan([6 => 2])],
            ['nama' => 'Izin Operasional Penyelenggaraan PAUD', 'data' => $setBulan([1 => 3])],
            ['nama' => 'Surat Keterangan Penelitian (SKP)', 'data' => $setBulan([1 => 1, 4 => 2, 5 => 1, 8 => 1, 9 => 1, 10 => 1])],
            ['nama' => 'Pencabutan Izin', 'data' => $setBulan([0 => 3, 1 => 3, 2 => 7, 3 => 4, 4 => 10, 5 => 7, 6 => 9, 7 => 16, 8 => 3, 9 => 11, 10 => 53])],
        ];

        // Data Group B
        $groupB = [
            ['nama' => 'Izin Penyelenggaraan Reklame', 'data' => $setBulan([0 => 17, 1 => 57, 2 => 35, 3 => 27, 4 => 28, 5 => 61, 6 => 40, 7 => 27, 8 => 29, 9 => 23, 10 => 30])],
            ['nama' => 'Rekomendasi Izin Reklame', 'data' => $setBulan([1 => 2, 2 => 3, 8 => 2, 10 => 1])],
            ['nama' => 'Izin Pemakaman', 'data' => $setBulan([0 => 2, 1 => 2, 2 => 1, 3 => 3, 4 => 2, 5 => 2, 6 => 2, 7 => 2, 8 => 1, 9 => 1, 10 => 1])],
            ['nama' => 'Izin Pembelian BBM Solar Bersubsidi Untuk Usaha Mikro', 'data' => $setBulan([0 => 808, 1 => 791, 2 => 1056, 3 => 1368, 4 => 859, 5 => 913, 6 => 1139, 7 => 1052, 8 => 988, 9 => 952, 10 => 736])],
            ['nama' => 'Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (PKKPR)', 'data' => $setBulan([0 => 3, 1 => 6, 2 => 11, 3 => 6, 4 => 4, 5 => 5, 6 => 10, 7 => 6, 8 => 4, 9 => 9])],
        ];

        return ['groupA' => $groupA, 'groupB' => $groupB];
    }
}
