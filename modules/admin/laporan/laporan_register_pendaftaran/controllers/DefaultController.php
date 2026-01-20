<?php

namespace app\modules\admin\laporan\laporan_register_pendaftaran\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

class DefaultController extends Controller
{

    /**
     * Menampilkan form pencarian dan hasil laporan (jika dicari).
     * @return string
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;

        $tanggal_awal = $request->get('tanggal_awal', date('Y-m-01'));
        $tanggal_akhir = $request->get('tanggal_akhir', date('Y-m-d'));
        $status_pendaftaran = $request->get('status_pendaftaran', 'SEMUA');
        $submitBtn = $request->get('submit_btn');

        // $isSearch hanya true jika tombol 'cari' yang diklik
        $isSearch = ($submitBtn !== null && $submitBtn === 'cari');
        $filteredData = [];

        // Ambil data jika $isSearch true
        if ($isSearch) {
            $filteredData = $this->findLaporanData($tanggal_awal, $tanggal_akhir, $status_pendaftaran);
        }

        // Logika untuk tombol excel
        if ($submitBtn === 'excel') {
            Yii::$app->session->setFlash('warning', [
                'title' => 'Fitur Belum Tersedia',
                'text' => 'Fungsi export Excel sedang dalam pengembangan.'
            ]);
            // Re-fetch data agar tampilan tidak kosong setelah klik excel
            // dan set $isSearch true agar tabel tetap tampil
            $filteredData = $this->findLaporanData($tanggal_awal, $tanggal_akhir, $status_pendaftaran);
            $isSearch = true;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'key' => 'id',
            'pagination' => ['pageSize' => 5],
            'sort' => [
                'attributes' => ['id', 'tanggal_register', 'pemohon_perusahaan'],
                'defaultOrder' => ['tanggal_register' => SORT_ASC],
            ],
        ]);

        // Render view 'index.php'
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
            'isSearch' => $isSearch,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'status_pendaftaran' => $status_pendaftaran,
            'statusItems' => $this->getStatusPendaftaranItems(), 
        ]);
    }

    /**
     * Action baru untuk halaman cetak saja (target _blank).
     */
    public function actionCetak()
    {
        $request = Yii::$app->request;

        // Ambil parameter dari GET
        $tanggal_awal = $request->get('tanggal_awal', date('Y-m-01'));
        $tanggal_akhir = $request->get('tanggal_akhir', date('Y-m-d'));
        $status_pendaftaran = $request->get('status_pendaftaran', 'SEMUA');

        // Cari data berdasarkan parameter
        $filteredData = $this->findLaporanData($tanggal_awal, $tanggal_akhir, $status_pendaftaran);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
            'key' => 'id',
            'pagination' => false,
        ]);

        // === INI PERBAIKAN ERROR ANDA ===
        // Gunakan 'layout' (singular), bukan 'layouts' (plural)
        $this->layout = false;

        // Render view '_cetak.php'
        return $this->render('_cetak', [
            'models' => $dataProvider->getModels(),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'status_pendaftaran' => $status_pendaftaran,
        ]);
    }

    /**
     * Logika reusable untuk memfilter data laporan.
     */
    protected function findLaporanData($tanggal_awal, $tanggal_akhir, $status_pendaftaran)
    {
        $allData = $this->getDummyRegisterData();

        return array_filter($allData, function ($item) use ($tanggal_awal, $tanggal_akhir, $status_pendaftaran) {
            $tanggal_valid = ($item['tanggal_register'] >= $tanggal_awal && $item['tanggal_register'] <= $tanggal_akhir);

            $status_valid = true;
            if ($status_pendaftaran !== 'SEMUA') {
                $status_valid = ($item['status_pendaftaran'] === $status_pendaftaran);
            }

            return $tanggal_valid && $status_valid;
        });
    }

    /**
     * Data dummy
     */
    protected function getDummyRegisterData()
    {
        return [
            [
                'id' => 1,
                'tanggal_register' => '2025-10-01',
                'status_pendaftaran' => 'OFFLINE',
                'pemohon_perusahaan' => 'USAHA PERTANIAN / PERTANIAN',
                'alamat_pemohon_lokasi' => 'Jl. Pertanian No. 1, Desa Suka Maju, Pemalang',
                'biaya' => null,
                'no_izin' => null,
                'nama_pengambil' => null,
                'tanggal_pengambil' => null,
                'ttd_pengambil' => null,
                'ttd_petugas' => null,
                'permohonan' => 'DAFTAR ULANG',
                'keterangan' => 'Izin Pembelian BBM Solar Bersubsidi Untuk Usaha Mikro',
            ],
            [
                'id' => 2,
                'tanggal_register' => '2025-10-01',
                'status_pendaftaran' => 'ONLINE',
                'pemohon_perusahaan' => 'USAHA PERTANIAN / PERTANIAN',
                'alamat_pemohon_lokasi' => 'Jl. Tani Jaya No. 2, Desa Makmur, Pemalang',
                'biaya' => null,
                'no_izin' => null,
                'nama_pengambil' => null,
                'tanggal_pengambil' => null,
                'ttd_pengambil' => null,
                'ttd_petugas' => null,
                'permohonan' => 'DAFTAR ULANG',
                'keterangan' => 'Izin Pembelian BBM Solar Bersubsidi Untuk Usaha Mikro',
            ],
            [
                'id' => 4, // ID 3 sengaja dilompati
                'tanggal_register' => '2025-10-03',
                'status_pendaftaran' => 'ONLINE',
                'pemohon_perusahaan' => 'CV. MEDIA KREATIF',
                'alamat_pemohon_lokasi' => 'Jl. Bengawan Solo No. 45, Kebondalem, Pemalang',
                'biaya' => 'Rp 500.000',
                'no_izin' => '123/IZN/REK/X/2025',
                'nama_pengambil' => 'Andi',
                'tanggal_pengambil' => '2025-10-10',
                'ttd_pengambil' => 'Andi',
                'ttd_petugas' => 'Petugas',
                'permohonan' => 'BARU',
                'keterangan' => 'Izin Penyelenggaraan Reklame',
            ],
            [
                'id' => 5,
                'tanggal_register' => '2025-10-04',
                'status_pendaftaran' => 'OFFLINE',
                'pemohon_perusahaan' => 'Slamet Riyadi',
                'alamat_pemohon_lokasi' => 'Jl. Tentara Pelajar No. 8, Petarukan',
                'biaya' => 'Rp 2.500.000',
                'no_izin' => '124/IMB/X/2025',
                'nama_pengambil' => 'Slamet Riyadi',
                'tanggal_pengambil' => '2025-10-11',
                'ttd_pengambil' => 'Slamet R.',
                'ttd_petugas' => 'Petugas B',
                'permohonan' => 'PERPANJANGAN',
                'keterangan' => 'Izin Mendirikan Bangunan (IMB) Rumah Tinggal',
            ],
            [
                'id' => 6,
                'tanggal_register' => '2025-10-05',
                'status_pendaftaran' => 'ONLINE',
                'pemohon_perusahaan' => 'Dr. Siti Aminah',
                'alamat_pemohon_lokasi' => 'Jl. A. Yani No. 12, Mulyoharjo, Pemalang',
                'biaya' => 'Rp 1.000.000',
                'no_izin' => '125/KLINIK/X/2025',
                'nama_pengambil' => 'Susi (Staf)',
                'tanggal_pengambil' => '2025-10-12',
                'ttd_pengambil' => 'Susi',
                'ttd_petugas' => 'Petugas A',
                'permohonan' => 'BARU',
                'keterangan' => 'Izin Praktik Klinik Pratama',
            ],
            [
                'id' => 7,
                'tanggal_register' => '2025-10-06',
                'status_pendaftaran' => 'OFFLINE',
                'pemohon_perusahaan' => 'Warung Nasi Grombyang Pak Budi',
                'alamat_pemohon_lokasi' => 'Jl. RE Martadinata No. 15, Pelutan, Pemalang',
                'biaya' => null,
                'no_izin' => null,
                'nama_pengambil' => null,
                'tanggal_pengambil' => null,
                'ttd_pengambil' => null,
                'ttd_petugas' => null,
                'permohonan' => 'BARU',
                'keterangan' => 'Izin Rumah Makan (TDUP)',
            ],
            [
                'id' => 8,
                'tanggal_register' => '2025-10-06',
                'status_pendaftaran' => 'OFFLINE',
                'pemohon_perusahaan' => 'USAHA NELAYAN / PERIKANAN',
                'alamat_pemohon_lokasi' => 'Desa Asemdoyong, Taman, Pemalang',
                'biaya' => null,
                'no_izin' => null,
                'nama_pengambil' => null,
                'tanggal_pengambil' => null,
                'ttd_pengambil' => null,
                'ttd_petugas' => null,
                'permohonan' => 'BARU',
                'keterangan' => 'Izin Pembelian BBM Solar Bersubsidi Untuk Usaha Nelayan',
            ],
            [
                'id' => 9,
                'tanggal_register' => '2025-10-07',
                'status_pendaftaran' => 'ONLINE',
                'pemohon_perusahaan' => 'DR. BUDIMAN',
                'alamat_pemohon_lokasi' => 'Jl. Melati No. 1, Mulyoharjo, Pemalang',
                'biaya' => 'Rp 250.000',
                'no_izin' => '126/SIP/X/2025',
                'nama_pengambil' => 'DR. BUDIMAN',
                'tanggal_pengambil' => '2025-10-14',
                'ttd_pengambil' => 'Budi',
                'ttd_petugas' => 'Petugas C',
                'permohonan' => 'BARU',
                'keterangan' => 'Surat Izin Praktik Dokter (SIP)',
            ],
            [
                'id' => 10,
                'tanggal_register' => '2025-10-08',
                'status_pendaftaran' => 'OFFLINE',
                'pemohon_perusahaan' => 'Apotek Sumber Waras',
                'alamat_pemohon_lokasi' => 'Jl. Surohadikusumo No. 55, Beji, Taman',
                'biaya' => null,
                'no_izin' => null,
                'nama_pengambil' => null,
                'tanggal_pengambil' => null,
                'ttd_pengambil' => null,
                'ttd_petugas' => null,
                'permohonan' => 'PERPANJANGAN',
                'keterangan' => 'Izin Apotek',
            ],
            [
                'id' => 11,
                'tanggal_register' => '2025-10-08',
                'status_pendaftaran' => 'ONLINE',
                'pemohon_perusahaan' => 'USAHA PERTANIAN / PERTANIAN',
                'alamat_pemohon_lokasi' => 'Desa Pegongsoran, Pemalang',
                'biaya' => null,
                'no_izin' => null,
                'nama_pengambil' => null,
                'tanggal_pengambil' => null,
                'ttd_pengambil' => null,
                'ttd_petugas' => null,
                'permohonan' => 'BARU',
                'keterangan' => 'Izin Pembelian BBM Solar Bersubsidi Untuk Usaha Mikro',
            ],
            [
                'id' => 12,
                'tanggal_register' => '2025-10-09',
                'status_pendaftaran' => 'ONLINE',
                'pemohon_perusahaan' => 'Toko Serba Ada Jaya',
                'alamat_pemohon_lokasi' => 'Jl. A. Yani No. 30, Mulyoharjo, Pemalang',
                'biaya' => 'Rp 350.000',
                'no_izin' => '127/IZN/REK/X/2025',
                'nama_pengambil' => 'Staf Toko',
                'tanggal_pengambil' => '2025-10-15',
                'ttd_pengambil' => 'Staf',
                'ttd_petugas' => 'Petugas A',
                'permohonan' => 'BARU',
                'keterangan' => 'Izin Penyelenggaraan Reklame (Neon Box)',
            ],
        ];
    }
    /**
     * Daftar item untuk dropdown status
     */
    protected function getStatusPendaftaranItems()
    {
        return [
            'SEMUA' => 'Semua Status',
            'OFFLINE' => 'Offline',
            'ONLINE' => 'Online',
        ];
    }
}
