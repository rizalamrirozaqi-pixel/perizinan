<?php

namespace app\modules\admin\back_office\penomoran_sk\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `penomoran_sk` module
 */
class DefaultController extends Controller
{

    // Data Pendaftaran Dummy Lokal (LOKASI PEMALANG)
    const DUMMY_DATA_PENDAFTARAN = [
        ['id' => 1, 'nomor_daftar' => '030004', 'nama_izin' => 'Izin Penyelenggaraan Reklame', 'jenis_permohonan' => 'PENCABUTAN', 'nama_pemohon' => 'Budi Santoso', 'no_ktp_npwp' => '3310010020030004 / 0123456789012345', 'alamat' => 'Jl. Jend. Sudirman No. 10, Kebondalem, Pemalang', 'lokasi_usaha' => 'Jl. Jend. Sudirman No. 10, Kebondalem', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kebondalem', 'keterangan' => 'Reklame 2x1m', 'tanggal_daftar' => '2014-04-28', 'telepon' => '08123456789'],
        ['id' => 2, 'nomor_daftar' => '040005', 'nama_izin' => 'Izin A (Klinik)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Dr. Siti Aminah', 'no_ktp_npwp' => '3310010020040005 / 0123456789012346', 'alamat' => 'Jl. A. Yani No. 12, Mulyoharjo, Pemalang', 'lokasi_usaha' => 'Jl. Ahmad Yani No. 1 (Depan Alun-alun)', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Mulyoharjo', 'keterangan' => 'Klinik Umum', 'tanggal_daftar' => '2014-04-27', 'telepon' => '08987654321'],
        ['id' => 3, 'nomor_daftar' => '050006', 'nama_izin' => 'Izin B (Apotek)', 'jenis_permohonan' => 'PERPANJANGAN', 'nama_pemohon' => 'Andi Wijaya', 'nama_usaha' => 'Apotek Sumber Waras', 'no_ktp_npwp' => '3327030030050006 / 0123456789012347', 'alamat' => 'Jl. Surohadikusumo No. 55, Taman', 'lokasi_usaha' => 'Jl. Surohadikusumo No. 55, Beji', 'kecamatan' => 'Taman', 'kelurahan' => 'Beji', 'keterangan' => 'Perpanjangan tahunan', 'tanggal_daftar' => '2014-04-26', 'telepon' => '087712345678'],
        ['id' => 4, 'nomor_daftar' => '060007', 'nama_izin' => 'Izin C (Lainnya)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Rina Kusuma', 'nama_usaha' => 'Warung Nasi Grombyang Pak Budi', 'no_ktp_npwp' => '3327010040060007 / 0123456789012348', 'alamat' => 'Jl. RE Martadinata No. 15, Pelutan, Pemalang', 'lokasi_usaha' => 'Jl. RE Martadinata No. 15 (Sebelah Toko A)', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Pelutan', 'keterangan' => 'Warung makan baru', 'tanggal_daftar' => '2014-04-25', 'telepon' => '081223344556'],
        ['id' => 5, 'nomor_daftar' => '070008', 'nama_izin' => 'Izin Mendirikan Bangunan (IMB)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Slamet Riyadi', 'nama_usaha' => 'Rumah Tinggal', 'no_ktp_npwp' => '3310050050070008 / 0123456789012349', 'alamat' => 'Jl. Tentara Pelajar No. 8, Petarukan', 'lokasi_usaha' => 'Jl. Tentara Pelajar No. 8, Petarukan', 'kecamatan' => 'Petarukan', 'kelurahan' => 'Petarukan', 'keterangan' => 'Rumah tinggal 2 lantai', 'tanggal_daftar' => '2021-04-09', 'telepon' => '081567890123'],
        ['id' => 6, 'nomor_daftar' => '080009', 'nama_izin' => 'Surat Izin Praktik Dokter (SIP)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'DR. BUDIMAN', 'nama_usaha' => 'Klinik Pribadi', 'no_ktp_npwp' => '3327010101800001 / 0123456789012350', 'alamat' => 'Jl. Melati No. 1, Pemalang', 'lokasi_usaha' => 'Jl. Melati No. 1, Mulyoharjo', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Mulyoharjo', 'keterangan' => 'Praktik Umum', 'tanggal_daftar' => '2024-01-24', 'telepon' => '081987654321'],
        ['id' => 7, 'nomor_daftar' => '090010', 'nama_izin' => 'Surat Izin Praktik Dokter (SIP)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'DR. ANITA DEWI', 'nama_usaha' => 'Klinik Pribadi', 'no_ktp_npwp' => '3327010202810002 / 0123456789012351', 'alamat' => 'Jl. Pemuda No. 20, Pemalang', 'lokasi_usaha' => 'Jl. Pemuda No. 20, Mulyoharjo', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Mulyoharjo', 'keterangan' => 'Praktik Gigi', 'tanggal_daftar' => '2024-01-25', 'telepon' => '081987654322'],
        ['id' => 8, 'nomor_daftar' => '100011', 'nama_izin' => 'Izin Pembelian BBM Solar', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'CV. USAHA MAKMUR', 'nama_usaha' => 'Usaha Transportasi', 'no_ktp_npwp' => '3327020303820003 / 0123456789012352', 'alamat' => 'Jl. Raya Petarukan No. 50', 'lokasi_usaha' => 'Jl. Raya Petarukan No. 50', 'kecamatan' => 'Petarukan', 'kelurahan' => 'Petarukan', 'keterangan' => 'Usaha Mikro Transportasi', 'tanggal_daftar' => '2024-01-26', 'telepon' => '081987654323'],
    ];
    // Session key Penomoran
    const DUMMY_DATA_KEY_PENOMORAN = 'penomoran_sk_dummy_data_v2';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'log' => ['GET'],
                    'tanda-terima' => ['GET'],
                    'simpan-penomoran' => ['POST'],
                    'delete' => ['POST'],
                    'search-pendaftaran' => ['GET'],
                    'search-penomoran' => ['GET'], // (FIX) Daftarkan action baru
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

    public function actionIndex($search_pendaftaran = null, $search_penomoran = null)
    {
        $modelPendaftaran = null;
        $modelPenomoran = null;
        $isSearch = !empty($search_pendaftaran);

        if ($isSearch) {
            $modelPendaftaran = $this->findPendaftaranModelBySearch($search_pendaftaran);
            if ($modelPendaftaran !== null) {
                $modelPenomoran = $this->findPenomoranModelByPendaftaranId($modelPendaftaran['id']);
            } else {
                Yii::$app->session->setFlash('warning', 'Data pendaftaran tidak ditemukan.');
            }
        }

        $allPenomoranData = $this->getDummyDataWithPendaftaran();
        $filteredPenomoranData = $allPenomoranData;

        // (FIX) Logika pencarian Laporan (form bawah)
        if (!empty($search_penomoran)) {
            $term = strtolower($search_penomoran);
            $filteredPenomoranData = array_filter($filteredPenomoranData, function ($item) use ($term) {
                return stripos($item['nama_pemohon'] ?? '', $term) !== false ||
                    stripos($item['nomor_daftar'] ?? '', $term) !== false || // (FIX) Ganti 'nomor_pendaftaran' jadi 'nomor_daftar'
                    stripos($item['nomor_sk'] ?? '', $term) !== false;
            });
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredPenomoranData,
            'key' => 'penomoran_id',
            'pagination' => ['pageSize' => 5],
            'sort' => [
                // (FIX) Ganti 'nomor_pendaftaran' jadi 'nomor_daftar'
                'attributes' => ['nomor_daftar', 'nama_pemohon', 'nomor_sk', 'tanggal_pengesahan', 'tanggal_berlaku'],
                'defaultOrder' => ['tanggal_pengesahan' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'search_pendaftaran' => $search_pendaftaran,
            'search_penomoran' => $search_penomoran,
            'modelPendaftaran' => $modelPendaftaran,
            'modelPenomoran' => $modelPenomoran,
            'isSearch' => $isSearch,
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
        ]);
    }

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
                    $results[] = [
                        'label' => $label,
                        'value' => $nomorDaftar,
                    ];
                }
            }
        }
        return $results;
    }

