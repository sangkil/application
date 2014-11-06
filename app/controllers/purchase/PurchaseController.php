<?php

namespace app\controllers\purchase;

use Yii;
use app\models\purchase\Purchase;
use app\models\purchase\searchs\Purchase as PurchaseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use biz\core\purchase\components\Purchase as ApiPurchase;
use app\models\inventory\GoodMovement;
use app\models\inventory\searchs\GoodMovement as GoodMovementSearch;

/**
 * PurchaseController implements the CRUD actions for Purchase model.
 */
class PurchaseController extends Controller
{

    public function behaviors()
    {
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
    public function actionIndex()
    {
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
    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Purchase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Purchase([
            'branch_id' => 1
        ]);
        $api = new ApiPurchase();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $data = $model->attributes;
                $data['details'] = Yii::$app->request->post('PurchaseDtl', []);
                $model = $api->create($data, $model);
                if (!$model->hasErrors() && !$model->hasRelatedErrors()) {
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
                'details' => $model->purchaseDtls
        ]);
    }

    /**
     * Updates an existing Purchase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $api = new ApiPurchase();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $data = $model->attributes;
                $data['details'] = Yii::$app->request->post('PurchaseDtl', []);
                $model = $api->update($id, $data, $model);
                if (!$model->hasErrors() && !$model->hasRelatedErrors()) {
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
                'details' => $model->purchaseDtls
        ]);
    }

    public function actionGr($id, $gr_id = null)
    {
        $model = $this->findModel($id);
        $modelSearch = new GoodMovementSearch([
            'reff_type' => GoodMovement::TYPE_PURCHASE,
            'reff_id' => $id,
        ]);

        if ($gr_id === null) {
            $grModel = GoodMovement::findOne([
                    'reff_type' => GoodMovement::TYPE_PURCHASE,
                    'reff_id' => $id,
                    'status' => GoodMovement::STATUS_OPEN,
            ]);
        } else {
            $grModel = GoodMovement::findOne([
                    'id' => $gr_id,
                    'reff_type' => GoodMovement::TYPE_PURCHASE,
                    'reff_id' => $id,
            ]);
        }
        $grModel = $grModel? : new GoodMovement([
            'reff_type' => GoodMovement::TYPE_PURCHASE,
            'reff_id' => $id,
            'status' => GoodMovement::STATUS_OPEN,
        ]);



        $dataProvider = $modelSearch->search(Yii::$app->request->getQueryParams());
        return $this->render('gr', [
                'model' => $model,
                'dataProvider' => $dataProvider,
                'grModel' => $grModel,
        ]);
    }

    /**
     * Deletes an existing Purchase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Purchase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Purchase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}