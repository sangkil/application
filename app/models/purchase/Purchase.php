<?php

namespace app\models\purchase;

use Yii;
use app\models\master\Supplier;
use app\models\inventory\GoodMovement;

/**
 * Description of Purchase
 *
 * @property PurchaseDtl[] $purchaseDtls
 * @property GoodMovement[] $grs
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 */
class Purchase extends \biz\core\purchase\models\Purchase
{

    public function rules()
    {
        $rules = parent::rules();
        return array_merge([
            [['nmSupplier', 'Date'], 'required'],
            [['nmSupplier'], 'in', 'range' => Supplier::find()->select('name')->column()],
            ], $rules, [
            [['purchaseDtls'], 'calcPurcValue'],
                
        ]);
    }

    public function calcPurcValue()
    {
        
    }
    
    public function getPurchaseDtls()
    {
        return $this->hasMany(PurchaseDtl::className(), ['purchase_id' => 'id']);
    }

    public function getGrs()
    {
        return $this->hasMany(GoodMovement::className(), ['reff_id' => 'id'])
                ->onCondition(['reff_type' => GoodMovement::TYPE_PURCHASE]);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            [
                'class' => 'mdm\converter\DateConverter',
                'attributes' => [
                    'Date' => 'date',
                ]
            ],
            [
                'class' => 'mdm\converter\RelatedConverter',
                'attributes' => [
                    'nmSupplier' => [[Supplier::className(), 'id' => 'supplier_id'], 'name'],
                ],
            ],
        ]);
    }
}