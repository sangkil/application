<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */

$rows = [
    [1, 'Pcs', 'Pieces', 1],
    [2, 'Dzn', 'Dozen', 12]
];

echo "Insert data product uom\n";
$total = count($rows);
Console::startProgress(0, $total);
$command->delete('{{%product_uom}}')->execute();
$command->sql = "insert into product_uom(product_id,uom_id,isi,created_at,updated_at)\n"
    . "select id,:uom_id,:isi,NOW(),NOW() from product";
foreach ($rows as $i=>$row) {
    $command->bindValues([':uom_id' => $row[0], ':isi' => $row[3]])->execute();
    Console::updateProgress($i + 1, $total);
}
Console::endProgress();
