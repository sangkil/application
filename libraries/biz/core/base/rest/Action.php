<?php

namespace biz\core\base\rest;

use Yii;
use yii\base\InvalidConfigException;
use biz\core\base\Api;

/**
 * Description of Action
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  * @since 3.0
 */
class Action extends \yii\base\Action
{
    /**
     *
     * @var Api 
     */
    public $api;

    public function init()
    {
        if ($this->api === null) {
            if ($this->controller instanceof Controller) {
                $this->api = $this->controller->api;
            } else {
                throw new InvalidConfigException(get_class($this) . '::$api must be set.');
            }
        }
        if (!$this->api instanceof Api) {
            $this->api = Yii::createObject($this->api);
        }
    }
}