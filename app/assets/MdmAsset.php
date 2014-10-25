<?php

namespace app\assets;

/**
 * MdmAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class MdmAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/assets/js';
    public $js = [
        'mdm.kelas.js',
        'mdm.storage.js',
    ];

}