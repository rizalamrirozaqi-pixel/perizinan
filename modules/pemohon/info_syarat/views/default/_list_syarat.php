<?php

use yii\helpers\Html;

/** @var array $syarat */
?>

<?php if (!empty($syarat)): ?>
    <ul class="list-group list-group-flush bg-transparent">
        <?php foreach ($syarat as $index => $item): ?>
            <li class="list-group-item bg-transparent border-0 px-0 py-2 d-flex align-items-start">
                <div class="form-check">
                    <input class="form-check-input border-secondary mt-1" type="checkbox" value="" id="chk_<?= $index ?>">
                    <label class="form-check-label text-body cursor-pointer lh-sm" for="chk_<?= $index ?>">
                        <?= Html::encode($item) ?>
                    </label>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <div class="alert alert-info d-flex align-items-center mb-0" role="alert">
        <i class="material-symbols-outlined me-2">info</i>
        <div>Tidak ada persyaratan khusus untuk kategori ini.</div>
    </div>
<?php endif; ?>