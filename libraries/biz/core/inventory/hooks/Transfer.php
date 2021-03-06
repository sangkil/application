<?php

namespace biz\core\inventory\hooks;

use Yii;
use biz\core\inventory\models\GoodsMovement as MGoodsMovement;
use biz\core\inventory\models\Transfer as MTransfer;
use yii\helpers\ArrayHelper;

/**
 * Transfer
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class Transfer extends \yii\base\Behavior
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
         * 300 = Transfer Release
         * 400 = Transfer Receive
         */
        if (!in_array($model->reff_type, [300, 400])) {
            return;
        }
        $type = $model->type;
        $transfer = MTransfer::findOne($model->reff_id);
        $transferDtls = ArrayHelper::index($transfer->transferDtls, 'product_id');
        // change total qty for reff document
        /* @var $transferDtl \biz\core\inventory\models\TransferDtl */
        foreach ($model->goodsMovementDtls as $detail) {
            $transferDtl = $transferDtls[$detail->product_id];
            if ($type == MGoodsMovement::TYPE_ISSUE) {
                $transferDtl->total_release += $detail->qty;
            } else {
                $transferDtl->total_receive += $detail->qty;
            }
            $transferDtl->save(false);
        }

        $complete = true;
        switch ($model->reff_type) {
            case '300':
                foreach ($transferDtls as $transferDtl) {
                    if ($transferDtl->total_release != $transferDtl->qty) {
                        $complete = false;
                        break;
                    }
                }
                $transfer->status = ($complete) ? MTransfer::STATUS_ISSUED : MTransfer::STATUS_PARTIAL_ISSUED;
                break;
            case '400':
                foreach ($transferDtls as $transferDtl) {
                    if ($transferDtl->total_receive != $transferDtl->qty) {
                        $complete = false;
                        break;
                    }
                }
                $transfer->status = ($complete) ? MTransfer::STATUS_RECEIVED : MTransfer::STATUS_PARTIAL_RECEIVED;
                break;
        }
        $transfer->save(false);
    }
}