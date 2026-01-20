<?php

namespace app\modules\admin\laporan\laporan_perizinan\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $formatter = Yii::$app->formatter;
        $tahun = $request->get('tahun', date('Y'));
        $bulan = $request->get('bulan', date('n'));
        $tanggal_cetak = $request->get('tanggal_cetak', date('Y-m-d'));
        $submitBtn = $request->get('submit_btn');

        // $isSearch hanya true jika salah satu tombol submit diklik
        $isSearch = ($submitBtn !== null);
        $rekapData = [];
        $bulanItems = $this->getBulanItems();

        if ($isSearch) {
            $rekapData = $this->getDummyRekapData($tahun, $bulan);
            if ($submitBtn === 'excel') {
                Yii::$app->session->setFlash('warning', [
                    'title' => 'Fitur Belum Tersedia',
                    'text' => 'Fungsi export Excel sedang dalam pengembangan.'
                ]);
            }
        }

        $bulan_ini_nama = strtoupper($bulanItems[$bulan] ?? '...');
        // Handle kasus bulan Januari (bulan 1), bulan lalunya adalah 12
        $bulan_lalu = ($bulan == 1) ? 12 : ($bulan - 1);
        $bulan_lalu_nama = strtoupper($bulanItems[$bulan_lalu] ?? '...');

        return $this->render('index', [
            'isSearch' => $isSearch,
            // 'autoPrint' dihapus, dipindah ke actionCetak
            'rekapData' => $rekapData,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'tanggal_cetak' => $tanggal_cetak,
            'tahunItems' => $this->getTahunItems(),
            'bulanItems' => $bulanItems,
            'bulan_ini_nama' => $bulan_ini_nama,
            'bulan_lalu_nama' => $bulan_lalu_nama,
        ]);
    }

    /**
     * Action baru untuk halaman cetak (HTML)
     */
    public function actionCetak()
    {
        $request = Yii::$app->request;
        $tahun = $request->get('tahun', date('Y'));
        $bulan = $request->get('bulan', date('n'));
        $tanggal_cetak = $request->get('tanggal_cetak', date('Y-m-d'));

        $bulanItems = $this->getBulanItems();
        $rekapData = $this->getDummyRekapData($tahun, $bulan);

        $bulan_ini_nama = strtoupper($bulanItems[$bulan] ?? '...');
        $bulan_lalu = ($bulan == 1) ? 12 : ($bulan - 1);
        $bulan_lalu_nama = strtoupper($bulanItems[$bulan_lalu] ?? '...');

        // Nonaktifkan layout
        $this->layout = false;

        return $this->render('_cetak', [
            'rekapData' => $rekapData,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'tanggal_cetak' => $tanggal_cetak,
            'bulan_ini_nama' => $bulan_ini_nama,
            'bulan_lalu_nama' => $bulan_lalu_nama,
        ]);
    }

    /**
     * Menampilkan halaman detail (drill-down)
     * * @var string $jenis_izin (FIX: Menambahkan '$')
     * @var string $status
     * @var string $tahun
     * @var string|null $bulan
     * @var string|null $sd_bulan
     */
    public function actionDetail($jenis_izin, $status, $tahun, $bulan = null, $sd_bulan = null)
    {
        $request = Yii::$app->request;
        $this->layout = false;

        $allData = $this->getDummyDetailData();

        $filteredData = array_filter($allData, function ($item) use ($jenis_izin, $status) {
            // Filter Jenis Izin
            $jenisSesuai = true;
            if ($jenis_izin !== 'SEMUA') {
                $jenisSesuai = ($item['jenis_izin_kode'] === $jenis_izin);
            }

            // (FIX) Logika filter status dirombak
            $statusSesuai = false;
            switch ($status) {
                case 'masuk':
                    $statusSesuai = in_array($item['keterangan'], ['BARU', 'DAFTAR ULANG']);
                    break;
                case 'terbit':
                    $statusSesuai = ($item['tgl_terbit'] !== null);
                    break;
                case 'proses':
                    // Proses = Belum terbit DAN tidak ditolak
                    $statusSesuai = ($item['tgl_terbit'] === null && $item['status_permohonan'] !== 'Ditolak');
                    break;
                case 'ditolak':
                    $statusSesuai = ($item['status_permohonan'] === 'Ditolak');
                    break;
            }

            return $jenisSesuai && $statusSesuai;
        });

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'key' => 'id',
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('detail', [
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
            'params' => $request->get(),
        ]);
    }


    // --- FUNGSI DATA HELPER ---
    protected function getDummyRekapData($tahun, $bulan)
    {
        return [
            'A' => [
                'nama' => 'Perizinan Terstruktur',
                'items' => [
                    1 => ['nama' => 'Izin Lokasi', 'kode' => 'IL', 'data' => [
                        'prev' => ['masuk' => 0, 'terbit' => 0, 'proses' => 0, 'ditolak' => 0],
                        'current' => ['masuk' => 0, 'terbit' => 0, 'proses' => 0, 'ditolak' => 0],
                        'total' => ['masuk' => 0, 'terbit' => 0, 'proses' => 0, 'ditolak' => 0],
                    ]],
                    2 => ['nama' => 'Surat Terdaftar Pengobatan Tradisional (STPT)', 'kode' => 'STPT', 'data' => [
                        'prev' => ['masuk' => 6, 'terbit' => 5, 'proses' => 1, 'ditolak' => 0],
                        'current' => ['masuk' => 1, 'terbit' => 0, 'proses' => 1, 'ditolak' => 0],
                        'total' => ['masuk' => 7, 'terbit' => 5, 'proses' => 2, 'ditolak' => 0],
                    ]],
                    3 => ['nama' => 'Surat Izin Operasional Lembaga Kesejahteraan Sosial (LKS) /Panti', 'kode' => 'LKS', 'data' => [
                        'prev' => ['masuk' => 4, 'terbit' => 0, 'proses' => 4, 'ditolak' => 0],
                        'current' => ['masuk' => 0, 'terbit' => 0, 'proses' => 0, 'ditolak' => 0],
                        'total' => ['masuk' => 4, 'terbit' => 0, 'proses' => 4, 'ditolak' => 0],
                    ]],
                    4 => ['nama' => 'Surat Izin Praktik Apoteker (SIPA)', 'kode' => 'SIPA', 'data' => [
                        'prev' => ['masuk' => 0, 'terbit' => 0, 'proses' => 0, 'ditolak' => 0],
                        'current' => ['masuk' => 0, 'terbit' => 0, 'proses' => 0, 'ditolak' => 0],
                        'total' => ['masuk' => 0, 'terbit' => 0, 'proses' => 0, 'ditolak' => 0],
                    ]],
                    5 => ['nama' => 'Surat Izin Praktik Ahli Teknologi Laboratorium Medik (SIP-ATLM)', 'kode' => 'ATLM', 'data' => [
                        'prev' => ['masuk' => 0, 'terbit' => 0, 'proses' => 0, 'ditolak' => 0],
                        'current' => ['masuk' => 0, 'terbit' => 0, 'proses' => 0, 'ditolak' => 0],
                        'total' => ['masuk' => 0, 'terbit' => 0, 'proses' => 0, 'ditolak' => 0],
                    ]],
                ],
            ],
            'B' => [
                'nama' => 'Perizinan Tidak Terstruktur',
                'items' => [
                    1 => ['nama' => 'Izin Penyelenggaraan Reklame', 'kode' => 'REKLAME', 'data' => [
                        'prev' => ['masuk' => 335, 'terbit' => 321, 'proses' => 14, 'ditolak' => 0],
                        'current' => ['masuk' => 17, 'terbit' => 15, 'proses' => 2, 'ditolak' => 0],
                        'total' => ['masuk' => 352, 'terbit' => 336, 'proses' => 16, 'ditolak' => 0],
                    ]],
                    2 => ['nama' => 'Rekomendasi Izin Reklame', 'kode' => 'REK-REKLAME', 'data' => [
                        'prev' => ['masuk' => 9, 'terbit' => 7, 'proses' => 2, 'ditolak' => 0],
                        'current' => ['masuk' => 0, 'terbit' => 0, 'proses' => 0, 'ditolak' => 0],
                        'total' => ['masuk' => 9, 'terbit' => 7, 'proses' => 2, 'ditolak' => 0],
                    ]],
                ],
            ],
            'total' => [
                'prev' => ['masuk' => 9829, 'terbit' => 9532, 'proses' => 9724, 'ditolak' => 2],
                'current' => ['masuk' => 788, 'terbit' => 753, 'proses' => 780, 'ditolak' => 0],
                'total' => ['masuk' => 10617, 'terbit' => 10285, 'proses' => 10504, 'ditolak' => 2],
            ]
        ];
    }


    protected function getDummyDetailData()
    {
        return [
            1 => [
                'id' => 1,
                'jenis_izin_kode' => 'STPT',
                'nomor_daftar' => '025',
                'nama_pemohon' => 'Slamet Riyadi',
                'alamat_pemohon' => 'Jl. Jend. Sudirman, Pelutan, Pemalang',
                'nama_usaha' => 'Pijat Urut Tradisional Pak Slamet',
                'lokasi_izin' => 'Desa Pelutan RT 02/RW 01, Kec. Pemalang',
                'waktu_daftar' => '30 Januari 2025',
                'tgl_seharusnya' => '6 Februari 2025',
                'tgl_terbit' => null,
                'status_sop' => 'Tidak Sesuai',
                'keterangan' => 'BARU',
                'status_permohonan' => 'Proses'
            ],
            2 => [
                'id' => 2,
                'jenis_izin_kode' => 'STPT',
                'nomor_daftar' => '025',
                'nama_pemohon' => 'Siti Aminah',
                'alamat_pemohon' => 'Desa Wanarejan, Kec. Taman',
                'nama_usaha' => 'Terapi Tulang Belakang Ibu Aminah',
                'lokasi_izin' => 'Jl. Pemuda, Wanarejan, Taman',
                'waktu_daftar' => '7 Februari 2025',
                'tgl_seharusnya' => '14 Februari 2025',
                'tgl_terbit' => '20 Februari 2025',
                'status_sop' => 'Tidak Sesuai',
                'keterangan' => 'BARU',
                'status_permohonan' => 'Selesai'
            ],
            3 => [
                'id' => 3,
                'jenis_izin_kode' => 'STPT',
                'nomor_daftar' => '025',
                'nama_pemohon' => 'Budi Santoso',
                'alamat_pemohon' => 'Jl. Gatot Subroto, Mulyoharjo, Pemalang',
                'nama_usaha' => 'Pengobatan Alternatif Budi Sehat',
                'lokasi_izin' => 'Mulyoharjo, Kec. Pemalang',
                'waktu_daftar' => '28 April 2025',
                'tgl_seharusnya' => '5 Mei 2025',
                'tgl_terbit' => '4 Mei 2025',
                'status_sop' => 'Sesuai',
                'keterangan' => 'DAFTAR ULANG',
                'status_permohonan' => 'Selesai'
            ],
            4 => [
                'id' => 4,
                'jenis_izin_kode' => 'STPT',
                'nomor_daftar' => '025',
                'nama_pemohon' => 'Eko Wibowo',
                'alamat_pemohon' => 'Desa Kaligelang, Kec. Taman',
                'nama_usaha' => 'Jamu Herbal Warisan',
                'lokasi_izin' => 'Perumahan Kaligelang Indah, Taman',
                'waktu_daftar' => '14 Mei 2025',
                'tgl_seharusnya' => '21 Mei 2025',
                'tgl_terbit' => '4 Juni 2025',
                'status_sop' => 'Sesuai',
                'keterangan' => 'BARU',
                'status_permohonan' => 'Selesai'
            ],
            5 => [
                'id' => 5,
                'jenis_izin_kode' => 'STPT',
                'nomor_daftar' => '025',
                'nama_pemohon' => 'Indah Lestari',
                'alamat_pemohon' => 'Jl. Pemuda, Kebondalem, Pemalang',
                'nama_usaha' => 'Bekam dan Ruqyah As-Syifa',
                'lokasi_izin' => 'Kebondalem, Kec. Pemalang',
                'waktu_daftar' => '28 Mei 2025',
                'tgl_seharusnya' => '4 Juni 2025',
                'tgl_terbit' => '3 Juli 2025',
                'status_sop' => 'Tidak Sesuai',
                'keterangan' => 'BARU',
                'status_permohonan' => 'Selesai'
            ],
            6 => [
                'id' => 6,
                'jenis_izin_kode' => 'STPT',
                'nomor_daftar' => '025',
                'nama_pemohon' => 'Mulyono Sutrisno',
                'alamat_pemohon' => 'Desa Petarukan, Kec. Petarukan',
                'nama_usaha' => 'Griya Sehat Pak Mulyono (STPT)',
                'lokasi_izin' => 'Jl. Raya Petarukan No. 10',
                'waktu_daftar' => '3 Juli 2025',
                'tgl_seharusnya' => '10 Juli 2025',
                'tgl_terbit' => '28 Juli 2025',
                'status_sop' => 'Tidak Sesuai',
                'keterangan' => 'BARU',
                'status_permohonan' => 'Selesai'
            ],
            7 => [
                'id' => 7,
                'jenis_izin_kode' => 'REKLAME',
                'nomor_daftar' => '2025',
                'nama_pemohon' => 'Rudi Purnomo',
                'alamat_pemohon' => 'Jl. Kolonel Sugiono, Bojongbata, Pemalang',
                'nama_usaha' => 'Reklame Toko Mas Semar',
                'lokasi_izin' => 'Perempatan Bojongbata, Pemalang',
                'waktu_daftar' => '13 Oktober 2025',
                'tgl_seharusnya' => '22 Oktober 2025',
                'tgl_terbit' => null,
                'status_sop' => 'Sesuai',
                'keterangan' => 'BARU',
                'status_permohonan' => 'Proses'
            ],
            8 => [
                'id' => 8,
                'jenis_izin_kode' => 'REKLAME',
                'nomor_daftar' => '2026',
                'nama_pemohon' => 'Dewi Kurniati (Ditolak)',
                'alamat_pemohon' => 'Jl. Raya Comal, Kec. Comal',
                'nama_usaha' => 'Spanduk Warung Makan Bu Dewi',
                'lokasi_izin' => 'Jl. A. Yani, Comal (Trotoar)',
                'waktu_daftar' => '14 Oktober 2025',
                'tgl_seharusnya' => '23 Oktober 2025',
                'tgl_terbit' => null,
                'status_sop' => 'Tidak Sesuai',
                'keterangan' => 'BARU',
                'status_permohonan' => 'Ditolak'
            ],
        ];
    }

    protected function getTahunItems()
    {
        $years = range(date('Y'), date('Y') - 5);
        return array_combine($years, $years);
    }

    // (FIX) Ubah menjadi public
    public function getBulanItems()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }
}
