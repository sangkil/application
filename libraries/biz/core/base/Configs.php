<?php

namespace biz\core\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Configs
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Configs
{
    public static $configs = [
        'movement' => '@biz/core/base/configs/movement.php',
        'invoice' => '@biz/core/base/configs/invoice.php',
    ];
    private static $_configs = [];

    private static function initialize($name)
    {
        if (!isset(static::$_configs[$name])) {
            if (isset(static::$configs[$name])) {
                $config = static::$configs[$name];
                if (is_string($config)) {
                    $config = require(Yii::getAlias($config));
                }
                static::$_configs[$name] = $config;
            } else {
                static::$_configs[$name] = [];
            }
        }
    }

    public static function __callStatic($name, $arguments)
    {
        $type = reset($arguments);
        return static::getConfigFor($name, $type);
    }

    protected static function getConfigFor($name, $type = false)
    {
        static::initialize($name);
        if ($type !== false) {
            return isset(static::$_configs[$name][$type]) ? static::$_configs[$name][$type] : null;
        } else {
            return static::$_configs[$name];
        }
    }

    public static function merge($name, $configs)
    {
        static::initialize($name);
        if (is_string($configs)) {
            $configs = require(Yii::getAlias($configs));
        }
        foreach ($configs as $key => $value) {
            if (isset(static::$_configs[$name][$key])) {
                static::$_configs[$name][$key] = ArrayHelper::merge(static::$_configs[$name][$key], $value);
            } else {
                static::$_configs[$name][$key] = $value;
            }
        }
    }

    /**
     * Configuration fo Good Movement
     * @param integer $type
     * @return array
     */
    public static function movement($type = false)
    {
        return static::getConfigFor('movement', $type);
    }

    /**
     * Configuration fo Good Movement
     * @param integer $type
     * @return array
     */
    public static function invoice($type = false)
    {
        return static::getConfigFor('invoice', $type);
    }
}