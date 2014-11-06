<?php

namespace app\models\inventory;

use Yii;
use app\models\master\Product;

/**
 * GoodMovementDtl
 *
 * @property Product $product
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class GoodMovementDtl extends \biz\core\inventory\models\GoodMovementDtl
{
    public $avaliable;

    public function rules()
    {
        $rules = parent::rules();
        return array_merge($rules, [
            [['avaliable'], 'safe'],
            [['qty'], 'compare', 'compareAttribute' => 'avaliable', 'operator' => '>=',
                'when' => function($obj) {
                return $obj->avaliable !== null && $obj->avaliable !== '';
            }]
        ]);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}