<?php

namespace biz\core\purchase\hooks;

use Yii;
use biz\core\inventory\models\GoodsMovement as MGoodsMovement;
use biz\core\purchase\models\Purchase as MPurchase;
use yii\helpers\ArrayHelper;

/**
 * Purchase
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class Purchase extends \yii\base\Behavior
{

    public function events()
    {
        return [
            'e_good-movement_applied' => 'goodsMovementApplied',
        ];
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \biz\core\base\Event $event
     */
    public function goodsMovementApplied($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        /*
         * 100 = Purchase
         */
        if (!in_array($model->reff_type, [100])) {
            return;
        }

        $purchase = MPurchase::findOne($model->reff_id);
        $purchaseDtls = ArrayHelper::index($purchase->purchaseDtls, 'product_id');
        // change total qty for reff document
        /* @var $purcDtl \biz\core\purchase\models\PurchaseDtl */
        foreach ($model->goodsMovementDtls as $detail) {
            $purcDtl = $purchaseDtls[$detail->product_id];
            $purcDtl->total_receive += $detail->qty;
            $purcDtl->save(false);
        }
        $complete = true;
        foreach ($purchaseDtls as $purcDtl) {
            if ($purcDtl->total_receive != $purcDtl->qty) {
                $complete = false;
                break;
            }
        }
        if ($complete) {
            $purchase->status = MPurchase::STATUS_COMPLETE_RECEIVE;
            $purchase->save(false);
        }  elseif($purchase->status == MPurchase::STATUS_DRAFT) {
            $purchase->status = MPurchase::STATUS_PARTIAL_RECEIVE;
            $purchase->save(false);
        }
    }
}