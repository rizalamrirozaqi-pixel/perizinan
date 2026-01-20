<?php

namespace app\modules\pemohon\pengambilan\pengambilan_sk\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `pengambilan_sk` module
 */
class DefaultController extends Controller
{

    const DUMMY_DATA_PENDAFTARAN = [
        [
            'id' => 1,
            'nomor_daftar' => '030004',
            'nama_izin' => 'Izin Penyelenggaraan Reklame',
            'jenis_permohonan' => 'PENCABUTAN',
            'nama_pemohon' => 'Budi Santoso',
            'no_ktp_npwp' => '3310010020030004 / 0123456789012345',
            'alamat' => 'Jl. Jend. Sudirman No. 10, Kebondalem, Pemalang',
            'lokasi_usaha' => 'Jl. Jend. Sudirman No. 10, Kebondalem',
            'kecamatan' => 'Pemalang',
            'kelurahan' => 'Kebondalem',
            'keterangan' => 'Reklame 2x1m',
            'tanggal_daftar' => '2014-04-28',
            'telepon' => '08123456789'
        ],
        [
            'id' => 2,
            'nomor_daftar' => '040005',
            'nama_izin' => 'Izin A (Klinik)',
            'jenis_permohonan' => 'BARU',
            'nama_pemohon' => 'Dr. Siti Aminah',
            'no_ktp_npwp' => '3310010020040005 / 0123456789012346',
            'alamat' => 'Jl. A. Yani No. 12, Mulyoharjo, Pemalang',
            'lokasi_usaha' => 'Jl. Ahmad Yani No. 1 (Depan Alun-alun)',
            'kecamatan' => 'Pemalang',
            'kelurahan' => 'Mulyoharjo',
            'keterangan' => 'Klinik Umum',
            'tanggal_daftar' => '2014-04-27',
            'telepon' => '08987654321'
        ],
        [
            'id' => 3,
            'nomor_daftar' => '050006',
            'nama_izin' => 'Izin B (Apotek)',
            'jenis_permohonan' => 'PERPANJANGAN',
            'nama_pemohon' => 'Andi Wijaya',
            'nama_usaha' => 'Apotek Sumber Waras',
            'no_ktp_npwp' => '3327030030050006 / 0123456789012347',
            'alamat' => 'Jl. Surohadikusumo No. 55, Taman',
            'lokasi_usaha' => 'Jl. Surohadikusumo No. 55, Beji',
            'kecamatan' => 'Taman',
            'kelurahan' => 'Beji',
            'keterangan' => 'Perpanjangan tahunan',
            'tanggal_daftar' => '2014-04-26',
            'telepon' => '087712345678'
        ],
        [
            'id' => 4,
            'nomor_daftar' => '060007',
            'nama_izin' => 'Izin C (Lainnya)',
            'jenis_permohonan' => 'BARU',
            'nama_pemohon' => 'Rina Kusuma',
            'nama_usaha' => 'Warung Nasi Grombyang Pak Budi',
            'no_ktp_npwp' => '3327010040060007 / 0123456789012348',
            'alamat' => 'Jl. RE Martadinata No. 15, Pelutan, Pemalang',
            'lokasi_usaha' => 'Jl. RE Martadinata No. 15 (Sebelah Toko A)',
            'kecamatan' => 'Pemalang',
            'kelurahan' => 'Pelutan',
            'keterangan' => 'Warung makan baru',
            'tanggal_daftar' => '2014-04-25',
            'telepon' => '081223344556'
        ],
        [
            'id' => 5,
            'nomor_daftar' => '213704',
            'nama_izin' => 'Izin Mendirikan Bangunan (IMB)',
            'jenis_permohonan' => 'BARU',
            'nama_pemohon' => 'Slamet Riyadi',
            'nama_usaha' => 'Rumah Tinggal',
            'no_ktp_npwp' => '3310050050070008 / 0123456789012349',
            'alamat' => 'Jl. Tentara Pelajar No. 8, Petarukan',
            'lokasi_usaha' => 'Jl. Tentara Pelajar No. 8, Petarukan',
            'kecamatan' => 'Petarukan',
            'kelurahan' => 'Petarukan',
            'keterangan' => 'Rumah tinggal 2 lantai',
            'tanggal_daftar' => '2021-04-09',
            'telepon' => '081567890123'
        ],
        [
            'id' => 6,
            'nomor_daftar' => '120201',
            'nama_izin' => 'Surat Izin Praktik Dokter (SIP)',
            'jenis_permohonan' => 'BARU',
            'nama_pemohon' => 'DR. BUDIMAN',
            'nama_usaha' => 'Klinik Pribadi',
            'no_ktp_npwp' => '3327010101800001 / 0123456789012350',
            'alamat' => 'Jl. Melati No. 1, Pemalang',
            'lokasi_usaha' => 'Jl. Melati No. 1, Mulyoharjo',
            'kecamatan' => 'Pemalang',
            'kelurahan' => 'Mulyoharjo',
            'keterangan' => 'Praktik Umum',
            'tanggal_daftar' => '2024-01-24',
            'telepon' => '081987654321'
        ],
    ];

