<?php
return[
    'yii\\grid\\ActionColumn'=>[
        'class'=>'app\\components\\ActionColumn',
        'visibleCallback'=>function($name, $model){
            if(method_exists($model, 'visibleButton')){
                return call_user_func([$model,'visibleButton'], $name);
            }
            return true;
        }
    ]
];