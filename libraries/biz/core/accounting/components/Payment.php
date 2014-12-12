<?php

namespace biz\core\accounting\components;

use Yii;
use biz\core\accounting\models\Payment as MPayment;
use biz\core\accounting\models\PaymentDtl;
use biz\core\accounting\models\Invoice;
use yii\base\UserException;

/**
 * Description of Payment
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Payment extends \biz\core\base\Api
{
    /**
     *
     * @var string 
     */
    public $modelClass = 'biz\core\accounting\models\Payment';

    /**
     *
     * @var string 
     */
    public $prefixEventName = 'e_payment';

    /**
     *
     * @param  type                            $data
     * @param  \biz\core\accounting\models\Payment $model
     * @return \biz\core\accounting\models\Payment
     */
    public function create($data, $model = null)
    {
        /* @var $model MPayment */
        $model = $model ? : $this->createNewModel();
        $success = false;
        $model->scenario = MPayment::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!empty($data['details'])) {
            $this->fire('_create', [$model]);
            $success = $model->save();
            $success = $model->saveRelated('paymentDtls', $data, $success, 'details');
            if ($success) {
                $this->fire('_created', [$model]);
            } else {
                if ($model->hasRelatedErrors('paymentDtls')) {
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
     *
     * @param  string                          $id
     * @param  array                           $data
     * @param  \biz\core\accounting\models\Payment $model
     * @return \biz\core\accounting\models\Payment
     */
    public function update($id, $data, $model = null)
    {
        /* @var $model MPayment */
        $model = $model ? : $this->findModel($id);
        $success = false;
        $model->scenario = MPayment::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!isset($data['details']) || $data['details'] !== []) {
            $this->fire('_update', [$model]);
            $success = $model->save();
            if (!empty($data['details'])) {
                $success = $model->saveRelated('paymentDtls', $data, $success, 'details');
            }
            if ($success) {
                $this->fire('_updated', [$model]);
            } else {
                if ($model->hasRelatedErrors('paymentDtls')) {
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
     *
     * @param  array                           $data
     * @param  \biz\core\accounting\models\Payment $model
     * @return \biz\core\accounting\models\Payment
     * @throws UserException
     */
    public function createFromInvoice($data, $model = null)
    {
        /* @var $model MPayment */
        $pay_vals = ArrayHelper::map($data['details'], 'id_invoice', 'value');
        $ids = array_keys($pay_vals);

        $invoice_values = Invoice::find()
            ->where(['id_invoice' => $ids])
            ->indexBy('id_invoice')
            ->asArray()
            ->all();

        $vendor = $inv_type = null;
        $vendors = $inv_types = [];
        foreach ($invoice_values as $row) {
            $vendor = $row['id_vendor'];
            $vendors[$vendor] = true;
            $inv_type = $row['invoice_type'];
            $inv_types[$inv_type] = true;
        }
        if (count($vendors) !== 1) {
            throw new UserException('Vendor harus sama');
        }
        if (count($inv_types) !== 1) {
            throw new UserException('Type invoice harus sama');
        }

        $invoice_paid = PaymentDtl::find()
            ->select(['id_invoice', 'total' => 'sum(payment_value)'])
            ->where(['id_invoice' => $ids])
            ->groupBy('id_invoice')
            ->indexBy('id_invoice')
            ->asArray()
            ->all();

        $data['id_vendor'] = $vendor;
        $data['payment_type'] = $inv_type;
        $details = [];
        foreach ($inv_vals as $id => $value) {
            $sisa = $invoice_values[$id]['invoice_value'];
            if (isset($invoice_paid[$id])) {
                $sisa -= $invoice_paid[$id]['total'];
            }
            if ($value > $sisa) {
                throw new UserException('Tagihan lebih besar dari sisa');
            }
            $details[] = [
                'id_invoice' => $id,
                'payment_value' => $value,
            ];
        }
        $data['details'] = $details;

        return $this->create($data, $model);
    }

    /**
     *
     * @param  string                          $id
     * @param  array                           $data
     * @param  \biz\core\accounting\models\Payment $model
     * @return \biz\core\accounting\models\Payment
     */
    public function post($id, $data, $model = null)
    {
        /* @var $model MPayment */
        $model = $model ? : $this->findModel($id);
        $model->load($data, '');

        return $this->processOutput($success, $model);
    }
}