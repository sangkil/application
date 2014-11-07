<?php

$config = [
    'modules' => [
    ],
    'components' => [
        'authManager' => [
            'class' => 'mdm\admin\components\DbManager'
        ],        
//        'authManager' => [
//            'class' => 'yii\rbac\DbManager'
//        ],
        'assetManager' => [
            'forceCopy' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'yORMWFRtOQmeLhV4Djmzrlxt6JSIbMz7',
        ],
        'session' => [
            'cookieParams' => ['httponly' => true, 'path' => '/']
        ],
        'urlManager' => [
            'enablePrettyUrl' => false,
            'enableStrictParsing' => false,
            'showScriptName' => true,
            'rules' => [
                
            ],
        ],
        'view'=>[
            'theme'=>[
                'pathMap'=>[
                    '@mdm/admin/views'=>'@app/views/admin',
                    '@dektrium/user/views'=>'@app/views/user',
                ]
            ]
        ]
    ]
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'd-crud' => ['class' => 'mdm\gii\generators\crud\Generator'],
            'd-mvc' => ['class' => 'mdm\gii\generators\mvc\Generator'],
        ]
    ];
}

return $config;
