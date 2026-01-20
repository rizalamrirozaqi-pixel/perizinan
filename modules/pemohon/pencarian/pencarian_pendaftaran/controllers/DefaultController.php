<?php

namespace app\modules\pemohon\pencarian\pencarian_pendaftaran\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\Response;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'search-autocomplete' => ['GET'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $searchParams = $request->get('Search', []); // Ambil array filter

        // 1. Ambil Data Dummy
        $allData = $this->getDummyData();
        $filteredData = $allData;

        // 2. Logika Filter Detail (Sesuai Form Gambar)
        if (!empty($searchParams)) {
            $filteredData = array_filter($filteredData, function ($item) use ($searchParams) {
                $isValid = true;

                // Filter Text (Partial Match)
                $textFields = [
                    'nomor_daftar',
                    'nama_pemohon',
                    'nama_usaha',
                    'no_ktp_npwp',
                    'alamat',
                    'telepon',
                    'lokasi_usaha',
                    'keterangan'
                ];

                foreach ($textFields as $field) {
                    if (!empty($searchParams[$field])) {
                        if (stripos($item[$field] ?? '', $searchParams[$field]) === false) {
                            $isValid = false;
                        }
                    }
                }

                // Filter Dropdown (Exact Match)
                $dropFields = ['jenis_izin', 'jenis_permohonan', 'kecamatan', 'kelurahan'];
                foreach ($dropFields as $field) {
                    if (!empty($searchParams[$field])) {
                        if (($item[$field] ?? '') !== $searchParams[$field]) {
                            $isValid = false;
                        }
                    }
                }

                // Filter Tanggal (Range)
                if (!empty($searchParams['tgl_awal']) && !empty($searchParams['tgl_akhir'])) {
                    $dateItem = strtotime($item['tanggal_raw']);
                    $dateStart = strtotime($searchParams['tgl_awal']);
                    $dateEnd = strtotime($searchParams['tgl_akhir']);

                    if ($dateItem < $dateStart || $dateItem > $dateEnd) {
                        $isValid = false;
                    }
                }

                return $isValid;
            });
        }

        // 3. Data Provider
        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'pagination' => ['pageSize' => 10],
            'sort' => [
                'attributes' => ['nomor_daftar', 'nama_pemohon', 'waktu_daftar'],
                'defaultOrder' => ['waktu_daftar' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchParams' => $searchParams,
            'dropdowns' => $this->getDropdownItems(),
            // Flag untuk menampilkan tabel hanya setelah dicari (opsional, kalau mau selalu tampil hapus kondisi di view)
            'isSearch' => !empty($searchParams),
        ]);
    }

    /**
     * Action Autocomplete untuk kolom Nomor Pendaftaran
     */
    public function actionSearchAutocomplete($term = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $results = [];

        if (!empty($term)) {
            $term = strtolower($term);
            $allData = $this->getDummyData();

            foreach ($allData as $item) {
                if (stripos($item['nomor_daftar'], $term) !== false) {
                    $results[] = [
                        'label' => $item['nomor_daftar'] . ' - ' . $item['nama_pemohon'],
                        'value' => $item['nomor_daftar'],
                    ];
                }
            }
        }
        return array_slice($results, 0, 10);
    }

    // --- DUMMY DATA ---
    protected function getDummyData()
    {
        $data = [];
        for ($i = 1; $i <= 20; $i++) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $data[] = [
                'id' => $i,
                'nomor_daftar' => sprintf("%03d/2025", $i),
                'jenis_izin' => ($i % 2 == 0) ? 'SIP' : 'REKLAME',
                'nama_izin' => ($i % 2 == 0) ? 'Surat Izin Praktik Dokter (SIP)' : 'Izin Penyelenggaraan Reklame',
                'jenis_permohonan' => ($i % 3 == 0) ? 'PERPANJANGAN' : 'BARU',
                'nama_pemohon' => ($i % 2 == 0) ? "dr. Dokter {$i}" : "Pengusaha {$i}",
                'nama_usaha' => ($i % 2 == 0) ? "Klinik Sehat {$i}" : "CV. Maju {$i}",
                'no_ktp_npwp' => '3327' . sprintf("%012d", $i),
                'alamat' => "Jl. Pemuda No. {$i}",
                'telepon' => '08123456789',
                'lokasi_usaha' => "Kecamatan Pemalang",
                'kecamatan' => 'KEC1',
                'kelurahan' => 'KEL1',
                'keterangan' => '-',
                'waktu_daftar' => Yii::$app->formatter->asDate($date, 'full') . ' (Pukul 09:00)',
                'tanggal_raw' => $date,
            ];
        }
        return $data;
    }

    protected function getDropdownItems()
    {
        return [
            'jenis_izin' => ['SIP' => 'Surat Izin Praktik Dokter (SIP)', 'REKLAME' => 'Izin Penyelenggaraan Reklame'],
            'jenis_permohonan' => ['BARU' => 'BARU', 'PERPANJANGAN' => 'PERPANJANGAN', 'PERUBAHAN' => 'PERUBAHAN'],
            'kecamatan' => ['KEC1' => 'Pemalang', 'KEC2' => 'Taman'],
            'kelurahan' => ['KEL1' => 'Mulyoharjo', 'KEL2' => 'Beji'],
        ];
    }
}
