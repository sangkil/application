<?php

namespace app\models\purchase;

use Yii;
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

//    public $supplier;

    public function rules()
    {
        $rules = parent::rules();
        return array_merge([
            [['supplier', 'Date'], 'required'],
            [['supplier'], 'in', 'range' => Supplier::find()->select('name')->column()],
            ], $rules);
    }

    public function getPurchaseDtls()
    {
        return $this->hasMany(PurchaseDtl::className(), ['purchase_id' => 'id']);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge([
            [
                'class' => 'mdm\converter\DateConverter',
                'attributes' => [
                    'Date' => 'date',
                ]
            ],
            [
                'class' => 'mdm\converter\RelatedConverter',
                'attributes' => [
                    'supplier' => ['supplier_id', Supplier::className(), 'name', 'id'],
                ],
            ],
            ], $behaviors);
    }
}