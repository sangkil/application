<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */

$rows = [
    [1, "Celana Panjang"],
    [2, "Celana Pendek"],
    [3, "Jaket"],
    [4, "Sweater"],
    [5, "Kaos"],
    [6, "Kemeja"],
    [7, "Sandal"],
    [8, "Tas"],
    [9, "Aksesoris"],
    [10, "Sepatu"],
    [11, "Parfum"]
];

echo "Insert data product category\n";
$total = count($rows);
Console::startProgress(0, $total);
$command->delete('{{%category}}')->execute();
foreach ($rows as $i => $row) {
    $command->insert('{{%category}}', [
        'id' => $row[0],
        'code' => sprintf('%04d', $row[0]),
        'name' => $row[1],
        'created_at' => $now,
        'updated_at' => $now,
    ])->execute();
    Console::updateProgress($i + 1, $total);
}
Console::endProgress();