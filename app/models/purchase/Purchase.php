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
    public $supplier;

    public function rules()
    {
        $rules = parent::rules();
        return array_merge([
            [['supplier', 'Date'], 'required'],
            [['supplier'], 'in', 'range' => Supplier::find()->select('name')->column()],
            [['supplier'], 'applySupplier'],
            ], $rules);
    }

    public function applySupplier()
    {
        $supplier = Supplier::findOne(['name' => $this->supplier]);
        if($supplier){
            $this->supplier_id = $supplier->id;
        }  else {
            $this->addError('supplier', 'Supplier not valid');
        }
    }

    public function getPurchaseDtls()
    {
        return $this->hasMany(PurchaseDtl::className(), ['purchase_id' => 'id']);
    }
}