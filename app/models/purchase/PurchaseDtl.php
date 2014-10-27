<?php

namespace app\models\purchase;

use yii\helpers\ArrayHelper;
use app\models\master\Uom;
use app\models\master\Product;

/**
 * PurchaseDtl
 *
 * @property Uom $uoms
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class PurchaseDtl extends \biz\core\purchase\models\PurchaseDtl
{
    private $_uomList;

    public function getUomList()
    {
        if ($this->_uomList === null) {
            $this->_uomList = ArrayHelper::map($this->uoms, 'id', 'name');
        }
        return $this->_uomList;
    }

    public function getUoms()
    {
        return $this->hasMany(Uom::className(), ['id' => 'uom_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}