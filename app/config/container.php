<?php

return[
    'yii\\grid\\ActionColumn' => [
        'class' => 'app\\components\\ActionColumn',
        'visibleCallback' => function($name, $model) {
            return method_exists($model, 'visibleButton') ? call_user_func([$model, 'visibleButton'], $name) : true;
        },
        'buttons' => [
            'apply' => function ($url, $model) {
            return yii\helpers\Html::a('<span class="glyphicon glyphicon-save"></span>', $url, [
                    'title' => Yii::t('yii', 'Apply'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to apply this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
            ]);
        }
        ]
    ]
];
