<?php

namespace biz\core\inventory\components;

use biz\core\inventory\models\StockAdjustment as MStockAdjustment;
use biz\core\inventory\models\StockOpname;
use biz\core\master\models\ProductStock;
use biz\core\master\models\ProductUom;

/**
 * Description of StockAdjusment
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class StockAdjustment extends \biz\core\base\Api
{
    /**
     *
     * @var string 
     */
    public $modelClass = 'biz\core\inventory\models\StockAdjustment';

    /**
     *
     * @var string 
     */
    public $prefixEventName = 'e_stock-adjustment';

    /**
     * Create stock adjustment.
     *
     * @param  array                                  $data
     * @param  \biz\core\inventory\models\StockAdjustment $model
     * @return \biz\core\inventory\models\StockAdjustment
     */
    public function create($data, $model = null)
    {
        /* @var $model MStockAdjustment */
        $model = $model ? : $this->createNewModel();
        $success = false;
        $model->scenario = MStockAdjustment::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!empty($data['details'])) {
            $this->fire('_create', [$model]);
            $success = $model->save();
            $success = $model->saveRelated('stockAdjustmentDtls', $data, $success, 'details');
            if ($success) {
                $this->fire('_created', [$model]);
            } else {
                if ($model->hasRelatedErrors('stockAdjustmentDtls')) {
                    $model->addError('details', 'Details validation error');
                }
            }
        } else {
            $model->validate();
            $model->addError('details', 'Details cannot be blank');
        }

        return $this->processOutput($success, $model);
    }

    /**
     * Update stock adjustment.
     *
     * @param  string                                 $id
     * @param  array                                  $data
     * @param  \biz\core\inventory\models\StockAdjustment $model
     * @return \biz\core\inventory\models\StockAdjustment
     */
    public function update($id, $data, $model = null)
    {
        /* @var $model MStockAdjustment */
        $model = $model ? : $this->findModel($id);
        $success = false;
        $model->scenario = MStockAdjustment::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!isset($data['details']) || $data['details'] !== []) {
            $this->fire('_update', [$model]);
            $success = $model->save();
            if (!empty($data['details'])) {
                $success = $model->saveRelated('stockAdjustmentDtls', $data, $success, 'details', MStockAdjustment::SCENARIO_DEFAULT);
            }
            if ($success) {
                $this->fire('_updated', [$model]);
            } else {
                if ($model->hasRelatedErrors('stockAdjustmentDtls')) {
                    $model->addError('details', 'Details validation error');
                }
            }
        } else {
            $model->validate();
            $model->addError('details', 'Details cannot be blank');
        }

        return $this->processOutput($success, $model);
    }

    /**
     * Apply stock adjustment
     *
     * @param  string                                 $id
     * @param  array                                  $data
     * @param  \biz\core\inventory\models\StockAdjustment $model
     * @return \biz\core\inventory\models\StockAdjustment
     */
    public function apply($id, $data = [], $model = null)
    {
        /* @var $model MStockAdjustment */
        $model = $model ? : $this->findModel($id);
        $success = false;
        $model->scenario = MStockAdjustment::SCENARIO_DEFAULT;
        $model->load($data, '');
        $model->status = MStockAdjustment::STATUS_APPLIED;
        $this->fire('_apply', [$model]);
        $success = $model->save();
        if ($success) {
            $this->fire('_applied', [$model]);
        } else {
            $success = false;
        }

        return $this->processOutput($success, $model);
    }

    /**
     *
     * @param  StockOpname      $opname
     * @param  MStockAdjustment $model
     * @return mixed
     * @throws \Exception
     */
    public function createFromOpname($opname, $model = null)
    {
        // info product
        $currentStocks = ProductStock::find()->select(['product_id', 'qty_stock'])
                ->where(['warehouse_id' => $opname->warehouse_id])
                ->indexBy('product_id')->asArray()->all();
        $isiProductUoms = [];
        foreach (ProductUom::find()->asArray()->all() as $row) {
            $isiProductUoms[$row['product_id']][$row['uom_id']] = $row['isi'];
        }
        // ***

        $data = [
            'warehouse_id' => $opname->warehouse_id,
            'adjustment_date' => date('Y-m-d'),
            'reff_id' => $opname->id,
            'description' => "Stock adjustment from stock opname no \"{$opname->opname_num}\"."
        ];
        $details = [];
        foreach ($opname->stockOpnameDtls as $detail) {
            $cQty = $currentStocks[$detail->product_id] / $isiProductUoms[$detail->product_id][$detail->uom_id];
            $details[] = [
                'product_id' => $detail->product_id,
                'uom_id' => $detail->uom_id,
                'qty' => $detail->qty - $cQty,
            ];
        }
        $data['details'] = $details;

        return $this->create($data, $model);
    }
}
