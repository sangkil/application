<?php

namespace app\assets;

/**
 * BizMasterAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class BizMasterAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/assets/js';
    public $js = [
        'biz.master.js',
    ];
    public $depends = [
        'app\assets\BizAsset',
        'app\assets\MdmAsset',
    ];

}