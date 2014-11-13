<?php

namespace app\models\inventory;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * GoodMovement
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
            ], parent::rules());
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
            return $this->reffDoc ? Html::a($this->reffDoc->number, [$config['link'],'id'=>$this->reffDoc->id]) : null;
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
foreach (require(__DIR__ . '/reff_types.php') as $key => $value) {
    if (isset(GoodMovement::$reffTypes[$key])) {
        GoodMovement::$reffTypes[$key] = ArrayHelper::merge(GoodMovement::$reffTypes[$key], $value);
    } else {
        GoodMovement::$reffTypes[$key] = $value;
    }
}
