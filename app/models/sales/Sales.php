<?php

namespace app\models\sales;

use Yii;
use app\models\master\Customer;

/**
 * Sales
 *
 * @property SalesDtl[] $salesDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Sales extends \biz\core\sales\models\Sales
{
    public $customer;

    public function rules()
    {
        $rules = parent::rules();
        return array_merge([
            [['Date'], 'required'],
            [['customer'], 'in', 'range' => Customer::find()->select('name')->column()]
            ], $rules);
    }

    public function getSalesDtls()
    {
        return $this->hasMany(SalesDtl::className(), ['sales_id' => 'id']);
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
                    'nmCustomer' => [[Customer::className(), 'id' => 'customer_id'], 'name'],
                ],
            ],
            ], $behaviors);
    }
}