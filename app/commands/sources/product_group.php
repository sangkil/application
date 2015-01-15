<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */


$rows = [
    [1, "The Dexter"],
    [2, "Warning"],
    [3, "Top Extreme"],
    [4, "-"],
    [5, "Air Borne"],
    [6, "Black ID"],
    [7, "Petak Sembilan/Top Corner"],
    [8, "Lain-lain"],
    [9, "One Three/Report"],
    [10, "Insider"],
    [11, "Ozone"],
    [12, "WRN 74"],
    [13, "-"],
    [14, "Bluff"],
    [15, "Rollink"],
    [16, "Top Riders"],
    [17, "Magma"],
    [18, "Camo"],
    [19, "ON FIRE"],
    [20, "Provider"],
    [21, " Red Cable"],
    [22, "Insave"],
    [23, " Ahmed"],
    [24, "Black Angel"],
    [25, "Kidd Rock"],
    [26, "Screamous"],
    [27, "Coffee Park"],
    [28, "Dloops"],
    [29, "Blankwear"],
    [30, "Kuyagaya"],
    [31, "Defly"],
    [32, "Invictus"],
    [33, "Friendshell"],
    [34, "Triad"],
    [35, "Shiverwear"]
];

echo "Insert data product group\n";
$total = count($rows);
Console::startProgress(0, $total);
$command->delete('{{%product_group}}')->execute();
foreach ($rows as $i => $row) {
    $command->insert('{{%product_group}}', [
        'id' => $row[0],
        'code' => sprintf('%04d', $row[0]),
        'name' => $row[1],
        'created_at' => $now,
        'updated_at' => $now,
    ])->execute();
    Console::updateProgress($i + 1, $total);
}
Console::endProgress();
