<?php

namespace biz\core\master\hooks;

use biz\core\master\models\ProductStock as MProductStock;
use biz\core\master\models\ProductUom;
use biz\core\base\NotFoundException;
use yii\base\UserException;
use biz\core\master\models\Cogs;
use biz\core\inventory\models\GoodsMovement as MGoodsMovement;

/**
 * Description of Stock
 *
 * @author MDMunir
 */
class ProductStock extends \yii\base\Behavior
{

    public function events()
    {
        return [
            'e_good-movement_applied' => 'goodsMovementApplied',
        ];
    }

    /**
     *
     * @param  array $params Required field warehouse_id, product_id, qty
     * Optional field app, reff_id, uom_id, item_value
     * @return boolean
     * @throws UserException
     */
    public function updateStock($params)
    {
        $stock = MProductStock::findOne([
                'warehouse_id' => $params['warehouse_id'],
                'product_id' => $params['product_id'],
        ]);
        if (isset($params['uom_id'])) {
            $qty_per_uom = ProductUom::find()->select('isi')
                    ->where([
                        'product_id' => $params['product_id'],
                        'uom_id' => $params['uom_id']
                    ])->scalar();
            if ($qty_per_uom === false) {
                throw new NotFoundException("Uom '{$params['uom_id']}' not found for product '{$params['product_id']}'");
            }
        } else {
            $qty_per_uom = 1;
        }

        if (!$stock) {
            $stock = new MProductStock([
                'warehouse_id' => $params['warehouse_id'],
                'product_id' => $params['product_id'],
                'qty' => 0,
            ]);
        }
        // update cogs
        if (isset($params['price']) && $params['price'] !== '') {
            $params['qty_per_uom'] = $qty_per_uom;
            $this->updateCogs($params);
        }

        $stock->qty = $stock->qty + $params['qty'] * $qty_per_uom;
        if ($stock->canSetProperty('logParams')) {
            $logParams = ['mv_qty' => $params['qty'] * $qty_per_uom];
            foreach (['app', 'reff_id'] as $key) {
                if (isset($params[$key]) || array_key_exists($key, $params)) {
                    $logParams[$key] = $params[$key];
                }
            }
            $stock->logParams = $logParams;
        }
        if (!$stock->save()) {
            throw new UserException(implode(",\n", $stock->firstErrors));
        }

        return true;
    }

    protected function updateCogs($params)
    {
        $cogs = Cogs::findOne(['product_id' => $params['product_id']]);
        if (!$cogs) {
            $cogs = new Cogs([
                'product_id' => $params['product_id'],
                'cogs' => 0.0
            ]);
        }
        $current_stock = MProductStock::find()
            ->where(['product_id' => $params['product_id']])
            ->sum('qty');
        $qty_per_uom = $params['qty_per_uom'];
        $added_stock = $params['qty'] * $qty_per_uom;
        if ($current_stock + $added_stock != 0) {
            $cogs->cogs = 1.0 * ($cogs->cogs * $current_stock + $params['price'] * $params['qty']) / ($current_stock + $added_stock);
        } else {
            $cogs->cogs = 0;
        }
        if ($cogs->canSetProperty('logParams')) {
            $cogs->logParams = [
                'app' => $params['app'],
                'reff_id' => $params['reff_id'],
            ];
        }
        if (!$cogs->save()) {
            throw new UserException(implode(",\n", $cogs->firstErrors));
        }

        return true;
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
        $warehouse_id = $model->warehouse_id;
        foreach ($model->goodsMovementDtls as $detail) {
            $params = [
                'warehouse_id' => $warehouse_id,
                'product_id' => $detail->product_id,
                'qty' => $detail->qty,
                'uom_id' => $detail->uom_id,
                'app' => 'goods_movement',
                'price' => $detail->item_value,
                'reff_id' => $detail->movement_id,
            ];
            $this->updateStock($params);
        }
    }
}