

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Perizinan\PendaftaranForm;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PerizinanController extends Controller
{
    /**
     * Mengambil atau membuat data dummy dan menyimpannya di session.
     * @return array
     */
    private function getPendaftaranData()
    {
        $session = Yii::$app->session;
        if (!$session->has('pendaftaranData')) {
            $dummyData = [];
            for ($i = 1; $i <= 50; $i++) {
                $dummyData[$i] = [
                    'id' => $i, // Menambahkan ID unik untuk setiap record
                    'nomor_daftar' => 'REG-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'jenis_izin' => 'izin_reklame',
                    'jenis_permohonan' => ['baru', 'perpanjangan'][array_rand([0, 1])],
                    'nama_usaha' => 'Usaha Fiktif ' . $i,
                    'bidang_usaha' => 'Bidang Usaha ' . $i,
                    'nama_pemohon' => 'Bapak/Ibu Pemohon ' . $i,
                    'nomor_ktp' => rand(33100, 33199) . '000000' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'nomor_npwp' => '08.00' . rand(1, 9) . '.000.' . $i . '-525.000',
                    'alamat' => 'Jl. Merdeka No. ' . $i . ', Klaten',
                    'nomor_hp' => '081234567' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'lokasi_usaha' => 'Jl. Pemuda No. ' . $i . ', Klaten',
                    'kecamatan' => (string)rand(1, 3),
                    'kelurahan' => (string)rand(1, 3),
                    'keterangan' => 'Keterangan untuk pendaftaran ke-' . $i,
                    'nama_izin' => 'Pencabutan Izin',
                    'nama_permohonan' => ['SIPP', 'SIP (Dokter)', 'SIPTTK', 'SIKTS'][array_rand([0,1,2,3])],
                    'waktu' => date('Y-m-d H:i:s', strtotime("-{$i} days")),
                ];
            }
            $session->set('pendaftaranData', $dummyData);
        }
        return $session->get('pendaftaranData');
    }

    /**
     * Menyimpan data yang sudah dimodifikasi kembali ke session.
     * @param array $data
     */
    private function setPendaftaranData($data)
    {
        Yii::$app->session->set('pendaftaranData', $data);
    }

    /**
     * Menampilkan form pendaftaran dan daftar data.
     */
    public function actionPendaftaran()
    {
        $model = new PendaftaranForm();
        $allData = $this->getPendaftaranData();
        
        $globalSearch = Yii::$app->request->get('globalSearch');
        if ($globalSearch) {
            $allData = array_filter($allData, function($item) use ($globalSearch) {
                return stripos($item['nomor_daftar'], $globalSearch) !== false ||
                       stripos($item['nama_pemohon'], $globalSearch) !== false;
            });
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $allData,
            'pagination' => ['pageSize' => 10],
            'sort' => [
                'attributes' => ['nomor_daftar', 'waktu', 'nama_pemohon'],
                'defaultOrder' => ['waktu' => SORT_DESC],
            ],
            'key' => 'id' // Penting untuk Pjax
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->setFlash('success', 'Pendaftaran baru berhasil disimpan.');
            // Logika untuk menambahkan data baru ke session
            $newDataArray = $this->getPendaftaranData();
            $newId = count($newDataArray) > 0 ? max(array_keys($newDataArray)) + 1 : 1;
            $newRecord = $model->attributes;
            $newRecord['id'] = $newId;
            $newRecord['nomor_daftar'] = 'REG-' . str_pad($newId, 4, '0', STR_PAD_LEFT);
            $newRecord['waktu'] = date('Y-m-d H:i:s');
            // Menambahkan atribut yang ada di gridview
            $newRecord['nama_izin'] = 'Izin Penyelenggaraan Reklame'; 
            $newRecord['nama_permohonan'] = strtoupper($model->jenis_permohonan);

            $newDataArray[$newId] = $newRecord;
            $this->setPendaftaranData($newDataArray);
            
            return $this->refresh();
        }

        return $this->render('pendaftaran', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'listKecamatan' => ['1' => 'Kecamatan A', '2' => 'Kecamatan B', '3' => 'Kecamatan C'],
            'listKelurahan' => ['1' => 'Kelurahan X', '2' => 'Kelurahan Y', '3' => 'Kelurahan Z'],
        ]);
    }

    /**
     * Mengambil data satu record untuk ditampilkan di modal (via AJAX).
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $data = $this->getPendaftaranData();
        if (isset($data[$id])) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $data[$id];
        }
        throw new NotFoundHttpException('Data tidak ditemukan.');
    }

    /**
     * Mengupdate data dari modal (via AJAX).
     * @param int $id
     * @return array
     */
    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new PendaftaranForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $allData = $this->getPendaftaranData();
            if (isset($allData[$id])) {
                // Merge data lama dengan data baru dari form
                $allData[$id] = array_merge($allData[$id], $model->attributes);
                $this->setPendaftaranData($allData);
                return ['success' => true];
            }
        }
        return ['success' => false, 'errors' => $model->getErrors()];
    }

    /**
     * Membuat data baru dari modal (untuk fitur copy) (via AJAX).
     * @return array
     */
    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new PendaftaranForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $allData = $this->getPendaftaranData();
            $newId = count($allData) > 0 ? max(array_keys($allData)) + 1 : 1;
            
            $newRecord = $model->attributes;
            $newRecord['id'] = $newId;
            $newRecord['nomor_daftar'] = 'REG-' . str_pad($newId, 4, '0', STR_PAD_LEFT);
            $newRecord['waktu'] = date('Y-m-d H:i:s');
            // Menambahkan atribut yang ada di gridview
            $newRecord['nama_izin'] = 'Izin Penyelenggaraan Reklame'; 
            $newRecord['nama_permohonan'] = strtoupper($model->jenis_permohonan);

            $allData[$newId] = $newRecord;
            $this->setPendaftaranData($allData);
            return ['success' => true];
        }
        return ['success' => false, 'errors' => $model->getErrors()];
    }

    /**
     * Menghapus data berdasarkan ID.
     * @param int $id
     * @return Response
     */
    public function actionDelete($id)
    {
        $allData = $this->getPendaftaranData();
        if (isset($allData[$id])) {
            unset($allData[$id]);
            $this->setPendaftaranData($allData);
            Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
        }
        return $this->redirect(['pendaftaran']);
    }

    /**
     * Action untuk mencetak tanda terima.
     */
    public function actionCetakTandaTerima($id)
    {
        $data = $this->getPendaftaranData();
        if (isset($data[$id])) {
            // Sebaiknya buat file view terpisah untuk cetak
            return $this->renderPartial('_cetak-tanda-terima', ['model' => $data[$id]]);
        }
        throw new NotFoundHttpException('Data tidak ditemukan.');
    }

    /**
     * Action untuk mencetak monitoring.
     */
    public function actionCetakMonitoring($id)
    {
        $data = $this->getPendaftaranData();
        if (isset($data[$id])) {
            return $this->renderPartial('_cetak-monitoring', ['model' => $data[$id]]);
        }
        throw new NotFoundHttpException('Data tidak ditemukan.');
    }
}
