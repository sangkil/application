<?php
/*
 * Create By Mujib Masyhudi <mujib.masyhudi@gmail.com>
 * Create at {date('now')}
 */

/**
 * Description of newPHPClass
 *
 * @author samsung-pc
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AddAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //replace some origin-style with mine
    public $css = [
        'css/mjb-style.css'
    ];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
