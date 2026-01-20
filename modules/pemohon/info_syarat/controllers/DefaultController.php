<?php

namespace app\modules\pemohon\info_syarat\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'get-syarat' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'listIzin' => $this->getListIzin(),
            'listPermohonan' => $this->getListPermohonan(),
        ]);
    }

    public function actionGetSyarat()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $izinId = $request->post('izin_id');
        $permohonanId = $request->post('permohonan_id');

        if (empty($izinId) || empty($permohonanId)) {
            return [
                'found' => false,
                'html' => '<span class="text-muted fst-italic">(Pilih dulu Jenis Izin dan Jenis Permohonan)</span>'
            ];
        }

        $allSyarat = $this->getDummySyarat();
        $key = $izinId . '_' . $permohonanId;
        $syaratDitemukan = $allSyarat[$key] ?? null;

        // Jika tidak ketemu persis, coba cari fallback (opsional, biar tidak kosong melompong)
        if (!$syaratDitemukan) {
            // Contoh: Kalau tidak ada data spesifik, ambil data umum izin tersebut
            // $syaratDitemukan = $allSyarat[$izinId . '_BARU'] ?? []; 
        }

        if ($syaratDitemukan) {
            // Render file partial _list_syarat.php
            // PENTING: Pastikan file ini ada di views/default/_list_syarat.php
            $html = $this->renderAjax('_list_syarat', [
                'syarat' => $syaratDitemukan
            ]);
            return ['found' => true, 'html' => $html];
        } else {
            return [
                'found' => false,
                'html' => '<div class="alert alert-warning d-flex align-items-center"><i class="material-symbols-outlined me-2">warning</i> Data syarat untuk kombinasi ini belum tersedia di database.</div>'
            ];
        }
    }

    public function actionCetak($izin_id, $permohonan_id)
    {
        $allSyarat = $this->getDummySyarat();
        $key = $izin_id . '_' . $permohonan_id;
        $syarat = $allSyarat[$key] ?? [];

        $listIzin = $this->getListIzin();
        $listPermohonan = $this->getListPermohonan();

        $namaIzin = $listIzin[$izin_id] ?? '-';
        $namaPermohonan = $listPermohonan[$permohonan_id] ?? '-';

        $this->layout = false;
        return $this->renderPartial('_cetak', [
            'syarat' => $syarat,
            'namaIzin' => $namaIzin,
            'namaPermohonan' => $namaPermohonan
        ]);
    }

    // --- DATA DUMMY LENGKAP ---
    protected function getListIzin()
    {
        return [
            'SIP_DOKTER' => 'Surat Izin Praktik Dokter (SIP)',
            'IZIN_REKLAME' => 'Izin Penyelenggaraan Reklame',
            'IZIN_APOTEK' => 'Izin Apotek',
        ];
    }

    protected function getListPermohonan()
    {
        return ['BARU' => 'BARU', 'PERPANJANGAN' => 'PERPANJANGAN', 'PENCABUTAN' => 'PENCABUTAN'];
    }

    protected function getDummySyarat()
    {
        // Isikan data untuk SEMUA kombinasi agar tidak ada yang kosong/error
        return [
            // SIP DOKTER
            'SIP_DOKTER_BARU' => ['Surat Permohonan', 'Fotokopi KTP', 'Fotokopi Ijazah Legalisir', 'STR Asli & Fotokopi', 'Rekomendasi Organisasi Profesi', 'Surat Keterangan Sehat', 'Pas Foto 4x6 (3 lbr)', 'SIP Lama (jika ada)'],
            'SIP_DOKTER_PERPANJANGAN' => ['Surat Permohonan Perpanjangan', 'Fotokopi KTP', 'SIP Asli Lama', 'STR yang masih berlaku', 'Rekomendasi Organisasi Profesi', 'Pas Foto Terbaru'],
            'SIP_DOKTER_PENCABUTAN' => ['Surat Permohonan Pencabutan', 'SIP Asli', 'Alasan Pencabutan'],

            // IZIN REKLAME
            'IZIN_REKLAME_BARU' => ['Formulir Permohonan', 'KTP Pemohon', 'NPWP', 'Gambar/Desain Reklame', 'Denah Lokasi', 'Persetujuan Pemilik Lahan', 'Foto Lokasi'],
            'IZIN_REKLAME_PERPANJANGAN' => ['Surat Permohonan', 'SK Izin Lama (Asli)', 'Foto Reklame Terpasang', 'Bukti Lunas Pajak Reklame'],
            'IZIN_REKLAME_PENCABUTAN' => ['Surat Pemberitahuan', 'SK Izin Asli', 'Dokumentasi Pembongkaran'],

            // IZIN APOTEK
            'IZIN_APOTEK_BARU' => ['Surat Permohonan', 'KTP & NPWP Pemilik', 'STRA Apoteker', 'Denah Lokasi & Bangunan', 'Daftar Sarana Prasarana', 'IMB', 'BAP Lapangan'],
            'IZIN_APOTEK_PERPANJANGAN' => ['Surat Permohonan', 'SIA Lama (Asli)', 'STRA Apoteker (Update)', 'Rekomendasi Dinkes', 'Laporan Narkotika Terakhir'],
            'IZIN_APOTEK_PENCABUTAN' => ['Surat Permohonan Tutup', 'SIA Asli', 'Berita Acara Pemusnahan Obat', 'Papan Nama Dicabut'],
        ];
    }
}
