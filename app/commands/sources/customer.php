<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */

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
    Console::updateProgress($i + 1, 10);
}
Console::endProgress();
