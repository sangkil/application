<?php

/*
 * Avaliable source for invoicing
 */

return[
    // Purchase order
    100 => [
        'class' => 'app\models\purchase\Purchase',
        'name' => 'Purchase Invoice',
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
    ]
];
