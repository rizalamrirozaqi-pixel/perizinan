<?php

namespace app\modules\admin\pendaftaran\pendaftaran\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DefaultController extends Controller
{
    const DUMMY_DATA_KEY = 'pendaftaran_dummy_data_v5';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
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
        $allData = $this->getDummyData();
        $search = Yii::$app->request->get('search');

        if (!empty($search)) {
            $filteredData = array_filter($allData, function ($item) use ($search) {
                $nomorDaftar = $item['nomor_daftar'] ?? '';
                $namaPemohon = $item['nama_pemohon'] ?? '';
                $namaUsaha = $item['nama_usaha'] ?? '';
                return stripos($nomorDaftar, $search) !== false ||
                    stripos($namaPemohon, $search) !== false ||
                    stripos($namaUsaha, $search) !== false;
            });
        } else {
            $filteredData = $allData;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'key' => 'id',
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'attributes' => ['id', 'nomor_daftar', 'nama_izin', 'nama_pemohon', 'nama_usaha', 'tanggal', 'waktu'],
                'defaultOrder' => [
                    'tanggal' => SORT_DESC,
                    'waktu' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('index', [
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

            // (FIX) Kita ambil data dari getDummyData()
            $allPendaftaran = $this->getDummyData();

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

    public function actionFormDaftar()
    {
        $dropdownData = $this->getDropdownData();
        $modelData = [];

        return $this->render('form-daftar', [
            'modelData' => $modelData,
            'isUpdate' => false,
            'defaultValues' => $this->getDefaultValues($modelData),
            'syaratItems' => $this->getSyaratItems(),
        ] + $dropdownData);
    }

    public function actionCreate()
    {
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            $newRecord = [
                'id' => microtime(true),
                'nomor_daftar' => 'REG-' . substr(str_replace('.', '', (string)microtime(true)), -5),
                'jenis_izin' => $postData['jenis_izin'] ?? null,
                'jenis_permohonan' => $postData['jenis_permohonan'] ?? null,
                'nama_usaha' => $postData['nama_usaha'] ?? null,
                'bidang_usaha' => $postData['bidang_usaha'] ?? null,
                'nama_pemohon' => $postData['nama_pemohon'] ?? null,
                'no_ktp' => $postData['no_ktp'] ?? null,
                'no_npwp' => $postData['no_npwp'] ?? null,
                'alamat' => $postData['alamat'] ?? null,
                'no_hp' => $postData['no_hp'] ?? null,
                'lokasi_usaha' => $postData['lokasi_usaha'] ?? null,
                'kecamatan' => $postData['kecamatan'] ?? null,
                'kelurahan' => $postData['kelurahan'] ?? null,
                'keterangan' => $postData['keterangan'] ?? null,
                'syarat' => $postData['syarat'] ?? [],
                'tanggal' => date('Y-m-d'),
                'waktu' => date('H:i:s'),
            ];
            $dropdownData = $this->getDropdownData();
            $newRecord['nama_izin'] = $dropdownData['jenisIzinItems'][$newRecord['jenis_izin']] ?? $newRecord['jenis_izin'];
            $newRecord['nama_permohonan'] = $dropdownData['jenisPermohonanItems'][$newRecord['jenis_permohonan']] ?? $newRecord['jenis_permohonan'];
            $data = $this->getDummyData();
            $data[] = $newRecord;
            $this->saveDummyData($data);
            Yii::$app->session->setFlash('success', 'Data pendaftaran berhasil disimpan.');
            return $this->redirect(['index']);
        }
        return $this->redirect(['form-daftar']);
    }

    public function actionUpdate($id)
    {
        $modelData = $this->findDummyModel($id);
        if ($modelData === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            $index = $this->findDummyModel($id, true);
            if ($index !== null) {
                $updatedRecord = [
                    'jenis_izin' => $postData['jenis_izin'] ?? null,
                    'jenis_permohonan' => $postData['jenis_permohonan'] ?? null,
                    'nama_usaha' => $postData['nama_usaha'] ?? null,
                    'bidang_usaha' => $postData['bidang_usaha'] ?? null,
                    'nama_pemohon' => $postData['nama_pemohon'] ?? null,
                    'no_ktp' => $postData['no_ktp'] ?? null,
                    'no_npwp' => $postData['no_npwp'] ?? null,
                    'alamat' => $postData['alamat'] ?? null,
                    'no_hp' => $postData['no_hp'] ?? null,
                    'lokasi_usaha' => $postData['lokasi_usaha'] ?? null,
                    'kecamatan' => $postData['kecamatan'] ?? null,
                    'kelurahan' => $postData['kelurahan'] ?? null,
                    'keterangan' => $postData['keterangan'] ?? null,
                    'syarat' => $postData['syarat'] ?? [],
                ];
                $dropdownData = $this->getDropdownData();
                $updatedRecord['nama_izin'] = $dropdownData['jenisIzinItems'][$updatedRecord['jenis_izin']] ?? $updatedRecord['jenis_izin'];
                $updatedRecord['nama_permohonan'] = $dropdownData['jenisPermohonanItems'][$updatedRecord['jenis_permohonan']] ?? $updatedRecord['jenis_permohonan'];
                $data = $this->getDummyData();
                $data[$index] = array_merge($data[$index], $updatedRecord);
                $this->saveDummyData($data);
                Yii::$app->session->setFlash('success', 'Data pendaftaran berhasil diperbarui.');
            } else {
                Yii::$app->session->setFlash('error', 'Gagal memperbarui data (index tidak ditemukan).');
            }
            return $this->redirect(['index']);
        }

        // --- BAGIAN GET (Membuka Halaman Update) ---
        return $this->render('form-daftar', [
            'modelData' => $modelData,
            'isUpdate' => true,
            'defaultValues' => $this->getDefaultValues($modelData),
            'syaratItems' => $this->getSyaratItems(),
        ] + $this->getDropdownData());
    }

    /**
     * FUNGSI COPY BARU
     * Membuka form-daftar dengan data yang sudah terisi
     */
    public function actionCopy($id)
    {
        $modelData = $this->findDummyModel($id);
        if ($modelData === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        // 1. Modifikasi data untuk 'copy'
        $modelData['nama_usaha'] = '(Salinan) ' . ($modelData['nama_usaha'] ?? '');
        unset($modelData['id']);
        unset($modelData['nomor_daftar']);

        // 2. Render form-daftar dalam mode 'create' ($isUpdate = false)
        //    tapi dengan 'defaultValues' yang sudah terisi
        return $this->render('form-daftar', [
            'modelData' => [], // <-- Penting: $isUpdate akan jadi false
            'isUpdate' => false,
            'defaultValues' => $this->getDefaultValues($modelData), // <-- Data kopian
            'syaratItems' => $this->getSyaratItems(),
        ] + $this->getDropdownData());
    }

    public function actionDelete($id)
    {
        $data = $this->getDummyData();
        $index = $this->findDummyModel($id, true);
        if ($index !== null) {
            unset($data[$index]);
            $this->saveDummyData(array_values($data));
            Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
        } else {
            Yii::$app->session->setFlash('error', 'Data gagal dihapus atau tidak ditemukan.');
        }
        return $this->redirect(['index']);
    }

    public function actionCetak($id)
    {
        $this->layout = false;
        $modelData = $this->findDummyModel($id);
        if ($modelData === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }
        $dropdownData = $this->getDropdownData();
        $namaKecamatan = $dropdownData['kecamatanItems'][$modelData['kecamatan']] ?? ($modelData['kecamatan'] ?? '-');
        $namaKelurahan = $dropdownData['kelurahanItems'][$modelData['kelurahan']] ?? ($modelData['kelurahan'] ?? '-');
        $tanggalFormatted = Yii::$app->formatter->asDate($modelData['tanggal'] ?? null, 'php:d M Y');
        $waktuFormatted = $modelData['waktu'] ?? '-';
        Yii::$app->response->format = Response::FORMAT_HTML;
        return $this->renderPartial('_cetak', [
            'modelData' => $modelData,
            'namaKecamatan' => $namaKecamatan,
            'namaKelurahan' => $namaKelurahan,
            'tanggalFormatted' => $tanggalFormatted,
            'waktuFormatted' => $waktuFormatted,
        ]);
    }

    // ===================================================================
    // FUNGSI HELPER BARU
    // ===================================================================

    protected function getSyaratItems()
    {
        // Dipindah dari view
        return [
            'syarat_1' => 'Surat Permohonan',
            'syarat_2' => 'Foto Copy KTP Pemilik Usaha',
            'syarat_3' => 'Gambar Tulisan Reklame atau Contoh Bentuk Reklamenya',
        ];
    }

    protected function getDefaultValues($modelData = [])
    {
        // Dipindah dari view
        return [
            'jenis_izin' => $modelData['jenis_izin'] ?? null,
            'jenis_permohonan' => $modelData['jenis_permohonan'] ?? null,
            'nama_usaha' => $modelData['nama_usaha'] ?? null,
            'bidang_usaha' => $modelData['bidang_usaha'] ?? null,
            'nama_pemohon' => $modelData['nama_pemohon'] ?? null,
            'no_ktp' => $modelData['no_ktp'] ?? null,
            'no_npwp' => $modelData['no_npwp'] ?? null,
            'alamat' => $modelData['alamat'] ?? null,
            'no_hp' => $modelData['no_hp'] ?? null,
            'lokasi_usaha' => $modelData['lokasi_usaha'] ?? null,
            'kecamatan' => $modelData['kecamatan'] ?? null,
            'kelurahan' => $modelData['kelurahan'] ?? null,
            'keterangan' => $modelData['keterangan'] ?? null,
            'syarat' => $modelData['syarat'] ?? [],
        ];
    }

    // ===================================================================
    // FUNGSI HELPER BAWAAN
    // ===================================================================

    protected function getDropdownData()
    {
        return [
            'jenisIzinItems' => ['IZIN_REKLAME' => 'Izin Penyelenggaraan Reklame', 'IZIN_A' => 'Izin A (Klinik)', 'IZIN_B' => 'Izin B (Apotek)', 'IZIN_C' => 'Izin C (Lainnya)',],
            'jenisPermohonanItems' => ['BARU' => 'BARU', 'PERPANJANGAN' => 'PERPANJANGAN', 'PERUBAHAN' => 'PERUBAHAN', 'PENCABUTAN' => 'PENCABUTAN',],
            'kecamatanItems' => ['KEC1' => 'Kecamatan Satu', 'KEC2' => 'Kecamatan Dua', 'KEC3' => 'Kecamatan Tiga'],
            'kelurahanItems' => ['KEL1' => 'Kelurahan A', 'KEL2' => 'Kelurahan B', 'KEL3' => 'Kelurahan C'],
        ];
    }

    protected function initDummyData()
    {
        $session = Yii::$app->session;
        $data = $session->get(self::DUMMY_DATA_KEY);
        if (empty($data)) {
            $dropdownData = $this->getDropdownData();
            // ... (Isi dummyJson Anda sudah benar, tidak perlu diubah) ...
            $dummyJson = '[
                {
                    "id": 1,
                    "nomor_daftar": "030004",
                    "jenis_izin": "IZIN_REKLAME",
                    "jenis_permohonan": "PENCABUTAN",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_REKLAME'] ?? 'Izin Penyelenggaraan Reklame') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['PENCABUTAN'] ?? 'PENCABUTAN') . '",
                    "nama_pemohon": "Budi Santoso",
                    "nama_usaha": "Toko Kelontong Berkah",
                    "bidang_usaha": "Perdagangan Eceran",
                    "tanggal": "2014-04-28",
                    "waktu": "10:00:00",
                    "no_ktp": "3310010020030004",
                    "no_npwp": "0123456789012345",
                    "no_hp": "08123456789",
                    "alamat": "Jl. Jend. Sudirman No. 10, Kebondalem, Pemalang",
                    "lokasi_usaha": "Jl. Jend. Sudirman No. 10, Kebondalem",
                    "kecamatan": "KEC1",
                    "kelurahan": "KEL1",
                    "keterangan": "Reklame 2x1m",
                    "syarat": ["syarat_1", "syarat_2", "syarat_3"]
                },
                {
                    "id": 2,
                    "nomor_daftar": "040005",
                    "jenis_izin": "IZIN_A",
                    "jenis_permohonan": "BARU",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_A'] ?? 'Izin A (Klinik)') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['BARU'] ?? 'BARU') . '",
                    "nama_pemohon": "Dr. Siti Aminah",
                    "nama_usaha": "Klinik Sehat Utama",
                    "bidang_usaha": "Jasa Kesehatan",
                    "tanggal": "2014-04-27",
                    "waktu": "10:01:00",
                    "no_ktp": "3310010020040005",
                    "no_npwp": "0123456789012346",
                    "no_hp": "08987654321",
                    "alamat": "Jl. A. Yani No. 12, Mulyoharjo, Pemalang",
                    "lokasi_usaha": "Jl. Ahmad Yani No. 1 (Depan Alun-alun)",
                    "kecamatan": "KEC2",
                    "kelurahan": "KEL2",
                    "keterangan": "Klinik Umum",
                    "syarat": ["syarat_1", "syarat_2"]
                },
                {
                    "id": 3,
                    "nomor_daftar": "050006",
                    "jenis_izin": "IZIN_B",
                    "jenis_permohonan": "PERPANJANGAN",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_B'] ?? 'Izin B (Apotek)') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['PERPANJANGAN'] ?? 'PERPANJANGAN') . '",
                    "nama_pemohon": "Andi Wijaya",
                    "nama_usaha": "Apotek Sumber Waras",
                    "bidang_usaha": "Perdagangan Farmasi",
                    "tanggal": "2014-04-26",
                    "waktu": "10:02:00",
                    "no_ktp": "3327030030050006",
                    "no_npwp": "0123456789012347",
                    "no_hp": "087712345678",
                    "alamat": "Jl. Surohadikusumo No. 55, Taman",
                    "lokasi_usaha": "Jl. Surohadikusumo No. 55, Beji",
                    "kecamatan": "KEC3",
                    "kelurahan": "KEL3",
                    "keterangan": "Perpanjangan tahunan",
                    "syarat": ["syarat_1", "syarat_2", "syarat_3"]
                },
                {
                    "id": 4,
                    "nomor_daftar": "060007",
                    "jenis_izin": "IZIN_C",
                    "jenis_permohonan": "BARU",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_C'] ?? 'Izin C (Lainnya)') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['BARU'] ?? 'BARU') . '",
                    "nama_pemohon": "Rina Kusuma",
                    "nama_usaha": "Warung Nasi Grombyang Pak Budi",
                    "bidang_usaha": "Kuliner",
                    "tanggal": "2014-04-25",
                    "waktu": "10:03:00",
                    "no_ktp": "3327010040060007",
                    "no_npwp": "0123456789012348",
                    "no_hp": "081223344556",
                    "alamat": "Jl. RE Martadinata No. 15, Pelutan, Pemalang",
                    "lokasi_usaha": "Jl. RE Martadinata No. 15 (Sebelah Toko A)",
                    "kecamatan": "KEC4",
                    "kelurahan": "KEL4",
                    "keterangan": "Warung makan baru",
                    "syarat": ["syarat_1", "syarat_2"]
                },
                {
                    "id": 5,
                    "nomor_daftar": "070008",
                    "jenis_izin": "IZIN_C",
                    "jenis_permohonan": "BARU",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_C'] ?? 'Izin C (Lainnya)') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['BARU'] ?? 'BARU') . '",
                    "nama_pemohon": "Slamet Riyadi",
                    "nama_usaha": "Rumah Tinggal",
                    "bidang_usaha": "Properti",
                    "tanggal": "2021-04-09",
                    "waktu": "10:04:00",
                    "no_ktp": "3310050050070008",
                    "no_npwp": "0123456789012349",
                    "no_hp": "081567890123",
                    "alamat": "Jl. Tentara Pelajar No. 8, Petarukan",
                    "lokasi_usaha": "Jl. Tentara Pelajar No. 8, Petarukan",
                    "kecamatan": "KEC5",
                    "kelurahan": "KEL5",
                    "keterangan": "Rumah tinggal 2 lantai",
                    "syarat": ["syarat_1", "syarat_2", "syarat_3"]
                },
                {
                    "id": 6,
                    "nomor_daftar": "080009",
                    "jenis_izin": "IZIN_A",
                    "jenis_permohonan": "BARU",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_A'] ?? 'Izin A (Klinik)') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['BARU'] ?? 'BARU') . '",
                    "nama_pemohon": "DR. BUDIMAN",
                    "nama_usaha": "Klinik Pribadi",
                    "bidang_usaha": "Jasa Kesehatan",
                    "tanggal": "2024-01-24",
                    "waktu": "10:05:00",
                    "no_ktp": "3327010101800001",
                    "no_npwp": "0123456789012350",
                    "no_hp": "081987654321",
                    "alamat": "Jl. Melati No. 1, Pemalang",
                    "lokasi_usaha": "Jl. Melati No. 1, Mulyoharjo",
                    "kecamatan": "KEC2",
                    "kelurahan": "KEL2",
                    "keterangan": "Praktik Umum",
                    "syarat": ["syarat_1", "syarat_2"]
                },
                {
                    "id": 7,
                    "nomor_daftar": "090010",
                    "jenis_izin": "IZIN_A",
                    "jenis_permohonan": "BARU",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_A'] ?? 'Izin A (Klinik)') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['BARU'] ?? 'BARU') . '",
                    "nama_pemohon": "DR. ANITA DEWI",
                    "nama_usaha": "Klinik Pribadi",
                    "bidang_usaha": "Jasa Kesehatan",
                    "tanggal": "2024-01-25",
                    "waktu": "10:06:00",
                    "no_ktp": "3327010202810002",
                    "no_npwp": "0123456789012351",
                    "no_hp": "081987654322",
                    "alamat": "Jl. Pemuda No. 20, Pemalang",
                    "lokasi_usaha": "Jl. Pemuda No. 20, Mulyoharjo",
                    "kecamatan": "KEC2",
                    "kelurahan": "KEL2",
                    "keterangan": "Praktik Gigi",
                    "syarat": ["syarat_1", "syarat_2", "syarat_3"]
                },
                {
                    "id": 8,
                    "nomor_daftar": "100011",
                    "jenis_izin": "IZIN_C",
                    "jenis_permohonan": "BARU",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_C'] ?? 'Izin C (Lainnya)') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['BARU'] ?? 'BARU') . '",
                    "nama_pemohon": "CV. USAHA MAKMUR",
                    "nama_usaha": "Usaha Transportasi",
                    "bidang_usaha": "Transportasi",
                    "tanggal": "2024-01-26",
                    "waktu": "10:07:00",
                    "no_ktp": "3327020303820003",
                    "no_npwp": "0123456789012352",
                    "no_hp": "081987654323",
                    "alamat": "Jl. Raya Petarukan No. 50",
                    "lokasi_usaha": "Jl. Raya Petarukan No. 50",
                    "kecamatan": "KEC5",
                    "kelurahan": "KEL5",
                    "keterangan": "Usaha Mikro Transportasi",
                    "syarat": ["syarat_1", "syarat_2"]
                }
            ]';
            $dummyData = json_decode($dummyJson, true);
            $session->set(self::DUMMY_DATA_KEY, $dummyData);
        }
    }

    protected function getDummyData()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY, []);
    }

    protected function saveDummyData(array $data)
    {
        Yii::$app->session->set(self::DUMMY_DATA_KEY, array_values($data));
    }

    protected function findDummyModel($id, $returnIndex = false)
    {
        $data = $this->getDummyData();
        foreach ($data as $index => $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                return $returnIndex ? $index : $item;
            }
        }
        return null;
    }
}
