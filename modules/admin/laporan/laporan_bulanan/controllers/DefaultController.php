<?php

namespace app\modules\admin\laporan\laporan_bulanan\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

class DefaultController extends Controller
{
    /**
     * Menampilkan halaman Laporan Rekapitulasi Izin Terbit (Gambar 1)
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $formatter = Yii::$app->formatter;

        // Ambil parameter GET
        $tahun = $request->get('tahun', date('Y'));
        $tanggal_cetak = $request->get('tanggal_cetak', date('Y-m-d'));
        $submitBtn = $request->get('submit_btn');

        $isSearch = ($submitBtn !== null && $submitBtn === 'cari'); // Hanya true jika klik 'Tampilkan'
        $rekapData = [];

        if ($isSearch) {
            $rekapData = $this->getDummyRekapIzinTerbitData($tahun);
        }

        // Handle tombol excel/word
        if ($submitBtn === 'excel') {
            Yii::$app->session->setFlash('warning', [
                'title' => 'Fitur Belum Tersedia',
                'text' => 'Fungsi export Excel sedang dalam pengembangan.'
            ]);
            $rekapData = $this->getDummyRekapIzinTerbitData($tahun); // Tampilkan lagi datanya
            $isSearch = true; // Tetap tampilkan tabel
        }
        if ($submitBtn === 'word') {
            Yii::$app->session->setFlash('warning', [
                'title' => 'Fitur Belum Tersedia',
                'text' => 'Fungsi export Word sedang dalam pengembangan.'
            ]);
            $rekapData = $this->getDummyRekapIzinTerbitData($tahun); // Tampilkan lagi datanya
            $isSearch = true; // Tetap tampilkan tabel
        }


        return $this->render('index', [
            'isSearch' => $isSearch,
            // 'autoPrint' dihapus dari sini
            'rekapData' => $rekapData,

            'tahun' => $tahun,
            'tanggal_cetak' => $tanggal_cetak,
            'tahunItems' => $this->getTahunItems(),
        ]);
    }

    /**
     * (BARU) Action untuk halaman cetak HTML
     */
    public function actionCetak()
    {
        $request = Yii::$app->request;
        $tahun = $request->get('tahun', date('Y'));
        $tanggal_cetak = $request->get('tanggal_cetak', date('Y-m-d'));

        $rekapData = $this->getDummyRekapIzinTerbitData($tahun);

        // Matikan layout
        $this->layout = false;

        return $this->render('_cetak', [
            'rekapData' => $rekapData,
            'tahun' => $tahun,
            'tanggal_cetak' => $tanggal_cetak,
        ]);
    }

