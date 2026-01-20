<?php

namespace app\modules\admin\back_office\berita_acara_pemeriksaan\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Default controller for the `berita_acara_pemeriksaan` module
 */
class DefaultController extends Controller
{

    // Data Pendaftaran Dummy Lokal
    const DUMMY_DATA_PENDAFTARAN = [
        [
            'id' => 1,
            'nomor_daftar' => '030004',
            'nama_izin' => 'Izin Penyelenggaraan Reklame',
            'jenis_izin_id' => 'IZIN_REKLAME',
            'jenis_permohonan' => 'PENCABUTAN',
            'jenis_permohonan_id' => 'PENCABUTAN',
            'nama_pemohon' => 'Budi Santoso',
            'nama_usaha' => 'Toko Kelontong Berkah',
            'no_ktp_npwp' => '3310010020030004 / 0123456789012345',
            'alamat' => 'Jl. Merdeka No. 10, Pemalang',
            'lokasi_usaha' => 'Jl. Merdeka No. 10, Pemalang',
            'kecamatan' => 'Pemalang',
            'kelurahan' => 'Kelurahan A',
            'keterangan' => 'Reklame ukuran 2x1 meter di depan toko.',
            'tanggal_daftar' => '2014-04-28',
            'telepon' => '08123456789',
        ],
        [
            'id' => 2,
            'nomor_daftar' => '040005',
            'nama_izin' => 'Izin A (Klinik)',
            'jenis_izin_id' => 'IZIN_A',
            'jenis_permohonan' => 'BARU',
            'jenis_permohonan_id' => 'BARU',
            'nama_pemohon' => 'Dr. Siti Aminah',
            'nama_usaha' => 'Klinik Sehat Utama',
            'no_ktp_npwp' => '3310010020040005 / 0123456789012346',
            'alamat' => 'Jl. Sudirman No. 12, Pemalang',
            'lokasi_usaha' => 'Jl. Pahlawan No. 1, Pemalang',
            'kecamatan' => 'Pemalang',
            'kelurahan' => 'Kelurahan B',
            'keterangan' => 'Klinik Pratama Umum',
            'tanggal_daftar' => '2014-04-27',
            'telepon' => '08987654321',
        ],
        [
            'id' => 3,
            'nomor_daftar' => '050006',
            'nama_izin' => 'Izin B (Apotek)',
            'jenis_izin_id' => 'IZIN_B',
            'jenis_permohonan' => 'PERPANJANGAN',
            'jenis_permohonan_id' => 'PERPANJANGAN',
            'nama_pemohon' => 'Andi Wijaya',
            'nama_usaha' => 'Apotek Sejahtera Farma',
            'no_ktp_npwp' => '3310020030050006 / 0123456789012347',
            'alamat' => 'Jl. Diponegoro No. 55, Pemalang',
            'lokasi_usaha' => 'Jl. Diponegoro No. 55, Pemalang',
            'kecamatan' => 'Pemalang',
            'kelurahan' => 'Kelurahan C',
            'keterangan' => 'Perpanjangan izin apotek tahunan.',
            'tanggal_daftar' => '2014-04-26',
            'telepon' => '087712345678',
        ],
        [
            'id' => 4,
            'nomor_daftar' => '060007',
            'nama_izin' => 'Izin C (Lainnya)',
            'jenis_izin_id' => 'IZIN_C',
            'jenis_permohonan' => 'BARU',
            'jenis_permohonan_id' => 'BARU',
            'nama_pemohon' => 'Rina Kusuma',
            'nama_usaha' => 'Warung Nasi Padang Maknyus',
            'no_ktp_npwp' => '3310040040060007 / 0123456789012348',
            'alamat' => 'Jl. Raya Jogja-Solo No. 15, Pemalang',
            'lokasi_usaha' => 'Jl. Raya Jogja-Solo No. 15, Pemalang',
            'kecamatan' => 'Pemalang',
            'kelurahan' => 'Kelurahan D',
            'keterangan' => 'Warung makan baru.',
            'tanggal_daftar' => '2014-04-25',
            'telepon' => '081223344556',
        ],
    ];

