<?php

namespace app\modules\executive_summary\verifikasi_draft_sk\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

/**
 * Default controller for the `verifikasi_draft_sk` module
 */
class DefaultController extends Controller
{

    /**
     * Definisikan verbs untuk action
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'do-validasi' => ['POST'],
                    'revisi' => ['POST'],
                    'log' => ['GET'],
                    'index' => ['GET'],
                    'validasi' => ['GET'],
                    'preview-pdf' => ['GET'],
                    'search-pendaftaran' => ['GET'],
                ],
            ],
        ];
    }


    /**
     * Renders the index view (tabel)
     * @return string
     */
    public function actionIndex()
    {
        $allData = $this->getDummyData();
        $search = Yii::$app->request->get('search');

        // Filter data jika ada pencarian
        if (!empty($search)) {
            $filteredData = array_filter($allData, function ($item) use ($search) {
                // ... (logika filter Anda) ...
                return stripos($item['nomor_daftar'], $search) !== false ||
                    stripos($item['nama_pemohon'], $search) !== false;
            });
        } else {
            $filteredData = $allData;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'key' => 'id',
            'pagination' => ['pageSize' => 5],
            'sort' => [
                'attributes' => [
                    'id',
                    'nomor_daftar',
                    'nama_izin',
                    'jenis_permohonan',
                    'nama_pemohon',
                    'nama_usaha',
                    'dari',
                    'keterangan',
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
        ]);
    }

    /**
     * (BARU) Menampilkan halaman Validasi (Info Kiri, Preview Kanan)
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionValidasi($id)
    {
        $model = $this->findDummyModel($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        return $this->render('validasi', [
            'model' => $model,
        ]);
    }

    /**
     * (BARU) Membuat preview SK dalam format PDF untuk iframe
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPreviewPdf($id)
    {
        $modelPendaftaran = $this->findDummyModel($id); // Data dari dummy
        if ($modelPendaftaran === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        // Data SK bisa diambil dari modul lain atau dummy di sini
        $modelSk = [
            'no_sk' => '503 / ... / TAHUN ...',
            'tgl_mohon_pu' => $modelPendaftaran['tanggal_daftar'] ?? '...', // Asumsi
            // ... data SK lain ...
        ];

        $this->layout = false;
        // Kita gunakan template cetak dari modul 'cetak_draft_sk' (jika ada)
        // atau buat template baru '_cetak_draft.php' di modul ini
        $content = $this->renderPartial('_cetak_draft', [
            'modelPendaftaran' => $modelPendaftaran,
            'modelSk' => $modelSk,
        ]);

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 20,
            'margin_right' => 20,
            'margin_top' => 20,
            'margin_bottom' => 20,
        ]);

        $mpdf->WriteHTML($content);
        return $mpdf->Output('preview_sk.pdf', Destination::INLINE);
    }

    public function actionSearchPendaftaran($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $results = [];

        if (!empty($term)) {
            $term = strtolower($term);
            $allPendaftaran = $this->getDummyData();

            foreach ($allPendaftaran as $item) {
                $nomorDaftar = $item['nomor_daftar'] ?? '';
                $namaPemohon = $item['nama_pemohon'] ?? '';
                $namaUsaha = $item['nama_usaha'] ?? '';

                if (stripos($nomorDaftar, $term) !== false || stripos($namaPemohon, $term) !== false || stripos($namaUsaha, $term) !== false) {
                    // Format yang diharapkan jQuery UI: [ { "label": "Tampilan", "value": "Nilai" }, ... ]
                    $label = "{$nomorDaftar} - {$namaPemohon}" . (!empty($namaUsaha) ? " ({$namaUsaha})" : "");
                    $results[] = [
                        'label' => $label,
                        'value' => $nomorDaftar, // Nilai yang akan dimasukkan ke input box
                    ];
                }
            }
        }
        return $results;
    }

    /**
     * Memproses data dari form Validasi (POST request)
     */
    public function actionDoValidasi($id)
    {
        $model = $this->findDummyModel($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        // ... (Logika validasi Anda) ...

        Yii::$app->session->setFlash('success', "Data pendaftaran {$model['nomor_daftar']} berhasil divalidasi.");
        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $this->layout = false;
        $model = $this->findDummyModel($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }
        $lembarKendaliData = $this->getLogDummyData();
        return $this->render('view', [
            'model' => $model,
            'lembarKendaliData' => $lembarKendaliData,
        ]);
    }


    public function actionRevisi($id)
    {
        $model = $this->findDummyModel($id);
        if ($model === null) {
            throw new NotFoundHttpException('Data pendaftaran tidak ditemukan.');
        }

        $catatan = Yii::$app->request->post('catatan_revisi'); // Ambil catatan

        // ... (Logika revisi Anda di sini) ...

        Yii::$app->session->setFlash('warning', "Data pendaftaran {$model['nomor_daftar']} telah dikembalikan untuk revisi. Catatan: " . $catatan);
        return $this->redirect(['index']);
    }


    public function actionLog($id)
    {
        $model = $this->findDummyModel($id);
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

    // --- Helper Functions ---

    protected function findDummyModel($id)
    {
        $data = $this->getDummyData();
        foreach ($data as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }

    protected function getDummyData()
    {
        // Ini data pendaftaran yang digunakan di modul Verifikasi Draft SK
        return [
            [
                'id' => 1,
                'nomor_daftar' => '030004',
                'nama_izin' => 'Izin Penyelenggaraan Reklame',
                'jenis_permohonan' => 'PENCABUTAN',
                'nama_pemohon' => 'Budi Santoso',
                'nama_usaha' => 'Toko Kelontong Berkah',
                'no_ktp_npwp' => '3310010020030004 / 0123456789012345',
                'alamat' => 'Jl. Merdeka No. 10, Pemalang', // Lokasi Pemalang
                'lokasi_usaha' => 'Jl. Merdeka No. 10, Pemalang',
                'kecamatan' => 'Pemalang',
                'kelurahan' => 'Kelurahan A',
                'dari' => 'Front Office',
                'keterangan' => 'Proses verifikasi oleh Back Office',
                'tanggal_daftar' => '2014-04-28',
                'telepon' => '08123456789',
            ],
            [
                'id' => 2,
                'nomor_daftar' => '040005',
                'nama_izin' => 'Izin A (Klinik)',
                'jenis_permohonan' => 'BARU',
                'nama_pemohon' => 'Dr. Siti Aminah',
                'nama_usaha' => 'Klinik Sehat Utama',
                'no_ktp_npwp' => '3310010020040005 / 0123456789012346',
                'alamat' => 'Jl. Sudirman No. 12, Pemalang',
                'lokasi_usaha' => 'Jl. Pahlawan No. 1, Pemalang',
                'kecamatan' => 'Pemalang',
                'kelurahan' => 'Kelurahan B',
                'dari' => 'Front Office',
                'keterangan' => 'Menunggu scan berkas',
                'tanggal_daftar' => '2014-04-27',
                'telepon' => '08987654321',
            ],
        ];
    }

    protected function getLogDummyData()
    {
        return [
            ['pos' => 1, 'tanggal_mulai_entry' => '2021-04-09', 'tanggal_mulai_system' => '2021-04-09 10:30:44', 'dari' => 'Pemohon', 'nama_pengguna' => 'STI', 'proses' => 'Memeriksa Berkas Permohonan', 'tanggal_selesai_entry' => '2021-04-09', 'tanggal_selesai_system' => '2021-04-09 10:30:44', 'kirim_ke' => 'Front Office', 'berkas_tolak_kirim_entry' => '2021-04-09', 'berkas_tolak_kirim_system' => '2021-04-09 10:30:44', 'catatan' => 'SUDH DINPUTING', 'status' => '2021-04-09 10:30:44', 'tanggal_terima_tolak' => '2021-04-09', 'penilaian_kepatuhan' => null, 'lambat_hari' => 0, 'lambat_jam' => 0, 'lambat_menit' => 0,],
            ['pos' => 2, 'tanggal_mulai_entry' => '2021-04-09', 'tanggal_mulai_system' => '2021-04-09 10:37:59', 'dari' => 'Front Office', 'nama_pengguna' => 'FO1', 'proses' => 'Menerima, Memeriksa Kelengkapan Berkas Dan Input Data Primer Permohonan Izin', 'tanggal_selesai_entry' => '2021-04-09', 'tanggal_selesai_system' => '2021-04-09 10:37:59', 'kirim_ke' => 'Back Office', 'berkas_tolak_kirim_entry' => '2021-04-14', 'berkas_tolak_kirim_system' => '2021-04-14 08:35:46', 'catatan' => 'SUDH DINPUTING', 'status' => '2021-04-14 14:40:03', 'tanggal_terima_tolak' => '2021-04-14', 'penilaian_kepatuhan' => null, 'lambat_hari' => 0, 'lambat_jam' => 0, 'lambat_menit' => 0,],
        ];
    }
}
