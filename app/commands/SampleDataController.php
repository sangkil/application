<?php

namespace app\commands;

use Yii;
use yii\db\Connection;
use yii\console\Exception;
use yii\db\Expression;
use yii\helpers\Console;

/**
 * SampleDataController
 *
 * @property \Faker\Generator $generator
 * @property string $sourcePath Directory of sample
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class SampleDataController extends \yii\console\Controller
{
    public $defaultAction = 'create';

    /**
     * @var Connection 
     */
    public $db = 'db';

    /**
     * @var string 
     */
    public $language;

    /**
     * @var \Faker\Generator
     */
    private $_generator;

    /**
     * @var string 
     */
    private $_sourcePath;

    /**
     * @var array
     */
    private $_samples = [
        'orgn',
        'branch' => ['orgn'],
        'warehouse' => ['branch'],
        'supplier',
        'customer',
        'category',
        'product_group',
        'product' => ['category', 'product_group'],
        'barcode' => ['product'],
        'uom',
        'product_uom' => ['product', 'uom'],
        'coa'
    ];

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (is_string($this->db)) {
                $this->db = Yii::$app->get($this->db);
            }
            if (!$this->db instanceof Connection) {
                throw new Exception("The 'db' option must refer to the application component ID of a DB connection.");
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Create sample data
     * @param string $sample Sample want to create.
     * Default all mean apply to all
     */
    public function actionCreate($sample = 'all')
    {
        $command = $this->db->createCommand();
        if ($sample === 'all') {
            foreach ($this->_samples as $sample => $requirements) {
                if (is_integer($sample)) {
                    $this->load($requirements, $command);
                } else {
                    $this->load($sample, $command);
                }
            }
            return self::EXIT_CODE_NORMAL;
        } elseif (in_array($sample, $this->_samples)) {
            $this->load($sample, $command);
            return self::EXIT_CODE_NORMAL;
        }
        throw new Exception("Unable to find the sample '$sample'.");
    }

    /**
     * Load sample
     * @param string $sample
     * @param \yii\db\Command $command
     * @param boolean $confirm
     */
    public function load($sample, $command, $confirm = true)
    {
        $exists = $command->setSql("select count(*) from {{%{$sample}}}")->queryScalar() > 0;
        if (!$exists || ($confirm && Console::confirm("Overwrote {$sample}"))) {
            $samples = isset($this->_samples[$sample]) ? $this->_samples[$sample] : [];
            $this->resolveRequired($samples, $command);
            $file = $this->sourcePath . "/{$sample}.php";
            $this->internalLoad($file, [
                'command' => $command,
                'faker' => $this->generator,
                'now' => new Expression('NOW()'),
            ]);
        }
    }

    public function resolveRequired($samples = [], $command)
    {
        foreach ($samples as $sample) {
            $this->load($sample, $command, false);
        }
    }

    private function internalLoad($_file_, $_data_ = [])
    {
        extract($_data_);
        include $_file_;
    }

    /**
     * Get directory of sample
     * @return string
     */
    public function getSourcePath()
    {
        if ($this->_sourcePath === null) {
            return $this->_sourcePath = __DIR__ . '/sources';
        }
        return $this->_sourcePath;
    }

    /**
     * Set directory of sample
     * @param string $path
     */
    public function setSourcePath($path)
    {
        $this->_sourcePath = Yii::getAlias($path);
    }

    /**
     * Returns Faker generator instance. Getter for private property.
     * @return \Faker\Generator
     */
    public function getGenerator()
    {
        if ($this->_generator === null) {
            $language = $this->language === null ? Yii::$app->language : $this->language;
            $this->_generator = \Faker\Factory::create(str_replace('-', '_', $language));
        }
        return $this->_generator;
    }

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['sourcePath']);
    }
}