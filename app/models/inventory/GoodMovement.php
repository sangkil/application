<?php

namespace app\models\inventory;

use Yii;
use yii\helpers\Html;
use biz\core\base\Configs;

/**
 * GoodMovement
 *
 * @property GoodMovementDtl[] $goodMovementDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class GoodMovement extends \biz\core\inventory\models\GoodMovement
{

    public function getGoodMovementDtls()
    {
        return $this->hasMany(GoodMovementDtl::className(), ['movement_id' => 'id']);
    }

    public function rules()
    {
        return array_merge([
            [['Date'], 'required'],
            ], parent::rules(), [
            [['goodMovementDtls'], 'caclTransValue']
        ]);
    }

    public function caclTransValue()
    {
        $value = 0;
        foreach ($this->goodMovementDtls as $detail) {
            $value += $detail->qty * $detail->trans_value;
        }
        $this->trans_value = $value;
    }

    public function getNmReffType()
    {
        if (($config = $this->reffConfig) !== null) {
            return isset($config['name']) ? $config['name'] : null;
        }
        return null;
    }

    public function getReffLink()
    {
        if (($config = $this->reffConfig) !== null && isset($config['link'])) {
            return $this->reffDoc ? Html::a($this->reffDoc->number, [$config['link'], 'id' => $this->reffDoc->id]) : null;
        }
        return null;
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
