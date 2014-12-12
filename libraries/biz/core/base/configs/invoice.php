<?php

use biz\core\accounting\models\Invoice;

/*
 * Avaliable source for good movement
 */

return[
    // Purchase receive
    100 => [
        'type' => Invoice::TYPE_INCOMING,
        'class' => 'biz\core\purchase\models\Purchase',
        'relation' => 'purchaseDtls',
        'apply_method' => 'applyGR',
        'uom_field' => 'uom_id',
    ],
];
