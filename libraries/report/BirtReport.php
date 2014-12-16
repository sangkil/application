<?php

namespace mdm\report;

use Yii;
use Java;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * BirtReport
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class BirtReport extends \yii\base\Object
{
    const OUTPUT_TYPE_HTML = 'html';
    const OUTPUT_TYPE_PDF = 'pdf';
    const OUTPUT_TYPE_XLS = 'xls';

    public $javaBridgeFile = '/var/lib/tomcat7/webapps/JavaBridge/java/Java.inc';
    public $reportPath;
    public $optionClasses = [];
    public $imagePath = '@runtime/birtreport/images';
    public $db = [];
    

    public function init()
    {
        require_once $this->javaBridgeFile;
        if (!(get_cfg_var('java.web_inf_dir'))) {
            defined('JAVA_HOSTS') || define("JAVA_HOSTS", "127.0.0.1:8080");
            defined('JAVA_SERVLET') || define("JAVA_SERVLET", "JavaBridge.phpjavabridge");
        }
        $this->imagePath = Yii::getAlias($this->imagePath);
        $this->optionClasses = array_merge([
            self::OUTPUT_TYPE_HTML => 'org.eclipse.birt.report.engine.api.HTMLRenderOption',
            self::OUTPUT_TYPE_PDF => 'org.eclipse.birt.report.engine.api.PDFRenderOption',
            self::OUTPUT_TYPE_XLS => 'org.eclipse.birt.report.engine.api.RenderOption',
            'default' => 'org.eclipse.birt.report.engine.api.RenderOption',
            ], $this->optionClasses);
        
        
    }

    public function renderReport($reportName, $options = [], $outputType = self::OUTPUT_TYPE_HTML)
    {
        $reportPath = ArrayHelper::getValue($options, 'reportPath', $this->reportPath);
        if ($reportPath === null) {
            throw new InvalidConfigException('The "reportPath" property must be set.');
        }
        $reportPath = Yii::getAlias($reportPath);

        $context = java_context()->getServletContext();
        $birtReportEngine = java("org.eclipse.birt.php.birtengine.BirtEngine")->getBirtEngine($context);
        java_context()->onShutdown(java("org.eclipse.birt.php.birtengine.BirtEngine")->getShutdownHook());

        $report = $birtReportEngine->openReportDesign("{$reportPath}/{$reportName}");
//        $parameterArray = $report->getDesignHandle()->getParameters();
//        $ds = $report->getDesignHandle()->findDataSource("Data Source");
//        $ds->setProperty('odaURL', 'jdbc:postgresql://localhost:5432/mdmbiz3');
        $task = $birtReportEngine->createRunAndRenderTask($report);

        if (!empty($options['params'])) {
            foreach ($options['params'] as $key => $value) {
                $nval = new Java("java.lang.String", $value);
                $task->setParameterValue($key, $nval);
            }
        }

        if ($outputType == self::OUTPUT_TYPE_PDF) {
            $outputOptions = [
                'pdfRenderOption.pageOverflow' => 'pdfRenderOption.fitToPage',
            ];
        } else {
            $outputOptions = [];
        }

        if (!empty($options['options'])) {
            $outputOptions = array_merge($outputOptions, $options['options']);
        }

        $optionClass = isset($this->optionClasses[$outputType]) ? $this->optionClasses[$outputType] : $this->optionClasses['default'];
        $taskOptions = new Java($optionClass);
        $outputStream = new Java("java.io.ByteArrayOutputStream");
        $taskOptions->setOutputStream($outputStream);
        foreach ($outputOptions as $key => $value) {
            $taskOptions->setOption($key, $value);
        }
        $taskOptions->setOutputFormat($outputType);

        if ($outputType == self::OUTPUT_TYPE_HTML) {
            $ih = new Java("org.eclipse.birt.report.engine.api.HTMLServerImageHandler");
            $taskOptions->setImageHandler($ih);
            $taskOptions->setEnableAgentStyleEngine(true);
            $taskOptions->setBaseImageURL($this->imagePath);
            $taskOptions->setImageDirectory($this->imagePath);
        }

        $task->setRenderOption($taskOptions);
        $task->run();
        $task->close();
        return java_values($outputStream->toByteArray());
    }
}