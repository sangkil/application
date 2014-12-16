<?php

namespace mdm\report;

use Yii;
use yii\di\Instance;
use yii\web\Response;

/**
 * BirtAction
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class BirtAction extends \yii\base\Action
{
    /**
     * @var BirtReport 
     */
    public $report;

    /**
     * @var Response 
     */
    public $response = 'response';

    public function init()
    {
        $this->report = Instance::ensure($this->report, BirtReport::className());
        $this->response = Instance::ensure($this->response, Response::className());
    }

    public function run()
    {
        $queryParams = Yii::$app->request->getQueryParams();
        
    }
}