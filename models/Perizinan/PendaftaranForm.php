<?php

namespace app\models\Perizinan;

use Yii;
use yii\base\Model;

class PendaftaranForm extends Model
{
    // Tambahkan 'id'
    public $id; 
    public $jenis_izin;
    public $jenis_permohonan;
    public $nama_usaha;
    public $bidang_usaha;
    public $nama_pemohon;
    public $nomor_ktp;
    public $nomor_npwp;
    public $alamat;
    public $nomor_hp;
    public $lokasi_usaha;
    public $sama_dengan_alamat;
    public $kecamatan;
    public $kelurahan;
    public $keterangan;
    public $syarat;

    public function rules()
    {
        return [
            [['jenis_izin', 'jenis_permohonan', 'nama_usaha', 'nama_pemohon', 'nomor_ktp', 'alamat', 'nomor_hp', 'lokasi_usaha', 'kecamatan', 'kelurahan'], 'required', 'message' => '{attribute} tidak boleh kosong.'],
            [['syarat'], 'required', 'on' => 'create', 'message' => '{attribute} tidak boleh kosong.'],
            [['nama_usaha', 'bidang_usaha', 'nama_pemohon', 'alamat', 'lokasi_usaha', 'keterangan'], 'string'],
            [['nomor_ktp', 'nomor_npwp', 'nomor_hp'], 'string', 'max' => 25],
            ['sama_dengan_alamat', 'boolean'],
            ['syarat', 'each', 'rule' => ['string']],
            // ID hanya perlu integer
            ['id', 'integer'],
        ];
    }
    
    // Attribut labels tidak perlu diubah
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_izin' => 'Jenis Izin',
            'jenis_permohonan' => 'Jenis Permohonan',
            'nama_usaha' => 'Nama Usaha',
            'bidang_usaha' => 'Bidang Usaha',
            'nama_pemohon' => 'Nama Pemohon',
            'nomor_ktp' => 'Nomor KTP',
            'nomor_npwp' => 'Nomor NPWP',
            'alamat' => 'Alamat',
            'nomor_hp' => 'Nomor HP',
            'lokasi_usaha' => 'Lokasi / Usaha / Bangunan',
            'kecamatan' => 'Kecamatan',
            'kelurahan' => 'Kelurahan/Kalurahan',
            'keterangan' => 'Keterangan',
            'syarat' => 'Syarat-syarat',
        ];
    }
}