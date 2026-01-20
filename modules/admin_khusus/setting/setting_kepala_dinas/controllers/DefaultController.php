<?php

namespace app\modules\admin_khusus\setting\setting_kepala_dinas\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    // Halaman Index (Tabel)
    public function actionIndex()
    {
        // 1. Data Tradisional (Manual Array 20 Data)
        $rawData = [
            ['id' => 1, 'nik' => '3327010101010001', 'nip' => '197501011999031001', 'nama' => 'Dr. H. Mulyana, S.Sos, M.Si', 'jabatan' => 'Kepala Dinas', 'eselon' => 'II.b', 'ditampilkan' => 'Ya', 'file' => 'ttd_mulyana.png'],
            ['id' => 2, 'nik' => '3327020202020002', 'nip' => '197802022000031002', 'nama' => 'Ir. Budi Santoso, MT', 'jabatan' => 'Sekretaris Dinas', 'eselon' => 'III.a', 'ditampilkan' => 'Tidak', 'file' => 'ttd_budi.png'],
            ['id' => 3, 'nik' => '3327030303030003', 'nip' => '198003032005031003', 'nama' => 'Siti Aminah, SE, MM', 'jabatan' => 'Kabid Pelayanan Perizinan', 'eselon' => 'III.b', 'ditampilkan' => 'Tidak', 'file' => 'ttd_siti.png'],
            ['id' => 4, 'nik' => '3327040404040004', 'nip' => '198204042006031004', 'nama' => 'Drs. Joko Widodo', 'jabatan' => 'Kabid Pengaduan', 'eselon' => 'III.b', 'ditampilkan' => 'Tidak', 'file' => 'ttd_joko.png'],
            ['id' => 5, 'nik' => '3327050505050005', 'nip' => '198505052008031005', 'nama' => 'Rina Kartika, S.H', 'jabatan' => 'Kabid Data & Informasi', 'eselon' => 'III.b', 'ditampilkan' => 'Tidak', 'file' => 'ttd_rina.png'],
            ['id' => 6, 'nik' => '3327060606060006', 'nip' => '197906062002031006', 'nama' => 'Agus Setiawan, S.Kom', 'jabatan' => 'Kasi Sistem Informasi', 'eselon' => 'IV.a', 'ditampilkan' => 'Tidak', 'file' => 'ttd_agus.png'],
            ['id' => 7, 'nik' => '3327070707070007', 'nip' => '198307072009031007', 'nama' => 'Dewi Lestari, S.AP', 'jabatan' => 'Kasi Pelayanan Terpadu', 'eselon' => 'IV.a', 'ditampilkan' => 'Tidak', 'file' => 'ttd_dewi.png'],
            ['id' => 8, 'nik' => '3327080808080008', 'nip' => '198108082004031008', 'nama' => 'Bambang Sudarsono, ST', 'jabatan' => 'Kasi Verifikasi', 'eselon' => 'IV.a', 'ditampilkan' => 'Tidak', 'file' => 'ttd_bambang.png'],
            ['id' => 9, 'nik' => '3327090909090009', 'nip' => '198609092010031009', 'nama' => 'Yuni Astuti, S.KM', 'jabatan' => 'Kasi Pengawasan', 'eselon' => 'IV.a', 'ditampilkan' => 'Tidak', 'file' => 'ttd_yuni.png'],
            ['id' => 10, 'nik' => '3327101010100010', 'nip' => '198410102007031010', 'nama' => 'Eko Prasetyo, S.Sos', 'jabatan' => 'Kasi Penetapan', 'eselon' => 'IV.a', 'ditampilkan' => 'Tidak', 'file' => 'ttd_eko.png'],
            ['id' => 11, 'nik' => '3327111111110011', 'nip' => '198711112011031011', 'nama' => 'Fajar Nugroho, S.H', 'jabatan' => 'Kasubag Umum', 'eselon' => 'IV.b', 'ditampilkan' => 'Tidak', 'file' => 'ttd_fajar.png'],
            ['id' => 12, 'nik' => '3327121212120012', 'nip' => '198912122012031012', 'nama' => 'Sri Wahyuni, SE', 'jabatan' => 'Kasubag Keuangan', 'eselon' => 'IV.b', 'ditampilkan' => 'Tidak', 'file' => 'ttd_sri.png'],
            ['id' => 13, 'nik' => '3327131313130013', 'nip' => '199001012013031013', 'nama' => 'Hendra Gunawan, S.Kom', 'jabatan' => 'Pranata Komputer Ahli Muda', 'eselon' => '-', 'ditampilkan' => 'Tidak', 'file' => 'ttd_hendra.png'],
            ['id' => 14, 'nik' => '3327141414140014', 'nip' => '199102022014031014', 'nama' => 'Ratna Sari, A.Md', 'jabatan' => 'Arsiparis Mahir', 'eselon' => '-', 'ditampilkan' => 'Tidak', 'file' => 'ttd_ratna.png'],
            ['id' => 15, 'nik' => '3327151515150015', 'nip' => '199203032015031015', 'nama' => 'Dedi Kurniawan, S.IP', 'jabatan' => 'Analis Kebijakan', 'eselon' => '-', 'ditampilkan' => 'Tidak', 'file' => 'ttd_dedi.png'],
            ['id' => 16, 'nik' => '3327161616160016', 'nip' => '199304042016031016', 'nama' => 'Lina Marlina, S.H', 'jabatan' => 'Perancang Peraturan', 'eselon' => '-', 'ditampilkan' => 'Tidak', 'file' => 'ttd_lina.png'],
            ['id' => 17, 'nik' => '3327171717170017', 'nip' => '199405052017031017', 'nama' => 'Rudi Hartono, ST', 'jabatan' => 'Teknik Tata Bangunan', 'eselon' => '-', 'ditampilkan' => 'Tidak', 'file' => 'ttd_rudi.png'],
            ['id' => 18, 'nik' => '3327181818180018', 'nip' => '199506062018031018', 'nama' => 'Wulan Dari, S.Si', 'jabatan' => 'Analis Lingkungan', 'eselon' => '-', 'ditampilkan' => 'Tidak', 'file' => 'ttd_wulan.png'],
            ['id' => 19, 'nik' => '3327191919190019', 'nip' => '199607072019031019', 'nama' => 'Toni Sucipto, S.Kom', 'jabatan' => 'Pranata Komputer Pertama', 'eselon' => '-', 'ditampilkan' => 'Tidak', 'file' => 'ttd_toni.png'],
            ['id' => 20, 'nik' => '3327202020200020', 'nip' => '199708082020031020', 'nama' => 'Maya Sofa, A.Md', 'jabatan' => 'Pengelola Keuangan', 'eselon' => '-', 'ditampilkan' => 'Tidak', 'file' => 'ttd_maya.png'],
        ];

        // 2. Set Pagination & Sorting
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 5, // Tampil 5 data per halaman (Total 20 data = 4 Halaman)
            ],
            'sort' => [
                'attributes' => ['nama', 'nik', 'nip', 'jabatan'], // Fitur sort aktif
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    // Halaman Edit (Form)
    public function actionUpdate($id)
    {
        // 3. Logic Edit: Cari data di array dummy berdasarkan ID
        $rawData = [
            ['id' => 1, 'nik' => '3327010101010001', 'nip' => '197501011999031001', 'nama' => 'Dr. H. Mulyana, S.Sos, M.Si', 'jabatan' => 'Kepala Dinas', 'eselon' => 'II.b', 'ditampilkan' => 'Ya', 'file' => 'ttd_mulyana.png'],
            // ... (Data dummy lainnya dianggap ada di database)
        ];

        // Default Model (Fallback jika ID tidak ditemukan di dummy di atas)
        $model = [
            'id' => $id,
            'nik' => '3327010101010001',
            'nip' => '197501011999031001',
            'nama' => 'Dr. H. Mulyana, S.Sos, M.Si',
            'jabatan' => 'Kepala Dinas',
            'eselon' => 'II.b',
            'ditampilkan' => 'Ya',
            'file' => 'ttd_mulyana.png'
        ];

        // Coba cari data yang sesuai ID (Simulasi query database)
        foreach ($rawData as $data) {
            if ($data['id'] == $id) {
                $model = $data;
                break;
            }
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('success', 'Data Kepala Dinas berhasil disimpan.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}