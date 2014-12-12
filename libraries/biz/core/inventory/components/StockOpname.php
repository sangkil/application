<?php

namespace biz\core\inventory\components;

use Yii;
use biz\core\inventory\models\StockOpname as MStockOpname;
use biz\core\inventory\models\StockOpnameDtl;
use yii\helpers\ArrayHelper;

/**
 * Description of StockOpname
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class StockOpname extends \biz\core\base\Api
{
    /**
     *
     * @var string 
     */
    public $modelClass = 'biz\core\inventory\models\StockOpname';

    /**
     *
     * @var string 
     */
    public $prefixEventName = 'e_stock-opname';

    /**
     *
     * @param  array                              $data
     * @param  \biz\core\inventory\models\StockOpname $model
     * @return \biz\core\inventory\models\StockOpname
     */
    public function create($data, $model = null)
    {
        /* @var $model MStockOpname */
        $model = $model ? : $this->createNewModel();
        $success = false;
        $model->scenario = MStockOpname::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!empty($data['details'])) {
            $this->fire('_create', [$model]);
            $success = $model->save();
            $success = $model->saveRelated('goodsMovementDtls', $data, $success, 'details');
            if ($success) {
                $this->fire('_created', [$model]);
            } else {
                if ($model->hasRelatedErrors('goodsMovementDtls')) {
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
     * @param  string                             $id
     * @param  array                              $data
     * @param  \biz\core\inventory\models\StockOpname $model
     * @return \biz\core\inventory\models\StockOpname
     */
    public function append($id, $data, $model = null)
    {
        /* @var $model MStockOpname */
        $model = $model ? : $this->findModel($id);
        $success = true;
        $model->scenario = MStockOpname::SCENARIO_DEFAULT;
        $model->load($data, '');
        $this->fire('_append', [$model]);
        $success = $model->save();
        $stockOpnameDtls = ArrayHelper::index($model->stockOpnameDtls, 'product_id');
        foreach ($data['details'] as $dataDetail) {
            $index = $dataDetail['product_id']; // product_id
            if (isset($stockOpnameDtls[$index])) {
                $detail = $stockOpnameDtls[$index];
            } else {
                $detail = new StockOpnameDtl([
                    'id_opname' => $model->id_opname,
                    'product_id' => $dataDetail['product_id'],
                    'uom_id' => $dataDetail['uom_id'],
                    'qty' => 0
                ]);
            }
            $detail->qty += $dataDetail['qty'];
            $success = $success && $detail->save();
            $stockOpnameDtls[$index] = $detail;
            $this->fire('_append_body', [$model, $detail]);
        }
        $model->populateRelation('stockOpnameDtls', array_values($stockOpnameDtls));
        if ($success) {
            $this->fire('_appended', [$model]);
        }

        return $this->processOutput($success, $model);
    }
}
