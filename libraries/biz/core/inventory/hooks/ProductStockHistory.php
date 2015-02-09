<?php

namespace biz\core\inventory\hooks;

use biz\core\master\models\ProductStock;
use biz\core\inventory\models\ProductStockHistory as MProductStockHistory;
use yii\base\UserException;
use yii\db\Expression;

/**
 * ProductStockHistory
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ProductStockHistory extends \yii\base\Behavior
{
    public $dateFindExpresion = 'CURRENT_DATE';
    public $dateInsertExpresion = 'CURRENT_DATE';

    public function events()
    {
        return [
            'e_product-stock_changed' => 'productStockChanged',
        ];
    }

    /**
     * @param \biz\core\base\Event $event
     */
    public function productStockChanged($event)
    {
        /* @var $stock ProductStock */
        $stock = $event->params[0];

        $hstock = MProductStockHistory::findOne([
                'date' => new Expression($this->dateFindExpresion),
                'warehouse_id' => $stock->warehouse_id,
                'product_id' => $stock->product_id,
        ]);
        if ($hstock === null) {
            $hstock = new MProductStockHistory([
                'date' => new Expression($this->dateInsertExpresion),
                'warehouse_id' => $stock->warehouse_id,
                'product_id' => $stock->product_id,
            ]);
        }
        $hstock->qty = $stock->qty;
        if ($hstock->save()) {
            
        } else {
            throw new UserException(implode(",\n", $hstock->firstErrors));
        }
    }
}