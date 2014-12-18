<?php

use yii\helpers\Console;

/* @var $this app\commands\SampleDataController */
/* @var $command yii\db\Command */
/* @var $faker Faker\Generator */

// id, parent_id, code, name, type, normal_balance
$rows = [
    [1, null, '100000', 'AKTIVA', 100000, 'D',],
    [2, null, '200000', 'KEWAJIBAN', 200000, 'K',],
    [3, null, '300000', 'MODAL', 300000, 'K',],
    [4, null, '400000', 'PENDAPATAN', 400000, 'K',],
    [5, null, '500000', 'HARGA POKOK PENJUALAN', 500000, 'K',],
    [6, null, '600000', 'BIAYA', 600000, 'D',],
    [7, 1, '110000', 'AKTIVA LANCAR', 100000, 'D',],
    [8, 1, '120000', 'AKTIVA TETAP', 100000, 'D',],
    [9, 7, '110001', 'Kas Kecil', 100000, 'D',],
    [10, 7, '110002', 'Bank BNI64', 100000, 'D',],
    [11, 7, '110003', 'Piutang Dagang', 100000, 'D',],
    [12, 7, '110004', 'Persediaan Barang Dagang', 100000, 'D'],
    [13, 7, '110005', 'Kas Lain', 100000, 'D',],
    [14, 8, '121000', 'Tanah Kapling A', 100000, 'D',],
    [15, 8, '122000', 'Ruko Jl.Sudirman 45', 100000, 'D',],
    [16, 2, '210000', 'HUTANG LANCAR', 200000, 'K',],
    [24, 6, '620001', 'Beban Adm & Umum', 600000, 'D',],
    [17, 2, '220000', 'HUTANG JANGKA PANJANG', 200000, 'K',],
    [18, 16, '210001', 'Hutang Dagang', 200000, 'K',],
    [19, 16, '210002', 'Hutang Gaji', 200000, 'K',],
    [20, 3, '310000', 'MODAL', 300000, 'K',],
    [21, 20, '310001', 'Modal Pemilik', 300000, 'K',],
    [22, 5, '510000', 'HPP', 500000, 'D',],
    [23, 6, '610001', 'Beban Gaji/ Upah', 600000, 'D',],
];

echo "Insert data coa\n";
$total = count($rows);
Console::startProgress(0, $total);
$command->delete('{{%coa}}')->execute();
foreach ($rows as $i => $row) {
    $command->insert('{{%coa}}', [
        'id' => $row[0],
        'parent_id' => $row[1],
        'code' => $row[2],
        'name' => $row[3],
        'type' => $row[4],
        'normal_balance' => $row[5],
        'created_at' => $now,
        'updated_at' => $now,
    ])->execute();
    Console::updateProgress($i + 1, $total);
}
Console::endProgress();