    /**
     * (FIX) Action baru untuk autocomplete Laporan Penomoran (search box bawah)
     */
    public function actionSearchPenomoran($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $results = [];

        if (!empty($term)) {
            $term = strtolower($term);

            // (FIX) Ambil data yang benar (yang sudah ada SK-nya)
            $allPenomoranData = $this->getDummyDataWithPendaftaran();

            foreach ($allPenomoranData as $item) {
                // Cari berdasarkan Nomor SK, Nama Pemohon, atau Nomor Daftar
                $nomorSK = $item['nomor_sk'] ?? '';
                $namaPemohon = $item['nama_pemohon'] ?? '';
                $nomorDaftar = $item['nomor_daftar'] ?? '';

                if (
                    stripos($nomorSK, $term) !== false ||
                    stripos($namaPemohon, $term) !== false ||
                    stripos($nomorDaftar, $term) !== false
                ) {
                    $label = "{$nomorSK} - {$namaPemohon} ({$nomorDaftar})";
                    $results[] = [
                        'label' => $label,
                        'value' => $nomorSK, // (FIX) Value diisi No SK
                    ];
                }
            }
            // (FIX) Hapus duplikat jika ada
            $results = array_values(array_unique($results, SORT_REGULAR));
        }
        return $results;
    }


    public function actionSimpanPenomoran($pendaftaran_id)
    {
        $modelPendaftaran = $this->findPendaftaranModelById($pendaftaran_id);
        if ($modelPendaftaran === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            $saveData = [
                'pendaftaran_id' => $pendaftaran_id,
                'nomor_sk' => $postData['nomor_sk'] ?? null,
                'tanggal_pengesahan' => $postData['tanggal_pengesahan'] ?? null,
                'tanggal_berlaku' => $postData['tanggal_berlaku'] ?? null,
            ];
            $this->savePenomoranData($saveData);
            Yii::$app->session->setFlash('success', 'Data penomoran SK berhasil disimpan.');
        }
        return $this->redirect(['index', 'search_pendaftaran' => $modelPendaftaran['nomor_daftar']]);
    }

