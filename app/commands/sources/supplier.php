<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */

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
    Console::updateProgress($i + 1, 10);
}
Console::endProgress();
