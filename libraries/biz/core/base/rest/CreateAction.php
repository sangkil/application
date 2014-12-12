<?php

namespace biz\core\base\rest;

use Yii;
use yii\helpers\Url;

/**
 * Description of CreateAction
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  * @since 3.0
 */
class CreateAction extends Action
{
    public $viewAction = 'view';

    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $model = $this->api->create(Yii::$app->getRequest()->getBodyParams());
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