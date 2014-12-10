<?php

namespace app\models\inventory;

use Yii;
use yii\helpers\Html;
use biz\core\base\Configs;

/**
 * GoodsMovement
 *
 * @property GoodsMovementDtl[] $goodsMovementDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class TransferMovement extends \biz\core\inventory\models\Transfer
{
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
                'class' => 'mdm\converter\EnumConverter',
                'attributes' => [
                    'nmType' => 'type'
                ],
                'enumPrefix' => 'TYPE_'
            ],
        ]);
    }
}
// Extend reference
Configs::merge('movement', '@app/components/configs/movement.php');
