<?php

namespace app\commands;

use Yii;
use yii\db\Connection;
use yii\console\Exception;

/**
 * SampleDataController
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
     */
    public function actionCreate()
    {
        // create product category
    }

    protected function insertCategory()
    {
        $categories = require(__DIR__ . '/sources/product_category.php');
        $command = $this->db->createCommand();
        $command->delete('{{%category}}');
        foreach ($categories as $category) {
            try {
                $command->insert('{{%category}}', [
                    'id' => $category[0],
                    'code' => sprintf('%04d', $category[0]),
                    'name' => $category[1],
                ]);
            } catch (\Exception $exc) {
                
            }
        }
    }

    private function internalGenerateRow($_template_, $_params_ = [])
    {
        extract($_params_, EXTR_OVERWRITE);
        return require($_template_);
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

    protected function generateRow($template, $index)
    {
        $template = __DIR__ . '/' . $template . '.php';
        return $this->internalGenerateRow($template, [
                'faker' => $this->getGenerator(),
                'index' => $index,
        ]);
    }
}