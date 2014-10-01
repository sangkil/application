<?php

namespace app\controllers\purchase;

/**
 * Description of PurchaseController
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class PurchaseController extends \yii\web\Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new \app\models\purchase\Purchase();
        return $this->render('create',[
            'model'=>$model,
            'details'=>$model->purchaseDtls
        ]);
    }
}