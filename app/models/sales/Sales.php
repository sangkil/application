<?php

namespace app\models\sales;

use Yii;
use app\models\master\Customer;

/**
 * Sales
 *
 * @property SalesDtls[] $salesDtls
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
            [['customer'], 'required'],
            [['customer'], 'in', 'range' => Customer::find()->select('name')->column()]
            ], $rules);
    }
    
    public function getSalesDtls()
    {
        return $this->hasMany(SalesDtl::className(), ['sales_id'=>'id']);
    }
}