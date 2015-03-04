<?php

namespace app\models\accounting;
use biz\core\base\Configs;
use yii\helpers\Html;

/**
 * Invoice
 *
 * @property InvoiceDtl[] $invoiceDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Invoice extends \biz\core\accounting\models\Invoice
{

    /**
     * @inheritdoc
     */
    public function getInvoiceDtls()
    {
        return $this->hasMany(InvoiceDtl::className(), ['invoice_id' => 'id']);
    }

    public function getNmReffType()
    {
        if (($config = $this->reffConfig) !== null) {
            return isset($config['name']) ? $config['name'] : null;
        }
        return null;
    }

    public function getReffLink()
    {
        if (($config = $this->reffConfig) !== null && isset($config['link'])) {
            return $this->reffDoc ? Html::a($this->reffDoc->number, [$config['link'], 'id' => $this->reffDoc->id]) : null;
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            [
                'class' => 'mdm\converter\DateConverter',
                'attributes' => [
                    'Date' => 'date',
                    'DueDate' => 'due_date'
                ]
            ],
            [
                'class' => 'mdm\converter\EnumConverter',
                'attributes' => [
                    'nmType' => 'type'
                ],
                'enumPrefix' => 'TYPE_'
            ],
        ]);
    }
    
}
// Extend reference
Configs::merge('invoice', '@app/config/biz/invoice.php');
