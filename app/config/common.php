<?php

return[
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'dateFormat' => 'dd/MM/yyyy',
            'datetimeFormat' => 'dd/MM/yyyy HH:mm:ss'
        ],
    ],
];
