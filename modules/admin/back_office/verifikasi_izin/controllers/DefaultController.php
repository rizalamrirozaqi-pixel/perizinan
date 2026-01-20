<?php

namespace app\modules\admin\back_office\verifikasi_izin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile; // Untuk upload file
use yii\helpers\FileHelper; // Untuk manajemen direktori

/**
 * Default controller for the `verifikasi_izin` module
 */
class DefaultController extends Controller
{

    // Data Pendaftaran Dummy Lokal
    const DUMMY_DATA_PENDAFTARAN = [
        ['id' => 1, 'nomor_daftar' => '030004', 'nama_izin' => 'Izin Penyelenggaraan Reklame', 'jenis_permohonan' => 'PENCABUTAN', 'nama_pemohon' => 'Budi Santoso', 'no_ktp_npwp' => '3310010020030004 / 0123456789012345', 'alamat' => 'Jl. Merdeka No. 10, Pemalang', 'lokasi_usaha' => 'Jl. Merdeka No. 10, Pemalang', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kelurahan A', 'keterangan' => 'Reklame 2x1m', 'tanggal_daftar' => '2014-04-28', 'telepon' => '08123456789'],
        ['id' => 2, 'nomor_daftar' => '040005', 'nama_izin' => 'Izin A (Klinik)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Dr. Siti Aminah', 'no_ktp_npwp' => '3310010020040005 / 0123456789012346', 'alamat' => 'Jl. Sudirman No. 12', 'lokasi_usaha' => 'Jl. Pahlawan No. 1', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kelurahan B', 'keterangan' => 'Klinik Umum', 'tanggal_daftar' => '2014-04-27', 'telepon' => '08987654321'],
        ['id' => 3, 'nomor_daftar' => '050006', 'nama_izin' => 'Izin B (Apotek)', 'jenis_permohonan' => 'PERPANJANGAN', 'nama_pemohon' => 'Andi Wijaya', 'nama_usaha' => 'Apotek Sejahtera Farma', 'no_ktp_npwp' => '3310020030050006 / 0123456789012347', 'alamat' => 'Jl. Diponegoro No. 55', 'lokasi_usaha' => 'Jl. Diponegoro No. 55', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kelurahan C', 'keterangan' => 'Perpanjangan tahunan', 'tanggal_daftar' => '2014-04-26', 'telepon' => '087712345678'],
        ['id' => 4, 'nomor_daftar' => '060007', 'nama_izin' => 'Izin C (Lainnya)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'Rina Kusuma', 'nama_usaha' => 'Warung Nasi Padang Maknyus', 'no_ktp_npwp' => '3310040040060007 / 0123456789012348', 'alamat' => 'Jl. Raya Jogja-Solo No. 15', 'lokasi_usaha' => 'Jl. Raya Jogja-Solo No. 15', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kelurahan D', 'keterangan' => 'Warung makan baru', 'tanggal_daftar' => '2014-04-25', 'telepon' => '081223344556'],
    ];

    // Session key Verifikasi
    const DUMMY_DATA_KEY_VERIFIKASI = 'verifikasi_izin_dummy_data_v1';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'update' => ['POST'],
                    'upload-rekom' => ['GET', 'POST'],
                    'detail' => ['GET'],
                    'download-rekom' => ['GET'],
                    'search-pendaftaran' => ['GET'],
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
        $defaultSearch = [
            'pencarian' => null,
            'hasil' => null,
            'kasi_perizinan' => null,
            'keterangan' => null,
        ];
        
        // (FIX) Ambil data dari GET (kosong jika tidak ada)
        $getSearch = Yii::$app->request->get('SearchModel', []);
        
        // (FIX) Gabungkan (merge) data GET dengan default.
        // Data dari $getSearch akan menimpa $defaultSearch jika key-nya ada.
        // Ini memastikan $searchModel SELALU memiliki semua key.
        $searchModel = array_merge($defaultSearch, $getSearch);

        $allData = $this->getDummyDataWithPendaftaran();
        $filteredData = $allData;

        // Apply filters
        if (!empty($searchModel['pencarian'])) {
            $term = strtolower($searchModel['pencarian']);
            $filteredData = array_filter($filteredData, function ($item) use ($term) {
                return stripos($item['nama_pemohon'] ?? '', $term) !== false ||
                    stripos($item['jenis_izin'] ?? '', $term) !== false ||
                    stripos($item['nomor_verifikasi'] ?? '', $term) !== false ||
                    // (FIX) Tambahkan pencarian berdasarkan nomor daftar
                    stripos($item['nomor_daftar'] ?? '', $term) !== false;
            });
        }
        if (!empty($searchModel['hasil'])) {
            $filteredData = array_filter($filteredData, function ($item) use ($searchModel) {
                return ($item['hasil_id'] ?? '') === $searchModel['hasil'];
            });
        }
        if (!empty($searchModel['kasi_perizinan'])) {
            $filteredData = array_filter($filteredData, function ($item) use ($searchModel) {
                return ($item['kasi_perizinan_id'] ?? '') === $searchModel['kasi_perizinan'];
            });
        }
        if (!empty($searchModel['keterangan'])) {
            $termKet = strtolower($searchModel['keterangan']);
            $filteredData = array_filter($filteredData, function ($item) use ($termKet) {
                return stripos($item['keterangan'] ?? '', $termKet) !== false;
            });
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'key' => 'id',
            'pagination' => ['pageSize' => 5],
            'sort' => [
                'attributes' => [
                    'id',
                    'nomor_verifikasi',
                    'nama_pemohon',
                    'jenis_izin',
                    'jenis_permohonan',
                    'hasil',
                    'tanggal_cetak',
                    'kasi_perizinan',
                ],
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
            'searchModel' => $searchModel,
            'hasilItems' => $this->getHasilItems(),
            'kasiItems' => $this->getKasiItems(),
        ]);
    }

    /**
     * (FIX) ACTION BARU UNTUK AUTOCOMPLETE
     */
    public function actionSearchPendaftaran($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $results = [];

        if (!empty($term)) {
            $term = strtolower($term);

            // (FIX) Ambil data pendaftaran (dari konstanta)
            $allPendaftaran = self::DUMMY_DATA_PENDAFTARAN;

            foreach ($allPendaftaran as $item) {
                $nomorDaftar = $item['nomor_daftar'] ?? '';
                $namaPemohon = $item['nama_pemohon'] ?? '';
                $namaUsaha = $item['nama_usaha'] ?? '';

                if (stripos($nomorDaftar, $term) !== false || stripos($namaPemohon, $term) !== false || stripos($namaUsaha, $term) !== false) {
                    $label = "{$nomorDaftar} - {$namaPemohon}" . (!empty($namaUsaha) ? " ({$namaUsaha})" : "");
                    $results[] = [
                        'label' => $label,
                        'value' => $nomorDaftar, // Nilai yang akan dimasukkan ke input
                    ];
                }
            }
        }
        return $results;
    }

    public function actionUpdate()
    {
        $postId = Yii::$app->request->post('verification_id');
        $postData = Yii::$app->request->post('SearchModel');

        if (empty($postId) || $postData === null) {
            Yii::$app->session->setFlash('error', 'Data tidak valid untuk pembaruan.');
            return $this->redirect(['index']);
        }

        $allVerifikasi = $this->getDummyData();
        $indexToUpdate = $this->findModelIndex($postId);

        if ($indexToUpdate === null) {
            throw new NotFoundHttpException('Data verifikasi tidak ditemukan.');
        }

        $hasilItems = $this->getHasilItems();
        $kasiItems = $this->getKasiItems();
        $allVerifikasi[$indexToUpdate]['hasil_id'] = $postData['hasil'] ?? null;
        $allVerifikasi[$indexToUpdate]['hasil'] = $hasilItems[$postData['hasil'] ?? null] ?? null;
        $allVerifikasi[$indexToUpdate]['keterangan'] = $postData['keterangan'] ?? $allVerifikasi[$indexToUpdate]['keterangan'];
        $allVerifikasi[$indexToUpdate]['kasi_perizinan_id'] = $postData['kasi_perizinan'] ?? null;
        $allVerifikasi[$indexToUpdate]['kasi_perizinan'] = $kasiItems[$postData['kasi_perizinan'] ?? null] ?? null;

        $this->saveDummyData($allVerifikasi);

        Yii::$app->session->setFlash('success', 'Data verifikasi berhasil diperbarui.');
        return $this->redirect(['index']);
    }

    public function actionDetail($id)
    {
        $modelVerifikasi = $this->findModel($id);
        if ($modelVerifikasi === null) {
            throw new NotFoundHttpException('Data verifikasi tidak ditemukan.');
        }

        $this->layout = false;

        $modelPendaftaran = $this->findPendaftaranModelById($modelVerifikasi['pendaftaran_id']);
        if ($modelPendaftaran === null) {
            throw new NotFoundHttpException('Data pendaftaran terkait tidak ditemukan.');
        }

        $logData = [ /* ... data log dummy ... */];

        return $this->render('detail', [
            'model' => $modelPendaftaran,
            'verifModel' => $modelVerifikasi,
            'logData' => $logData,
        ]);
    }

    public function actionUploadRekom($id)
    {
        $model = $this->findModel($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data verifikasi tidak ditemukan.');
        }
        $pendaftaranModel = $this->findPendaftaranModelById($model['pendaftaran_id']);

        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName('rekomFile');
            if ($file) {
                if ($file->size > 2 * 1024 * 1024) {
                    Yii::$app->session->setFlash('error-upload', 'Ukuran file terlalu besar (Maks 2MB).');
                } elseif (!in_array($file->extension, ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'])) {
                    Yii::$app->session->setFlash('error-upload', 'Tipe file tidak diizinkan (Hanya PDF, DOC, DOCX, JPG, PNG).');
                } else {
                    $allVerifikasi = $this->getDummyData();
                    $indexToUpdate = $this->findModelIndex($id);
                    if ($indexToUpdate !== null) {
                        $allVerifikasi[$indexToUpdate]['upload_rekom_status'] = true;
                        $allVerifikasi[$indexToUpdate]['upload_rekom_filename'] = $file->name;
                        $this->saveDummyData($allVerifikasi);
                        Yii::$app->session->setFlash('success', 'File rekomendasi berhasil diupload (simulasi).');
                        return $this->redirect(['index']);
                    } else {
                        Yii::$app->session->setFlash('error-upload', 'Gagal menyimpan status upload data.');
                    }
                }
            } else {
                Yii::$app->session->setFlash('error-upload', 'Tidak ada file yang dipilih untuk diupload.');
            }
            return $this->render('upload_rekom', [
                'model' => $model,
                'pendaftaranModel' => $pendaftaranModel,
            ]);
        }

        return $this->render('upload_rekom', [
            'model' => $model,
            'pendaftaranModel' => $pendaftaranModel,
        ]);
    }

    public function actionDownloadRekom($id)
    {
        $model = $this->findModel($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data verifikasi tidak ditemukan.');
        }

        $filename = $model['upload_rekom_filename'] ?? null;

        if ($model['upload_rekom_status'] && $filename) {
            Yii::$app->session->setFlash('info', "Simulasi Download: File '{$filename}' akan mulai diunduh.");
        } else {
            Yii::$app->session->setFlash('error', 'File rekomendasi tidak ditemukan untuk diunduh.');
        }

        return $this->redirect(['index']);
    }

    // --- Helper Functions ---

    protected function getHasilItems()
    {
        return ['Diterima' => 'Diterima', 'Ditolak' => 'Ditolak', 'Direvisi' => 'Direvisi'];
    }

    protected function getKasiItems()
    {
        return ['KASI_A' => 'Widyo Utomo, S.Kom', 'KASI_B' => 'Nama Kasi Lain'];
    }

    protected function initDummyData()
    {
        $session = Yii::$app->session;
        if (empty($session->get(self::DUMMY_DATA_KEY_VERIFIKASI))) {
            $hasilItems = $this->getHasilItems();
            $kasiItems = $this->getKasiItems();
            $session->set(self::DUMMY_DATA_KEY_VERIFIKASI, [
                ['id' => 1, 'pendaftaran_id' => 1, 'nomor_verifikasi' => '00011/VRFPFT-S/2025', 'hasil_id' => 'Diterima', 'hasil' => $hasilItems['Diterima'], 'keterangan' => 'OK Sesuai', 'kasi_perizinan_id' => 'KASI_A', 'kasi_perizinan' => $kasiItems['KASI_A'], 'tanggal_cetak' => '2025-10-28', 'upload_rekom_status' => true, 'upload_rekom_filename' => 'rekom_budi.pdf'],
                ['id' => 2, 'pendaftaran_id' => 3, 'nomor_verifikasi' => '00012/VRFPFT-S/2025', 'hasil_id' => 'Ditolak', 'hasil' => $hasilItems['Ditolak'], 'keterangan' => 'Berkas Kurang Lengkap (NPWP)', 'kasi_perizinan_id' => 'KASI_B', 'kasi_perizinan' => $kasiItems['KASI_B'], 'tanggal_cetak' => '2025-07-29', 'upload_rekom_status' => false, 'upload_rekom_filename' => null],
                ['id' => 3, 'pendaftaran_id' => 4, 'nomor_verifikasi' => '00013/VRFPFT-S/2025', 'hasil_id' => 'Diterima', 'hasil' => $hasilItems['Diterima'], 'keterangan' => 'Sesuai BAP', 'kasi_perizinan_id' => 'KASI_A', 'kasi_perizinan' => $kasiItems['KASI_A'], 'tanggal_cetak' => '2025-07-20', 'upload_rekom_status' => false, 'upload_rekom_filename' => null],
            ]);
        }
    }

    protected function getDummyData()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY_VERIFIKASI, []);
    }

