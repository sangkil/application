<?php

use biz\core\inventory\models\GoodsMovement;

/*
 * Avaliable source for good movement
 */

return[
    // Purchase receive
    100 => [
        'type' => GoodsMovement::TYPE_RECEIVE,
        'class' => 'biz\core\purchase\models\Purchase',
        'relation' => 'purchaseDtls',
        'apply_method' => 'applyGR',
    ],
    // Sales release
    200 => [
        'type' => GoodsMovement::TYPE_ISSUE,
        'class' => 'biz\core\sales\models\Sales',
        'relation' => 'salesDtls',
        'apply_method' => 'applyGI',
    ],
    // Transfer release
    300 => [
        'type' => GoodsMovement::TYPE_ISSUE,
        'class' => 'biz\core\inventory\models\Transfer',
        'relation' => 'transferDtls',
        'apply_method' => 'applyGI',
    ],
    // Transfer release
    400 => [
        'type' => GoodsMovement::TYPE_RECEIVE,
        'class' => 'biz\core\inventory\models\Transfer',
        'relation' => 'transferDtls',
        'apply_method' => 'applyGR',
    ],
];