    const DUMMY_DATA_SK = [
        1 => ['nomor_sk' => '503.1/007/DPMPTSP', 'tanggal_sk' => '2025-10-28', 'tanggal_habis_berlaku' => '2025-12-28'],
        2 => ['nomor_sk' => '503.2/008/DPMPTSP', 'tanggal_sk' => '2025-10-28', 'tanggal_habis_berlaku' => '2025-12-28'],
        3 => ['nomor_sk' => '503.3/009/DPMPTSP', 'tanggal_sk' => '2025-10-28', 'tanggal_habis_berlaku' => '2025-12-28'],
        4 => ['nomor_sk' => '503.4/010/DPMPTSP', 'tanggal_sk' => '2025-10-28', 'tanggal_habis_berlaku' => '2025-12-28'],
        5 => ['nomor_sk' => '503.84/10007/DPMPTSP', 'tanggal_sk' => '2025-10-28', 'tanggal_habis_berlaku' => '2025-12-28'],
        6 => ['nomor_sk' => '1202/01/2024', 'tanggal_sk' => '2024-02-01', 'tanggal_habis_berlaku' => '2029-02-01'],
    ];

    const DUMMY_DATA_KEY_PENGAMBILAN = 'pengambilan_sk_dummy_data_v2';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'simpan-penyerahan' => ['POST'],
                    'bukti-penerimaan' => ['GET'],
                    'pencabutan' => ['GET'],
                    'simpan-pencabutan' => ['POST'],
                    'log' => ['GET'],
                    'tanda-terima' => ['GET'],
                    'search-pendaftaran' => ['GET'], // <-- (FIX) Tambahan action
                    'search-laporan' => ['GET'],     // <-- (FIX) Tambahan action
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
     * Halaman Index (Form + Grid)
     */
    public function actionIndex($search_pendaftaran = null, $filter_data = null)
    {
        $modelPendaftaran = null;
        $modelPengambilan = null;
        $isSearch = !empty($search_pendaftaran);

        // --- Logika Form Atas (Pencarian Pendaftaran) ---
        if ($isSearch) {
            $modelPendaftaran = $this->findPendaftaranModelBySearch($search_pendaftaran);
            if ($modelPendaftaran !== null) {
                $modelPengambilan = $this->findPengambilanModelByPendaftaranId($modelPendaftaran['id']);
            } else {
                Yii::$app->session->setFlash('warning', 'Data pendaftaran tidak ditemukan.');
            }
        }

        // --- Logika Grid Laporan (Form Bawah) ---
        $allPengambilanData = $this->getDummyDataWithRelations();
        $filteredData = $allPengambilanData;

        if (!empty($filter_data)) {
            $term = strtolower($filter_data);
            $filteredData = array_filter($filteredData, function ($item) use ($term) {
                // (FIX) Bug fix: 'nomor_pendaftaran' diubah menjadi 'nomor_daftar'
                return stripos($item['nama_pemohon'] ?? '', $term) !== false ||
                    stripos($item['nomor_daftar'] ?? '', $term) !== false;
            });
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'key' => 'pengambilan_id',
            'pagination' => ['pageSize' => 5],
            'sort' => [
                'attributes' => ['nomor_daftar', 'nama_pemohon', 'nama_usaha', 'tanggal_diserahkan'],
                'defaultOrder' => ['tanggal_diserahkan' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'search_pendaftaran' => $search_pendaftaran,
            'filter_data' => $filter_data,
            'modelPendaftaran' => $modelPendaftaran,
            'modelPengambilan' => $modelPengambilan,
            'isSearch' => $isSearch,
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
        ]);
    }

    /**
     * (FIX BARU) Action for autocomplete search (Form Atas)
     */
    public function actionSearchPendaftaran($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $results = [];

        if (!empty($term)) {
            $term = strtolower($term);
            $allPendaftaran = self::DUMMY_DATA_PENDAFTARAN;

            foreach ($allPendaftaran as $item) {
                $nomorDaftar = $item['nomor_daftar'] ?? '';
                $namaPemohon = $item['nama_pemohon'] ?? '';
                $namaUsaha = $item['nama_usaha'] ?? '';

                if (stripos($nomorDaftar, $term) !== false || stripos($namaPemohon, $term) !== false || stripos($namaUsaha, $term) !== false) {
                    $label = "{$nomorDaftar} - {$namaPemohon}" . (!empty($namaUsaha) ? " ({$namaUsaha})" : "");
                    $value = $nomorDaftar; // We submit the 'nomor_daftar'

                    $results[] = [
                        'label' => $label,
                        'value' => $value,
                    ];
                }
            }
        }
        return $results;
    }

    /**
     * (FIX BARU) Action for autocomplete search (Grid Bawah)
     */
    public function actionSearchLaporan($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $results = [];

        if (!empty($term)) {
            $term = strtolower($term);
            $allPengambilanData = $this->getDummyDataWithRelations(); // Use the same data source as the grid

            foreach ($allPengambilanData as $item) {
                // Filter logic from actionIndex
                $nomorDaftar = $item['nomor_daftar'] ?? '';
                $namaPemohon = $item['nama_pemohon'] ?? '';

                if (stripos($namaPemohon, $term) !== false || stripos($nomorDaftar, $term) !== false) {
                    $label = "{$nomorDaftar} - {$namaPemohon} (Diambil: " . Yii::$app->formatter->asDate($item['tanggal_diserahkan'], 'php:d M Y') . ")";
                    $value = $nomorDaftar; // Submit the 'nomor_daftar'

                    $results[] = [
                        'label' => $label,
                        'value' => $value,
                    ];
                }
            }
            // Make results unique
            $results = array_map("unserialize", array_unique(array_map("serialize", $results)));
        }
        return array_values($results);
    }

    /**
     * Simpan data dari "Menu Penyerahan SK"
     */
    public function actionSimpanPenyerahan($pendaftaran_id)
    {
        $modelPendaftaran = $this->findPendaftaranModelById($pendaftaran_id);
        if ($modelPendaftaran === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();

            $saveData = [
                'pendaftaran_id' => $pendaftaran_id,
                'nama_pengambil' => $postData['nama_pengambil'] ?? null,
                'tanggal_diambil' => $postData['tanggal_diambil'] ?? null,
                'yang_menyerahkan' => $postData['yang_menyerahkan'] ?? null,
            ];

            $this->savePengambilanData($saveData);
            Yii::$app->session->setFlash('success', 'Data penyerahan SK berhasil disimpan.');
        }

        return $this->redirect(['index', 'search_pendaftaran' => $modelPendaftaran['nomor_daftar']]);
    }

    /**
     * Tampilkan halaman form Pencabutan
     */
    public function actionPencabutan($id) // $id di sini adalah $pengambilan_id
    {
        $modelPengambilan = $this->findPengambilanModelById($id);
        if ($modelPengambilan === null) {
            throw new NotFoundHttpException('Data pengambilan tidak ditemukan.');
        }

        $modelPendaftaran = $this->findPendaftaranModelById($modelPengambilan['pendaftaran_id']);
        if ($modelPendaftaran === null) {
            throw new NotFoundHttpException('Data pendaftaran terkait tidak ditemukan.');
        }

        return $this->render('pencabutan', [
            'modelPendaftaran' => $modelPendaftaran,
            'modelPengambilan' => $modelPengambilan,
        ]);
    }

    /**
     * Simpan data Pencabutan
     */
    public function actionSimpanPencabutan($id) // $id di sini adalah $pengambilan_id
    {
        $modelPengambilan = $this->findPengambilanModelById($id);
        if ($modelPengambilan === null) {
            throw new NotFoundHttpException('Data pengambilan tidak ditemukan.');
        }

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            // ... (Logika Simpan Pencabutan) ...
            Yii::$app->session->setFlash('success', 'Izin berhasil dicabut (simulasi).');
        }

        return $this->redirect(['index']); // Kembali ke grid
    }

