<?php

namespace app\modules\admin_khusus\referensi\referensi_jenis_permohonan\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\base\DynamicModel;

class DefaultController extends Controller
{
    const SESSION_KEY = 'referensi_jenis_permohonan_data';
    const SESSION_KEY_IZIN = 'referensi_jenis_izin_data'; // Key dari modul sebelah

    private function initData()
    {
        $session = Yii::$app->session;
        if (!$session->has(self::SESSION_KEY)) {
            $data = [
                ['id' => 1, 'id_jenis_izin' => 1, 'nama_permohonan' => 'Izin Mendirikan Bangunan (IMB)', 'nama_izin_display' => 'BARU', 'register' => 'IMB-001', 'is_aktif' => 'T'],
                ['id' => 2, 'id_jenis_izin' => 2, 'nama_permohonan' => 'Izin Lokasi', 'nama_izin_display' => 'BARU', 'register' => 'IL-001', 'is_aktif' => 'T'],
                ['id' => 3, 'id_jenis_izin' => 3, 'nama_permohonan' => 'Izin Gangguan / HO', 'nama_izin_display' => 'DAFTAR ULANG', 'register' => 'HO-DU', 'is_aktif' => 'T'],
                ['id' => 4, 'id_jenis_izin' => 4, 'nama_permohonan' => 'Izin Gangguan / HO', 'nama_izin_display' => 'BALIK NAMA', 'register' => 'HO-BN', 'is_aktif' => 'T'],
            ];
            $session->set(self::SESSION_KEY, $data);
        }
    }

    private function getJenisIzinList()
    {
        $session = Yii::$app->session;
        $dataIzin = $session->get(self::SESSION_KEY_IZIN, []);

        if (empty($dataIzin)) {
            return [
                1 => 'Izin Mendirikan Bangunan (IMB)',
                2 => 'Izin Lokasi',
                3 => 'Izin Gangguan / HO'
            ];
        }

        $list = [];
        foreach ($dataIzin as $item) {
            $list[$item['id']] = $item['nama_jenis_izin'];
        }
        return $list;
    }

    private function createDynamicModel($data = [])
    {
        $model = new DynamicModel([
            'id_jenis_izin',
            'nama_permohonan',
            'register',
            'is_aktif'
        ]);
        $model->addRule(['id_jenis_izin', 'nama_permohonan'], 'required', ['message' => 'Wajib diisi.'])
            ->addRule(['id_jenis_izin'], 'integer')
            ->addRule(['nama_permohonan', 'register', 'is_aktif'], 'string');

        if (!empty($data)) $model->attributes = $data;
        return $model;
    }

    public function actionIndex()
    {
        $this->initData();
        $request = Yii::$app->request;
        $search = $request->get('search');

        $rawData = Yii::$app->session->get(self::SESSION_KEY, []);
        $jenisIzinList = $this->getJenisIzinList();

        $filteredData = $rawData;
        if ($search) {
            $filteredData = array_filter($rawData, function ($item) use ($search) {
                return stripos($item['nama_permohonan'], $search) !== false ||
                    stripos($item['nama_izin_display'], $search) !== false;
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
            'jenisIzinList' => $jenisIzinList, 
        ]);
    }

    public function actionCreate()
    {
        $model = $this->createDynamicModel();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $session = Yii::$app->session;
            $data = $session->get(self::SESSION_KEY, []);
            $jenisIzinList = $this->getJenisIzinList();

            $newItem = [
                'id' => count($data) > 0 ? max(array_column($data, 'id')) + 1 : 1,
                'id_jenis_izin' => $model->id_jenis_izin,
                'nama_izin_display' => $jenisIzinList[$model->id_jenis_izin] ?? '-',
                'nama_permohonan' => $model->nama_permohonan,
                'register' => $model->register,
                'is_aktif' => $model->is_aktif ?? 'F',
            ];

            $data[] = $newItem;
            $session->set(self::SESSION_KEY, $data);
            Yii::$app->session->setFlash('success', 'Data berhasil ditambahkan.');
        }
        return $this->redirect(['index']);
    }

    public function actionUpdate($id)
    {
        $session = Yii::$app->session;
        $data = $session->get(self::SESSION_KEY, []);
        $index = array_search($id, array_column($data, 'id'));
        $jenisIzinList = $this->getJenisIzinList();

        if ($index !== false) {
            $model = $this->createDynamicModel();
            if ($this->request->isPost && $model->load($this->request->post())) {
                $data[$index] = array_merge($data[$index], [
                    'id_jenis_izin' => $model->id_jenis_izin,
                    'nama_izin_display' => $jenisIzinList[$model->id_jenis_izin] ?? '-',
                    'nama_permohonan' => $model->nama_permohonan,
                    'register' => $model->register,
                    'is_aktif' => $model->is_aktif ?? 'F',
                ]);
                $session->set(self::SESSION_KEY, $data);
                Yii::$app->session->setFlash('success', 'Data berhasil diupdate.');
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

    public function actionSearchPermohonan($term)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->session->get(self::SESSION_KEY, []);
        $results = [];
        foreach ($data as $item) {
            if (stripos($item['nama_permohonan'], $term) !== false) {
                $results[] = ['label' => $item['nama_permohonan'], 'value' => $item['nama_permohonan']];
            }
        }
        return array_slice($results, 0, 10);
    }
}
