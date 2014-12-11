<?php

/*
 * Avaliable source for good movement
 */

return[
    // Purchase receive
    100 => [
        'class' => 'app\models\purchase\Purchase',
        'name' => 'Purchase',
        'link' => '/purchase/purchase/view',
        'label_field' => 'number',
        'branch_field' => 'branch_id',
    ],
    // Sales release
    200 => [
        'class' => 'app\models\sales\Sales',
        'name' => 'Sales',
        'link' => '/sales/sales/view',
        'label_field' => 'number',
        'branch_field' => 'branch_id',
    ],
    // Transfer release
    300 => [
        'class' => 'app\models\inventory\Transfer',
        'name' => 'Transfer',
        'link' => '/inventory/transfer/view',
        'label_field' => 'number',
        'branch_field' => 'branch_id',
    ],
    // Transfer receive
    400 => [
        'class' => 'app\models\inventory\Transfer',
        'name' => 'Transfer',
        'link' => '/inventory/transfer/view',
        'label_field' => 'number',
        'branch_field' => 'branch_dest_id',
    ],
];
