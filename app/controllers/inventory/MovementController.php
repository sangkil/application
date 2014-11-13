<?php

namespace app\controllers\inventory;

use Yii;
use app\models\inventory\GoodMovement;
use app\models\inventory\searchs\GoodMovement as GoodMovementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use biz\core\inventory\components\GoodMovement as ApiMovement;
use yii\helpers\ArrayHelper;
use app\models\inventory\GoodMovementDtl;

/**
 * MovementController implements the CRUD actions for GoodMovement model.
 */
class MovementController extends Controller
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
     * Lists all GoodMovement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodMovementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GoodMovement model.
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
     * Creates a new GoodMovement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type, $id)
    {
        $model = GoodMovement::findOne([
                'reff_type' => $type,
                'reff_id' => $id,
                'status' => GoodMovement::STATUS_OPEN,
        ]);
        $model = $model ? : new GoodMovement([
            'reff_type' => $type,
            'reff_id' => $id,
        ]);
        $api = new ApiMovement();

        list($modelRef, $details) = $this->getReference($type, $id, $model->goodMovementDtls);
        $model->populateRelation('goodMovementDtls', $details);
        if ($model->load(Yii::$app->request->post())) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $data = $model->attributes;

                $data['details'] = Yii::$app->request->post('GoodMovementDtl', []);

                $model = $api->create($data, $model);
                if (!$model->hasErrors() && !$model->hasRelatedErrors()) {
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
                'details' => $model->goodMovementDtls,
        ]);
    }

    /**
     * Updates an existing GoodMovement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $api = new ApiMovement();

        list($modelRef, $details) = $this->getReference($model->reff_type, $model->reff_id, $model->goodMovementDtls);
        $model->populateRelation('goodMovementDtls', $details);
        if ($model->load(Yii::$app->request->post())) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $data = $model->attributes;

                $data['details'] = Yii::$app->request->post('GoodMovementDtl', []);

                $model = $api->update($id, $data, $model);
                if (!$model->hasErrors() && !$model->hasRelatedErrors()) {
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
        return $this->render('update', [
                'model' => $model,
                'modelRef' => $modelRef,
                'details' => $model->goodMovementDtls,
        ]);
    }

    protected function getReference($reff_type, $reff_id, $origin = [])
    {
        $config = GoodMovement::reffConfig($reff_type);
        $class = $config['class'];
        $relation = $config['relation'];

        $modelRef = $class::findOne($reff_id);
        $refDtls = $modelRef->$relation;

        $details = ArrayHelper::index($origin, 'product_id');
        foreach ($refDtls as $refDtl) {
            if (!isset($details[$refDtl->product_id])) {
                $details[$refDtl->product_id] = new GoodMovementDtl([
                    'product_id' => $refDtl->product_id,
                ]);
            }
            if (!empty($config['apply_method'])) {
                call_user_func([$refDtl, $config['apply_method']], $details[$refDtl->product_id]);
            }
        }
        return [$modelRef, array_values($details)];
    }

    /**
     * Deletes an existing GoodMovement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $api = new ApiMovement();
        $api->delete($id, $model);
        return $this->redirect(['index']);
    }

    public function actionApply($id)
    {
        $model = $this->findModel($id);
        $api = new ApiMovement();
        $api->apply($id, $model);
        return $this->redirect(['index']);
    }

    /**
     * Finds the GoodMovement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GoodMovement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodMovement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}