    protected function saveDummyData(array $data)
    {
        Yii::$app->session->set(self::DUMMY_DATA_KEY_VERIFIKASI, array_values($data));
    }

    protected function findModel($id)
    {
        $data = $this->getDummyData();
        foreach ($data as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }

    protected function findModelIndex($id)
    {
        $data = $this->getDummyData();
        foreach ($data as $index => $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                return $index;
            }
        }
        return null;
    }

    protected function getDummyDataWithPendaftaran()
    {
        $verifikasiData = $this->getDummyData();
        $pendaftaranData = self::DUMMY_DATA_PENDAFTARAN;
        $pendaftaranMap = ArrayHelper::index($pendaftaranData, 'id');
        $combinedData = [];
        foreach ($verifikasiData as $verif) {
            $pendaftaranId = $verif['pendaftaran_id'] ?? null;
            $pendaftaranInfo = $pendaftaranMap[$pendaftaranId] ?? [];
            $combinedData[] = array_merge($verif, [
                // (FIX) Tambahkan nomor daftar ke data gabungan
                'nomor_daftar' => $pendaftaranInfo['nomor_daftar'] ?? 'N/A',
                'nama_pemohon' => $pendaftaranInfo['nama_pemohon'] ?? 'N/A',
                'jenis_izin' => $pendaftaranInfo['nama_izin'] ?? 'N/A',
                'jenis_permohonan' => $pendaftaranInfo['jenis_permohonan'] ?? 'N/A',
            ]);
        }
        return $combinedData;
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
}
