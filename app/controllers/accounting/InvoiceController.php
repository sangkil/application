<?php

namespace app\controllers\accounting;

use Yii;
use app\models\accounting\Invoice;
use app\models\accounting\searchs\Invoice as InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use biz\core\accounting\components\Invoice as ApiInvoice;
use biz\core\base\Configs;
use yii\helpers\ArrayHelper;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller {

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
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Invoice models.
     * filter by type = purchase
     * @return mixed
     */
    public function actionPurchase() {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Invoice models.
     * filter by type = purchase
     * @return mixed
     */
    public function actionSales() {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type, $id = null) {    
        $gGets = filter_input_array(INPUT_GET);
        $dGR = (isset($gGets['dtl']))?$gGets['dtl']:[];
        
        $model = Invoice::findOne([
                    'reff_type' => $type,
                    'reff_id' => $id,
                    'status' => Invoice::STATUS_DRAFT
        ]);
        $model = $model ? : new Invoice([
            'reff_type' => $type,
            'reff_id' => $id,
            'date' => date('Y-m-d')
        ]);

        $api = new ApiInvoice();
        $config = Configs::invoice($type);

        list($modelRef, $details) = $this->getReference($type, $id, $model->invoiceDtls);
        $model->populateRelation('invoiceDtls', $details);
        if ($model->load(Yii::$app->request->post())) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $data = $model->attributes;

                $data['details'] = Yii::$app->request->post('InvoiceDtl', []);

                $model = $api->create($data, $model);
                if (!$model->hasErrors()) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
        }
        return $this->render('create', [
                    'model' => $model,
                    'modelRef' => $modelRef,
                    'details' => $model->invoiceDtls,
                    'config' => $config
        ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getReference($reff_type, $reff_id, $origin = []) {
        $config = Configs::invoice($reff_type);
        $class = $config['class'];
        $relation = $config['relation'];

        $modelRef = $class::findOne($reff_id);
        $details = ArrayHelper::index($origin, 'product_id');

//        $refDtls = $modelRef->$relation;
//        foreach ($refDtls as $refDtl) {
//            if (!isset($details[$refDtl->product_id])) {
//                $details[$refDtl->product_id] = new GoodsMovementDtl([
//                    'product_id' => $refDtl->product_id,
//                ]);
//            }
//            if (!empty($config['apply_method'])) {
//                call_user_func([$refDtl, $config['apply_method']], $details[$refDtl->product_id]);
//            }
//        }
        return [$modelRef, array_values($details)];
    }

}
