<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'defaultRoute' => 'admin/login',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',

            'modules' => [
                'pendaftaran' => [
                    'class' => 'app\modules\admin\pendaftaran\Module',
                    'modules' => [
                        'pendaftaran' => [
                            'class' => 'app\modules\admin\pendaftaran\pendaftaran\Module',
                        ],
                        'pendaftaran_multi' => [
                            'class' => 'app\modules\admin\pendaftaran\pendaftaran_multi\Module',
                        ],
                        'pendaftaran_online' => [
                            'class' => 'app\modules\admin\pendaftaran\pendaftaran_online\Module',
                        ],
                    ],
                ],
                'laporan' => [
                    'class' => 'app\modules\admin\laporan\Module',
                    'modules' => [
                        'laporan_register_pendaftaran' => [
                            'class' => 'app\modules\admin\laporan\laporan_register_pendaftaran\Module',
                        ],
                        'laporan_perizinan' => [
                            'class' => 'app\modules\admin\laporan\laporan_perizinan\Module',
                        ],
                        'laporan_bulanan' => [
                            'class' => 'app\modules\admin\laporan\laporan_bulanan\Module',
                        ],
                    ],
                ],
                'back_office' => [
                    'class' => 'app\modules\admin\back_office\Module',
                    'modules' => [
                        'berita_acara_pemeriksaan' => [
                            'class' => 'app\modules\admin\back_office\berita_acara_pemeriksaan\Module',
                        ],
                        'cetak_skrd' => [
                            'class' => 'app\modules\admin\back_office\cetak_skrd\Module',
                        ],
                        'perhitungan_retribusi' => [
                            'class' => 'app\modules\admin\back_office\perhitungan_retribusi\Module',
                        ],
                        'surat_tugas' => [
                            'class' => 'app\modules\admin\back_office\surat_tugas\Module',
                        ],
                        'verifikasi_draft_sk' => [
                            'class' => 'app\modules\admin\back_office\verifikasi_draft_sk\Module',
                        ],
                        'verifikasi_izin' => [
                            'class' => 'app\modules\admin\back_office\verifikasi_izin\Module',
                        ],
                        'cetak_draft_sk' => [
                            'class' => 'app\modules\admin\back_office\cetak_draft_sk\Module',
                        ],
                        'penomoran_sk' => [
                            'class' => 'app\modules\admin\back_office\penomoran_sk\Module',
                        ],
                        'pengambilan_sk' => [
                            'class' => 'app\modules\admin\back_office\pengambilan_sk\Module',
                        ],
                        'laporan_penyerahan_sk' => [
                            'class' => 'app\modules\admin\back_office\laporan_penyerahan_sk\Module',
                        ],
                    ],
                ],

                'master_data' => [
                    'class' => 'app\modules\admin\master_data\Module',
                    'modules' => [
                        'kbli' => [
                            'class' => 'app\modules\admin\master_data\kbli\Module',
                        ],
                    ],
                ],
                'login' => [
                    'class' => 'app\modules\admin\login\Module',
                ],
                'logout' => [
                    'class' => 'app\modules\admin\logout\Module',
                ],
                'dashboard' => [
                    'class' => 'app\modules\admin\dashboard\Module',
                ],
            ],
        ],
        'pemohon' => [
            'class' => 'app\modules\pemohon\Module',
            'modules' => [
                'login' => [
                    'class' => 'app\modules\pemohon\login\Module',
                ],
                'logout' => [
                    'class' => 'app\modules\pemohon\logout\Module',
                ],
                'dashboard' => [
                    'class' => 'app\modules\pemohon\dashboard\Module',
                ],
                'info_syarat' => [
                    'class' => 'app\modules\pemohon\info_syarat\Module',
                ],
                'ganti_password' => [
                    'class' => 'app\modules\pemohon\ganti_password\Module',
                ],
                'pencarian' => [
                    'class' => 'app\modules\pemohon\pencarian\Module',
                    'modules' => [
                        'pencarian_pendaftaran' => [
                            'class' => 'app\modules\pemohon\pencarian\pencarian_pendaftaran\Module',
                        ],
                        'pencarian_routing' => [
                            'class' => 'app\modules\pemohon\pencarian\pencarian_routing\Module',
                        ],
                    ],
                ],
                'pengambilan' => [
                    'class' => 'app\modules\pemohon\pengambilan\Module',
                    'modules' => [
                        'pengambilan_sk' => [
                            'class' => 'app\modules\pemohon\pengambilan\pengambilan_sk\Module',
                        ],
                        'laporan_penyerahan_sk' => [
                            'class' => 'app\modules\pemohon\pengambilan\laporan_penyerahan_sk\Module',
                        ],
                    ],
                ],
                'berkas_masuk' => [
                    'class' => 'app\modules\pemohon\berkas_masuk\Module',
                    'modules' => [
                        'berkas_masuk_diterima' => [
                            'class' => 'app\modules\pemohon\berkas_masuk\berkas_masuk_diterima\Module',
                        ],
                        'berkas_masuk_diproses' => [
                            'class' => 'app\modules\pemohon\berkas_masuk\berkas_masuk_diproses\Module',
                        ],
                        'berkas_masuk_arsip' => [
                            'class' => 'app\modules\pemohon\berkas_masuk\berkas_masuk_arsip\Module',
                        ],
                    ],
                ],
                'berkas_keluar' => [
                    'class' => 'app\modules\pemohon\berkas_keluar\Module',
                    'modules' => [
                        'berkas_keluar_sukses' => [
                            'class' => 'app\modules\pemohon\berkas_keluar\berkas_keluar_sukses\Module',
                        ],
                        'berkas_keluar_menunggu' => [
                            'class' => 'app\modules\pemohon\berkas_keluar\berkas_keluar_menunggu\Module',
                        ],
                        'berkas_keluar_dikembalikan' => [
                            'class' => 'app\modules\pemohon\berkas_keluar\berkas_keluar_dikembalikan\Module',
                        ],
                        'berkas_keluar_arsip' => [
                            'class' => 'app\modules\pemohon\berkas_keluar\berkas_keluar_arsip\Module',
                        ],
                    ],
                ],
            ],
        ],
        'executive_summary' => [
            'class' => 'app\modules\executive_summary\Module',
            'modules' => [
                'laporan' => [
                    'class' => 'app\modules\executive_summary\laporan\Module',
                    'modules' => [
                        'laporan_cetak_skrd' => [
                            'class' => 'app\modules\executive_summary\laporan\laporan_cetak_skrd\Module',
                        ],
                        'laporan_cetak_sk' => [
                            'class' => 'app\modules\executive_summary\laporan\laporan_cetak_sk\Module',
                        ],
                        'laporan_pemrosesan_izin' => [
                            'class' => 'app\modules\executive_summary\laporan\laporan_pemrosesan_izin\Module',
                        ],
                        'laporan_pemrosesan_izin_online' => [
                            'class' => 'app\modules\executive_summary\laporan\laporan_pemrosesan_izin_online\Module',
                        ],
                        'laporan_register_pendaftaran' => [
                            'class' => 'app\modules\executive_summary\laporan\laporan_register_pendaftaran\Module',
                        ],
                        'laporan_perizinan' => [
                            'class' => 'app\modules\executive_summary\laporan\laporan_perizinan\Module',
                        ],
                        'laporan_perizinan_online' => [
                            'class' => 'app\modules\executive_summary\laporan\laporan_perizinan_online\Module',
                        ],
                        'laporan_bulanan' => [
                            'class' => 'app\modules\executive_summary\laporan\laporan_bulanan\Module',
                        ],
                        'laporan_penyerahan_sk' => [
                            'class' => 'app\modules\executive_summary\laporan\laporan_penyerahan_sk\Module',
                        ],
                    ],
                ],
                'izin_terbit_sk' => [
                    'class' => 'app\modules\executive_summary\izin_terbit_sk\Module',
                ],
                'verifikasi_draft_sk' => [
                    'class' => 'app\modules\executive_summary\verifikasi_draft_sk\Module',
                ],
                'dashboard' => [
                    'class' => 'app\modules\executive_summary\dashboard\Module',
                ],
                'login' => [
                    'class' => 'app\modules\executive_summary\login\Module',
                ],
                'logout' => [
                    'class' => 'app\modules\executive_summary\logout\Module',
                ],
            ],
        ],
        'admin_khusus' => [
            'class' => 'app\modules\admin_khusus\Module',
            'modules' => [
                'setting' => [
                    'class' => 'app\modules\admin_khusus\setting\Module',
                    'modules' => [
                        'setting_kepala_dinas' => 'app\modules\admin_khusus\setting\setting_kepala_dinas\Module',
                        'setting_sektor' => 'app\modules\admin_khusus\setting\setting_sektor\Module',
                        'setting_jenis_izin' => 'app\modules\admin_khusus\setting\setting_jenis_izin\Module',
                    ],
                ],
                'login' => [
                    'class' => 'app\modules\admin_khusus\login\Module',
                ],
                'logout' => [
                    'class' => 'app\modules\admin_khusus\logout\Module',
                ],
                'dashboard' => [
                    'class' => 'app\modules\admin_khusus\dashboard\Module',
                ],
                'referensi' => [
                    'class' => 'app\modules\admin_khusus\referensi\Module',
                    'modules' => [
                        'referensi_jenis_izin' => [
                            'class' => 'app\modules\admin_khusus\referensi\referensi_jenis_izin\Module',
                        ],
                        'referensi_jenis_permohonan' => [
                            'class' => 'app\modules\admin_khusus\referensi\referensi_jenis_permohonan\Module',
                        ],
                        'referensi_pengguna' => [
                            'class' => 'app\modules\admin_khusus\referensi\referensi_pengguna\Module',
                        ],
                        'referensi_tugas_blok_sistem' => [
                            'class' => 'app\modules\admin_khusus\referensi\referensi_tugas_blok_sistem\Module',
                        ],
                        'referensi_persyaratan' => [
                            'class' => 'app\modules\admin_khusus\referensi\referensi_persyaratan\Module',
                        ],
                        'referensi_kendali_alur' => [
                            'class' => 'app\modules\admin_khusus\referensi\referensi_kendali_alur\Module',
                        ],
                    ],
                ],
            ],
        ]
    ],

    'components' => [
        'request' => [
            'cookieValidationKey' => 'HryQDeuMVsoirujkfcTU7Qam4oIHOK6M',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
