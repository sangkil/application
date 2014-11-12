<?php

namespace app\models\master;

use yii\helpers\ArrayHelper;

/**
 * ProductGroup
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ProductGroup extends \biz\core\master\models\ProductGroup
{

    public static function selectOptions()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'name');
    }
}