<?php

namespace app\controllers\purchase;

use Yii;
use app\models\purchase\Purchase;


/**
* PurchaseController .
 */
class PurchaseController extends \yii\web\Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new Purchase();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('create', [
            'model' => $model,
            'details' => $model->purchaseDtls
        ]);
    }

    public function actionUpdate()
    {
        $model = new Purchase();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
