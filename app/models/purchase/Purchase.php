<?php

namespace app\models\purchase;

/**
 * Description of Purchase
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Purchase extends \yii\base\DynamicModel
{

    public function __construct($config = [])
    {
        $attributes = [
            'id_purchase', 'purchase_num', 'status'
        ];
        parent::__construct($attributes, $config);
    }

    public function rules()
    {
        return[
            [['id_purchase', 'purchase_num', 'status'], 'safe'],
        ];
    }
}