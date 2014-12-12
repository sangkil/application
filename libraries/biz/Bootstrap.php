<?php

namespace biz;

use Yii;

/**
 * Description of Bootstrap
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Bootstrap implements \yii\base\BootstrapInterface
{

    /**
     * Initialize application before process request
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $definitions = require(__DIR__ . '/definitions.php');
        foreach ($definitions as $name => $definition) {
            Yii::$container->set($name, $definition);
        }

        $hooks = require(__DIR__ . '/hooks.php');
        $app->attachBehaviors(array_combine($hooks, $hooks));
    }
}