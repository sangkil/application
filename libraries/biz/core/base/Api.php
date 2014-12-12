<?php

namespace biz\core\base;

use Yii;
use yii\db\ActiveRecord;
use yii\base\InvalidConfigException;
use yii\helpers\Inflector;
use yii\web\ServerErrorHttpException;

/**
 * Api is base class for API.
 *
 * Api implements commonly fiture for crud.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Api extends \yii\base\Object
{
    /**
     * @var string Model class name
     */
    public $modelClass;

    /**
     * @var string prefix event name
     */
    public $prefixEventName;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException(get_class($this) . '::$modelClass must be set.');
        }
        if ($this->prefixEventName === null) {
            $pos = strrpos($this->modelClass, '\\');
            $name = $pos !== 0 ? substr($this->modelClass, $pos + 1) : $this->modelClass;
            $this->prefixEventName = 'e_' . Inflector::camel2id($name);
        }
    }

    /**
     * Process output. Throw error when not success with unknown reason.
     * @param boolean      $success
     * @param ActiveRecord $model
     *
     * @return ActiveRecord
     * @throws \yii\web\ServerErrorHttpException
     */
    protected static function processOutput($success, $model)
    {
        if (!$success && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Error with unknown reason.');
        }

        return $model;
    }

    /**
     * Create document
     * @param array $data
     * @param ActiveRecord $model
     *
     * @return ActiveRecord
     */
    public function create($data, $model = null)
    {
        /* @var $model ActiveRecord */
        $model = $model ? : $this->createNewModel();
        $this->fire('_create', [$model]);
        $model->load($data, '');
        if ($model->save()) {
            $this->fire('_created', [$model]);

            return $model;
        } else {
            return $this->processOutput(false, $model);
        }
    }

    /**
     * Update document
     * @param string $id
     * @param array $data
     * @param ActiveRecord $model
     * @return ActiveRecord
     */
    public function update($id, $data, $model = null)
    {
        /* @var $model ActiveRecord */
        $model = $model ? : $this->findModel($id);
        $this->fire('_update', [$model]);
        $model->load($data, '');
        if ($model->save()) {
            $this->fire('_updated', [$model]);

            return $model;
        } else {
            return $this->processOutput(false, $model);
        }
    }

    /**
     * Delete document
     * @param  string       $id
     * @param  ActiveRecord $model
     * @return boolean
     */
    public function delete($id, $model = null)
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = $model ? : $this->findModel($id);
        $this->fire('_delete', [$model]);
        if ($model->delete() !== false) {
            $this->fire('_deleted', [$model]);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Create model
     * @return ActiveRecord
     */
    public function createNewModel()
    {
        return Yii::createObject($this->modelClass);
    }

    /**
     * Returns the data model based on the primary key given.
     * If the data model is not found, a 404 HTTP exception will be raised.
     * @param string $id the ID of the model to be loaded. If the model has a composite primary key,
     * the ID must be a string of the primary key values separated by commas.
     * The order of the primary key values should follow that returned by the `primaryKey()` method
     * of the model.
     * @param  boolean  $throwException
     * @return ActiveRecord  the model found
     * @throws NotFoundException if the model cannot be found
     */
    public function findModel($id, $throwException = true)
    {
        /* @var $modelClass ActiveRecord */
        $modelClass = $this->modelClass;
        $keys = $modelClass::primaryKey();
        if (count($keys) > 1) {
            $values = explode(',', $id);
            if (count($keys) === count($values)) {
                $model = $modelClass::findOne(array_combine($keys, $values));
            }
        } elseif ($id !== null) {
            $model = $modelClass::findOne($id);
        }

        if (isset($model)) {
            $this->fire('_find', [$model]);

            return $model;
        } elseif ($throwException) {
            throw new \yii\web\NotFoundHttpException("Object not found: $id");
        }

        return null;
    }

    /**
     * Trigger event to `Yii::$app`.
     * @param string $name
     * @param array  $params
     */
    public function fire($name, $params = [])
    {
        Yii::$app->trigger($this->prefixEventName . $name, new Event($params));
    }
}