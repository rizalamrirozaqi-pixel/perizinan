<?php

namespace app\modules\admin_khusus\referensi\referensi_pengguna\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\base\DynamicModel;

class DefaultController extends Controller
{
    const SESSION_KEY = 'referensi_pengguna_data';

    // Data Dummy Awal
    private function initData()
    {
        $session = Yii::$app->session;
        if (!$session->has(self::SESSION_KEY)) {
            $data = [
                [
                    'id' => 1,
                    'username' => 'admin',
                    'password' => '123456',
                    'nama_lengkap' => 'Administrator Sistem',
                    'nip' => '-',
                    'unit_kerja' => '-',
                    'blok_sistem' => 'Admin'
                ],
                [
                    'id' => 2,
                    'username' => 'dpmptsp',
                    'password' => '123456',
                    'nama_lengkap' => 'Admin Dinas',
                    'nip' => '198001012005011001',
                    'unit_kerja' => 'DPMPTSP',
                    'blok_sistem' => 'Admin Khusus'
                ],
                [
                    'id' => 3,
                    'username' => 'bo_teknis',
                    'password' => '123456',
                    'nama_lengkap' => 'Staf Teknis',
                    'nip' => '199002022015021002',
                    'unit_kerja' => 'Back Office',
                    'blok_sistem' => 'Back Office'
                ],
            ];
            $session->set(self::SESSION_KEY, $data);
        }
    }

    private function getPrivilegeOptions()
    {
        return [
            'sektor' => [
                'KESEHATAN' => 'KESEHATAN',
                'PERDAGANGAN' => 'PERDAGANGAN',
                'INDUSTRI' => 'INDUSTRI',
            ],
            'bidang' => [
                'Semua Izin / Bidang' => 'Semua Izin / Bidang',
                'Izin Praktik Dokter' => 'Izin Praktik Dokter',
                'Izin Usaha' => 'Izin Usaha',
            ],
            'permohonan' => [
                'Baru' => 'Baru',
                'Perpanjangan' => 'Perpanjangan',
                'Daftar Ulang' => 'Daftar Ulang',
            ]
        ];
    }

    private function getBlokSistemOptions()
    {
        return [
            'Admin' => 'Admin',
            'Admin Khusus' => 'Admin Khusus',
            'Back Office' => 'Back Office',
            'Front Office' => 'Front Office',
            'Customer Service' => 'Customer Service (Informasi & Pengaduan)',
            'Kepala DPMPTSP' => 'Kepala DPMPTSP',
            'OPD Teknis' => 'OPD Teknis',
            'Kasi Perizinan' => 'Kasi Perizinan',
        ];
    }

    private function createDynamicModel($data = [])
    {
        $model = new DynamicModel([
            'username',
            'password',
            'nama_lengkap',
            'nip',
            'unit_kerja',
            'blok_sistem'
        ]);

        $model->addRule(['username', 'password', 'nama_lengkap', 'blok_sistem'], 'required', ['message' => 'Wajib diisi.'])
            ->addRule(['username', 'password', 'nama_lengkap', 'nip', 'unit_kerja', 'blok_sistem'], 'string');

        if (!empty($data)) $model->attributes = $data;
        return $model;
    }

    public function actionIndex()
    {
        $this->initData();
        $request = Yii::$app->request;
        $search = $request->get('search');

        $rawData = Yii::$app->session->get(self::SESSION_KEY, []);
        $blokSistemOptions = $this->getBlokSistemOptions();
        $privilegeOptions = $this->getPrivilegeOptions();

        $filteredData = $rawData;
        if ($search) {
            $filteredData = array_filter($rawData, function ($item) use ($search) {
                return stripos($item['username'], $search) !== false ||
                    stripos($item['nama_lengkap'], $search) !== false ||
                    stripos($item['nip'], $search) !== false;
            });
        }

        // Sort ID desc
        usort($filteredData, function ($a, $b) {
            return $b['id'] <=> $a['id'];
        });

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
            'allDataJson' => json_encode($rawData),
            'blokSistemOptions' => $blokSistemOptions,
            'privilegeOptions' => $privilegeOptions,
        ]);
    }

    public function actionCreate()
    {
        $model = $this->createDynamicModel();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $session = Yii::$app->session;
            $data = $session->get(self::SESSION_KEY, []);

            $newItem = [
                'id' => count($data) > 0 ? max(array_column($data, 'id')) + 1 : 1,
                'username' => $model->username,
                'password' => $model->password,
                'nama_lengkap' => $model->nama_lengkap,
                'nip' => $model->nip ?? '-',
                'unit_kerja' => $model->unit_kerja ?? '-',
                'blok_sistem' => $model->blok_sistem,
            ];

            $data[] = $newItem;
            $session->set(self::SESSION_KEY, $data);
            Yii::$app->session->setFlash('success', 'Pengguna berhasil ditambahkan.');
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
            if ($this->request->isPost && $model->load($this->request->post())) {
                $data[$index] = array_merge($data[$index], [
                    'username' => $model->username,
                    'password' => $model->password,
                    'nama_lengkap' => $model->nama_lengkap,
                    'nip' => $model->nip,
                    'unit_kerja' => $model->unit_kerja,
                    'blok_sistem' => $model->blok_sistem,
                ]);
                $session->set(self::SESSION_KEY, $data);
                Yii::$app->session->setFlash('success', 'Pengguna berhasil diupdate.');
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
        Yii::$app->session->setFlash('success', 'Pengguna berhasil dihapus.');
        return $this->redirect(['index']);
    }

    public function actionSearchPengguna($term)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->session->get(self::SESSION_KEY, []);
        $results = [];
        foreach ($data as $item) {
            if (stripos($item['username'], $term) !== false || stripos($item['nama_lengkap'], $term) !== false) {
                $results[] = [
                    'label' => $item['username'] . ' - ' . $item['nama_lengkap'],
                    'value' => $item['username']
                ];
            }
        }
        return array_slice($results, 0, 10);
    }
}
