<?php

namespace app\modules\admin_khusus\dashboard\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        $cardMasuk = 1250;
        $cardTerbit = 135;
        $cardDitolak = 425;
        $lineLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        $lineMasuk   = [20, 25, 35, 75, 80, 42]; // Ungu
        $lineTerbit  = [40, 25, 30, 40, 70, 40]; // Hijau
        $lineDitolak = [0, 5, 38, 45, 60, 60];   // Orange
        $pieData = [69, 8, 24];

        $barMasuk   = [65, 65, 70, 70, 65, 60, 65, 50, 40, 0, 0, 0];
        $barTerbit  = [45, 45, 40, 50, 55, 60, 50, 50, 45, 0, 0, 0];
        $barDitolak = [40, 45, 40, 45, 40, 45, 50, 60, 50, 0, 0, 0];
        return $this->render('index', [
            'cardMasuk'   => $cardMasuk,
            'cardTerbit'  => $cardTerbit,
            'cardDitolak' => $cardDitolak,
            'lineLabels'  => $lineLabels,
            'lineMasuk'   => $lineMasuk,
            'lineTerbit'  => $lineTerbit,
            'lineDitolak' => $lineDitolak,
            'pieData'     => $pieData,
            'barMasuk'    => $barMasuk,
            'barTerbit'   => $barTerbit,
            'barDitolak'  => $barDitolak,
        ]);
    }
}