    public function actionLog($pendaftaran_id)
    {
        $model = $this->findPendaftaranModelById($pendaftaran_id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }
        $logData = $this->getLogDummyData();
        $this->layout = false;
        return $this->renderPartial('_lembar_kendali', ['model' => $model, 'logData' => $logData]);
    }

    public function actionTandaTerima($pendaftaran_id)
    {
        $model = $this->findPendaftaranModelById($pendaftaran_id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }
        $this->layout = false;
        return $this->renderPartial('_tanda_terima', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $allData = $this->getDummyData();
        if (isset($allData[$id])) {
            unset($allData[$id]);
            $this->saveDummyData($allData);
            Yii::$app->session->setFlash('success', 'Data penomoran berhasil dihapus.');
        } else {
            Yii::$app->session->setFlash('error', 'Data penomoran tidak ditemukan.');
        }
        return $this->redirect(['index']);
    }

    // --- Helper Functions ---

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

    protected function initDummyData()
    {
        $session = Yii::$app->session;
        if (empty($session->get(self::DUMMY_DATA_KEY_PENOMORAN))) {
            $session->set(self::DUMMY_DATA_KEY_PENOMORAN, [
                1 => ['penomoran_id' => 1, 'pendaftaran_id' => 6, 'nomor_sk' => '1202/01/2024', 'tanggal_pengesahan' => '2024-02-01', 'tanggal_berlaku' => '2029-02-01'],
                2 => ['penomoran_id' => 2, 'pendaftaran_id' => 7, 'nomor_sk' => '1202/01/2024', 'tanggal_pengesahan' => '2024-02-12', 'tanggal_berlaku' => '2029-02-12'],
                3 => ['penomoran_id' => 3, 'pendaftaran_id' => 8, 'nomor_sk' => '503.84/10006/DPMPTSP', 'tanggal_pengesahan' => '2025-10-28', 'tanggal_berlaku' => '2025-12-28'],
                4 => ['penomoran_id' => 4, 'pendaftaran_id' => 1, 'nomor_sk' => '503.1/007/DPMPTSP', 'tanggal_pengesahan' => '2025-10-28', 'tanggal_berlaku' => '2025-12-28'],
                5 => ['penomoran_id' => 5, 'pendaftaran_id' => 2, 'nomor_sk' => '503.2/008/DPMPTSP', 'tanggal_pengesahan' => '2025-10-28', 'tanggal_berlaku' => '2025-12-28'],
                6 => ['penomoran_id' => 6, 'pendaftaran_id' => 3, 'nomor_sk' => '503.3/009/DPMPTSP', 'tanggal_pengesahan' => '2025-10-28', 'tanggal_berlaku' => '2025-12-28'],
                7 => ['penomoran_id' => 7, 'pendaftaran_id' => 4, 'nomor_sk' => '503.4/010/DPMPTSP', 'tanggal_pengesahan' => '2025-10-28', 'tanggal_berlaku' => '2025-12-28'],
                8 => ['penomoran_id' => 8, 'pendaftaran_id' => 5, 'nomor_sk' => '503.84/10007/DPMPTSP', 'tanggal_pengesahan' => '2025-10-28', 'tanggal_berlaku' => '2025-12-28'],
                9 => ['penomoran_id' => 9, 'pendaftaran_id' => 5, 'nomor_sk' => '503.84/10008/DPMPTSP', 'tanggal_pengesahan' => '2025-10-28', 'tanggal_berlaku' => '2025-12-28'],
                10 => ['penomoran_id' => 10, 'pendaftaran_id' => 5, 'nomor_sk' => '503.84/10009/DPMPTSP', 'tanggal_pengesahan' => '2025-10-28', 'tanggal_berlaku' => '2025-12-28'],
            ]);
        }
    }
    protected function getDummyData()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY_PENOMORAN, []);
    }
    protected function saveDummyData(array $data)
    {
        Yii::$app->session->set(self::DUMMY_DATA_KEY_PENOMORAN, $data);
    }

    protected function findPenomoranModelById($id)
    {
        $allData = $this->getDummyData();
        return $allData[$id] ?? null;
    }

    protected function findPenomoranModelByPendaftaranId($pendaftaranId)
    {
        $allData = $this->getDummyData();
        foreach ($allData as $item) {
            if (isset($item['pendaftaran_id']) && $item['pendaftaran_id'] == $pendaftaranId) {
                return $item;
            }
        }
        return null;
    }

    protected function savePenomoranData(array $data)
    {
        if (empty($data['pendaftaran_id'])) return;
        $allData = $this->getDummyData();
        $existingModel = $this->findPenomoranModelByPendaftaranId($data['pendaftaran_id']);
        if ($existingModel) {
            $id = $existingModel['penomoran_id'];
            $data['penomoran_id'] = $id;
            $allData[$id] = $data;
        } else {
            $newId = empty($allData) ? 1 : max(array_keys($allData)) + 1;
            $data['penomoran_id'] = $newId;
            $allData[$newId] = $data;
        }
        $this->saveDummyData($allData);
    }

    protected function getDummyDataWithPendaftaran()
    {
        $penomoranData = $this->getDummyData();
        $pendaftaranData = self::DUMMY_DATA_PENDAFTARAN;
        $pendaftaranMap = ArrayHelper::index($pendaftaranData, 'id');
        $combinedData = [];
        foreach ($penomoranData as $sk) {
            $pendaftaranId = $sk['pendaftaran_id'] ?? null;
            $pendaftaranInfo = $pendaftaranMap[$pendaftaranId] ?? [];
            $combinedData[] = array_merge($pendaftaranInfo, $sk, [
                'alamat_usaha' => $pendaftaranInfo['lokasi_usaha'] ?? 'N/A',
                'nomor_sk' => $sk['nomor_sk'] ?? 'N/A',
            ]);
        }
        return $combinedData;
    }

    protected function getLogDummyData()
    {
        return [
            ['pos' => 1, 'tanggal_mulai_entry' => '2021-04-09', 'tanggal_mulai_system' => '2021-04-09 10:30:44', 'dari' => 'Pemohon', 'nama_pengguna' => 'STI', 'proses' => 'Memeriksa Berkas Permohonan', 'tanggal_selesai_entry' => '2021-04-09', 'tanggal_selesai_system' => '2021-04-09 10:30:44', 'kirim_ke' => 'Front Office', 'berkas_tolak_kirim_entry' => '2021-04-09', 'berkas_tolak_kirim_system' => '2021-04-09 10:30:44', 'catatan' => 'SUDH DINPUTING', 'status' => '2021-04-09 10:30:44', 'tanggal_terima_tolak' => '2021-04-09', 'penilaian_kepatuhan' => null, 'lambat_hari' => 0, 'lambat_jam' => 0, 'lambat_menit' => 0,],
            ['pos' => 2, 'tanggal_mulai_entry' => '2021-04-09', 'tanggal_mulai_system' => '2021-04-09 10:37:59', 'dari' => 'Front Office', 'nama_pengguna' => 'FO1', 'proses' => 'Menerima, Memeriksa Kelengkapan Berkas Dan Input Data Primer Permohonan Izin', 'tanggal_selesai_entry' => '2021-04-09', 'tanggal_selesai_system' => '2021-04-09 10:37:59', 'kirim_ke' => 'Back Office', 'berkas_tolak_kirim_entry' => '2021-04-14', 'berkas_tolak_kirim_system' => '2021-04-14 08:35:46', 'catatan' => 'SUDH DINPUTING', 'status' => '2021-04-14 14:40:03', 'tanggal_terima_tolak' => '2021-04-14', 'penilaian_kepatuhan' => null, 'lambat_hari' => 0, 'lambat_jam' => 0, 'lambat_menit' => 0,],
        ];
    }
}
