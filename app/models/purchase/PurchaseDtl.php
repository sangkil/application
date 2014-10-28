<?php

namespace app\models\purchase;

use yii\helpers\ArrayHelper;
use app\models\master\Uom;
use app\models\master\Product;
use app\models\master\ProductUom;

/**
 * PurchaseDtl
 *
 * @property Product $product
 * @property ProductUom[] $productUoms
 * @property Uom[] $uoms
 * @property Purchase $purchase
 * @property array $uomList
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
        return $this->hasMany(Uom::className(), ['id' => 'uom_id'])->via('productUoms');
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProductUoms()
    {
        return $this->hasMany(ProductUom::className(), ['product_id' => 'id'])->via('product');
    }

    public function getPurchase()
    {
        return $this->hasOne(Purchase::className(), ['id' => 'purchase_id']);
    }
}