<?php

namespace app\controllers\master;

use Yii;
use app\models\master\GlobalConfig;
use app\models\master\searchs\GlobalConfig as GlobalConfigSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\DynamicModel;

/**
 * ConfigController implements the CRUD actions for GlobalConfig model.
 */
class ConfigController extends Controller
{
    const GROUP_SCHEMA = 'GROUP_SCHEMA';

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
     * Lists all GlobalConfig models.
     * @return mixed
     */
    public function actionIndex($group)
    {
        $schema = $this->getSchema($group);
        $modelSearch = new GlobalConfigSearch([
            'group' => $group,
        ]);
        return $this->render('index', [
                'dataProvider' => $modelSearch->search([]),
                'schema' => $schema,
                'group' => $group
        ]);
    }

    protected function getSchema($group)
    {
        return $this->findModel(self::GROUP_SCHEMA, $group);
    }

    /**
     * Displays a single GlobalConfig model.
     * @param string $group
     * @param string $name
     * @return mixed
     */
    public function actionView($group, $name)
    {
        $schema = $this->getSchema($group);
        return $this->render('view', [
                'model' => $this->findModel($group, $name),
                'schema' => $schema,
                'group' => $group
        ]);
    }

    /**
     * Creates a new GlobalConfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($group)
    {
        $schema = $this->getSchema($group);
        $attrs = ['name', 'description'];
        foreach ($schema->serializeValue as $col) {
            $attrs[] = $col;
        }
        $model = new DynamicModel($attrs);
        $model->addRule('name', 'required');
        $model->addRule('name', 'unique', [
            'targetClass' => GlobalConfig::className(),
            'targetAttribute' => 'name',
            'filter' => ['group' => $group]
        ]);
        $model->addRule($attrs, 'safe');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $attrs = $model->attributes;
            unset($attrs['name'], $attrs['description']);
            $configModel = new GlobalConfig([
                'group' => $group,
                'name' => $model->name,
                'description' => $model->description,
            ]);
            $configModel->serializeValue = $attrs;
            if ($configModel->save()) {
                return $this->redirect(['view', 'group' => $group, 'name' => $model->name]);
            }
        }
        return $this->render('create', [
                'model' => $model,
                'group' => $group,
                'schema' => $schema
        ]);
    }

    /**
     * Updates an existing GlobalConfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $group
     * @param string $name
     * @return mixed
     */
    public function actionUpdate($group, $name)
    {
        $model = $this->findModel($group, $name);

        $schema = $this->getSchema($group);

        $attrs = [
            'name' => $model->name,
            'description' => $model->description
        ];
        $serializeValue = $model->serializeValue;
        foreach ($schema->serializeValue as $col) {
            if (isset($serializeValue[$col])) {
                $attrs[$col] = $serializeValue[$col];
            } else {
                $attrs[] = $col;
            }
        }
        $model = new DynamicModel($attrs);
        $model->addRule('name', 'required');
        $model->addRule('name', 'unique', [
            'targetClass' => GlobalConfig::className(),
            'targetAttribute' => 'name',
            'filter' => ['group' => $group]
        ]);
        $model->addRule('description', 'safe');
        $model->addRule($schema->serializeValue, 'safe');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $attrs = $model->attributes;
            unset($attrs['name'], $attrs['description']);
            $configModel = new GlobalConfig([
                'group' => $group,
                'name' => $model->name,
                'description' => $model->description,
            ]);
            $configModel->serializeValue = $attrs;
            if ($configModel->save()) {
                return $this->redirect(['view', 'group' => $group, 'name' => $model->name]);
            }
        }
        return $this->render('update', [
                'model' => $model,
                'group' => $group,
                'schema' => $schema
        ]);
    }

    /**
     * Deletes an existing GlobalConfig model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $group
     * @param string $name
     * @return mixed
     */
    public function actionDelete($group, $name)
    {
        $this->findModel($group, $name)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GlobalConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $group
     * @param string $name
     * @return GlobalConfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($group, $name)
    {
        if (($model = GlobalConfig::findOne(['group' => $group, 'name' => $name])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}