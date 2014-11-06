<?php

namespace app\models\master;

use yii\helpers\ArrayHelper;

/**
 * Warehouse
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Warehouse extends \biz\core\master\models\Warehouse
{

    public static function warehouseList($branch_id = null)
    {
        $whs = static::find()->andFilterWhere([
            'branch_id' => $branch_id
        ])->all();
        return ArrayHelper::map($whs, 'id', 'name');
    }
}