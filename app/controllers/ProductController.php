<?php

namespace app\controllers;

/**
 * ProductController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ProductController extends \yii\rest\ActiveController
{
    public $modelClass='app\\models\\master\\Product';
    
    public function actionHello()
    {
        return 'Hello';
    }
}