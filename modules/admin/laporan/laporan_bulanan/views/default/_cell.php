<?php
/**
 * @var yii\web\View $this
 * @var array 
 * @var array 
 * @var bool|null 
 */

use yii\helpers\Html;
use yii\helpers\Url;

$isTotal = $isTotal ?? false;

$createLink = function($status, $count) use ($params, $jenis_izin_kode, $isTotal) { 
    if ($count == 0 || $count === null) {
        return 0;
    }
    
    $linkParams = $params;
    if ($jenis_izin_kode !== 'SEMUA') {
         $linkParams['jenis_izin'] = $jenis_izin_kode;
    }
    $linkParams['status'] = $status;
    
    $linkParams[0] = 'detail'; 

    return Html::a($count, Url::to($linkParams), ['target' => '_blank']);
};
?>

<td class="text-center"><?= $createLink('masuk', $data['masuk'] ?? 0) ?></td>
<td class="text-center"><?= $createLink('terbit', $data['terbit'] ?? 0) ?></td>
<td class="text-center"><?= $createLink('proses', $data['proses'] ?? 0) ?></td>
<td class="text-center"><?= $createLink('ditolak', $data['ditolak'] ?? 0) ?></td>