    // Session key BAP
    const DUMMY_DATA_KEY_BAP = 'bap_dummy_data_v1';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'update' => ['GET', 'POST'],
                    'cetak' => ['GET'],
                    'search-pendaftaran' => ['GET'], // (FIX) Daftarkan action autocomplete
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $this->initDummyBapData();
        return true;
    }

    public function actionIndex()
    {
        $search = Yii::$app->request->get('search');
        $model = null;
        $bapData = null;
        $isSearch = !empty($search);

        if ($isSearch) {
            $model = $this->findPendaftaranModelBySearch($search);
            if ($model !== null) {
                $bapData = $this->findBapData($model['id']);
            } else {
                Yii::$app->session->setFlash('warning', 'Data pendaftaran tidak ditemukan.');
            }
        }

        return $this->render('index', [
            'search' => $search,
            'model' => $model,
            'bapData' => $bapData,
            'isSearch' => $isSearch,
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


    public function actionUpdate($id)
    {
        $model = $this->findPendaftaranModelById($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        $bapData = $this->findBapData($id);

        $bapDefaults = [
            'nomor_bap' => $bapData['nomor_bap'] ?? '1',
            'tanggal_bap' => !empty($bapData['tanggal_bap']) ? Yii::$app->formatter->asDate($bapData['tanggal_bap'], 'php:Y-m-d') : date('Y-m-d'),
            'tanggal_lapangan' => !empty($bapData['tanggal_lapangan']) ? Yii::$app->formatter->asDate($bapData['tanggal_lapangan'], 'php:Y-m-d') : date('Y-m-d'),
        ];


        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            $saveData = [
                'pendaftaran_id' => $id,
                'nomor_bap' => $postData['nomor_bap'] ?? null,
                'tanggal_bap' => $postData['tanggal_bap'] ?? null,
                'tanggal_lapangan' => $postData['tanggal_lapangan'] ?? null,
            ];
            $this->saveBapData($saveData);

            Yii::$app->session->setFlash('success', "Berita Acara Pemeriksaan untuk {$model['nomor_daftar']} berhasil disimpan.");
            return $this->redirect(['index', 'search' => $model['nomor_daftar']]);
        }

        return $this->render('update', [
            'model' => $model,
            'bapDefaults' => $bapDefaults,
        ]);
    }

    public function actionCetak($id)
    {
        $model = $this->findPendaftaranModelById($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }
        $bapData = $this->findBapData($id);
        if ($bapData === null) {
            Yii::$app->session->setFlash('error', "Data Berita Acara belum dibuat untuk pendaftaran {$model['nomor_daftar']}.");
            return $this->redirect(['index', 'search' => $model['nomor_daftar']]);
        }

        $this->layout = false;
        Yii::$app->response->format = Response::FORMAT_HTML;
        return $this->renderPartial('_cetak_bap', [
            'model' => $model,
            'bapData' => $bapData,
        ]);
    }

    // --- Helper Functions ---

    protected function findPendaftaranModelBySearch($search)
    {
        $allPendaftaran = self::DUMMY_DATA_PENDAFTARAN;
        foreach ($allPendaftaran as $item) {
            $nomorDaftar = $item['nomor_daftar'] ?? '';
            $namaPemohon = $item['nama_pemohon'] ?? '';
            $namaUsaha = $item['nama_usaha'] ?? '';

            if (
                stripos($nomorDaftar, $search) !== false ||
                stripos($namaPemohon, $search) !== false ||
                stripos($namaUsaha, $search) !== false
            ) {
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

    protected function initDummyBapData()
    {
        $session = Yii::$app->session;
        if (empty($session->get(self::DUMMY_DATA_KEY_BAP))) {
            $session->set(self::DUMMY_DATA_KEY_BAP, [
                1 => [
                    'pendaftaran_id' => 1,
                    'nomor_bap' => 'BAP/001/REK/X/2025',
                    'tanggal_bap' => '2025-10-09',
                    'tanggal_lapangan' => '2025-10-08',
                ],
                3 => [
                    'pendaftaran_id' => 3,
                    'nomor_bap' => 'BAP/002/APT/XI/2025',
                    'tanggal_bap' => '2025-11-15',
                    'tanggal_lapangan' => '2025-11-14',
                ],
            ]);
        }
    }

    protected function getBapData()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY_BAP, []);
    }

    protected function findBapData($pendaftaranId)
    {
        $allBap = $this->getBapData();
        return $allBap[$pendaftaranId] ?? null;
    }

    protected function saveBapData(array $data)
    {
        if (empty($data['pendaftaran_id'])) return;
        $allBap = $this->getBapData();
        $pendaftaranId = $data['pendaftaran_id'];
        $allBap[$pendaftaranId] = $data;
        Yii::$app->session->set(self::DUMMY_DATA_KEY_BAP, $allBap);
    }
}
