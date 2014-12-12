<?php

namespace biz\core\base\rest;

use Yii;

/**
 * Description of ViewAction
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  * @since 3.0
 */
class ViewAction extends Action
{

    public function run($id)
    {
        $model = $this->api->findModel($id);
        $this->api->fire('_view', [$model]);
        return $model;
    }
}