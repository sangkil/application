<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */

$rows = require __DIR__ . '/_product.php';
echo "Insert data product\n";
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
    Console::updateProgress($i + 1, $total);
}
Console::endProgress();
