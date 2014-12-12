<?php

namespace biz\core\base\rest;

use Yii;

/**
 * Description of UpdateAction
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  * @since 3.0
 */
class CustomUpdateAction extends Action
{
    /**
     *
     * @var string 
     */
    public $action;

    public function init()
    {
        parent::init();
        if ($this->action === null) {
            $this->action = $this->id;
        }
    }

    public function run($id)
    {
        /* @var $model \yii\db\ActiveRecord */
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $model = call_user_func([$this->api, $this->action], $id, Yii::$app->getRequest()->getBodyParams());
            if (!$model->hasErrors()) {
                $transaction->commit();
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