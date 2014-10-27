<?php

namespace app\assets;

use yii\helpers\Json;
use yii\web\View;
use yii\helpers\ArrayHelper;

/**
 * BizWidget
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class BizWidget extends \yii\base\Widget
{
    /**
     * @var array 
     */
    public $config = [];

    /**
     * @var array 
     */
    public $scripts = [];

    protected function getClientOptions()
    {
        return ArrayHelper::merge([
                'pullUrl' => \yii\helpers\Url::to(['/masters']),
                ], $this->config);
    }

    public function run()
    {
        $view = $this->getView();
        BizAsset::register($view);
        $options = $this->getClientOptions();
        if (isset($options['masters'])) {
            BizMasterAsset::register($view);
        }

        $config = Json::encode($options);
        $view->registerJs("biz.configure({$config});", View::POS_END);

        /* from yiqing */
        $jsBlockPattern = '|^<script[^>]*>(?P<block_content>.+?)</script>$|is';

        foreach ($this->scripts as $position => $js) {
            if (preg_match($jsBlockPattern, $js, $matches)) {
                $js = $matches['block_content'];
            }
            $view->registerJs($js, $position);
        }
    }
}