<?php

$config = [
    'modules' => [
    ],
    'components' => [
        'authManager' => [
            'class' => 'mdm\admin\components\DbManager'
        ],
        'request' => [
            'cookieValidationKey' => '',
        ],
        'session' => [
            'cookieParams' => ['httponly' => true, 'path' => '/']
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                
            ],
        ]
    ]
];

return $config;
