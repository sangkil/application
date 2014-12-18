<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */

$rows = require __DIR__ . '/_product.php';
echo "Insert data barcode product\n";
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
    Console::updateProgress($i + 1, $total);
}
Console::endProgress();
