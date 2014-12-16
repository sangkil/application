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
    public $name;
    public $outputType = 'html';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->report = Instance::ensure($this->report, BirtReport::className());
    }

    
    public function run()
    {
        /* @var $request \yii\web\Request */
        /* @var $response \yii\web\Response */
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        $reportName = $request->getQueryParam('name', $this->name);
        $outputType = $request->getQueryParam('outputType', $this->outputType);
        $params = $request->getQueryParam('params', []);

        $return = $this->report->renderReport($reportName, [
            'params' => $params
            ], $outputType);

        if ($outputType != BirtReport::OUTPUT_TYPE_HTML) {
            $response->format = Response::FORMAT_RAW;
            $fileName = explode('.', $reportName, 1)[0] . '.' . $outputType;
            $mimeType = \yii\helpers\FileHelper::getMimeTypeByExtension($fileName);
            $response->setDownloadHeaders($fileName, $mimeType);
        }
        return $return;
    }
}