<?php

namespace app\modules\admin\back_office\cetak_draft_sk\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `cetak_draft_sk` module
 */
class DefaultController extends Controller
{

    // Data Pendaftaran Dummy Lokal (sesuai gambar)
    const DUMMY_DATA_PENDAFTARAN = [
        ['id' => 1, 'nomor_daftar' => '030004', 'nama_izin' => 'Izin Penyelenggaraan Reklame', 'jenis_permohonan' => 'PENCABUTAN', 'nama_pemohon' => 'Budi Santoso', 'no_ktp_npwp' => '3310010020030004 / 0123456789012345', 'alamat' => 'Jl. Bengawan Solo No. 10, Pemalang', 'lokasi_usaha' => 'Jl. Bengawan Solo No. 10, Pemalang', 'kecamatan' => 'Pemalang', 'kelurahan' => 'Kebondalem', 'keterangan' => 'Reklame 2x1m', 'tanggal_daftar' => '2014-04-28', 'telepon' => '08123456789', 'nilai_retribusi' => 500000],
        // Data sesuai gambar '2137/04/2021'
        ['id' => 5, 'nomor_daftar' => '2137/04/2021', 'nama_izin' => 'Izin Mendirikan Bangunan (IMB)', 'jenis_permohonan' => 'BARU', 'nama_pemohon' => 'SITI ANIFAH', 'nama_usaha' => 'PT. GRIYA AMANAH SEJAHTERA', 'no_ktp_npwp' => '3310050050070008 / 86.116.319.0-502.000', 'alamat' => 'Jl. Veteran No. 8, Pemalang', 'lokasi_usaha' => 'Desa A, Kec. B', 'kecamatan' => 'Taman', 'kelurahan' => 'Kaligelang', 'keterangan' => 'Perumahan Griya Amanah Sejahtera', 'tanggal_daftar' => '2021-04-09', 'telepon' => '081567890123', 'nilai_retribusi' => 10696000],
    ];

    // Session key untuk data SK
    const DUMMY_DATA_KEY_DRAFT_SK = 'draft_sk_dummy_data_v1';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'log' => ['GET'],
                    'edit-data-primer' => ['GET', 'POST'], 
                    'simpan-cetak' => ['POST'],
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

