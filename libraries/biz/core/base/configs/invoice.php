<?php

use biz\core\accounting\models\Invoice;

/*
 * Avaliable source for good movement
 */

return[
    // Purchase Invoice
    100 => [
        'type' => Invoice::TYPE_OUTGOING,
        'class' => 'biz\core\purchase\models\Purchase',
        'relation' => 'purchaseDtls'
    ],
    
    // Sales Billing
    200 => [
        'type' => Invoice::TYPE_INCOMING,
        'class' => 'biz\core\purchase\models\Purchase',
        'relation' => 'salesDtls'
    ]
];
