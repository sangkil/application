<?php

namespace app\controllers\purchase;

use Yii;
use app\models\purchase\Purchase;
use app\models\purchase\searchs\Purchase as PurchaseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use biz\core\purchase\components\Purchase as ApiPurchase;
use app\models\inventory\GoodsMovement;
use yii\data\ActiveDataProvider;

/**
 * PurchaseController implements the CRUD actions for Purchase model.
 */
class PurchaseController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Purchase models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PurchaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Purchase model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);

        //load gr list
        $greceipt = ($model->status >= Purchase::STATUS_CONFIRMED) ? $this->findGR($id) : new \yii\data\ArrayDataProvider();;

        if ($model->load(Yii::$app->request->post())) {
            $api = new ApiPurchase([
                'modelClass' => Purchase::className(),
            ]);

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->status = Purchase::STATUS_CONFIRMED;
                if ($model->save()) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('view', [
                    'model' => $model,
                    'details' => $model->purchaseDtls,
                    'greceipt' => $greceipt
        ]);
    }

    /**
     * Creates a new Purchase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Purchase([
            'branch_id' => 1,
            'date'=>date('Y-m-d')
        ]);
        
        $api = new ApiPurchase([
            'modelClass' => Purchase::className(),
        ]);

        //load gr list
        $greceipt = new \yii\data\ArrayDataProvider();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $data = $model->attributes;
                $data['details'] = Yii::$app->request->post('PurchaseDtl', []);
                $model = $api->create($data, $model);
                if (!$model->hasErrors()) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        return $this->render('create', [
                    'model' => $model,
                    'details' => $model->purchaseDtls,
                    'greceipt' => $greceipt
        ]);
    }

    /**
     * Updates an existing Purchase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $api = new ApiPurchase([
            'modelClass' => Purchase::className(),
        ]);

        //load gr list
        $greceipt = ($model->status >= Purchase::STATUS_CONFIRMED) ? $this->findGR($id) : new \yii\data\ArrayDataProvider();;

        if ($model->status > Purchase::STATUS_DRAFT) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $data = $model->attributes;
                $data['details'] = Yii::$app->request->post('PurchaseDtl', []);
                $model = $api->update($id, $data, $model);
                if (!$model->hasErrors()) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        return $this->render('update', [
                    'model' => $model,
                    'details' => $model->purchaseDtls,
                    'greceipt' => $greceipt
        ]);
    }

    public function actionReceive($id) {
        return $this->redirect(['/inventory/movement/create', 'type' => 100, 'id' => $id]);
    }

    /**
     * Deletes an existing Purchase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $api = new ApiPurchase([
            'modelClass' => Purchase::className(),
        ]);
        $api->delete($id, $model);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Purchase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Purchase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Purchase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findGR($id) {
        return new ActiveDataProvider([
            'query' => GoodsMovement::find()->where(['reff_type' => 100, 'reff_id' => $id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

}
