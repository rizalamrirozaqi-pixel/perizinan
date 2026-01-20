<?php

namespace app\modules\executive_summary\laporan\laporan_cetak_sk\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    // Halaman Utama (Cuma Form Filter)
    public function actionIndex()
    {
        $request = Yii::$app->request;

        // Data Dropdown
        $listJenisIzin = [
            '' => '-- Pilih Jenis Izin --',
            'IUJK' => 'Izin Usaha Jasa Konstruksi (IUJK)',
            'SIUP' => 'Surat Izin Usaha Perdagangan',
        ];

        $listJenisPermohonan = [
            '' => '-- Pilih Jenis Permohonan --',
            'Baru' => 'Baru',
            'Daftar Ulang' => 'Daftar Ulang',
            'Perubahan' => 'Perubahan',
            'Perpanjangan' => 'Perpanjangan',
        ];

        return $this->render('index', [
            'listJenisIzin' => $listJenisIzin,
            'listJenisPermohonan' => $listJenisPermohonan,
            'params' => $request->get(),
        ]);
    }

    // Action Khusus Cetak HTML (Tab Baru)
    public function actionCetakHtml()
    {
        $this->layout = false; // Matikan layout dashboard (header/sidebar hilang)

        $params = Yii::$app->request->get();
        $dataProvider = $this->getDummyData($params); // Ambil data

        return $this->render('cetak_html', [
            'dataProvider' => $dataProvider,
            'params' => $params,
            'isExcel' => false
        ]);
    }

    // Action Khusus Cetak Excel (Download)
    public function actionExportExcel()
    {
        $this->layout = false;

        $params = Yii::$app->request->get();
        $dataProvider = $this->getDummyData($params);

        // Header agar dibaca sebagai Excel
        $filename = 'Laporan_Cetak_SK_' . date('YmdHis') . '.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");

        // Render view yang sama dengan HTML tapi tanpa tombol print
        return $this->render('cetak_html', [
            'dataProvider' => $dataProvider,
            'params' => $params,
            'isExcel' => true
        ]);
    }

    // --- Private Function: Data Dummy (Biar gak copy paste logic) ---
    private function getDummyData($params)
    {
        $jenisPermohonan = $params['jenis_permohonan'] ?? null;
        $dariTanggal = $params['dari_tanggal'] ?? null;
        $sampaiTanggal = $params['sampai_tanggal'] ?? null;

        $rawData = [
            [
                'id' => 1,
                'nama_pemohon' => 'Budi Santoso',
                'nama_usaha' => 'CV. Konstruksi Jaya',
                'lokasi_izin' => 'Jl. Merdeka No. 10',
                'kelurahan' => 'Mulyoharjo',
                'kecamatan' => 'Pemalang',
                'asosiasi' => 'GAPENSI',
                'kualifikasi' => 'Kecil',
                'kegiatan_usaha' => 'Jasa Konstruksi',
                'klasifikasi_usaha' => 'Bangunan Sipil',
                'tgl_penetapan' => '2025-11-04',
                'tgl_berlaku' => '2025-11-04 s/d 2028',
                'jenis_permohonan' => 'Baru',
                'penanggung_jawab' => 'Ir. Budi',
                'alamat_tenaga' => 'Jl. Melati',
                'kualifikasi_tenaga' => 'Ahli Muda',
                'no_sk' => '503/IUJK/001/2025',
                'telp' => '08123456789'
            ],
            [
                'id' => 2,
                'nama_pemohon' => 'Siti Aminah',
                'nama_usaha' => 'PT. Bangun Persada',
                'lokasi_izin' => 'Jl. Sudirman',
                'kelurahan' => 'Pelutan',
                'kecamatan' => 'Pemalang',
                'asosiasi' => 'AKLI',
                'kualifikasi' => 'Menengah',
                'kegiatan_usaha' => 'Instalasi Listrik',
                'klasifikasi_usaha' => 'Mekanikal',
                'tgl_penetapan' => '2025-10-20',
                'tgl_berlaku' => '2025-10-20 s/d 2028',
                'jenis_permohonan' => 'Daftar Ulang',
                'penanggung_jawab' => 'Siti, ST',
                'alamat_tenaga' => 'Jl. Mawar',
                'kualifikasi_tenaga' => 'Ahli Madya',
                'no_sk' => '503/IUJK/002/2025',
                'telp' => '08567890123'
            ],
            // Tambahkan data dummy lain jika perlu
        ];

        $filteredData = array_filter($rawData, function ($row) use ($jenisPermohonan, $dariTanggal, $sampaiTanggal) {
            if (!empty($jenisPermohonan) && $row['jenis_permohonan'] !== $jenisPermohonan) return false;
            if (!empty($dariTanggal) && !empty($sampaiTanggal)) {
                if ($row['tgl_penetapan'] < $dariTanggal || $row['tgl_penetapan'] > $sampaiTanggal) return false;
            }
            return true;
        });

        return new ArrayDataProvider([
            'allModels' => $filteredData,
            'pagination' => false, // Kalo cetak biasanya ditampilkan semua (tanpa paging)
            'sort' => false,
        ]);
    }
}