    /**
     * Tampilkan Bukti Penerimaan (Download)
     */
    public function actionBuktiPenerimaan($id) // $id di sini adalah $pengambilan_id
    {
        $modelPengambilan = $this->findPengambilanModelById($id);
        if ($modelPengambilan === null) {
            throw new NotFoundHttpException('Data pengambilan tidak ditemukan.');
        }

        $modelPendaftaran = $this->findPendaftaranModelById($modelPengambilan['pendaftaran_id']);
        if ($modelPendaftaran === null) {
            throw new NotFoundHttpException('Data pendaftaran terkait tidak ditemukan.');
        }

        $modelSk = $this->findSkModelByPendaftaranId($modelPendaftaran['id']);

        $this->layout = false;
        return $this->renderPartial('_bukti_penerimaan', [
            'model' => $modelPendaftaran,
            'modelSk' => $modelSk,
            'modelPengambilan' => $modelPengambilan,
        ]);
    }

    /**
     * (BARU) Menampilkan Lembar Kendali (dari link LOG)
     */
    public function actionLog($pendaftaran_id)
    {
        $model = $this->findPendaftaranModelById($pendaftaran_id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        $logData = $this->getLogDummyData(); // Ambil data log
        $this->layout = false;

        return $this->renderPartial('_lembar_kendali', [
            'model' => $model,
            'logData' => $logData,
        ]);
    }

    /**
     * (BARU) Menampilkan Tanda Terima (dari link Nomor Pendaftaran)
     */
    public function actionTandaTerima($pendaftaran_id)
    {
        $model = $this->findPendaftaranModelById($pendaftaran_id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }
        $this->layout = false;
        return $this->renderPartial('_tanda_terima', [
            'model' => $model,
        ]);
    }


    // --- Helper Functions (LENGKAP) ---

    protected function findPendaftaranModelBySearch($search)
    {
        $allPendaftaran = self::DUMMY_DATA_PENDAFTARAN;
        foreach ($allPendaftaran as $item) {
            $nomorDaftar = $item['nomor_daftar'] ?? '';
            $namaPemohon = $item['nama_pemohon'] ?? '';
            $namaUsaha = $item['nama_usaha'] ?? '';
            if (stripos($nomorDaftar, $search) !== false || stripos($namaPemohon, $search) !== false || stripos($namaUsaha, $search) !== false) {
                return $item;
            }
        }
        return null;
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

    // Helper data SK (ambil dari const)
    protected function findSkModelByPendaftaranId($pendaftaranId)
    {
        return self::DUMMY_DATA_SK[$pendaftaranId] ?? null;
    }

    protected function initDummyData()
    {
        $session = Yii::$app->session;
        if (empty($session->get(self::DUMMY_DATA_KEY_PENGAMBILAN))) {
            // Kunci array adalah ID Pengambilan (unik)
            $session->set(self::DUMMY_DATA_KEY_PENGAMBILAN, [
                1 => ['pengambilan_id' => 1, 'pendaftaran_id' => 6, 'nama_pengambil' => 'DR. BUDIMAN', 'tanggal_diambil' => '2024-02-05', 'yang_menyerahkan' => 'Dian'],
                2 => ['pengambilan_id' => 2, 'pendaftaran_id' => 5, 'nama_pengambil' => 'GATOT NURGIYONO, A.S', 'tanggal_diambil' => '2025-10-28', 'yang_menyerahkan' => 'Dian'],
                3 => ['pengambilan_id' => 3, 'pendaftaran_id' => 1, 'nama_pengambil' => 'Budi Santoso', 'tanggal_diambil' => '2025-10-29', 'yang_menyerahkan' => 'Petugas A'],
                4 => ['pengambilan_id' => 4, 'pendaftaran_id' => 3, 'nama_pengambil' => 'Andi Wijaya', 'tanggal_diambil' => '2025-10-29', 'yang_menyerahkan' => 'Petugas B'],
                // Data tambahan
                5 => ['pengambilan_id' => 5, 'pendaftaran_id' => 2, 'nama_pengambil' => 'Staf Klinik', 'tanggal_diambil' => '2025-10-30', 'yang_menyerahkan' => 'Petugas A'],
                6 => ['pengambilan_id' => 6, 'pendaftaran_id' => 4, 'nama_pengambil' => 'Rina Kusuma', 'tanggal_diambil' => '2025-10-31', 'yang_menyerahkan' => 'Petugas C'],
            ]);
        }
    }
    protected function getDummyData()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY_PENGAMBILAN, []);
    }
    protected function saveDummyData(array $data)
    {
        Yii::$app->session->set(self::DUMMY_DATA_KEY_PENGAMBILAN, $data);
    }

