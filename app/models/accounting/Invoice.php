<?php

namespace app\models\accounting;

/**
 * Invoice
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Invoice extends \biz\core\accounting\models\Invoice
{

    public function getInvoiceDtls()
    {
        return $this->hasMany(InvoiceDtl::className(), ['invoice_id' => 'id']);
    }
}