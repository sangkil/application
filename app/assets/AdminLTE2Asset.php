<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminLTE2Asset extends AssetBundle {

    //change source location
    public $sourcePath = '@app/views/adminlte2';
    public $css = [
        'dist/css/AdminLTE.min.css',
        'dist/css/skins/_all-skins.min.css'
    ];
    public $js = [
        'dist/js/app.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
