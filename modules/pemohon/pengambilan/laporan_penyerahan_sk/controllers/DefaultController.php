<?php

namespace app\modules\pemohon\pengambilan\laporan_penyerahan_sk\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `laporan_penyerahan_sk` module
 */
class DefaultController extends Controller
{

    // --- KUMPULAN DATA DUMMY DARI MODUL LAIN ---
    const DUMMY_DATA_PENDAFTARAN = [
        ['id' => 1, 'nomor_daftar' => '030004', 'nama_izin' => 'Izin Penyelenggaraan Reklame', 'jenis_permohonan' => 'PENCABUTAN', 'nama_pemohon' => 'Budi Santoso', 'no_ktp_npwp' => '3310010020030004 / 0123456789012345', 'alamat' => 'Jl. Jend. Sudirman No. 10, Kebondalem, Pemalang', 'lokasi_usaha' => 'Jl. Jend. Sudirman No. 10, Kebondalem', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kebondalem', 'keterangan' => 'Reklame 2x1m', 'tanggal_daftar' => '2014-04-28', 'telepon' => '08123456789', 'status_pendaftaran' => 'OFFLINE'],
        ['id' => 2, 'nomor_daftar' => '040005', 'nama_izin' => 'Izin A (Klinik)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Dr. Siti Aminah', 'no_ktp_npwp' => '3310010020040005 / 0123456789012346', 'alamat' => 'Jl. A. Yani No. 12, Mulyoharjo, Pemalang', 'lokasi_usaha' => 'Jl. Ahmad Yani No. 1 (Depan Alun-alun)', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Mulyoharjo', 'keterangan' => 'Klinik Umum', 'tanggal_daftar' => '2014-04-27', 'telepon' => '08987654321', 'status_pendaftaran' => 'ONLINE'],
        ['id' => 3, 'nomor_daftar' => '050006', 'nama_izin' => 'Izin B (Apotek)', 'jenis_permohonan' => 'PERPANJANGAN', 'nama_pemohon' => 'Andi Wijaya', 'nama_usaha' => 'Apotek Sumber Waras', 'no_ktp_npwp' => '3327030030050006 / 0123456789012347', 'alamat' => 'Jl. Surohadikusumo No. 55, Taman', 'lokasi_usaha' => 'Jl. Surohadikusumo No. 55, Beji', 'kecamatan' => 'Taman', 'kelurahan' => 'Beji', 'keterangan' => 'Perpanjangan tahunan', 'tanggal_daftar' => '2014-04-26', 'telepon' => '087712345678', 'status_pendaftaran' => 'OFFLINE'],
        ['id' => 4, 'nomor_daftar' => '060007', 'nama_izin' => 'Izin C (Lainnya)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Rina Kusuma', 'nama_usaha' => 'Warung Nasi Grombyang Pak Budi', 'no_ktp_npwp' => '3327010040060007 / 0123456789012348', 'alamat' => 'Jl. RE Martadinata No. 15, Pelutan, Pemalang', 'lokasi_usaha' => 'Jl. RE Martadinata No. 15 (Sebelah Toko A)', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Pelutan', 'keterangan' => 'Warung makan baru', 'tanggal_daftar' => '2014-04-25', 'telepon' => '081223344556', 'status_pendaftaran' => 'ONLINE'],
        ['id' => 5, 'nomor_daftar' => '213704', 'nama_izin' => 'Izin Mendirikan Bangunan (IMB)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Slamet Riyadi', 'nama_usaha' => 'Rumah Tinggal', 'no_ktp_npwp' => '3310050050070008 / 0123456789012349', 'alamat' => 'Jl. Tentara Pelajar No. 8, Petarukan', 'lokasi_usaha' => 'Jl. Tentara Pelajar No. 8, Petarukan', 'kecamatan' => 'Petarukan', 'kelurahan' => 'Petarukan', 'keterangan' => 'Rumah tinggal 2 lantai', 'tanggal_daftar' => '2021-04-09', 'telepon' => '081567890123', 'status_pendaftaran' => 'OFFLINE'],
        ['id' => 6, 'nomor_daftar' => '120201', 'nama_izin' => 'Surat Izin Praktik Dokter (SIP)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'DR. BUDIMAN', 'nama_usaha' => 'Klinik Pribadi', 'no_ktp_npwp' => '3327010101800001 / 0123456789012350', 'alamat' => 'Jl. Melati No. 1, Pemalang', 'lokasi_usaha' => 'Jl. Melati No. 1, Mulyoharjo', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Mulyoharjo', 'keterangan' => 'Praktik Umum', 'tanggal_daftar' => '2024-01-24', 'telepon' => '081987654321', 'status_pendaftaran' => 'ONLINE'],
    ];

    // Kunci array adalah ID Pendaftaran
    const DUMMY_DATA_SK = [
        1 => ['nomor_sk' => '503.1/007/DPMPTSP', 'tanggal_sk' => '2025-10-28', 'tanggal_habis_berlaku' => '2025-12-28', 'retribusi' => 500000],
        2 => ['nomor_sk' => '503.2/008/DPMPTSP', 'tanggal_sk' => '2025-10-28', 'tanggal_habis_berlaku' => '2025-12-28', 'retribusi' => 1500000],
        3 => ['nomor_sk' => '503.3/009/DPMPTSP', 'tanggal_sk' => '2025-10-28', 'tanggal_habis_berlaku' => '2025-12-28', 'retribusi' => 750000],
        4 => ['nomor_sk' => '503.4/010/DPMPTSP', 'tanggal_sk' => '2025-10-28', 'tanggal_habis_berlaku' => '2025-12-28', 'retribusi' => 1200000],
        5 => ['nomor_sk' => '503.84/10007/DPMPTSP', 'tanggal_sk' => '2025-10-28', 'tanggal_habis_berlaku' => '2025-12-28', 'retribusi' => 2500000],
        6 => ['nomor_sk' => '1202/01/2024', 'tanggal_sk' => '2024-02-01', 'tanggal_habis_berlaku' => '2029-02-01', 'retribusi' => 0],
    ];

    // Session key
    const DUMMY_DATA_KEY_PENGAMBILAN = 'pengambilan_sk_dummy_data_v1';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'], // Form dan hasil
                    'cetak' => ['GET'], // Action cetak HTML terpisah
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $this->initDummyData();
        return true;
    }

    /**
     * Halaman Index (Form Filter + Grid Laporan)
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $tahun = $request->get('tahun', date('Y'));
        $tanggal_cetak = $request->get('tanggal_cetak', date('Y-m-d'));
        $submit_btn = $request->get('submit_btn');

        $isSearch = !empty($submit_btn); // Anggap pencarian aktif jika tombol disubmit
        $laporanData = [];

        if ($isSearch) {
            $allData = $this->getDummyDataWithRelations();
            $filteredData = $allData;

            // 1. Filter by Tahun (berdasarkan tanggal_diserahkan)
            if (!empty($tahun)) {
                $filteredData = array_filter($filteredData, function ($item) use ($tahun) {
                    $tahun_diserahkan = !empty($item['tanggal_diserahkan']) ? date('Y', strtotime($item['tanggal_diserahkan'])) : null;
                    return $tahun_diserahkan === $tahun;
                });
            }

            // Logika Excel (jika submit_btn = 'excel')
            if ($submit_btn === 'excel') {
                $this->layout = false;
                $content = $this->renderPartial('_laporan_excel', [
                    'models' => $filteredData,
                    'tahun' => $tahun,
                    'tanggal_cetak' => $tanggal_cetak,
                ]);

                $filename = "Laporan_Penyerahan_SK_" . $tahun . ".xls";
                Yii::$app->response->headers->set('Content-Type', 'application/vnd.ms-excel');
                Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                Yii::$app->response->format = Response::FORMAT_RAW;
                return $content;
            }

            // Jika 'cari' (Tampilkan) atau 'word' (simulasi)
            $laporanData = $filteredData;
        }

        // DataProvider untuk grid di view 'index'
        $dataProvider = new ArrayDataProvider([
            'allModels' => $laporanData,
            'key' => 'pengambilan_id',
            'pagination' => ['pageSize' => 10],
            'sort' => [
                'attributes' => ['nomor_pendaftaran', 'nama_pemohon', 'nama_usaha', 'tanggal_diserahkan'],
                'defaultOrder' => ['tanggal_diserahkan' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'isSearch' => $isSearch,
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(), // Untuk tabel manual
            'pagination' => $dataProvider->getPagination(), // Untuk LinkPager
            'tahun' => $tahun,
            'tanggal_cetak' => $tanggal_cetak,
            'tahunItems' => $this->getTahunItems(), // Dropdown tahun
        ]);
    }

    /**
     * Action untuk Cetak HTML (Versi Cetak)
     */
    public function actionCetak($tahun, $tanggal_cetak)
    {
        $allData = $this->getDummyDataWithRelations();
        $filteredData = $allData;

        // Filter by Tahun
        if (!empty($tahun)) {
            $filteredData = array_filter($filteredData, function ($item) use ($tahun) {
                $tahun_diserahkan = !empty($item['tanggal_diserahkan']) ? date('Y', strtotime($item['tanggal_diserahkan'])) : null;
                return $tahun_diserahkan === $tahun;
            });
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'pagination' => false,
        ]);

        $this->layout = false;
        return $this->renderPartial('_laporan_html', [
            'models' => $dataProvider->getModels(),
            'tahun' => $tahun,
            'tanggal_cetak' => $tanggal_cetak,
        ]);
    }


    // --- Helper Functions ---

    protected function getTahunItems()
    {
        $tahunSekarang = date('Y');
        $tahunLalu = $tahunSekarang - 5;
        return ArrayHelper::map(range($tahunSekarang, $tahunLalu), function ($v) {
            return $v;
        }, function ($v) {
            return $v;
        });
    }

    protected function findPendaftaranModelById($id)
    {
        $allPendaftaran = self::DUMMY_DATA_PENDAFTARAN;
        foreach ($allPendaftaran as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }
    protected function findSkModelByPendaftaranId($pendaftaranId)
    {
        return self::DUMMY_DATA_SK[$pendaftaranId] ?? null;
    }
    protected function initDummyData()
    {
        $session = Yii::$app->session;
        if (empty($session->get(self::DUMMY_DATA_KEY_PENGAMBILAN))) {
            $session->set(self::DUMMY_DATA_KEY_PENGAMBILAN, [
                1 => ['pengambilan_id' => 1, 'pendaftaran_id' => 6, 'nama_pengambil' => 'DR. BUDIMAN', 'tanggal_diambil' => '2024-02-05', 'yang_menyerahkan' => 'Dian'],
                2 => ['pengambilan_id' => 2, 'pendaftaran_id' => 5, 'nama_pengambil' => 'GATOT NURGIYONO, A.S', 'tanggal_diambil' => '2024-10-28', 'yang_menyerahkan' => 'Dian'], // Ganti tahun ke 2024
                3 => ['pengambilan_id' => 3, 'pendaftaran_id' => 1, 'nama_pengambil' => 'Budi Santoso', 'tanggal_diambil' => '2024-10-29', 'yang_menyerahkan' => 'Petugas A'], // Ganti tahun ke 2024
                4 => ['pengambilan_id' => 4, 'pendaftaran_id' => 3, 'nama_pengambil' => 'Andi Wijaya', 'tanggal_diambil' => '2024-10-29', 'yang_menyerahkan' => 'Petugas B'], // Ganti tahun ke 2024
                5 => ['pengambilan_id' => 5, 'pendaftaran_id' => 2, 'nama_pengambil' => 'Staf Klinik', 'tanggal_diambil' => '2025-10-30', 'yang_menyerahkan' => 'Petugas A'], // Tahun 2025
                6 => ['pengambilan_id' => 6, 'pendaftaran_id' => 4, 'nama_pengambil' => 'Rina Kusuma', 'tanggal_diambil' => '2025-10-31', 'yang_menyerahkan' => 'Petugas C'], // Tahun 2025
            ]);
        }
    }
    protected function getDummyData()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY_PENGAMBILAN, []);
    }

    protected function getDummyDataWithRelations()
    {
        $pengambilanData = $this->getDummyData();
        $pendaftaranData = self::DUMMY_DATA_PENDAFTARAN;
        $skData = self::DUMMY_DATA_SK;
        $pendaftaranMap = ArrayHelper::index($pendaftaranData, 'id');
        $combinedData = [];
        foreach ($pengambilanData as $pengambilan) {
            $pendaftaranId = $pengambilan['pendaftaran_id'] ?? null;
            $pendaftaranInfo = $pendaftaranMap[$pendaftaranId] ?? [];
            $skInfo = $this->findSkModelByPendaftaranId($pendaftaranId);
            $combinedData[] = array_merge($pendaftaranInfo, $skInfo, $pengambilan, [
                'tanggal_diserahkan' => $pengambilan['tanggal_diambil'] ?? null,
                'diterima_oleh' => $pengambilan['nama_pengambil'] ?? null,
            ]);
        }
        return $combinedData;
    }
}
