<?php

namespace app\modules\admin\back_office\perhitungan_retribusi\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `perhitungan_retribusi` module
 */
class DefaultController extends Controller
{

    // Data Pendaftaran Dummy Lokal
    const DUMMY_DATA_PENDAFTARAN = [
        ['id' => 1, 'nomor_daftar' => '030004', 'nama_izin' => 'Izin Penyelenggaraan Reklame', 'jenis_permohonan' => 'PENCABUTAN', 'nama_pemohon' => 'Budi Santoso', 'no_ktp_npwp' => '3310010020030004 / 0123456789012345', 'alamat' => 'Jl. Merdeka No. 10, Pemalang', 'lokasi_usaha' => 'Jl. Merdeka No. 10, Pemalang', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kelurahan A', 'keterangan' => 'Reklame 2x1m', 'tanggal_daftar' => '2014-04-28', 'telepon' => '08123456789'],
        ['id' => 2, 'nomor_daftar' => '040005', 'nama_izin' => 'Izin A (Klinik)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Dr. Siti Aminah', 'no_ktp_npwp' => '3310010020040005 / 0123456789012346', 'alamat' => 'Jl. Sudirman No. 12', 'lokasi_usaha' => 'Jl. Pahlawan No. 1', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kelurahan B', 'keterangan' => 'Klinik Umum', 'tanggal_daftar' => '2014-04-27', 'telepon' => '08987654321'],
        ['id' => 3, 'nomor_daftar' => '050006', 'nama_izin' => 'Izin B (Apotek)', 'jenis_permohonan' => 'PERPANJANGAN', 'nama_pemohon' => 'Andi Wijaya', 'nama_usaha' => 'Apotek Sejahtera Farma', 'no_ktp_npwp' => '3310020030050006 / 0123456789012347', 'alamat' => 'Jl. Diponegoro No. 55', 'lokasi_usaha' => 'Jl. Diponegoro No. 55', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kelurahan C', 'keterangan' => 'Perpanjangan tahunan', 'tanggal_daftar' => '2014-04-26', 'telepon' => '087712345678'],
        ['id' => 4, 'nomor_daftar' => '060007', 'nama_izin' => 'Izin C (Lainnya)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Rina Kusuma', 'nama_usaha' => 'Warung Nasi Padang Maknyus', 'no_ktp_npwp' => '3310040040060007 / 0123456789012348', 'alamat' => 'Jl. Raya Jogja-Solo No. 15', 'lokasi_usaha' => 'Jl. Raya Jogja-Solo No. 15', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kelurahan D', 'keterangan' => 'Warung makan baru', 'tanggal_daftar' => '2014-04-25', 'telepon' => '081223344556'],
        ['id' => 5, 'nomor_daftar' => '1393/9/2014/2014', 'nama_izin' => 'Izin Mendirikan Bangunan (IMB)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Slamet Riyadi', 'nama_usaha' => 'Rumah Tinggal', 'no_ktp_npwp' => '3310050050070008 / 0123456789012349', 'alamat' => 'Jl. Veteran No. 8', 'lokasi_usaha' => 'Jl. Veteran No. 8', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kelurahan E', 'keterangan' => 'Rumah tinggal 2 lantai', 'tanggal_daftar' => '2014-05-01', 'telepon' => '081567890123'],
    ];

    // Session key
    const DUMMY_DATA_KEY_RETRIBUSI = 'retribusi_dummy_data_v1';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'hitung' => ['POST'],
                    'delete-rincian' => ['POST'],
                    'log' => ['GET'],
                    'index' => ['GET'],
                    'search-pendaftaran' => ['GET'], // <-- (FIX) Tambahkan action autocomplete
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

    public function actionIndex()
    {
        // ... (Tidak ada perubahan di sini) ...
        $search = Yii::$app->request->get('search');
        $model = null;
        $rincianData = [];
        $isSearch = !empty($search);

        if ($isSearch) {
            $model = $this->findPendaftaranModelBySearch($search);
            if ($model !== null) {
                $rincianData = $this->findRincianData($model['id']);
            } else {
                Yii::$app->session->setFlash('warning', 'Data pendaftaran tidak ditemukan.');
            }
        }

        $rincianProvider = new ArrayDataProvider([
            'allModels' => $rincianData,
            'key' => 'id',
            'pagination' => false,
        ]);

        return $this->render('index', [
            'search' => $search,
            'model' => $model,
            'isSearch' => $isSearch,
            'rincianProvider' => $rincianProvider,
            'dropdownData' => $this->getDropdownData(),
        ]);
    }

    /**
     * (FIX BARU) Action untuk autocomplete search
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

                // Search logic (sama seperti findPendaftaranModelBySearch)
                if (stripos($nomorDaftar, $term) !== false || stripos($namaPemohon, $term) !== false || stripos($namaUsaha, $term) !== false) {

                    // Label yang akan ditampilkan
                    $label = "{$nomorDaftar} - {$namaPemohon}" . (!empty($namaUsaha) ? " ({$namaUsaha})" : "");

                    // Value yang akan di-submit (kita gunakan nomor daftar untuk pencarian pasti)
                    $value = $nomorDaftar;

                    $results[] = [
                        'label' => $label,
                        'value' => $value, // Ini akan menjadi nilai di input box saat diklik
                    ];
                }
            }
        }
        return $results;
    }


    public function actionHitung($id)
    {
        $model = $this->findPendaftaranModelById($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();

            // (FIX) Ambil SEMUA data dari form
            $gedung = $postData['nama_gedung'] ?? 'Gedung Tanpa Nama';
            $luas = (float)($postData['luas_bangunan'] ?? 0);
            $jumlah = (int)($postData['jumlah_bangunan'] ?? 0);
            $tarif = (float)($postData['tarif_retribusi'] ?? 0);
            $indeks = (float)($postData['indeks_harga'] ?? 1.0);

            // (FIX) Ambil SEMUA koefisien
            $koef_luas = (float)($postData['koefisien_luas'] ?? 1.0);
            $koef_tingkat = (float)($postData['koefisien_tingkat'] ?? 1.0);
            $koef_guna = (float)($postData['koefisien_guna'] ?? 1.0);
            $koef_finansial = (float)($postData['koefisien_finansial'] ?? 1.0);
            $koef_jalan = (float)($postData['koefisien_jalan'] ?? 1.0);
            $koef_kelas = (float)($postData['koefisien_kelas'] ?? 1.0);

            // (FIX) Hitung total koefisien dan total biaya
            $total_koefisien = $koef_luas * $koef_tingkat * $koef_guna * $koef_finansial * $koef_jalan * $koef_kelas;
            $total_biaya = $luas * $jumlah * $tarif * $indeks * $total_koefisien;

            // (FIX) Ambil rincian data yang sudah ada
            $currentRincian = $this->findRincianData($id);
            $newId = empty($currentRincian) ? 1 : max(ArrayHelper::getColumn($currentRincian, 'id')) + 1;

            $newRincianData = [
                'id' => $newId,
                'gedung' => $gedung,
                'luas' => $luas,
                'jumlah_bangunan' => $jumlah,
                'tarif_retribusi' => $tarif,
                'indeks_harga' => $indeks,
                'koefisien_luas' => $koef_luas,
                'koefisien_tingkat' => $koef_tingkat,
                'koefisien_guna' => $koef_guna,
                'koefisien_finansial' => $koef_finansial,
                'koefisien_jalan' => $koef_jalan,
                'koefisien_kelas' => $koef_kelas,
                'total_koefisien' => $total_koefisien,
                'nilai_retribusi' => $total_biaya,
            ];

            // (FIX) Tambahkan data baru ke array, jangan timpa
            $currentRincian[] = $newRincianData;
            $this->saveRincianData($id, $currentRincian);

            Yii::$app->session->setFlash('success', 'Perhitungan retribusi berhasil ditambahkan.');
        }

        return $this->redirect(['index', 'search' => $model['nomor_daftar']]);
    }

    /**
     * (BARU) Action untuk menghapus baris rincian
     */
    public function actionDeleteRincian($pendaftaranId, $rincianId)
    {
        $model = $this->findPendaftaranModelById($pendaftaranId);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        $currentRincian = $this->findRincianData($pendaftaranId);

        // Filter array, buang data dengan rincianId yang cocok
        $newRincian = array_filter($currentRincian, function ($item) use ($rincianId) {
            return ($item['id'] ?? null) != $rincianId;
        });

        // Re-index array (penting!)
        $newRincian = array_values($newRincian);

        $this->saveRincianData($pendaftaranId, $newRincian);
        Yii::$app->session->setFlash('success', 'Rincian perhitungan berhasil dihapus.');

        return $this->redirect(['index', 'search' => $model['nomor_daftar']]);
    }

    public function actionLog($id)
    {
        // ... (Tidak ada perubahan di sini) ...
        $model = $this->findPendaftaranModelById($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }
        $this->layout = false;
        Yii::$app->response->format = Response::FORMAT_HTML;
        return $this->renderPartial('_tanda_terima', ['model' => $model]);
    }

    // --- Helper Functions ---
    // ... (Tidak ada perubahan di helper lainnya) ...
    protected function getDropdownData()
    {
        return [
            'tarifItems' => ['1000' => 'Rp 1.000/m2', '2000' => 'Rp 2.000/m2', '3000' => 'Rp 3.000/m2', '50000' => 'Rp 50.000/m2'],
            'indeksItems' => ['1.0' => '1.0 (Standar)', '1.2' => '1.2 (Kompleks)'],
            'koefisienItems' => ['1.0' => '1.0 (Biasa)', '1.1' => '1.1 (Sedang)', '1.2' => '1.2 (Tinggi)'],
        ];
    }

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
        if (empty($session->get(self::DUMMY_DATA_KEY_RETRIBUSI))) {
            $session->set(self::DUMMY_DATA_KEY_RETRIBUSI, [
                // Data untuk Budi Santoso (ID 1)
                1 => [
                    ['id' => 1, 'gedung' => 'Reklame Toko', 'luas' => 2, 'jumlah_bangunan' => 1, 'tarif_retribusi' => 50000, 'indeks_harga' => 1.0, 'koefisien_luas' => 1.0, 'koefisien_tingkat' => 1.0, 'koefisien_guna' => 1.0, 'koefisien_finansial' => 1.0, 'koefisien_jalan' => 1.0, 'koefisien_kelas' => 1.0, 'total_koefisien' => 1.0, 'nilai_retribusi' => 100000],
                ],
                // Data untuk Andi Wijaya (ID 3)
                3 => [
                    ['id' => 1, 'gedung' => 'Apotek Sejahtera', 'luas' => 80, 'jumlah_bangunan' => 1, 'tarif_retribusi' => 2500, 'indeks_harga' => 1.0, 'koefisien_luas' => 1.1, 'koefisien_tingkat' => 1.0, 'koefisien_guna' => 1.0, 'koefisien_finansial' => 1.0, 'koefisien_jalan' => 1.0, 'koefisien_kelas' => 1.0, 'total_koefisien' => 1.1, 'nilai_retribusi' => 220000],
                ],
                // Data lama untuk Slamet Riyadi (ID 5)
                5 => [
                    ['id' => 1, 'gedung' => 'Bangunan Utama', 'luas' => 150, 'jumlah_bangunan' => 1, 'tarif_retribusi' => 2000, 'indeks_harga' => 1.0, 'koefisien_luas' => 1.1, 'koefisien_tingkat' => 1.0, 'koefisien_guna' => 1.0, 'koefisien_finansial' => 1.0, 'koefisien_jalan' => 1.0, 'koefisien_kelas' => 1.0, 'total_koefisien' => 1.1, 'nilai_retribusi' => 330000],
                    ['id' => 2, 'gedung' => 'Garasi', 'luas' => 20, 'jumlah_bangunan' => 1, 'tarif_retribusi' => 1000, 'indeks_harga' => 1.0, 'koefisien_luas' => 1.0, 'koefisien_tingkat' => 1.0, 'koefisien_guna' => 1.0, 'koefisien_finansial' => 1.0, 'koefisien_jalan' => 1.0, 'koefisien_kelas' => 1.0, 'total_koefisien' => 1.0, 'nilai_retribusi' => 20000],
                ]
            ]);
        }
    }

    protected function getDummyData()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY_RETRIBUSI, []);
    }

    protected function findRincianData($pendaftaranId)
    {
        $allData = $this->getDummyData();
        return $allData[$pendaftaranId] ?? []; // Kembalikan array kosong jika tidak ada
    }

    protected function saveRincianData($pendaftaranId, array $rincian)
    {
        if (empty($pendaftaranId)) return;
        $allData = $this->getDummyData();
        $allData[$pendaftaranId] = $rincian;
        Yii::$app->session->set(self::DUMMY_DATA_KEY_RETRIBUSI, $allData);
    }
}
