<?php

namespace app\modules\admin_khusus\referensi\referensi_jenis_izin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\base\DynamicModel;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    const SESSION_KEY = 'referensi_jenis_izin_khusus_data'; // Ganti key biar gak bentrok sama modul sebelah

    // Daftar Sektor Sesuai Gambar
    private function getSektorOptions()
    {
        return [
            'Pertanian' => 'Pertanian',
            'Lingkungan hidup dan kehutanan' => 'Lingkungan hidup dan kehutanan',
            'Energi dan sumber daya mineral' => 'Energi dan sumber daya mineral',
            'Ketenaganukliran' => 'Ketenaganukliran',
            'Perindustrian' => 'Perindustrian',
            'Perdagangan' => 'Perdagangan',
            'Pekerjaan umum dan perumahan rakyat' => 'Pekerjaan umum dan perumahan rakyat',
            'Transportasi' => 'Transportasi',
            'Kesehatan, obat dan makanan' => 'Kesehatan, obat dan makanan',
            'Pendidikan dan kebudayaan' => 'Pendidikan dan kebudayaan',
            'Pariwisata' => 'Pariwisata',
        ];
    }

    private function initData()
    {
        $session = Yii::$app->session;
        if (!$session->has(self::SESSION_KEY)) {
            // Data dummy awal dengan tambahan SEKTOR
            $data = [
                [
                    'id' => 1,
                    'nama_jenis_izin' => 'Izin Mendirikan Bangunan (IMB)',
                    'sektor' => 'Pekerjaan umum dan perumahan rakyat', // Baru
                    'lama_proses' => 7,
                    'berbayar' => 'T',
                    'icon' => 'imb.png',
                    'terstruktur' => 'T',
                    'is_aktif' => 'T'
                ],
                [
                    'id' => 2,
                    'nama_jenis_izin' => 'Izin Lokasi',
                    'sektor' => 'Pekerjaan umum dan perumahan rakyat', // Baru
                    'lama_proses' => 14,
                    'berbayar' => 'F',
                    'icon' => 'lokasi.png',
                    'terstruktur' => 'T',
                    'is_aktif' => 'T'
                ],
                [
                    'id' => 3,
                    'nama_jenis_izin' => 'Surat Izin Usaha Perdagangan (SIUP)',
                    'sektor' => 'Perdagangan', // Baru
                    'lama_proses' => 3,
                    'berbayar' => 'F',
                    'icon' => 'store.png',
                    'terstruktur' => 'F',
                    'is_aktif' => 'T'
                ],
            ];
            $session->set(self::SESSION_KEY, $data);
        }
    }

    private function createDynamicModel($data = [])
    {
        // Tambahkan 'sektor' ke atribut model
        $model = new DynamicModel([
            'nama_jenis_izin',
            'sektor',
            'lama_proses',
            'berbayar',
            'icon',
            'terstruktur',
            'is_aktif'
        ]);

        $model->addRule(['nama_jenis_izin', 'sektor', 'lama_proses'], 'required', ['message' => 'Wajib diisi.'])
            ->addRule(['lama_proses'], 'integer')
            ->addRule(['icon'], 'file', ['extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => true, 'checkExtensionByMimeType' => false])
            ->addRule(['sektor', 'berbayar', 'terstruktur', 'is_aktif'], 'string'); // Validasi string untuk sektor

        if (!empty($data)) $model->attributes = $data;
        return $model;
    }

    private function handleUpload($model, $oldFileName = null)
    {
        $file = UploadedFile::getInstance($model, 'icon');
        if ($file) {
            $fileName = 'icon_' . time() . '_' . rand(100, 999) . '.' . $file->extension;
            $uploadPath = Yii::getAlias('@webroot/uploads/');
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $file->saveAs($uploadPath . $fileName);
            return $fileName;
        }
        return $oldFileName;
    }

    public function actionIndex()
    {
        $this->initData();
        $request = Yii::$app->request;
        $search = $request->get('search');

        $rawData = Yii::$app->session->get(self::SESSION_KEY, []);
        $sektorOptions = $this->getSektorOptions(); // Ambil opsi sektor untuk view

        $filteredData = $rawData;
        if ($search) {
            $filteredData = array_filter($rawData, function ($item) use ($search) {
                return stripos($item['nama_jenis_izin'], $search) !== false ||
                    stripos($item['sektor'], $search) !== false; // Cari juga berdasarkan sektor
            });
        }

        usort($filteredData, function ($a, $b) {
            return $b['id'] <=> $a['id'];
        });

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'pagination' => ['pageSize' => 5],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
            'allDataJson' => json_encode($rawData),
            'sektorOptions' => $sektorOptions, // Kirim ke View
        ]);
    }

    public function actionCreate()
    {
        $model = $this->createDynamicModel();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->icon = UploadedFile::getInstance($model, 'icon');

            if ($model->validate()) {
                $session = Yii::$app->session;
                $data = $session->get(self::SESSION_KEY, []);

                $fileName = $this->handleUpload($model);

                $newItem = [
                    'id' => count($data) > 0 ? max(array_column($data, 'id')) + 1 : 1,
                    'nama_jenis_izin' => $model->nama_jenis_izin,
                    'sektor' => $model->sektor, // Simpan Sektor
                    'lama_proses' => $model->lama_proses,
                    'berbayar' => $model->berbayar,
                    'icon' => $fileName,
                    'terstruktur' => $model->terstruktur ?? 'F',
                    'is_aktif' => $model->is_aktif ?? 'F',
                ];

                $data[] = $newItem;
                $session->set(self::SESSION_KEY, $data);
                Yii::$app->session->setFlash('success', 'Data berhasil ditambahkan.');
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menyimpan data.');
            }
        }
        return $this->redirect(['index']);
    }

    public function actionUpdate($id)
    {
        $session = Yii::$app->session;
        $data = $session->get(self::SESSION_KEY, []);
        $index = array_search($id, array_column($data, 'id'));

        if ($index !== false) {
            $model = $this->createDynamicModel();
            if ($this->request->isPost) {
                $model->load($this->request->post());
                $model->icon = UploadedFile::getInstance($model, 'icon');

                if ($model->validate()) {
                    $oldFile = $data[$index]['icon'] ?? null;
                    $fileName = $this->handleUpload($model, $oldFile);

                    $data[$index] = array_merge($data[$index], [
                        'nama_jenis_izin' => $model->nama_jenis_izin,
                        'sektor' => $model->sektor, // Update Sektor
                        'lama_proses' => $model->lama_proses,
                        'berbayar' => $model->berbayar,
                        'icon' => $fileName,
                        'terstruktur' => $model->terstruktur ?? 'F',
                        'is_aktif' => $model->is_aktif ?? 'F',
                    ]);

                    $session->set(self::SESSION_KEY, $data);
                    Yii::$app->session->setFlash('success', 'Data berhasil diupdate.');
                }
            }
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $session = Yii::$app->session;
        $data = $session->get(self::SESSION_KEY, []);
        $newData = array_filter($data, function ($item) use ($id) {
            return $item['id'] != $id;
        });
        $session->set(self::SESSION_KEY, array_values($newData));
        Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
        return $this->redirect(['index']);
    }

    public function actionSearchIzin($term)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->session->get(self::SESSION_KEY, []);
        $results = [];
        foreach ($data as $item) {
            if (stripos($item['nama_jenis_izin'], $term) !== false) {
                $results[] = ['label' => $item['nama_jenis_izin'], 'value' => $item['nama_jenis_izin']];
            }
        }
        return array_slice($results, 0, 10);
    }
}
