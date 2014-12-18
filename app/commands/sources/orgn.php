<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */

echo "\nInsert data to orgn\n";
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
    Console::updateProgress($i + 1, 1);
}
Console::endProgress();
