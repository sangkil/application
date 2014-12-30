<?php

namespace app\models\master;

/**
 * Price
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Price extends \biz\core\master\models\Price
{
    public $product_name;
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_push(parent::attributeLabels(), ['product_name'=>'Name of Product']);
    }
            
}