<?php

namespace app\models\purchase;

use app\models\master\Supplier;

/**
 * Description of Purchase
 *
 * @property PurchaseDtl[] $purchaseDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 */
class Purchase extends \biz\core\purchase\models\Purchase
{
    public $supplier;

    public function rules()
    {
        $rules = parent::rules();
        return array_merge([
            [['supplier'], 'required'],
            [['supplier'], 'in', 'range' => Supplier::find()->select(['name'])->column()],
            ], $rules);
    }

    public function getPurchaseDtls()
    {
        return $this->hasMany(PurchaseDtl::className(), ['purchase_id' => 'id']);
    }
}