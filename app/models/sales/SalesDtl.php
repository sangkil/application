<?php

namespace app\models\sales;

/**
 * SalesDtl
 *
 * @property Sales $sales
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class SalesDtl extends \biz\core\sales\models\SalesDtl
{

    public function getSales()
    {
        return $this->hasOne(Sales::className(), ['id' => 'sales_id']);
    }
}