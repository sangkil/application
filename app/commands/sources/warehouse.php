<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */

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
    Console::updateProgress($i + 1, 8);
}
Console::endProgress();
