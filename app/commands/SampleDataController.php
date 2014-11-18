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
        $command = $this->db->createCommand();
        $faker = $this->generator;
        $now = new Expression('NOW()');
        
        //*
        // orgn
        echo "\nInsert data orgn\n";
        Console::startProgress(0, 1);
        $command->delete('{{%orgn}}')->execute();
        for ($i = 0; $i < 1; $i++) {
            $command->insert('{{%orgn}}', [
                'id' => $i + 1,
                'code' => $i * 1000 + 1000,
                'name' => $faker->company,
                'created_at' => $now,
                'updated_at' => $now,
            ])->execute();
            Console::updateProgress($i+1, 1);
        }
        Console::endProgress();

        // branch
        echo "\nInsert data branch\n";
        Console::startProgress(0, 4);
        $command->delete('{{%branch}}')->execute();
        for ($i = 0; $i < 4; $i++) {
            $command->insert('{{%branch}}', [
                'id' => $i + 1,
                'orgn_id' => 1,
                'code' => 1100 + 100 * $i,
                'name' => $faker->city,
                'created_at' => $now,
                'updated_at' => $now,
            ])->execute();
            Console::updateProgress($i+1, 4);
        }
        Console::endProgress();

        // warehouse
        echo "\nInsert data warehouse\n";
        Console::startProgress(0, 8);
        $command->delete('{{%warehouse}}')->execute();
        for ($i = 0; $i < 8; $i++) {
            $b_id = floor($i / 2) + 1;
            $w_id = $i % 2 + 1;
            $command->insert('{{%warehouse}}', [
                'id' => $i + 1,
                'branch_id' => $b_id,
                'code' => 1000 + 100 * $b_id + $w_id,
                'name' => $faker->streetName,
                'created_at' => $now,
                'updated_at' => $now,
            ])->execute();
            Console::updateProgress($i+1, 8);
        }
        Console::endProgress();

        // create product category
        echo "Insert data product category\n";
        $rows = require(__DIR__ . '/sources/product_category.php');
        $total = count($rows);
        $command->delete('{{%category}}')->execute();
        foreach ($rows as $i => $row) {
            $command->insert('{{%category}}', [
                'id' => $row[0],
                'code' => sprintf('%04d', $row[0]),
                'name' => $row[1],
                'created_at' => $now,
                'updated_at' => $now,
            ])->execute();
            Console::updateProgress($i+1, $total);
        }
        Console::endProgress();

        // product group
        echo "Insert data product group\n";
        $rows = require(__DIR__ . '/sources/product_group.php');
        $total = count($rows);
        Console::startProgress(0, $total);
        $command->delete('{{%product_group}}')->execute();
        foreach ($rows as $i => $row) {
            $command->insert('{{%product_group}}', [
                'id' => $row[0],
                'code' => sprintf('%04d', $row[0]),
                'name' => $row[1],
                'created_at' => $now,
                'updated_at' => $now,
            ])->execute();
            Console::updateProgress($i+1, 1);
        }
        Console::endProgress();

        // product
        echo "Insert data product\n";
        $rows = require(__DIR__ . '/sources/product.php');
        $total = count($rows);
        Console::startProgress(0, $total);
        $command->delete('{{%product}}')->execute();
        foreach ($rows as $i => $row) {
            $command->insert('{{%product}}', [
                'id' => $row[0],
                'group_id' => $row[1],
                'category_id' => $row[2],
                'code' => $faker->ean13,
                'name' => $row[3],
                'status' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ])->execute();
            Console::updateProgress($i+1, $total);
        }
        Console::endProgress();

        // barcode
        echo "Insert data barcode product\n";
        $rows = require(__DIR__ . '/sources/product.php');
        $total = count($rows);
        Console::startProgress(0, $total);
        $command->delete('{{%product_child}}')->execute();
        foreach ($rows as $i => $row) {
            for ($j = 0; $j < 3; $j++) {
                try {
                    $command->insert('{{%product_child}}', [
                        'barcode' => $faker->ean13,
                        'product_id' => $row[0],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ])->execute();
                } catch (\Exception $exc) {
                    
                }
            }
            Console::updateProgress($i+1, $total);
        }
        Console::endProgress();

        // uom
        echo "Insert data uom\n";
        $rows = require(__DIR__ . '/sources/uom.php');
        $total = count($rows);
        Console::startProgress(0, $total);
        $command->delete('{{%uom}}')->execute();
        foreach ($rows as $row) {
            $command->insert('{{%uom}}', [
                'id' => $row[0],
                'code' => $row[1],
                'name' => $row[2],
                'created_at' => $now,
                'updated_at' => $now,
            ])->execute();
            Console::updateProgress($i+1, $total);
        }
        Console::endProgress();

        // product uom
        echo "Insert data product uom\n";
        $rows = require(__DIR__ . '/sources/uom.php');
        $total = count($rows);
        Console::startProgress(0, $total);
        $command->delete('{{%product_uom}}')->execute();
        $command->sql = "insert into product_uom(product_id,uom_id,isi,created_at,updated_at)\n"
            . "select id,:uom_id,:isi,NOW(),NOW() from product";
        foreach ($rows as $row) {
            $command->bindValues([':uom_id' => $row[0], ':isi' => $row[3]])->execute();
            Console::updateProgress($i+1, $total);
        }
        Console::endProgress();
        // */
        
        // supplier
        echo "Insert data supplier\n";
        Console::startProgress(0, 10);
        $command->delete('{{%supplier}}')->execute();
        for ($i = 0; $i < 10; $i++) {
            $command->insert('{{%supplier}}', [
                'id' => $i + 1,
                'code' => 6001 + $i,
                'name' => $faker->company,
                'created_at' => $now,
                'updated_at' => $now,
            ])->execute();
            Console::updateProgress($i+1, 10);
        }
        Console::endProgress();

        // customer
        echo "Insert data customer\n";
        Console::startProgress(0, 10);
        $command->delete('{{%customer}}')->execute();
        $command->insert('{{%customer}}', [
            'id' => 1,
            'code' => 8000,
            'name' => 'Reguler',
            'status' => 10,
            'created_at' => $now,
            'updated_at' => $now,
        ])->execute();
        for ($i = 1; $i < 10; $i++) {
            $command->insert('{{%customer}}', [
                'id' => $i + 1,
                'code' => 8000 + $i,
                'name' => $faker->name,
                'status' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ])->execute();
            Console::updateProgress($i+1, 10);
        }
        Console::endProgress();
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
}