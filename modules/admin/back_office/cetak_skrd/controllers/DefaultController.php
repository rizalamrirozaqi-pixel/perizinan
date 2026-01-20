<?php

namespace app\modules\admin\back_office\cetak_skrd\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `cetak_skrd` module
 */
class DefaultController extends Controller
{

    // Data Pendaftaran Dummy Lokal
    const DUMMY_DATA_PENDAFTARAN = [
        [
            'id' => 1,
            'nomor_daftar' => '030004',
            'nama_izin' => 'Izin Penyelenggaraan Reklame',
            'jenis_permohonan' => 'PENCABUTAN',
            'nama_pemohon' => 'Budi Santoso',
            'no_ktp_npwp' => '3327010020030004 / 0123456789012345',
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
            'no_ktp_npwp' => '3327020020040005 / 0123456789012346',
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
            'nomor_daftar' => '2137/04/2021',
            'nama_izin' => 'Izin Mendirikan Bangunan (IMB)',
            'jenis_permohonan' => 'BARU',
            'nama_pemohon' => 'Slamet Riyadi',
            'nama_usaha' => 'Rumah Tinggal',
            'no_ktp_npwp' => '3327040050070008 / 0123456789012349',
            'alamat' => 'Jl. Tentara Pelajar No. 8, Petarukan',
            'lokasi_usaha' => 'Jl. Tentara Pelajar No. 8, Petarukan',
            'kecamatan' => 'Petarukan',
            'kelurahan' => 'Petarukan',
            'keterangan' => 'Rumah tinggal 2 lantai',
            'tanggal_daftar' => '2021-04-09',
            'telepon' => '081567890123'
        ],
    ];

    // Session key SKRD
    const DUMMY_DATA_KEY_SKRD = 'skrd_dummy_data_v3'; // v2 as per your code

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'simpan-skr' => ['POST'],
                    'log' => ['GET'],
                    'index' => ['GET'],
                    'cetak' => ['GET'],
                    'cetak-word' => ['GET'],
                    'delete' => ['POST'],
                    'search-pendaftaran' => ['GET'], // <-- (FIX) Tambahan action
                    'search-skrd' => ['GET'],       // <-- (FIX) Tambahan action
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

