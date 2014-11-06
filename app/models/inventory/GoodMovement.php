<?php

namespace app\models\inventory;

use app\models\master\GlobalConfig;

/**
 * GoodMovement
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class GoodMovement extends \biz\core\inventory\models\GoodMovement
{
    const GROUP_REFF_TYPE = 'GM_REFF_TYPE';

    public function getGoodMovementDtls()
    {
        return $this->hasMany(GoodMovementDtl::className(), ['movement_id' => 'id']);
    }

    public function rules()
    {
        return array_merge([
            [['Date'], 'required'],
            [['reff_type'], 'resolveType'],
            ], parent::rules());
    }

    public function resolveType()
    {
        $config = GlobalConfig::findOne([
                'group' => self::GROUP_REFF_TYPE,
                'name' => $this->reff_type,
        ]);
        if ($config) {
            $this->type = $config->Value['type'];
        } else {
            $this->addError('reff_type', "Reference type {$this->reff_type} not recognize");
        }
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