<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */

echo "\nInsert data to branch\n";
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
    Console::updateProgress($i + 1, 4);
}
Console::endProgress();
