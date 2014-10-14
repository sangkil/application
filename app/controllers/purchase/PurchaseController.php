<?php

namespace app\controllers\purchase;

use Yii;

/**
 * app\controllers\purchase\PurchaseController .
 */
class app\controllers\purchase\PurchaseController extends \yii\web\Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new app\models\purchase\Purchase();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate()
    {
        $model = new app\models\purchase\Purchase();

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
