<?php

namespace app\modules\executive_summary\izin_terbit_sk\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $params = $request->get();

        // 1. DATA DUMMY (Sesuai Kolom Gambar Tabel)
        $rawData = [
            [
                'no_pendaftaran' => '001/P/XI/2025',
                'tgl_pendaftaran' => '2025-11-01',
                'nama_pemohon' => 'H. Suwandi',
                'nama_usaha' => 'TB. Sumber Rejeki',
                'alamat_pemohon' => 'Jl. Pemuda No. 45, RT.04 RW.01',
                'nama_izin' => 'Surat Izin Usaha Perdagangan',
                'nama_permohonan' => 'Baru',
                'lokasi' => 'Jl. Pemuda No. 45',
                'kecamatan_kelurahan' => 'Pemalang / Mulyoharjo',
                'nomor_sk' => '503/SIUP/055/2025',
                'retribusi' => 0,
                'tgl_pengesahan' => '2025-11-05',
                'tgl_berlaku' => '2025-11-05',
                'tgl_selesai' => '2028-11-05',
            ],
            [
                'no_pendaftaran' => '012/P/XI/2025',
                'tgl_pendaftaran' => '2025-11-03',
                'nama_pemohon' => 'PT. Konstruksi Jaya',
                'nama_usaha' => 'Kantor Cabang Pemalang',
                'alamat_pemohon' => 'Jl. Jend. Sudirman No. 10',
                'nama_izin' => 'Izin Mendirikan Bangunan (IMB)',
                'nama_permohonan' => 'Baru',
                'lokasi' => 'Jl. Jend. Sudirman No. 10',
                'kecamatan_kelurahan' => 'Pemalang / Pelutan',
                'nomor_sk' => '503/IMB/012/2025',
                'retribusi' => 1920000,
                'tgl_pengesahan' => '2025-11-10',
                'tgl_berlaku' => '2025-11-10',
                'tgl_selesai' => 'Seumur Hidup',
            ],
            [
                'no_pendaftaran' => '033/P/XI/2025',
                'tgl_pendaftaran' => '2025-11-12',
                'nama_pemohon' => 'Siti Aminah',
                'nama_usaha' => 'Apotek Sehat',
                'alamat_pemohon' => 'Jl. Gatot Subroto No. 88',
                'nama_izin' => 'Surat Izin Praktik Apoteker',
                'nama_permohonan' => 'Perpanjangan',
                'lokasi' => 'Jl. Gatot Subroto No. 88',
                'kecamatan_kelurahan' => 'Taman / Banjardawa',
                'nomor_sk' => '503/SIPA/009/2025',
                'retribusi' => 0,
                'tgl_pengesahan' => '2025-11-15',
                'tgl_berlaku' => '2025-11-15',
                'tgl_selesai' => '2030-11-15',
            ],
        ];

        // 2. Filter Logic (Sederhana)
        $namaPemohon = $params['nama_pemohon'] ?? '';
        $filteredData = array_filter($rawData, function ($row) use ($namaPemohon) {
            if ($namaPemohon && stripos($row['nama_pemohon'], $namaPemohon) === false) {
                return false;
            }
            return true;
        });

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'pagination' => ['pageSize' => 10],
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }
}
