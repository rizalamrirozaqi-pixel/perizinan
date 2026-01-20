<?php

namespace app\modules\executive_summary\laporan\laporan_register_pendaftaran\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    // 1. Halaman Filter Utama
    public function actionIndex()
    {
        $request = Yii::$app->request;
        return $this->render('index', [
            'params' => $request->get(),
        ]);
    }

    // 2. Action Cetak HTML (Tab Baru)
    public function actionCetakHtml()
    {
        $this->layout = false; // Tanpa sidebar/header dashboard
        $params = Yii::$app->request->get();
        $dataProvider = $this->getDummyData($params);

        return $this->render('cetak_html', [
            'dataProvider' => $dataProvider,
            'params' => $params,
            'isExcel' => false
        ]);
    }

    // 3. Action Cetak Excel (Download)
    public function actionExportExcel()
    {
        $this->layout = false;
        $params = Yii::$app->request->get();
        $dataProvider = $this->getDummyData($params);

        // Header Download Excel
        $filename = 'Register_Pendaftaran_' . date('YmdHis') . '.xls';
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
        // Simulasi Data sesuai kolom Buku Register
        $rawData = [
            [
                'pemohon' => 'PT. Sinar Mas Jaya',
                'alamat' => 'Jl. Jend. Sudirman No. 45, Pemalang',
                'biaya' => 500000,
                'no_izin' => '503/SIUP/001/XI/2025',
                'nama_pengambil' => 'Budi Santoso',
                'tgl_pengambil' => '2025-11-10',
                'permohonan' => 'Surat Izin Usaha Perdagangan (SIUP)',
                'keterangan' => 'Berkas Lengkap'
            ],
            [
                'pemohon' => 'CV. Abadi Sentosa',
                'alamat' => 'Jl. Pemuda No. 12',
                'biaya' => 150000,
                'no_izin' => '503/TDP/005/XI/2025',
                'nama_pengambil' => 'Siti Aminah',
                'tgl_pengambil' => '2025-11-11',
                'permohonan' => 'Tanda Daftar Perusahaan (TDP)',
                'keterangan' => 'Perpanjangan'
            ],
            [
                'pemohon' => 'Dr. Ahmad Rizky',
                'alamat' => 'Klinik Sehat, Jl. Merbabu',
                'biaya' => 0, // Retribusi 0
                'no_izin' => '503/SIP/088/XI/2025',
                'nama_pengambil' => 'Rizky',
                'tgl_pengambil' => '2025-11-12',
                'permohonan' => 'Surat Izin Praktik Dokter',
                'keterangan' => 'Baru'
            ],
            [
                'pemohon' => 'UD. Maju Bersama',
                'alamat' => 'Pasar Pagi Blok A',
                'biaya' => 250000,
                'no_izin' => '503/IUMK/012/XI/2025',
                'nama_pengambil' => 'Joko',
                'tgl_pengambil' => '2025-11-12',
                'permohonan' => 'Izin Usaha Mikro Kecil',
                'keterangan' => '-'
            ],
        ];

        // Logic Filter sederhana
        $dari = $params['dari_tanggal'] ?? null;
        $sampai = $params['sampai_tanggal'] ?? null;

        $filteredData = array_filter($rawData, function ($row) use ($dari, $sampai) {
            // Simulasi filter tanggal (berdasarkan tgl_pengambil)
            if ($dari && $sampai) {
                if ($row['tgl_pengambil'] < $dari || $row['tgl_pengambil'] > $sampai) return false;
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