    public function actionIndex($search_pendaftaran = null, $search_skrd = null)
    {
        $modelPendaftaran = null;
        $modelSkr = null;
        $isSearch = !empty($search_pendaftaran);

        if ($isSearch) {
            $modelPendaftaran = $this->findPendaftaranModelBySearch($search_pendaftaran);
            if ($modelPendaftaran !== null) {
                $modelSkr = $this->findSkrModelByPendaftaranId($modelPendaftaran['id']);
            } else {
                Yii::$app->session->setFlash('warning', 'Data pendaftaran tidak ditemukan.');
            }
        }

        $allSkrData = $this->getDummyDataWithPendaftaran();
        $filteredSkrData = $allSkrData;

        if (!empty($search_skrd)) {
            $term = strtolower($search_skrd);
            $filteredSkrData = array_filter($filteredSkrData, function ($item) use ($term) {
                return stripos($item['nama_pemohon'] ?? '', $term) !== false ||
                    stripos($item['nama_usaha'] ?? '', $term) !== false ||
                    stripos($item['nomor_skrd'] ?? '', $term) !== false;
            });
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredSkrData,
            'key' => 'skrd_id',
            'pagination' => ['pageSize' => 5],
            'sort' => [
                'attributes' => ['nomor_skrd', 'tanggal_skrd', 'nama_pemohon', 'nama_usaha', 'total_retribusi'],
                'defaultOrder' => ['tanggal_skrd' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'search_pendaftaran' => $search_pendaftaran,
            'search_skrd' => $search_skrd,
            'modelPendaftaran' => $modelPendaftaran,
            'modelSkr' => $modelSkr,
            'isSearch' => $isSearch,
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
        ]);
    }

    /**
     * (FIX BARU) Action untuk autocomplete search pendaftaran
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
                    $value = $nomorDaftar; // Submit nomor daftar

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
     * (FIX BARU) Action untuk autocomplete search SKRD
     */
    public function actionSearchSkrd($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $results = [];

        if (!empty($term)) {
            $term = strtolower($term);
            $allSkrData = $this->getDummyDataWithPendaftaran(); // Ambil data gabungan

            foreach ($allSkrData as $item) {
                $nomorSkrd = $item['nomor_skrd'] ?? '';
                $namaPemohon = $item['nama_pemohon'] ?? '';
                $namaUsaha = $item['nama_usaha'] ?? '';

                if (stripos($nomorSkrd, $term) !== false || stripos($namaPemohon, $term) !== false || stripos($namaUsaha, $term) !== false) {
                    $label = "{$nomorSkrd} - {$namaPemohon}" . (!empty($namaUsaha) ? " ({$namaUsaha})" : "");
                    $value = $nomorSkrd; // Submit nomor SKRD

                    $results[] = [
                        'label' => $label,
                        'value' => $value,
                    ];
                }
            }
            // Pastikan unik jika ada duplikat
            $results = array_map("unserialize", array_unique(array_map("serialize", $results)));
        }
        return array_values($results);
    }


    public function actionSimpanSkr($pendaftaran_id)
    {
        $modelPendaftaran = $this->findPendaftaranModelById($pendaftaran_id);
        if ($modelPendaftaran === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            $saveData = [
                'pendaftaran_id' => $pendaftaran_id,
                'nomor_skr' => $postData['nomor_skr'] ?? null,
                'tanggal_jatuh_tempo' => $postData['tanggal_jatuh_tempo'] ?? null,
                'tanggal_skr' => $postData['tanggal_skr'] ?? null,
                'masa' => $postData['masa'] ?? null,
                'npwr' => $postData['npwr'] ?? null,
                'nilai_retribusi' => $postData['nilai_retribusi'] ?? 0,
                'denda' => $postData['denda'] ?? 0,
                'nilai_pengurangan' => $postData['nilai_pengurangan'] ?? 0,
                'nilai_pembulatan' => $postData['nilai_pembulatan'] ?? 0,
            ];
            $this->saveSkrData($saveData);
            Yii::$app->session->setFlash('success', 'Data SKR berhasil disimpan.');
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
        return $this->renderPartial('_lembar_kendali', [
            'model' => $model,
            'logData' => $logData,
        ]);
    }

    public function actionCetak($skrd_id)
    {
        $modelSkr = $this->findSkrModelById($skrd_id);
        if ($modelSkr === null) {
            throw new NotFoundHttpException('Data SKRD tidak ditemukan.');
        }
        $modelPendaftaran = $this->findPendaftaranModelById($modelSkr['pendaftaran_id']);
        if ($modelPendaftaran === null) {
            throw new NotFoundHttpException('Data pendaftaran terkait tidak ditemukan.');
        }

        $rincianData = [
            'pokok' => $modelSkr['nilai_retribusi'] ?? 0,
            'sanksi_denda' => $modelSkr['denda'] ?? 0,
            'kenaikan' => 0,
            'pembulatan' => $modelSkr['pembulatan'] ?? 0,
        ];
        $rincianData['keseluruhan'] = $rincianData['pokok'] + $rincianData['sanksi_denda'] + $rincianData['kenaikan'] + $rincianData['pembulatan'];

        $this->layout = false;
        return $this->renderPartial('_cetak_skrd', [
            'model' => $modelPendaftaran,
            'modelSkr' => $modelSkr,
            'rincianData' => $rincianData,
        ]);
    }

    public function actionCetakWord($skrd_id)
    {
        Yii::$app->session->setFlash('info', "Cetak Word untuk SKRD ID: {$skrd_id} (belum diimplementasikan).");
        // PERBAIKAN: Redirect ke index
        return $this->redirect(['index']);
    }

    public function actionDelete($skrd_id)
    {
        $allSkr = $this->getDummyData();
        if (isset($allSkr[$skrd_id])) {
            unset($allSkr[$skrd_id]);
            $this->saveDummyData($allSkr);
            Yii::$app->session->setFlash('success', 'Data SKRD berhasil dihapus (simulasi).');
        } else {
            Yii::$app->session->setFlash('error', 'Data SKRD tidak ditemukan.');
        }
        // PERBAIKAN: Redirect ke index
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
        if (empty($session->get(self::DUMMY_DATA_KEY_SKRD))) {
            $session->set(self::DUMMY_DATA_KEY_SKRD, [
                1 => ['skrd_id' => 1, 'pendaftaran_id' => 5, 'nomor_skr' => '003/IMB/12/2020', 'tanggal_jatuh_tempo' => '2021-01-19', 'tanggal_skr' => '2020-12-20', 'masa' => '2020', 'npwr' => '1005600', 'nilai_retribusi' => 485166, 'denda' => 0, 'nilai_pengurangan' => 0, 'nilai_pembulatan' => 834,],
                2 => ['skrd_id' => 2, 'pendaftaran_id' => 3, 'nomor_skr' => '004/APT/07/2021', 'tanggal_jatuh_tempo' => '2021-08-20', 'tanggal_skr' => '2021-07-21', 'masa' => '2021', 'npwr' => '1005601', 'nilai_retribusi' => 2425354, 'denda' => 0, 'nilai_pengurangan' => 0, 'nilai_pembulatan' => 446,],
                3 => ['skrd_id' => 3, 'pendaftaran_id' => 1, 'nomor_skr' => '005/REK/07/2021', 'tanggal_jatuh_tempo' => '2021-08-22', 'tanggal_skr' => '2021-07-23', 'masa' => '2021', 'npwr' => '1005602', 'nilai_retribusi' => 3109683, 'denda' => 0, 'nilai_pengurangan' => 0, 'nilai_pembulatan' => 317,],
                4 => ['skrd_id' => 4, 'pendaftaran_id' => 4, 'nomor_skr' => '006/RM/07/2021', 'tanggal_jatuh_tempo' => '2021-08-29', 'tanggal_skr' => '2021-07-30', 'masa' => '2021', 'npwr' => '1005603', 'nilai_retribusi' => 5384736, 'denda' => 0, 'nilai_pengurangan' => 0, 'nilai_pembulatan' => 264,],
                5 => ['skrd_id' => 5, 'pendaftaran_id' => 5, 'nomor_skr' => '007/IMB/07/2021', 'tanggal_jatuh_tempo' => '2021-08-29', 'tanggal_skr' => '2021-07-30', 'masa' => '2021', 'npwr' => '1005605', 'nilai_retribusi' => 4309472, 'denda' => 0, 'nilai_pengurangan' => 0, 'nilai_pembulatan' => 528,],
                6 => ['skrd_id' => 6, 'pendaftaran_id' => 5, 'nomor_skr' => '008/IMB/07/2021', 'tanggal_jatuh_tempo' => '2021-08-28', 'tanggal_skr' => '2021-07-29', 'masa' => '2021', 'npwr' => '1005606', 'nilai_retribusi' => 2221204, 'denda' => 0, 'nilai_pengurangan' => 0, 'nilai_pembulatan' => 796,],
                7 => ['skrd_id' => 7, 'pendaftaran_id' => 5, 'nomor_skr' => '009/IMB/07/2021', 'tanggal_jatuh_tempo' => '2021-08-28', 'tanggal_skr' => '2021-07-29', 'masa' => '2021', 'npwr' => '1005607', 'nilai_retribusi' => 2360029, 'denda' => 0, 'nilai_pengurangan' => 0, 'nilai_pembulatan' => 971,],
                8 => ['skrd_id' => 8, 'pendaftaran_id' => 5, 'nomor_skr' => '010/IMB/07/2021', 'tanggal_jatuh_tempo' => '2021-08-28', 'tanggal_skr' => '2021-07-29', 'masa' => '2021', 'npwr' => '1005608', 'nilai_retribusi' => 2393442, 'denda' => 0, 'nilai_pengurangan' => 0, 'nilai_pembulatan' => 558,],
                9 => ['skrd_id' => 9, 'pendaftaran_id' => 5, 'nomor_skr' => '011/IMB/07/2021', 'tanggal_jatuh_tempo' => '2021-08-28', 'tanggal_skr' => '2021-07-29', 'masa' => '2021', 'npwr' => '1005609', 'nilai_retribusi' => 881430, 'denda' => 0, 'nilai_pengurangan' => 0, 'nilai_pembulatan' => 570,],
                10 => ['skrd_id' => 10, 'pendaftaran_id' => 5, 'nomor_skr' => '012/IMB/07/2021', 'tanggal_jatuh_tempo' => '2021-08-26', 'tanggal_skr' => '2021-07-27', 'masa' => '2021', 'npwr' => '1005610', 'nilai_retribusi' => 2298646, 'denda' => 0, 'nilai_pengurangan' => 0, 'nilai_pembulatan' => 354,],
            ]);
        }
    }
    protected function getDummyData()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY_SKRD, []);
    }
    protected function saveDummyData(array $data)
    {
        Yii::$app->session->set(self::DUMMY_DATA_KEY_SKRD, $data);
    }
    protected function findSkrModelById($skrd_id)
    {
        $allData = $this->getDummyData();
        return $allData[$skrd_id] ?? null;
    }
    protected function findSkrModelByPendaftaranId($pendaftaranId)
    {
        $allData = $this->getDummyData();
        foreach ($allData as $item) {
            if (isset($item['pendaftaran_id']) && $item['pendaftaran_id'] == $pendaftaranId) {
                return $item;
            }
        }
        return null;
    }
    protected function saveSkrData(array $data)
    {
        if (empty($data['pendaftaran_id'])) return;
        $allData = $this->getDummyData();
        $existingSkr = $this->findSkrModelByPendaftaranId($data['pendaftaran_id']);
        if ($existingSkr) {
            $skrd_id = $existingSkr['skrd_id'];
            $data['skrd_id'] = $skrd_id;
            $allData[$skrd_id] = $data;
        } else {
            $newId = empty($allData) ? 1 : max(array_keys($allData)) + 1;
            $data['skrd_id'] = $newId;
            $allData[$newId] = $data;
        }
        $this->saveDummyData($allData);
    }

    protected function getDummyDataWithPendaftaran()
    {
        $skrData = $this->getDummyData();
        $pendaftaranData = self::DUMMY_DATA_PENDAFTARAN;
        $pendaftaranMap = ArrayHelper::index($pendaftaranData, 'id');
        $combinedData = [];
        foreach ($skrData as $skr) {
            $pendaftaranId = $skr['pendaftaran_id'] ?? null;
            $pendaftaranInfo = $pendaftaranMap[$pendaftaranId] ?? [];
            // PERBAIKAN: Hapus 'kenaikan' dari total jika tidak ada di data
            $total = ($skr['nilai_retribusi'] ?? 0) + ($skr['denda'] ?? 0) + ($skr['pembulatan'] ?? 0);
            $combinedData[] = array_merge($pendaftaranInfo, $skr, [
                'nama_usaha_bangunan' => $pendaftaranInfo['nama_usaha'] ?? 'N/A',
                'lokasi_izin' => $pendaftaranInfo['kecamatan'] ?? 'N/A',
                'nomor_skrd' => $skr['nomor_skr'] ?? 'N/A',
                'tanggal_skrd' => $skr['tanggal_skr'] ?? 'N/A',
                'total_retribusi' => $total,
            ]);
        }
        return $combinedData;
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
