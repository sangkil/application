<?php

namespace app\assets;

/**
 * BizAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class BizAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/assets/js';
    public $js = [
        'mdm.numeric.js',
        'biz.js',
        'biz.global.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}