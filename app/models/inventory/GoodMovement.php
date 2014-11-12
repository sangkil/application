<?php

namespace app\models\inventory;

use Yii;
use yii\helpers\ArrayHelper;

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
        ]);
    }
}
// Load refference
GoodMovement::$reffTypes = ArrayHelper::merge(GoodMovement::$reffTypes, require(__DIR__ . DIRECTORY_SEPARATOR . 'reff_types.php'));
