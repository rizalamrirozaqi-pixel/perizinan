<?php

/**
 * @var yii\web\View $this
 * @var array $data Data untuk sel (e.g., ['masuk' => 0, 'terbit' => 0, ...])
 * @var array $params Parameter URL dasar (e.g., ['tahun' => 2025, 'bulan' => 10])
 * @var string $jenis_izin_kode Kode izin (e.g., 'STPT' atau 'SEMUA')
 * @var bool $isTotal Apakah ini baris total?
 */

use yii\helpers\Html;
use yii\helpers\Url;

// Default $isTotal jika tidak di-pass
$isTotal = $isTotal ?? false;

/**
 * Membuat link HANYA jika $count > 0
 */
$createLink = function ($status, $count) use ($params, $jenis_izin_kode, $isTotal) {
    if ($count == 0 || $count === null) {
        return 0; // Tampilkan angka 0 jika tidak ada data
    }

    $linkParams = $params;

    // Jangan tambahkan 'jenis_izin' jika ini adalah baris total (karena sudah SEMUA)
    if ($jenis_izin_kode !== 'SEMUA') {
        $linkParams['jenis_izin'] = $jenis_izin_kode;
    }

    $linkParams['status'] = $status;

    // Tentukan route
    $linkParams[0] = 'detail';

    // Buat link
    return Html::a($count, Url::to($linkParams), ['target' => '_blank']);
};
?>

<td class="text-center"><?= $createLink('masuk', $data['masuk'] ?? 0) ?></td>
<td class="text-center"><?= $createLink('terbit', $data['terbit'] ?? 0) ?></td>
<td class="text-center"><?= $createLink('proses', $data['proses'] ?? 0) ?></td>
<td class="text-center"><?= $createLink('ditolak', $data['ditolak'] ?? 0) ?></td>