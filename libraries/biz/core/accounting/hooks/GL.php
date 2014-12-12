<?php

namespace biz\core\accounting\hooks;

use Yii;
use biz\core\base\Event;
use biz\core\accounting\components\GL as ApiGL;
use yii\base\UserException;

/**
 * Description of GL
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class GL extends \yii\base\Behavior
{

    public function events()
    {
        return[
            'e_invoice_posted' => 'invoicePosted'
        ];
    }

    protected function createGL($data)
    {
        $model = ApiGL::create($data);
        if ($model->hasErrors()) {
            throw new UserException(implode("\n", $model->firstErrors));
        }
    }

    /**
     *
     * @param Event $event
     */
    public function invoicePosted($event)
    {
        /* @var $model \biz\core\accounting\models\Invoice */
        $model = $event->params[0];
        $value = 0;
        foreach ($model->invoiceDtls as $detail) {
            $value += $detail->trans_value;
        }
        $data = [
            'entry_sheet' => ''
        ];
        $this->createGL($data);
    }

    /**
     *
     * @param Event $event
     */
    public function paymentPosted($event)
    {
        /* @var $model \biz\core\accounting\models\Payment */
        $model = $event->params[0];
        $value = 0;
        foreach ($model->paymentDtls as $detail) {
            $value += $detail->trans_value;
        }
        $data = [
            'entry_sheet' => ''
        ];
        $this->createGL($data);
    }
}
