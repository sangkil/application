<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */

$rows = [
    [1, 'Pcs', 'Pieces', 1],
    [2, 'Dzn', 'Dozen', 12]
];

echo "Insert data uom\n";
$total = count($rows);
Console::startProgress(0, $total);
$command->delete('{{%uom}}')->execute();
foreach ($rows as $i=>$row) {
    $command->insert('{{%uom}}', [
        'id' => $row[0],
        'code' => $row[1],
        'name' => $row[2],
        'created_at' => $now,
        'updated_at' => $now,
    ])->execute();
    Console::updateProgress($i + 1, $total);
}
Console::endProgress();