    /**
     * Menampilkan halaman Laporan Detail Penerbitan Izin (Gambar 2)
     * (Tidak ada perubahan di fungsi ini)
     */
    public function actionDetail($jenis_izin, $tahun, $bulan)
    {
        $request = Yii::$app->request;
        $this->layout = false;

        // Memanggil fungsi getDummyDetailPenerbitanData yang sudah di-upgrade
        $allData = $this->getDummyDetailPenerbitanData($jenis_izin, $tahun, $bulan);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $allData,
            'key' => 'id',
            'pagination' => ['pageSize' => 50],
        ]);

        $bulanItems = $this->getBulanItems();
        $namaBulan = strtoupper($bulanItems[$bulan] ?? '...');

        return $this->render('detail', [
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
            'params' => $request->get(),
            'namaBulan' => $namaBulan,
            'tahun' => $tahun,
        ]);
    }


    // --- FUNGSI DATA HELPER ---
    // (Semua fungsi helper di bawah ini tidak perlu diubah, biarkan apa adanya)

    /**
     * Menyediakan data dummy untuk Laporan Rekapitulasi (Gambar 1)
     */
    protected function getDummyRekapIzinTerbitData($tahun)
    {
        // Data di-hardcode sesuai gambar 1
        return [
            'A' => [
                'nama' => 'PERIZINAN TERSTRUKTUR',
                'items' => [
                    1 => ['nama' => 'Izin Lokasi', 'kode' => 'IL', 'bulanan' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'jumlah' => 0],
                    2 => ['nama' => 'Surat Terdaftar Pengobatan Tradisional (STPT)', 'kode' => 'STPT', 'bulanan' => [1, 1, 1, 0, 0, 1, 2, 0, 0, 0, 0, 0], 'jumlah' => 6],
                    3 => ['nama' => 'Surat Izin Operasional Lembaga Kesejahteraan Sosial (LKS) /Panti', 'kode' => 'LKS', 'bulanan' => [0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'jumlah' => 1],
                    4 => ['nama' => 'Surat Izin Praktik Apoteker (SIPA)', 'kode' => 'SIPA', 'bulanan' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'jumlah' => 0],
                    5 => ['nama' => 'Surat Izin Praktik Ahli Teknologi Laboratorium Medik (SIP-ATLM)', 'kode' => 'ATLM', 'bulanan' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'jumlah' => 0],
                    6 => ['nama' => 'Izin Trayek Otobis Angkutan Kota / Pedesaan', 'kode' => 'TRAYEK', 'bulanan' => [4, 3, 4, 2, 2, 3, 1, 3, 2, 0, 0, 0], 'jumlah' => 24],
                ],
            ],
            'B' => [
                'nama' => 'PERIZINAN TIDAK TERSTRUKTUR',
                'items' => [
                    1 => ['nama' => 'Izin Penyelenggaraan Reklame', 'kode' => 'REKLAME', 'bulanan' => [17, 57, 35, 27, 28, 61, 40, 27, 29, 15, 0, 0], 'jumlah' => 336],
                    2 => ['nama' => 'Rekomendasi Izin Reklame', 'kode' => 'REK-REKLAME', 'bulanan' => [0, 2, 3, 0, 0, 0, 0, 0, 2, 0, 0, 0], 'jumlah' => 7],
                    3 => ['nama' => 'Izin Peternakan', 'kode' => 'PETERNAKAN', 'bulanan' => [2, 2, 1, 3, 2, 2, 2, 2, 1, 1, 0, 0], 'jumlah' => 18],
                    4 => ['nama' => 'Izin Penggalian Mayat', 'kode' => 'MAYAT', 'bulanan' => [0, 1, 2, 2, 1, 2, 1, 3, 0, 2, 0, 0], 'jumlah' => 14],
                    5 => ['nama' => 'Izin Pemakaian Stadion Sirandu', 'kode' => 'SIRANDU', 'bulanan' => [0, 1, 1, 1, 2, 1, 1, 2, 0, 2, 0, 0], 'jumlah' => 11],
                ],
            ],
            'total' => [
                'bulanan' => [838, 872, 1123, 1413, 910, 995, 1212, 1115, 1056, 757, 0, 0],
                'jumlah' => 10291,
            ]
        ];
    }

    /**
     * Menyediakan data dummy untuk Laporan Detail (Gambar 2)
     */
    protected function getDummyDetailPenerbitanData($jenis_izin, $tahun, $bulan)
    {
        // 1. Ambil data rekap lengkap
        $rekapData = $this->getDummyRekapIzinTerbitData($tahun);
        $bulanIndex = $bulan - 1; // Konversi bulan (1-12) ke index array (0-11)
        $generatedData = [];
        $counter = 1;

        // 2. Buat Peta (Map) untuk KODE -> NAMA IZIN
        $izinNameMap = [];
        foreach ($rekapData as $grupKode => $grupData) {
            if ($grupKode === 'total') continue;
            foreach ($grupData['items'] as $itemData) {
                $izinNameMap[$itemData['kode']] = $itemData['nama'];
            }
        }
        $izinNameMap['SEMUA'] = 'Semua Izin'; // Untuk link di baris Total


        // 3. Cek apakah yang diklik adalah link TOTAL (SEMUA)
        if ($jenis_izin === 'SEMUA') {
            $count = $rekapData['total']['bulanan'][$bulanIndex] ?? 0;
            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    $generatedData[] = [
                        'id' => $counter++,
                        'pemohon_perusahaan' => "Pemohon (dari Total) " . ($i + 1),
                        'alamat' => "Alamat Acak No. " . ($i + 1),
                        'no_izin' => "IZN/ALL/{$tahun}/" . ($i + 1),
                        'keterangan' => "Izin Terbit (Total Bulan Ini)"
                    ];
                }
            }
        } else {
            // 4. Jika bukan TOTAL, cari Izin spesifik
            $izinDitemukan = null;
            $namaIzin = $izinNameMap[$jenis_izin] ?? 'Izin Tidak Dikenal';

            foreach ($rekapData as $grupKode => $grupData) {
                if ($grupKode === 'total') continue;
                foreach ($grupData['items'] as $itemData) {
                    if ($itemData['kode'] === $jenis_izin) {
                        $izinDitemukan = $itemData;
                        break 2; // Keluar dari 2 loop
                    }
                }
            }

            // 5. Generate data dummy sesuai jumlah ($count)
            if ($izinDitemukan) {
                $count = $izinDitemukan['bulanan'][$bulanIndex] ?? 0;
                if ($count > 0) {
                    for ($i = 0; $i < $count; $i++) {
                        $generatedData[] = [
                            'id' => $counter++,
                            'pemohon_perusahaan' => "Pemohon {$jenis_izin} " . ($i + 1),
                            'alamat' => "Jl. {$namaIzin} No. " . ($i + 1),
                            'no_izin' => "IZN/{$jenis_izin}/{$tahun}/" . ($i + 1),
                            'keterangan' => $namaIzin
                        ];
                    }
                }
            }
        }

        return $generatedData;
    }

    /**
     * Helper tahun
     */
    protected function getTahunItems()
    {
        $years = range(date('Y'), date('Y') - 5);
        return array_combine($years, $years);
    }

    /**
     * Helper bulan
     */
    protected function getBulanItems()
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
