<?php

namespace app\models\master;

use yii\helpers\ArrayHelper;
/**
 * Customer
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Customer extends \biz\core\master\models\Customer
{

    public static function selectOptions()
    {
        return ArrayHelper::map(static::find()->asArray()->all(), 'id', 'name');
    }
}