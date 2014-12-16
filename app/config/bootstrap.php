<?php

Yii::setAlias('@biz', dirname(dirname(__DIR__)).'/libraries/biz');
Yii::setAlias('@mdm/report', dirname(dirname(__DIR__)).'/libraries/report');

// set DI
$container = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/container.php'),
    require(__DIR__ . '/container-local.php')
);

foreach ($container as $key => $value) {
    Yii::$container->set($key, $value);
}
