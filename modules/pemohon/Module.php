<?php

namespace app\modules\pemohon;

/**
 * pemohon module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\pemohon\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->layout = 'main';

        // custom initialization code goes here
    }
}
