<?php

namespace app\models\purchase;

use Yii;
use app\models\master\Supplier;
use yii\validators\ValidationAsset;

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
            [['supplier'], 'exist', 'targetClass' => Supplier::className(), 'targetAttribute' => 'name'],
            [['supplier'], 'applySupplier', 'clientValidate'=>'clientValidateSupplier'],
            ], $rules);
    }

    public function applySupplier()
    {
        $this->supplier_id = Supplier::findOne(['name' => $this->supplier])->id;
    }
    
    public function clientValidateSupplier()
    {
        $range = Supplier::find()->select('name')->column();
        
        $options = [
            'range' => $range,
            'not' => false,
            'message' => 'Nama supplier tidak valid',
        ];

        ValidationAsset::register(Yii::$app->view);

        return 'yii.validation.range(value, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }

    public function getPurchaseDtls()
    {
        return $this->hasMany(PurchaseDtl::className(), ['purchase_id' => 'id']);
    }
}