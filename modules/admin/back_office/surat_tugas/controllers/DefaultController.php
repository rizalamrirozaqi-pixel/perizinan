<?php

namespace app\modules\admin\back_office\surat_tugas\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Default controller for the `surat_tugas` module
 */
class DefaultController extends Controller
{

    // Session key for dummy data (unique to this controller)
    const DUMMY_DATA_KEY_SURAT_TUGAS = 'surat_tugas_dummy_data_v1';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete-jadwal' => ['POST'],
                    'cetak-html' => ['GET'],
                    'cetak-word' => ['GET'],
                    'search-jadwal' => ['GET'], // (FIX) Daftarkan action autocomplete
                ],
            ],
        ];
    }

    /**
     * Initialize dummy data if not exists in session
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $this->initDummyData();
        return true;
    }


    /**
     * Renders the index view for the module (Form + Grid)
     * @return string
     */
    public function actionIndex()
    {
        $allJadwal = $this->getDummyData();

        // (FIX) LOGIKA INI SUDAH BENAR
        // Logika pencarian untuk Grid Bawah. Ini sudah tepat.
        $search = Yii::$app->request->get('search');
        if (!empty($search)) {
            $term = strtolower($search);
            $filteredData = array_filter($allJadwal, function ($item) use ($term) {
                return stripos($item['nomor_surat_perintah'] ?? '', $term) !== false ||
                    stripos($item['lokasi'] ?? '', $term) !== false ||
                    stripos($item['tim_peninjau'] ?? '', $term) !== false ||
                    stripos($item['keterangan'] ?? '', $term) !== false;
            });
        } else {
            $filteredData = $allJadwal;
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData, // (FIX) Gunakan data yang sudah difilter
            'key' => 'id',
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'attributes' => ['id', 'tanggal_pemeriksaan_mulai'],
                'defaultOrder' => [
                    'tanggal_pemeriksaan_mulai' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
            'timPemeriksaItems' => $this->getTimPemeriksaItems(),
            'penandatanganItems' => $this->getPenandatanganItems(),
        ]);
    }

    /**
     * (FIX) ACTION AUTOCOMPLETE YANG DIOPTIMALKAN
     */
    public function actionSearchJadwal($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $results = [];
        $limit = 10; // Batasi hasil agar tidak overload

        // Hanya cari jika term tidak kosong dan lebih dari 1 karakter
        if (!empty($term) && strlen($term) >= 2) {
            $term = strtolower($term);
            $allJadwal = $this->getDummyData();
            $foundLabels = []; // Mencegah label yang sama muncul berulang kali

            foreach ($allJadwal as $item) {
                // Berhenti mencari jika sudah mencapai limit
                if (count($results) >= $limit) {
                    break;
                }

                $nomorSurat = $item['nomor_surat_perintah'] ?? '';
                $lokasi = $item['lokasi'] ?? '';
                $tim = $item['tim_peninjau'] ?? '';
                $keterangan = $item['keterangan'] ?? '';

                $label = null;
                $value = null;

                // Logika pencarian dengan prioritas
                if (stripos($nomorSurat, $term) !== false) {
                    $label = "No: {$nomorSurat} ({$lokasi})";
                    $value = $nomorSurat;
                } elseif (stripos($lokasi, $term) !== false) {
                    $label = "Lokasi: {$lokasi} ({$nomorSurat})";
                    $value = $lokasi;
                } elseif (stripos($tim, $term) !== false) {
                    $label = "Tim: {$tim} ({$lokasi})";
                    $value = $tim;
                } elseif (stripos($keterangan, $term) !== false) {
                    $label = "Ket: {$keterangan} ({$nomorSurat})";
                    $value = $keterangan;
                }

                // Jika ditemukan dan labelnya unik, tambahkan ke hasil
                if ($label !== null && !isset($foundLabels[$label])) {
                    $results[] = ['label' => $label, 'value' => $value];
                    $foundLabels[$label] = true; // Tandai label ini sudah ditemukan
                }
            }
        }
        return $results;
    }


    /**
     * Action to delete a schedule item (called via POST)
     */
    public function actionDeleteJadwal($id)
    {
        $allJadwal = $this->getDummyData();
        $indexToDelete = $this->findModel($id, true);

        if ($indexToDelete !== null) {
            unset($allJadwal[$indexToDelete]);
            $this->saveDummyData(array_values($allJadwal));
            Yii::$app->session->setFlash('success', 'Jadwal berhasil dihapus.');
        } else {
            Yii::$app->session->setFlash('error', 'Gagal menghapus jadwal: Data tidak ditemukan.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Renders the HTML print view for Surat Tugas
     */
    public function actionCetakHtml($id)
    {
        $model = $this->findModel($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data jadwal tidak ditemukan.');
        }
        $this->layout = false;
        Yii::$app->response->format = Response::FORMAT_HTML;

        return $this->renderPartial('_cetak_html', [
            'model' => $model,
            'penandatanganNama' => $this->getPenandatanganItems()[$model['penandatangan_id'] ?? null] ?? 'N/A',
        ]);
    }

    /**
     * Generates and downloads a Word document for Surat Tugas
     */
    public function actionCetakWord($id)
    {
        $model = $this->findModel($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data jadwal tidak ditemukan.');
        }
        $this->layout = false;
        $content = $this->renderPartial('_cetak_word', [
            'model' => $model,
            'penandatanganNama' => $this->getPenandatanganItems()[$model['penandatangan_id'] ?? null] ?? 'N/A',
        ]);
        $filename = "Surat_Tugas_" . preg_replace('/[^A-Za-z0-9\-]/', '_', $model['nomor_surat_perintah'] ?? $id) . ".doc";
        Yii::$app->response->headers->set('Content-Type', 'application/msword');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        Yii::$app->response->format = Response::FORMAT_RAW;
        return $content;
    }

    // --- Helper Functions ---

    protected function getTimPemeriksaItems()
    {
        return [
            'TIM_A' => 'Tim Pemeriksa Alpha',
            'TIM_B' => 'Tim Pemeriksa Bravo',
            'TIM_C' => 'Tim Pemeriksa Charlie',
        ];
    }

    protected function getPenandatanganItems()
    {
        return [
            'KADIN' => 'Kepala Dinas',
            'SEKRETARIS' => 'Sekretaris Dinas',
            'KABID_X' => 'Kepala Bidang X',
        ];
    }

    protected function initDummyData()
    {
        $session = Yii::$app->session;
        if (empty($session->get(self::DUMMY_DATA_KEY_SURAT_TUGAS))) {
            $session->set(self::DUMMY_DATA_KEY_SURAT_TUGAS, [
                [
                    'id' => 1,
                    'tanggal_pemeriksaan_mulai' => '2025-09-15',
                    'tanggal_pemeriksaan_selesai' => '2025-09-25',
                    'nomor_surat_perintah' => 'SP/IX/2025/001',
                    'lokasi' => 'Jl. Merdeka No. 10, Pemalang',
                    'tim_peninjau_id' => 'TIM_A',
                    'tim_peninjau' => 'Tim Pemeriksa Alpha (Andi, Budi)',
                    'penandatangan_id' => 'KADIN',
                    'keterangan' => 'Pemeriksaan Rutin',
                    'tanggal_cetak' => '2025-09-10',
                ],
                [
                    'id' => 2,
                    'tanggal_pemeriksaan_mulai' => '2025-09-15',
                    'tanggal_pemeriksaan_selesai' => '2025-09-20',
                    'nomor_surat_perintah' => 'SP/IX/2025/002',
                    'lokasi' => 'Jl. Sudirman No. 12, Pemalang',
                    'tim_peninjau_id' => 'TIM_B',
                    'tim_peninjau' => 'Tim Pemeriksa Bravo (Citra, Dian)',
                    'penandatangan_id' => 'SEKRETARIS',
                    'keterangan' => 'Verifikasi Lapangan Izin Baru',
                    'tanggal_cetak' => '2025-09-11',
                ],
                [
                    'id' => 3,
                    'tanggal_pemeriksaan_mulai' => '2025-07-30',
                    'tanggal_pemeriksaan_selesai' => '2025-08-10',
                    'nomor_surat_perintah' => 'SP/VII/2025/015',
                    'lokasi' => 'Jl. Diponegoro No. 55, Pemalang',
                    'tim_peninjau_id' => 'TIM_C',
                    'tim_peninjau' => 'Tim Pemeriksa Charlie (Eko, Fajar)',
                    'penandatangan_id' => 'KABID_X',
                    'keterangan' => 'Pemeriksaan Perpanjangan',
                    'tanggal_cetak' => '2025-07-28',
                ],
                [
                    'id' => 4,
                    'tanggal_pemeriksaan_mulai' => '2025-07-30',
                    'tanggal_pemeriksaan_selesai' => '2025-08-10',
                    'nomor_surat_perintah' => 'SP/VII/2025/016',
                    'lokasi' => 'Jl. Pemuda No. 1, Pemalang',
                    'tim_peninjau_id' => 'TIM_A',
                    'tim_peninjau' => 'Tim Pemeriksa Alpha (Andi, Budi)',
                    'penandatangan_id' => 'KADIN',
                    'keterangan' => 'Pemeriksaan Ulang',
                    'tanggal_cetak' => '2025-07-29',
                ],
                [
                    'id' => 5,
                    'tanggal_pemeriksaan_mulai' => '2025-06-10',
                    'tanggal_pemeriksaan_selesai' => '2025-06-15',
                    'nomor_surat_perintah' => 'SP/VI/2025/005',
                    'lokasi' => 'Jl. Veteran No. 8, Pemalang',
                    'tim_peninjau_id' => 'TIM_B',
                    'tim_peninjau' => 'Tim Pemeriksa Bravo (Citra, Dian)',
                    'penandatangan_id' => 'SEKRETARIS',
                    'keterangan' => 'Monitoring Pasca Izin',
                    'tanggal_cetak' => '2025-06-05',
                ],
                [
                    'id' => 6,
                    'tanggal_pemeriksaan_mulai' => '2025-06-11',
                    'tanggal_pemeriksaan_selesai' => '2025-06-16',
                    'nomor_surat_perintah' => 'SP/VI/2025/006',
                    'lokasi' => 'Jl. Raya Yogya-Solo Km 5',
                    'tim_peninjau_id' => 'TIM_C',
                    'tim_peninjau' => 'Tim Pemeriksa Charlie (Eko, Fajar)',
                    'penandatangan_id' => 'KABID_X',
                    'keterangan' => 'Inspeksi Mendadak',
                    'tanggal_cetak' => '2025-06-06',
                ],
                [
                    'id' => 7, 
                    'tanggal_pemeriksaan_mulai' => '2025-05-01',
                    'tanggal_pemeriksaan_selesai' => '2025-05-05',
                    'nomor_surat_perintah' => 'SP/V/2025/001',
                    'lokasi' => 'Kawasan Industri Pemalang',
                    'tim_peninjau_id' => 'TIM_A',
                    'tim_peninjau' => 'Tim Pemeriksa Alpha (Andi, Budi)',
                    'penandatangan_id' => 'KADIN',
                    'keterangan' => 'Pemeriksaan Awal',
                    'tanggal_cetak' => '2025-04-30',
                ],
            ]);
        }
    }

    protected function getDummyData()
    {
        return Yii::$app->session->get(self::DUMMY_DATA_KEY_SURAT_TUGAS, []);
    }

    protected function saveDummyData(array $data)
    {
        Yii::$app->session->set(self::DUMMY_DATA_KEY_SURAT_TUGAS, $data);
    }

    protected function findModel($id, $returnIndex = false)
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