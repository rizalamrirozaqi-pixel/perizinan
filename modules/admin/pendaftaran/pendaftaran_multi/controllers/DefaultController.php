<?php

namespace app\modules\admin\pendaftaran\pendaftaran_multi\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DefaultController extends Controller
{
    const DUMMY_DATA_KEY = 'pendaftaran_dummy_data_v6';
    const DUMMY_DATA_KEY_2 = 'pendaftaran_izin_dummy_data_v1';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'tambah-izin' => ['POST'],
                    'delete-izin' => ['POST'],
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
        $this->initDummyData2();
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
                $noKtp = $item['no_ktp'] ?? '';
                $noKk = $item['no_kk'] ?? '';

                return stripos($nomorDaftar, $search) !== false ||
                    stripos($namaPemohon, $search) !== false ||
                    stripos($namaUsaha, $search) !== false ||
                    stripos($noKtp, $search) !== false ||
                    stripos($noKk, $search) !== false;
            });
        } else {
            $filteredData = $allData;
        }

        // Opsional: Tambahkan hitungan jumlah izin ke model untuk ditampilkan di grid
        foreach ($filteredData as $key => $item) {
            $filteredData[$key]['jumlah_izin'] = count($item['izin_items'] ?? []);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'key' => 'id',
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                // Tambahkan 'jumlah_izin' jika Anda ingin bisa sort berdasarkan itu
                'attributes' => ['id', 'nomor_daftar', 'nama_izin', 'nama_pemohon', 'nama_usaha', 'tanggal', 'waktu', 'no_ktp', 'no_kk', 'jumlah_izin'],
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
        // Kosongkan session izin sementara saat membuat data baru
        $this->saveDummyData2([]);

        $dropdownData = $this->getDropdownData();
        $modelData = [];
        $defaultValues = $this->getDefaultValues($modelData);
        $syaratItems = $this->getSyaratItems();
        $data = $this->getDummyData2(); // Ini sekarang akan selalu [] (kosong)

        return $this->render('form-daftar', [
            'modelData' => $modelData,
            'defaultValues' => $defaultValues,
            'syaratItems' => $syaratItems,
            'data' => $data,
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
                'no_kk' => $postData['no_kk'] ?? null,
                'alamat' => $postData['alamat'] ?? null,
                'no_hp' => $postData['no_hp'] ?? null,
                'lokasi_usaha' => $postData['lokasi_usaha'] ?? null,
                'kecamatan' => $postData['kecamatan'] ?? null,
                'kelurahan' => $postData['kelurahan'] ?? null,
                'keterangan' => $postData['keterangan'] ?? null,
                'syarat' => $postData['syarat'] ?? [],
                'tanggal' => date('Y-m-d'),
                'waktu' => date('H:i:s'),
                // Simpan daftar izin dari session sementara ke record utama
                'izin_items' => $this->getDummyData2(),
            ];
            $dropdownData = $this->getDropdownData();
            $newRecord['nama_izin'] = $dropdownData['jenisIzinItems'][$newRecord['jenis_izin']] ?? $newRecord['jenis_izin'];
            $newRecord['nama_permohonan'] = $dropdownData['jenisPermohonanItems'][$newRecord['jenis_permohonan']] ?? $newRecord['jenis_permohonan'];

            $data = $this->getDummyData();
            $data[] = $newRecord;
            $this->saveDummyData($data);

            // Bersihkan session sementara setelah disimpan
            $this->saveDummyData2([]);

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
                    'no_kk' => $postData['no_kk'] ?? null,
                    'alamat' => $postData['alamat'] ?? null,
                    'no_hp' => $postData['no_hp'] ?? null,
                    'lokasi_usaha' => $postData['lokasi_usaha'] ?? null,
                    'kecamatan' => $postData['kecamatan'] ?? null,
                    'kelurahan' => $postData['kelurahan'] ?? null,
                    'keterangan' => $postData['keterangan'] ?? null,
                    'syarat' => $postData['syarat'] ?? [],
                    // Simpan daftar izin dari session sementara kembali ke record utama
                    'izin_items' => $this->getDummyData2(),
                ];
                $dropdownData = $this->getDropdownData();
                $updatedRecord['nama_izin'] = $dropdownData['jenisIzinItems'][$updatedRecord['jenis_izin']] ?? $updatedRecord['jenis_izin'];
                $updatedRecord['nama_permohonan'] = $dropdownData['jenisPermohonanItems'][$updatedRecord['jenis_permohonan']] ?? $updatedRecord['jenis_permohonan'];

                $data = $this->getDummyData();
                $data[$index] = array_merge($data[$index], $updatedRecord);
                $this->saveDummyData($data);

                // Bersihkan session sementara setelah disimpan
                $this->saveDummyData2([]);

                Yii::$app->session->setFlash('success', 'Data pendaftaran berhasil diperbarui.');
            } else {
                Yii::$app->session->setFlash('error', 'Gagal memperbarui data (index tidak ditemukan).');
            }
            return $this->redirect(['index']);
        }

        // --- BAGIAN GET (Saat Membuka Halaman Update) ---

        // Ambil daftar izin yang TERSIMPAN di record ini
        $izinItems = $modelData['izin_items'] ?? [];

        // Masukkan daftar izin tsb ke session sementara (DUMMY_DATA_KEY_2)
        $this->saveDummyData2($izinItems);

        $defaultValues = $this->getDefaultValues($modelData);
        $syaratItems = $this->getSyaratItems();

        // Ambil data dari session sementara (yang baru saja kita isi)
        $data = $this->getDummyData2(); // <-- Ini adalah $izinItems

        return $this->render('form-daftar', [
            'modelData' => $modelData,
            'defaultValues' => $defaultValues,
            'syaratItems' => $syaratItems,
            'data' => $data, // <-- INI ADALAH PERBAIKAN UNTUK ERROR ANDA
        ] + $this->getDropdownData());
    }

    /**
     * FUNGSI COPY YANG BARU
     * Membuka form-daftar dengan data yang sudah terisi
     */
    public function actionCopy($id)
    {
        $modelData = $this->findDummyModel($id);
        if ($modelData === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        // --- INI ADALAH LOGIKA BARU UNTUK COPY ---

        // 1. Ubah data yang akan di-copy
        $modelData['nama_usaha'] = '(Salinan) ' . ($modelData['nama_usaha'] ?? '');

        // 2. Kosongkan ID & nomor daftar (akan digenerate baru saat 'create')
        unset($modelData['id']);
        unset($modelData['nomor_daftar']);

        // 3. Ambil daftar izin yang TERSIMPAN di record ini
        $izinItems = $modelData['izin_items'] ?? [];

        // 4. Masukkan daftar izin tsb ke session sementara (DUMMY_DATA_KEY_2)
        //    sehingga tabel izin di form juga ikut terisi
        $this->saveDummyData2($izinItems);

        // 5. Siapkan variabel untuk view
        $defaultValues = $this->getDefaultValues($modelData); // Ini akan mengisi form
        $syaratItems = $this->getSyaratItems();

        // 6. Ambil data izin dari session sementara (yang baru saja kita isi)
        $data = $this->getDummyData2();

        // 7. Render 'form-daftar'
        // Penting: 'modelData' di-passing sebagai array kosong agar $isUpdate = false
        // Form akan mengarah ke action 'create' tapi sudah terisi data dari 'defaultValues'
        return $this->render('form-daftar', [
            'modelData' => [], // <-- PENTING: kirim array kosong agar $isUpdate = false
            'defaultValues' => $defaultValues, // <-- Ini yang berisi data kopian
            'syaratItems' => $syaratItems,
            'data' => $data,
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
            'modelData' => $modelData, // modelData sekarang berisi 'izin_items'
            'namaKecamatan' => $namaKecamatan,
            'namaKelurahan' => $namaKelurahan,
            'tanggalFormatted' => $tanggalFormatted,
            'waktuFormatted' => $waktuFormatted,
        ]);
    }

    // ===================================================================
    // AKSI BARU UNTUK TAMBAH/HAPUS IZIN (AJAX/SESSION)
    // ===================================================================

    public function actionTambahIzin()
    {
        // Wajib POST
        if (!Yii::$app->request->isPost) {
            return $this->redirect(Yii::$app->request->referrer ?? ['form-daftar']);
        }

        $postData = Yii::$app->request->post();
        $jenisIzin = $postData['jenis_izin'] ?? null;
        $jenisPermohonan = $postData['jenis_permohonan'] ?? null;

        // Validasi sederhana
        if (!empty($jenisIzin) && !empty($jenisPermohonan)) {
            $dropdownData = $this->getDropdownData();
            $dataIzin = $this->getDummyData2(); // Ambil list yg ada

            // Tambahkan item baru
            $dataIzin[] = [
                'id' => 'izin_' . microtime(true), // ID unik baru
                'jenis_izin_id' => $jenisIzin, // Simpan ID-nya
                'jenis_permohonan_id' => $jenisPermohonan, // Simpan ID-nya
                'jenis_izin' => $dropdownData['jenisIzinItems'][$jenisIzin] ?? $jenisIzin,
                'jenis_permohonan' => $dropdownData['jenisPermohonanItems'][$jenisPermohonan] ?? $jenisPermohonan,
            ];

            $this->saveDummyData2($dataIzin); // Simpan kembali ke session sementara
        } else {
            Yii::$app->session->setFlash('error', 'Jenis Izin dan Jenis Permohonan wajib dipilih untuk ditambahkan.');
        }

        // Kembali ke halaman form sebelumnya (bisa create atau update)
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeleteIzin($id)
    {
        Yii::$app->request->enableCsrfValidation = true;
        if (!Yii::$app->request->isPost) {
            throw new \yii\web\BadRequestHttpException('Metode tidak diizinkan.');
        }

        $data = $this->getDummyData2();
        $indexToDelete = null;

        foreach ($data as $index => $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                $indexToDelete = $index;
                break;
            }
        }

        if ($indexToDelete !== null) {
            unset($data[$indexToDelete]);
            $this->saveDummyData2(array_values($data)); // Gunakan saveDummyData2
            Yii::$app->session->setFlash('success', 'Item izin berhasil dihapus.');
        } else {
            Yii::$app->session->setFlash('error', 'Item izin tidak ditemukan.');
        }

        // Kembali ke halaman form sebelumnya
        return $this->redirect(Yii::$app->request->referrer ?? ['form-daftar']);
    }


    // ===================================================================
    // FUNGSI HELPER (DATA DUMMY, DROPDOWN, DLL)
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
                    "no_kk": "3310010101050001",
                    "no_hp": "08123456789",
                    "alamat": "Jl. Jend. Sudirman No. 10, Kebondalem, Pemalang",
                    "lokasi_usaha": "Jl. Jend. Sudirman No. 10, Kebondalem",
                    "kecamatan": "KEC1",
                    "kelurahan": "KEL1",
                    "keterangan": "Reklame 2x1m",
                    "syarat": ["syarat_1", "syarat_2", "syarat_3"],
                    "izin_items": [
                        {"id": "izin_1.1", "jenis_izin_id": "IZIN_REKLAME", "jenis_permohonan_id": "PENCABUTAN", "jenis_izin": "Izin Penyelenggaraan Reklame", "jenis_permohonan": "PENCABUTAN"}
                    ]
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
                    "no_kk": "3310020202060002",
                    "no_hp": "08987654321",
                    "alamat": "Jl. A. Yani No. 12, Mulyoharjo, Pemalang",
                    "lokasi_usaha": "Jl. Ahmad Yani No. 1 (Depan Alun-alun)",
                    "kecamatan": "KEC2",
                    "kelurahan": "KEL2",
                    "keterangan": "Klinik Umum",
                    "syarat": ["syarat_1", "syarat_2"],
                    "izin_items": [
                        {"id": "izin_2.1", "jenis_izin_id": "IZIN_A", "jenis_permohonan_id": "BARU", "jenis_izin": "Izin A (Klinik)", "jenis_permohonan": "BARU"},
                        {"id": "izin_2.2", "jenis_izin_id": "IZIN_B", "jenis_permohonan_id": "BARU", "jenis_izin": "Izin B (Apotek)", "jenis_permohonan": "BARU"}
                    ]
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
                    "no_kk": "3310030303070003",
                    "no_hp": "087712345678",
                    "alamat": "Jl. Surohadikusumo No. 55, Taman",
                    "lokasi_usaha": "Jl. Surohadikusumo No. 55, Beji",
                    "kecamatan": "KEC3",
                    "kelurahan": "KEL3",
                    "keterangan": "Perpanjangan tahunan",
                    "syarat": ["syarat_1", "syarat_2", "syarat_3"],
                    "izin_items": []
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
                    "no_kk": "3310040404080004",
                    "no_hp": "081223344556",
                    "alamat": "Jl. RE Martadinata No. 15, Pelutan, Pemalang",
                    "lokasi_usaha": "Jl. RE Martadinata No. 15 (Sebelah Toko A)",
                    "kecamatan": "KEC1",
                    "kelurahan": "KEL1",
                    "keterangan": "Warung makan baru",
                    "syarat": ["syarat_1", "syarat_2"],
                    "izin_items": []
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
                    "no_kk": "3310050505090005",
                    "no_hp": "081567890123",
                    "alamat": "Jl. Tentara Pelajar No. 8, Petarukan",
                    "lokasi_usaha": "Jl. Tentara Pelajar No. 8, Petarukan",
                    "kecamatan": "KEC3",
                    "kelurahan": "KEL3",
                    "keterangan": "Rumah tinggal 2 lantai",
                    "syarat": ["syarat_1", "syarat_2", "syarat_3"],
                    "izin_items": []
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
                    "no_kk": "3310010101800001",
                    "no_hp": "081987654321",
                    "alamat": "Jl. Melati No. 1, Pemalang",
                    "lokasi_usaha": "Jl. Melati No. 1, Mulyoharjo",
                    "kecamatan": "KEC2",
                    "kelurahan": "KEL2",
                    "keterangan": "Praktik Umum",
                    "syarat": ["syarat_1", "syarat_2"],
                    "izin_items": [
                        {"id": "izin_6.1", "jenis_izin_id": "IZIN_A", "jenis_permohonan_id": "BARU", "jenis_izin": "Izin A (Klinik)", "jenis_permohonan": "BARU"}
                    ]
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
                    "no_kk": "3310010202810002",
                    "no_hp": "081987654322",
                    "alamat": "Jl. Pemuda No. 20, Pemalang",
                    "lokasi_usaha": "Jl. Pemuda No. 20, Mulyoharjo",
                    "kecamatan": "KEC2",
                    "kelurahan": "KEL2",
                    "keterangan": "Praktik Gigi",
                    "syarat": ["syarat_1", "syarat_2", "syarat_3"],
                    "izin_items": []
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
                    "no_kk": "3310030303820003",
                    "no_hp": "081987654323",
                    "alamat": "Jl. Raya Petarukan No. 50",
                    "lokasi_usaha": "Jl. Raya Petarukan No. 50",
                    "kecamatan": "KEC3",
                    "kelurahan": "KEL3",
                    "keterangan": "Usaha Mikro Transportasi",
                    "syarat": ["syarat_1", "syarat_2"],
                    "izin_items": []
                },
                {
                    "id": 9,
                    "nomor_daftar": "110012",
                    "jenis_izin": "IZIN_REKLAME",
                    "jenis_permohonan": "BARU",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_REKLAME'] ?? 'Izin Penyelenggaraan Reklame') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['BARU'] ?? 'BARU') . '",
                    "nama_pemohon": "Agus Setiawan",
                    "nama_usaha": "Bengkel Jaya Motor",
                    "bidang_usaha": "Otomotif",
                    "tanggal": "2025-01-15",
                    "waktu": "09:30:00",
                    "no_ktp": "3310060060080009",
                    "no_npwp": "0123456789012353",
                    "no_kk": "3310060606080009",
                    "no_hp": "081345678912",
                    "alamat": "Jl. Gajah Mada No. 100, Pemalang",
                    "lokasi_usaha": "Jl. Gajah Mada No. 100, Pemalang",
                    "kecamatan": "KEC1",
                    "kelurahan": "KEL1",
                    "keterangan": "Papan nama bengkel",
                    "syarat": ["syarat_1", "syarat_2"],
                    "izin_items": []
                },
                {
                    "id": 10,
                    "nomor_daftar": "120013",
                    "jenis_izin": "IZIN_C",
                    "jenis_permohonan": "BARU",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_C'] ?? 'Izin C (Lainnya)') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['BARU'] ?? 'BARU') . '",
                    "nama_pemohon": "Dewi Lestari",
                    "nama_usaha": "Salon Cantika",
                    "bidang_usaha": "Jasa Kecantikan",
                    "tanggal": "2025-02-20",
                    "waktu": "11:15:00",
                    "no_ktp": "3310070070090010",
                    "no_npwp": "0123456789012354",
                    "no_kk": "3310070707090010",
                    "no_hp": "081278945612",
                    "alamat": "Jl. Kenanga No. 5, Pemalang",
                    "lokasi_usaha": "Jl. Kenanga No. 5, Pemalang",
                    "kecamatan": "KEC2",
                    "kelurahan": "KEL2",
                    "keterangan": "Izin usaha salon baru",
                    "syarat": ["syarat_1", "syarat_2"],
                    "izin_items": [
                        {"id": "izin_10.1", "jenis_izin_id": "IZIN_C", "jenis_permohonan_id": "BARU", "jenis_izin": "Izin C (Lainnya)", "jenis_permohonan": "BARU"}
                    ]
                },
                {
                    "id": 11,
                    "nomor_daftar": "130014",
                    "jenis_izin": "IZIN_C",
                    "jenis_permohonan": "BARU",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_C'] ?? 'Izin C (Lainnya)') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['BARU'] ?? 'BARU') . '",
                    "nama_pemohon": "PT. Bangun Cipta",
                    "nama_usaha": "Proyek Perumahan Mutiara",
                    "bidang_usaha": "Properti",
                    "tanggal": "2025-03-01",
                    "waktu": "13:45:00",
                    "no_ktp": "3310080080100011",
                    "no_npwp": "0123456789012355",
                    "no_kk": "3310080808100011",
                    "no_hp": "081812345678",
                    "alamat": "Jl. Thamrin No. 1, Jakarta",
                    "lokasi_usaha": "Desa Beji, Kec. Taman",
                    "kecamatan": "KEC3",
                    "kelurahan": "KEL3",
                    "keterangan": "Izin lokasi perumahan",
                    "syarat": ["syarat_1", "syarat_2", "syarat_3"],
                    "izin_items": []
                },
                {
                    "id": 12,
                    "nomor_daftar": "140015",
                    "jenis_izin": "IZIN_B",
                    "jenis_permohonan": "PERPANJANGAN",
                    "nama_izin": "' . ($dropdownData['jenisIzinItems']['IZIN_B'] ?? 'Izin B (Apotek)') . '",
                    "nama_permohonan": "' . ($dropdownData['jenisPermohonanItems']['PERPANJANGAN'] ?? 'PERPANJANGAN') . '",
                    "nama_pemohon": "Joko Susilo",
                    "nama_usaha": "Toko Bangunan Kokoh",
                    "bidang_usaha": "Perdagangan Material",
                    "tanggal": "2025-04-10",
                    "waktu": "14:20:00",
                    "no_ktp": "3310090090110012",
                    "no_npwp": "0123456789012356",
                    "no_kk": "3310090909110012",
                    "no_hp": "081912345678",
                    "alamat": "Jl. Ahmad Dahlan No. 30, Pemalang",
                    "lokasi_usaha": "Jl. Ahmad Dahlan No. 30, Pemalang",
                    "kecamatan": "KEC1",
                    "kelurahan": "KEL1",
                    "keterangan": "Perpanjangan SIUP",
                    "syarat": ["syarat_1", "syarat_2"],
                    "izin_items": []
                }
            ]';
            // Saya hapus data dummy yang duplikat
            $dummyData = json_decode($dummyJson, true);
            $session->set(self::DUMMY_DATA_KEY, $dummyData);
        }
    }
    protected function getDummyData()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY, []);
    }

    protected function initDummyData2()
    {
        $session = Yii::$app->session;
        $data2 = $session->get(self::DUMMY_DATA_KEY_2);
        if ($data2 === null) { // Gunakan === null agar array kosong tidak di-reset
            $session->set(self::DUMMY_DATA_KEY_2, []);
        }
    }
    protected function getDummyData2()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY_2, []);
    }

    protected function saveDummyData2(array $data)
    {
        Yii::$app->session->set(self::DUMMY_DATA_KEY_2, array_values($data));
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

    protected function getDefaultValues($modelData = [])
    {
        return [
            // Ini adalah nilai untuk 'primary' izin
            'jenis_izin' => $modelData['jenis_izin'] ?? null,
            'jenis_permohonan' => $modelData['jenis_permohonan'] ?? null,

            'nama_usaha' => $modelData['nama_usaha'] ?? null,
            'bidang_usaha' => $modelData['bidang_usaha'] ?? null,
            'nama_pemohon' => $modelData['nama_pemohon'] ?? null,
            'no_ktp' => $modelData['no_ktp'] ?? null,
            'no_npwp' => $modelData['no_npwp'] ?? null,
            'no_kk' => $modelData['no_kk'] ?? null,
            'alamat' => $modelData['alamat'] ?? null,
            'no_hp' => $modelData['no_hp'] ?? null,
            'lokasi_usaha' => $modelData['lokasi_usaha'] ?? null,
            'kecamatan' => $modelData['kecamatan'] ?? null,
            'kelurahan' => $modelData['kelurahan'] ?? null,
            'keterangan' => $modelData['keterangan'] ?? null,
            'syarat' => $modelData['syarat'] ?? [],
        ];
    }

    protected function getSyaratItems()
    {
        return [
            'syarat_1' => 'Foto berwarna 4x6 2 lembar dan 3x4 2 lembar',
            'syarat_2' => 'Foto Copy KTP',
            'syarat_3' => 'Fotocopy STRA dengan menunjukan STRA asli',
            'syarat_4' => 'Surat pernyataan mempunyai tempat praktik profesi atau surat keterangan dari pimpinan fasilitas pelayanan kefarmasian',
            'syarat_5' => 'Surat persetujuan atasan langsung',
        ];
    }
}