    protected function findPengambilanModelById($id)
    {
        $allData = $this->getDummyData();
        return $allData[$id] ?? null;
    }

    protected function findPengambilanModelByPendaftaranId($pendaftaranId)
    {
        $allData = $this->getDummyData();
        foreach ($allData as $item) {
            if (isset($item['pendaftaran_id']) && $item['pendaftaran_id'] == $pendaftaranId) {
                return $item;
            }
        }
        return null;
    }

    protected function savePengambilanData(array $data)
    {
        if (empty($data['pendaftaran_id'])) return;
        $allData = $this->getDummyData();
        $existingModel = $this->findPengambilanModelByPendaftaranId($data['pendaftaran_id']);
        if ($existingModel) {
            $id = $existingModel['pengambilan_id'];
            $data['pengambilan_id'] = $id;
            $allData[$id] = $data;
        } else {
            $newId = empty($allData) ? 1 : max(array_keys($allData)) + 1;
            $data['pengambilan_id'] = $newId;
            $allData[$newId] = $data;
        }
        $this->saveDummyData($allData);
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

            $skInfo = $this->findSkModelByPendaftaranId($pendaftaranId); // Ambil SK

            $combinedData[] = array_merge($pendaftaranInfo, $skInfo, $pengambilan, [
                'tanggal_diserahkan' => $pengambilan['tanggal_diambil'] ?? null,
                'diterima_oleh' => $pengambilan['nama_pengambil'] ?? null,
            ]);
        }
        return $combinedData;
    }

    // (BARU) Helper untuk data Log
    protected function getLogDummyData()
    {
        return [
            ['pos' => 1, 'tanggal_mulai_entry' => '2021-04-09', 'tanggal_mulai_system' => '2021-04-09 10:30:44', 'dari' => 'Pemohon', 'nama_pengguna' => 'STI', 'proses' => 'Memeriksa Berkas Permohonan', 'tanggal_selesai_entry' => '2021-04-09', 'tanggal_selesai_system' => '2021-04-09 10:30:44', 'kirim_ke' => 'Front Office', 'berkas_tolak_kirim_entry' => '2021-04-09', 'berkas_tolak_kirim_system' => '2021-04-09 10:30:44', 'catatan' => 'SUDH DINPUTING', 'status' => '2021-04-09 10:30:44', 'tanggal_terima_tolak' => '2021-04-09', 'penilaian_kepatuhan' => null, 'lambat_hari' => 0, 'lambat_jam' => 0, 'lambat_menit' => 0,],
            ['pos' => 2, 'tanggal_mulai_entry' => '2021-04-09', 'tanggal_mulai_system' => '2021-04-09 10:37:59', 'dari' => 'Front Office', 'nama_pengguna' => 'FO1', 'proses' => 'Menerima, Memeriksa Kelengkapan Berkas Dan Input Data Primer Permohonan Izin', 'tanggal_selesai_entry' => '2021-04-09', 'tanggal_selesai_system' => '2021-04-09 10:37:59', 'kirim_ke' => 'Back Office', 'berkas_tolak_kirim_entry' => '2021-04-14', 'berkas_tolak_kirim_system' => '2021-04-14 08:35:46', 'catatan' => 'SUDH DINPUTING', 'status' => '2021-04-14 14:40:03', 'tanggal_terima_tolak' => '2021-04-14', 'penilaian_kepatuhan' => null, 'lambat_hari' => 0, 'lambat_jam' => 0, 'lambat_menit' => 0,],
        ];
    }
}
