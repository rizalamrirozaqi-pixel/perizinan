<?php

namespace app\modules\executive_summary\laporan\laporan_penyerahan_sk\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    // Halaman Filter
    public function actionIndex()
    {
        $request = Yii::$app->request;
        return $this->render('index', [
            'params' => $request->get(),
        ]);
    }

    // Cetak HTML (Target Blank)
    public function actionCetakHtml()
    {
        $this->layout = false;
        $params = Yii::$app->request->get();
        $dataProvider = $this->getDummyData($params);

        return $this->render('cetak_html', [
            'dataProvider' => $dataProvider,
            'params' => $params,
            'isExcel' => false
        ]);
    }

    // Export Excel
    public function actionExportExcel()
    {
        $this->layout = false;
        $params = Yii::$app->request->get();
        $dataProvider = $this->getDummyData($params);

        $filename = 'Laporan_Penyerahan_SK_' . date('YmdHis') . '.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");

        return $this->render('cetak_html', [
            'dataProvider' => $dataProvider,
            'params' => $params,
            'isExcel' => true
        ]);
    }

    // Helper Data Dummy
    private function getDummyData($params)
    {
        $rawData = [
            [
                'no_pendaftaran' => '001/P/XI/2025',
                'nama_pemohon' => 'H. Suwandi',
                'nama_usaha' => 'TB. Sumber Rejeki',
                'jenis_izin' => 'SIUP',
                'retribusi' => 150000,
                'nomor_sk' => '503/SIUP/055/2025',
                'tgl_sk' => '2025-11-01',
                'tgl_habis' => '2028-11-01',
                'tgl_diserahkan' => '2025-11-05',
                'diterima_oleh' => 'Suwandi (Pemilik)'
            ],
            [
                'no_pendaftaran' => '015/P/XI/2025',
                'nama_pemohon' => 'PT. Adhi Karya',
                'nama_usaha' => 'Proyek Jembatan Comal',
                'jenis_izin' => 'IUJK',
                'retribusi' => 2500000,
                'nomor_sk' => '503/IUJK/012/2025',
                'tgl_sk' => '2025-11-03',
                'tgl_habis' => '2026-11-03',
                'tgl_diserahkan' => '2025-11-06',
                'diterima_oleh' => 'Budi (Admin)'
            ],
            [
                'no_pendaftaran' => '022/P/XI/2025',
                'nama_pemohon' => 'Drg. Anisa Putri',
                'nama_usaha' => 'Praktek Dokter Gigi',
                'jenis_izin' => 'SIP Dokter Gigi',
                'retribusi' => 0,
                'nomor_sk' => '503/SIP/089/2025',
                'tgl_sk' => '2025-11-10',
                'tgl_habis' => '2030-11-10',
                'tgl_diserahkan' => '2025-11-12',
                'diterima_oleh' => 'Anisa'
            ],
            [
                'no_pendaftaran' => '030/P/XI/2025',
                'nama_pemohon' => 'CV. Makmur Jaya',
                'nama_usaha' => 'Gudang Sembako',
                'jenis_izin' => 'Izin Gudang',
                'retribusi' => 500000,
                'nomor_sk' => '503/IG/005/2025',
                'tgl_sk' => '2025-11-15',
                'tgl_habis' => '2028-11-15',
                'tgl_diserahkan' => '2025-11-16',
                'diterima_oleh' => 'Joko (Staf)'
            ],
        ];

        // Filter Logic Sederhana
        $dari = $params['dari_tanggal'] ?? null;
        $sampai = $params['sampai_tanggal'] ?? null;

        $filteredData = array_filter($rawData, function ($row) use ($dari, $sampai) {
            if ($dari && $sampai) {
                if ($row['tgl_diserahkan'] < $dari || $row['tgl_diserahkan'] > $sampai) return false;
            }
            return true;
        });

        return new ArrayDataProvider([
            'allModels' => $filteredData,
            'pagination' => false,
            'sort' => false,
        ]);
    }
}
