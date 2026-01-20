<?php

namespace app\modules\executive_summary\laporan\laporan_cetak_skrd\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider; // Kita pakai ini buat data array manual

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;

        // 1. Ambil Parameter Filter
        $jenisIzin        = $request->get('jenis_izin');
        $jenisPermohonan  = $request->get('jenis_permohonan');
        $statusPendaftaran = $request->get('status_pendaftaran', 'OFFLINE');
        $dariTanggal      = $request->get('dari_tanggal');
        $sampaiTanggal    = $request->get('sampai_tanggal');

        // 2. DATA DUMMY (Hardcoded di sini)
        // Anggap ini data yang biasanya diambil dari database
        $rawData = [
            [
                'id' => 1,
                'nama_pemohon' => 'Budi Santoso',
                'nama_usaha' => 'Toko Kelontong Berkah',
                'lokasi_izin' => 'Jl. Ahmad Yani No. 12, Pemalang',
                'jenis_izin' => 'SIUP',
                'jenis_permohonan' => 'Baru',
                'status_daftar' => 'OFFLINE',
                'nomor_skrd' => 'SKRD/2025/001',
                'tanggal_skrd' => '2025-11-25',
                'nilai_retribusi' => 150000,
                'denda' => 0,
                'kenaikan' => 0,
                'total_retribusi' => 150000
            ],
            [
                'id' => 2,
                'nama_pemohon' => 'PT. Sinar Jaya Abadi',
                'nama_usaha' => 'Pabrik Tekstil Sinar',
                'lokasi_izin' => 'Kawasan Industri Blok C',
                'jenis_izin' => 'IMB',
                'jenis_permohonan' => 'Baru',
                'status_daftar' => 'ONLINE',
                'nomor_skrd' => 'SKRD/2025/002',
                'tanggal_skrd' => '2025-11-20',
                'nilai_retribusi' => 2500000,
                'denda' => 0,
                'kenaikan' => 0,
                'total_retribusi' => 2500000
            ],
            [
                'id' => 3,
                'nama_pemohon' => 'Siti Aminah',
                'nama_usaha' => 'Warung Makan Sederhana',
                'lokasi_izin' => 'Jl. Sudirman No. 45',
                'jenis_izin' => 'HO',
                'jenis_permohonan' => 'Perpanjangan',
                'status_daftar' => 'OFFLINE',
                'nomor_skrd' => 'SKRD/2025/003',
                'tanggal_skrd' => '2025-10-15',
                'nilai_retribusi' => 500000,
                'denda' => 50000,
                'kenaikan' => 0,
                'total_retribusi' => 550000
            ],
            [
                'id' => 4,
                'nama_pemohon' => 'CV. Konstruksi Maju',
                'nama_usaha' => 'Kantor Cabang',
                'lokasi_izin' => 'Jl. Pemuda No. 88',
                'jenis_izin' => 'IMB',
                'jenis_permohonan' => 'Renovasi',
                'status_daftar' => 'ONLINE',
                'nomor_skrd' => '', // Belum terbit SKRD
                'tanggal_skrd' => null,
                'nilai_retribusi' => 0,
                'denda' => 0,
                'kenaikan' => 0,
                'total_retribusi' => 0
            ],
            [
                'id' => 5,
                'nama_pemohon' => 'Ahmad Rizky',
                'nama_usaha' => 'Bengkel Motor Rizky',
                'lokasi_izin' => 'Jl. Kartini No. 5',
                'jenis_izin' => 'SIUP',
                'jenis_permohonan' => 'Daftar Ulang',
                'status_daftar' => 'OFFLINE',
                'nomor_skrd' => 'SKRD/2025/005',
                'tanggal_skrd' => '2025-11-28',
                'nilai_retribusi' => 200000,
                'denda' => 0,
                'kenaikan' => 0,
                'total_retribusi' => 200000
            ],
        ];

        // 3. Filter Data Array (Manual Filter biar form search tetap jalan)
        $filteredData = array_filter($rawData, function ($row) use ($jenisIzin, $jenisPermohonan, $statusPendaftaran, $dariTanggal, $sampaiTanggal) {

            // Filter Jenis Izin
            if (!empty($jenisIzin) && $row['jenis_izin'] !== $jenisIzin) {
                return false;
            }

            // Filter Jenis Permohonan
            if (!empty($jenisPermohonan) && $row['jenis_permohonan'] !== $jenisPermohonan) {
                return false;
            }

            // Filter Status Pendaftaran
            if (!empty($statusPendaftaran) && $row['status_daftar'] !== $statusPendaftaran) {
                return false;
            }

            // Filter Tanggal
            if (!empty($dariTanggal) && !empty($sampaiTanggal) && !empty($row['tanggal_skrd'])) {
                if ($row['tanggal_skrd'] < $dariTanggal || $row['tanggal_skrd'] > $sampaiTanggal) {
                    return false;
                }
            }

            return true;
        });

        // 4. Masukkan ke ArrayDataProvider
        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData, // Data hasil filter
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['nama_pemohon', 'tanggal_skrd', 'total_retribusi'],
            ],
        ]);

        // 5. Data Dropdown
        $listJenisIzin = [
            '' => '-- Pilih Jenis Izin --',
            'IMB' => 'Izin Mendirikan Bangunan (IMB)',
            'HO' => 'Izin Gangguan / HO',
            'SIUP' => 'Surat Izin Usaha Perdagangan',
        ];

        $listJenisPermohonan = [
            '' => '-- Pilih Jenis Permohonan --',
            'Baru' => 'Baru',
            'Perpanjangan' => 'Perpanjangan',
            'Renovasi' => 'Renovasi',
            'Daftar Ulang' => 'Daftar Ulang',
        ];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'listJenisIzin' => $listJenisIzin,
            'listJenisPermohonan' => $listJenisPermohonan,
            'params' => [
                'jenis_izin' => $jenisIzin,
                'jenis_permohonan' => $jenisPermohonan,
                'dari_tanggal' => $dariTanggal,
                'sampai_tanggal' => $sampaiTanggal,
                'status_pendaftaran' => $statusPendaftaran
            ]
        ]);
    }
}
