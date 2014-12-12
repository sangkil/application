<?php

namespace biz\core\accounting\components;

use Yii;
use biz\core\accounting\models\Invoice as MInvoice;
use biz\core\accounting\models\InvoiceDtl;
use biz\core\purchase\models\Purchase;
use biz\core\sales\models\Sales;
use yii\base\UserException;
use biz\core\inventory\models\GoodsMovement;
use biz\core\inventory\models\GoodsMovementDtl;

/**
 * Description of Invoice
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class Invoice extends \biz\core\base\Api
{
    /**
     *
     * @var string 
     */
    public $modelClass = 'biz\core\accounting\models\Invoice';

    /**
     *
     * @var string 
     */
    public $prefixEventName = 'e_invoice';

    /**
     *
     * @param  array                           $data
     * @param  \biz\core\accounting\models\Invoice $model
     * @return biz\core\accounting\models\Invoice
     * @throws \Exception
     */
    public function create($data, $model = null)
    {
        /* @var $model MInvoice */
        $model = $model ? : $this->createNewModel();
        $success = false;
        $model->status = MInvoice::STATUS_DRAFT;
        $model->load($data, '');
        if (!empty($data['details'])) {
            $this->fire('_create', [$model]);
            $model->invoiveDtls = $data['details'];
            $success = $model->save();
            if ($success) {
                $this->fire('_created', [$model]);
            }
        } else {
            $model->validate();
            $model->addError('invoiveDtls', 'Details cannot be blank');
        }

        return $this->processOutput($success, $model);
    }

    /**
     *
     * @param  string                          $id
     * @param  array                           $data
     * @param  \biz\core\accounting\models\Invoice $model
     * @return biz\core\accounting\models\Invoice
     * @throws \Exception
     */
    public function update($id, $data, $model = null)
    {
        /* @var $model MInvoice */
        $model = $model ? : $this->findModel($id);
        $success = false;
        $model->load($data, '');
        if (!isset($data['details']) || $data['details'] !== []) {
            $this->fire('_update', [$model]);
            if (!empty($data['details'])) {
                $model->invoiveDtls = $data['details'];
            }
            $success = $model->save();
            if ($success) {
                $this->fire('_updated', [$model]);
            }
        } else {
            $model->validate();
            $model->addError('invoiveDtls', 'Details cannot be blank');
        }

        return $this->processOutput($success, $model);
    }

    /**
     *
     * @param  array                           $data
     * @param  \biz\core\accounting\models\Invoice $model
     * @return biz\core\accounting\models\Invoice
     * @throws UserException
     */
    public function createFromPurchase($data, $model = null)
    {
        $ids = (array) $data['id_purchase'];
        $vendors = Purchase::find()->select('id_supplier')
                ->distinct()->column();

        if (count($vendors) !== 1) {
            throw new UserException('Vendor harus sama');
        }
        // invoice for GR
        $received = GoodsMovement::find()->select('id_movement')
                ->where([
                    'type_reff' => GoodsMovement::TYPE_PURCHASE,
                    'reff_id' => $ids
                ])->column();
        $invoiced = InvoiceDtl::find()->select('reff_id')
                ->where([
                    'type_reff' => InvoiceDtl::TYPE_PURCHASE_GR,
                    'reff_id' => $received,
                ])->column();
        $new = array_diff($received, $invoiced);
        $values = GoodsMovement::find()
                ->select(['hdr.id_movement', 'jml' => 'sum(dtl.qty*dtl.trans_value)'])
                ->from(GoodsMovement::tableName() . ' hdr')
                ->joinWith(['goodsMovementDtls' => function($q) {
                    $q->from(GoodsMovementDtl::tableName() . ' dtl');
                }])
                ->andWhere([
                    'hdr.type_reff' => GoodsMovement::TYPE_PURCHASE,
                    'hdr.reff_id' => $new
                ])
                ->groupBy('hdr.id_movement')
                ->indexBy('id_movement')
                ->asArray()->all();

        unset($data['id_purchase']);
        $data['id_vendor'] = reset($vendors);
        $data['invoice_type'] = MInvoice::TYPE_IN;
        $details = [];
        foreach ($new as $id) {
            $details[] = [
                'type_reff' => InvoiceDtl::TYPE_PURCHASE_GR,
                'reff_id' => $id,
                'trans_value' => $values[$id]['jml']
            ];
        }
        // Invoice for Global discount
        // get complete received purchase that invoiced yet :D
        $completed = Purchase::find()->select(['id_purchase', 'discount'])
            ->andWhere(['status' => Purchase::STATUS_RECEIVED, 'id_purchase' => $ids])
            ->andWhere(['<>', 'discount', null])
            ->asArray()->indexBy('id_purchase')
            ->all();
        $invoiced = InvoiceDtl::find()->select('reff_id')
                ->where([
                    'type_reff' => InvoiceDtl::TYPE_PURCHASE_DISCOUNT,
                    'reff_id' => array_keys($completed),
                ])->column();
        $new = array_diff(array_keys($completed), $invoiced);
        foreach ($new as $id) {
            $details[] = [
                'type_reff' => InvoiceDtl::TYPE_PURCHASE_DISCOUNT,
                'reff_id' => $id,
                'trans_value' => -$completed['discount']
            ];
        }

        $data['details'] = $details;
        $model = $this->create($data, $model);
        $model = $this->post('', [], $model);

        return $model;
    }

    /**
     * @param  array                           $data
     * @param  \biz\core\accounting\models\Invoice $model
     * @return \biz\core\accounting\models\Invoice
     * @throws UserException
     */
    public function createFromSales($data, $model = null)
    {
        $ids = (array) $data['id_sales'];
        $vendors = Sales::find()->select('id_customer')
                ->distinct()->column();

        if (count($vendors) !== 1) {
            throw new UserException('Vendor harus sama');
        }
        // invoice for GI
        $released = GoodsMovement::find()->select('id_movement')
                ->where([
                    'type_reff' => GoodsMovement::TYPE_SALES,
                    'reff_id' => $ids
                ])->column();
        $invoiced = InvoiceDtl::find()->select('reff_id')
                ->where([
                    'type_reff' => InvoiceDtl::TYPE_SALES_GI,
                    'reff_id' => $released,
                ])->column();
        $new = array_diff($released, $invoiced);
        $values = GoodsMovement::find()
                ->select(['hdr.id_movement', 'jml' => 'sum(dtl.qty*dtl.trans_value)'])
                ->from(GoodsMovement::tableName() . ' hdr')
                ->joinWith(['goodsMovementDtls' => function($q) {
                    $q->from(GoodsMovementDtl::tableName() . ' dtl');
                }])
                ->where([
                    'hdr.type_reff' => GoodsMovement::TYPE_SALES,
                    'hdr.reff_id' => $new
                ])
                ->groupBy('hdr.id_movement')
                ->indexBy('id_movement')
                ->asArray()->all();

        unset($data['id_sales']);
        $data['id_vendor'] = reset($vendors);
        $data['invoice_type'] = MInvoice::TYPE_OUT;
        $details = [];
        foreach ($new as $id) {
            $details[] = [
                'type_reff' => InvoiceDtl::TYPE_SALES_GI,
                'reff_id' => $id,
                'trans_value' => $values[$id]['jml']
            ];
        }

        // Invoice for discount
        $completed = Sales::find()->select(['id_sales', 'discount'])
            ->andWhere(['status' => Sales::STATUS_RELEASED, 'id_sales' => $ids])
            ->andWhere(['<>', 'discount', null])
            ->asArray()->indexBy('id_sales')
            ->all();
        $invoiced = InvoiceDtl::find()->select('reff_id')
                ->where([
                    'type_reff' => InvoiceDtl::TYPE_SALES_DISCOUNT,
                    'reff_id' => array_keys($completed),
                ])->column();
        $new = array_diff(array_keys($completed), $invoiced);
        foreach ($new as $id) {
            $details[] = [
                'type_reff' => InvoiceDtl::TYPE_SALES_DISCOUNT,
                'reff_id' => $id,
                'trans_value' => -$completed['discount']
            ];
        }

        $data['details'] = $details;
        $model = $this->create($data, $model);
        $model = $this->post('', [], $model);

        return $model;
    }

    public static function post($id, $data, $model = null)
    {
        /* @var $model MInvoice */
        $model = $model ? : $this->findModel($id);
        $success = false;
        $model->scenario = MInvoice::SCENARIO_DEFAULT;
        $model->load($data, '');
        $model->status = MInvoice::STATUS_POSTED;
        $this->fire('_post', [$model]);
        $success = $model->save();
        if ($success) {
            $this->fire('_posted', [$model]);
        } else {
            $success = false;
        }

        return $this->processOutput($success, $model);
    }
}