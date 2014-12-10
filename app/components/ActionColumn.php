<?php

namespace app\components;

/**
 * ActionColumn
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * @var \Closure
     * 
     * ```
     * function($name, $model, $key, $index){
     *     switch($name){
     *         case 'view':
     *             return true;
     *         case 'update':
     *         case 'delete':
     *             return $model->status == Order::STATUS_DRAFT;
     *     }
     * }
     * ```
     */
    public $visibleCallback;

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];
            if (isset($this->buttons[$name]) && ($this->visibleCallback === null || call_user_func($this->visibleCallback, $name, $model, $key, $index) !== false)) {
                $url = $this->createUrl($name, $model, $key, $index);
                
                return call_user_func($this->buttons[$name], $url, $model, $key);
            } else {
                return '';
            }
        }, $this->template);
    }
}