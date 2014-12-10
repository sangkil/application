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
        'label_field' => 'number'
    ],
    // Sales release
    200 => [
        'class' => 'app\models\sales\Sales',
        'name' => 'Sales',
        'link' => '/sales/sales/view',
        'label_field' => 'number'
    ],
];
