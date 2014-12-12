<?php

namespace biz\core\base\rest;

use Yii;
use yii\helpers\Url;
use yii\helpers\Inflector;

/**
 * Description of CreateAction
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  * @since 3.0
 */
class CustomCreateAction extends Action
{
    /**
     *
     * @var string 
     */
    public $viewAction = 'view';

    /**
     *
     * @var string 
     */
    public $action;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->action === null) {
            $this->action = Inflector::id2camel($this->id);
        }
    }

    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $model = call_user_func([$this->api, $this->action], Yii::$app->getRequest()->getBodyParams());
            if (!$model->hasErrors()) {
                $transaction->commit();
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                $id = implode(',', array_values($model->getPrimaryKey(true)));
                $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
            } else {
                $transaction->rollBack();
            }
        } catch (\Exception $exc) {
            $transaction->rollBack();
            throw $exc;
        }
        return $model;
    }
}