    /**
     * Halaman Index (Pencarian dan Form Entry SK)
     */
    public function actionIndex($search = null)
    {
        $modelPendaftaran = null;
        $modelSk = null;
        $isSearch = !empty($search);

        if ($isSearch) {
            $modelPendaftaran = $this->findPendaftaranModelBySearch($search);
            if ($modelPendaftaran !== null) {
                // Jika pendaftaran ditemukan, cari data SK yang sudah ada
                $modelSk = $this->findSkModelByPendaftaranId($modelPendaftaran['id']);
            } else {
                Yii::$app->session->setFlash('warning', 'Data pendaftaran tidak ditemukan.');
            }
        }

        return $this->render('index', [
            'search' => $search,
            'modelPendaftaran' => $modelPendaftaran,
            'modelSk' => $modelSk, // Data SK yang sudah ada (bisa null)
            'isSearch' => $isSearch,
            // (Data dropdown bisa ditambahkan di sini jika perlu)
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
                    // Format yang diharapkan jQuery UI: [ { "label": "Tampilan", "value": "Nilai" }, ... ]
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
     * Menyimpan data SK dan (simulasi) Cetak Word
     */
    public function actionSimpanCetak($pendaftaran_id)
    {
        $modelPendaftaran = $this->findPendaftaranModelById($pendaftaran_id);
        if ($modelPendaftaran === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();

            // 1. Simpan data SK (ke session dummy)
            $saveData = [
                'pendaftaran_id' => $pendaftaran_id,
                'no_sk' => $postData['no_sk'] ?? null,
                'tgl_mohon_pu' => $postData['tgl_mohon_pu'] ?? null,
                'tgl_penetapan' => $postData['tgl_penetapan'] ?? null,
                'tgl_pemeriksaan' => $postData['tgl_pemeriksaan'] ?? null,
                'untuk_keperluan' => $postData['untuk_keperluan'] ?? null,
                'pondasi' => $postData['pondasi'] ?? null,
                'rangka_bangunan' => $postData['rangka_bangunan'] ?? null,
                'dinding' => $postData['dinding'] ?? null,
                'rangka_atap' => $postData['rangka_atap'] ?? null,
                'penutup_atap' => $postData['penutup_atap'] ?? null,
                'lantai' => $postData['lantai'] ?? null,
                'luas_bangunan' => $postData['luas_bangunan'] ?? null,
                'status_tanah' => $postData['status_tanah'] ?? null,
                'wilayah' => $postData['wilayah'] ?? null,
                'pekerjaan_pemohon' => $postData['pekerjaan_pemohon'] ?? null,
                'nop' => $postData['nop'] ?? null,
            ];
            $this->saveSkData($saveData);

            Yii::$app->session->setFlash('success', 'Data SK Draft berhasil disimpan.');

            // 2. Simulasi Cetak Word
            $this->layout = false;
            $content = $this->renderPartial('_cetak_word', [
                'modelPendaftaran' => $modelPendaftaran,
                'modelSk' => $saveData, // Kirim data yang baru disimpan
            ]);
            $filename = "DRAFT_SK_" . preg_replace('/[^A-Za-z0-9\-]/', '_', $modelPendaftaran['nomor_daftar']) . ".doc";
            Yii::$app->response->headers->set('Content-Type', 'application/msword');
            Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
            Yii::$app->response->format = Response::FORMAT_RAW;
            return $content;
        }

        return $this->redirect(['index', 'search' => $modelPendaftaran['nomor_daftar']]);
    }

    /**
     * Menampilkan halaman Edit Data Primer (Placeholder)
     */
    public function actionEditDataPrimer($pendaftaran_id)
    {
        $model = $this->findPendaftaranModelById($pendaftaran_id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        // Di sini Anda bisa menambahkan logika POST untuk menyimpan perubahan data primer
        // if (Yii::$app->request->isPost) { ... simpan data ... }

        return $this->render('edit_data_primer', [
            'model' => $model,
            // Kirim dropdown items jika perlu (Kecamatan, Kelurahan, dll)
        ]);
    }


    /**
     * Menampilkan Tanda Terima (dari link LOG)
     */
    public function actionLog($pendaftaran_id)
    {
        $model = $this->findPendaftaranModelById($pendaftaran_id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        $logData = $this->getLogDummyData(); // Ambil data log
        $this->layout = false;

        // Gunakan view _lembar_kendali
        return $this->renderPartial('_lembar_kendali', [
            'model' => $model,
            'logData' => $logData,
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
        if (empty($session->get(self::DUMMY_DATA_KEY_DRAFT_SK))) {
            $session->set(self::DUMMY_DATA_KEY_DRAFT_SK, [
                5 => [ 
                    'pendaftaran_id' => 5,
                    'no_sk' => '503.2 / 80 / 2021',
                    'tgl_mohon_pu' => '2021-04-09',
                    'tgl_penetapan' => '2021-04-19',
                    'tgl_pemeriksaan' => '2021-04-15',
                    'untuk_keperluan' => 'Mendirikan Bangunan Perumahan GRIYA AMANAH SEJAHTERA 2',
                    'pondasi' => 'Batu kali',
                    'rangka_bangunan' => 'Beton bertulang',
                    'dinding' => 'Batu bata',
                    'rangka_atap' => 'Baja ringan',
                    'penutup_atap' => 'Multiroof',
                    'lantai' => 'Keramik',
                    'luas_bangunan' => 'Type 36 / 65 M2 sejumlah 54 Unit',
                    'status_tanah' => 'C No: 744 Persil No: 103 S/II, Luas L: 1.752 m2, Cover Note No: ...',
                    'wilayah' => 'V1',
                    'pekerjaan_pemohon' => 'Wiraswasta',
                    'nop' => '33.27.080.014.002.00',
                ],
            ]);
        }
    }
    protected function getDummyData()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY_DRAFT_SK, []);
    }
    protected function saveDummyData(array $data)
    {
        Yii::$app->session->set(self::DUMMY_DATA_KEY_DRAFT_SK, $data);
    }

    protected function findSkModelByPendaftaranId($pendaftaranId)
    {
        $allData = $this->getDummyData();
        return $allData[$pendaftaranId] ?? null;
    }

    protected function saveSkData(array $data)
    {
        if (empty($data['pendaftaran_id'])) return;
        $allData = $this->getDummyData();
        $pendaftaranId = $data['pendaftaran_id'];
        $allData[$pendaftaranId] = $data; // Add or replace data
        $this->saveDummyData($allData);
    }

    protected function getLogDummyData()
    {
        return [
            ['pos' => 1, 'tanggal_mulai_entry' => '2021-04-09', 'tanggal_mulai_system' => '2021-04-09 10:30:44', 'dari' => 'Pemohon', 'nama_pengguna' => 'STI', 'proses' => 'Memeriksa Berkas Permohonan', 'tanggal_selesai_entry' => '2021-04-09', 'tanggal_selesai_system' => '2021-04-09 10:30:44', 'kirim_ke' => 'Front Office', 'berkas_tolak_kirim_entry' => '2021-04-09', 'berkas_tolak_kirim_system' => '2021-04-09 10:30:44', 'catatan' => 'SUDH DINPUTING', 'status' => '2021-04-09 10:30:44', 'tanggal_terima_tolak' => '2021-04-09', 'penilaian_kepatuhan' => null, 'lambat_hari' => 0, 'lambat_jam' => 0, 'lambat_menit' => 0,],
            ['pos' => 2, 'tanggal_mulai_entry' => '2021-04-09', 'tanggal_mulai_system' => '2021-04-09 10:37:59', 'dari' => 'Front Office', 'nama_pengguna' => 'FO1', 'proses' => 'Menerima, Memeriksa Kelengkapan Berkas Dan Input Data Primer Permohonan Izin', 'tanggal_selesai_entry' => '2021-04-09', 'tanggal_selesai_system' => '2021-04-09 10:37:59', 'kirim_ke' => 'Back Office', 'berkas_tolak_kirim_entry' => '2021-04-14', 'berkas_tolak_kirim_system' => '2021-04-14 08:35:46', 'catatan' => 'SUDH DINPUTING', 'status' => '2021-04-14 14:40:03', 'tanggal_terima_tolak' => '2021-04-14', 'penilaian_kepatuhan' => null, 'lambat_hari' => 0, 'lambat_jam' => 0, 'lambat_menit' => 0,],
            ['pos' => 3, 'tanggal_mulai_entry' => '2021-04-14', 'tanggal_mulai_system' => '2021-04-14 08:35:46', 'dari' => 'Back Office', 'nama_pengguna' => 'BO1', 'proses' => 'Cetak Surat Keputusan (SK)', 'tanggal_selesai_entry' => '2021-04-19', 'tanggal_selesai_system' => '2021-04-19 08:35:46', 'kirim_ke' => 'Pengambilan', 'berkas_tolak_kirim_entry' => '2021-05-03', 'berkas_tolak_kirim_system' => '2021-05-03 12:39:43', 'catatan' => 'SUDH DPROSES', 'status' => '2021-05-03 12:39:33', 'tanggal_terima_tolak' => '2021-05-03', 'penilaian_kepatuhan' => null, 'lambat_hari' => 10, 'lambat_jam' => 0, 'lambat_menit' => 7,],
            ['pos' => 4, 'tanggal_mulai_entry' => '2021-05-03', 'tanggal_mulai_system' => '2021-05-03 12:39:43', 'dari' => 'Pengambilan', 'nama_pengguna' => 'PG1', 'proses' => 'Mengembalikan Berkas ke Back Office', 'tanggal_selesai_entry' => '2021-05-03', 'tanggal_selesai_system' => '2021-05-03 12:39:43', 'kirim_ke' => null, 'berkas_tolak_kirim_entry' => null, 'berkas_tolak_kirim_system' => null, 'catatan' => 'DITERIMA PEMOHON', 'status' => '2021-05-03 12:39:43', 'tanggal_terima_tolak' => null, 'penilaian_kepatuhan' => null, 'lambat_hari' => 0, 'lambat_jam' => 0, 'lambat_menit' => 0,],
        ];
    }
}
