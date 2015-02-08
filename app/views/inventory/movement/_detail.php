<?php

use yii\web\JsExpression;
use yii\jui\AutoComplete;
use yii\helpers\Html;
use app\models\purchase\PurchaseDtl;
use mdm\widgets\TabularInput;
use app\models\purchase\Purchase;

/* @var $details PurchaseDtl[] */
/* @var $model app\models\purchase\Purchase */
/* @var $this yii\web\View */
?>
<?php
//$allow_edit = ($model->status == Purchase::STATUS_DRAFT && ($this->context->action->id == 'create' || $this->context->action->id == 'update')) ? true : false;
?>
<div class="box box-info">
    <div class="box-body no-padding">
        <table class="table table-striped">
            <thead>
            <th>No.</th>
            <th>Code</th>
            <th>Product Name</th>
            <th>Req Qty</th>
            <th>Movement Qty</th>
            <th>UOM</th>
            </thead>
            <tbody>
                <?php
                /* @var $detail app\models\inventory\GoodsMovementDtl */
                $i = 0;
                ?>
                <?php foreach ($details as $detail): ?>
                    <tr>
                        <td><?= $i + 1; ?>
                            <div style="display: none;">
                                <?= Html::activeHiddenInput($detail, "[{$i}]product_id") ?>
                                <?= Html::activeHiddenInput($detail, "[{$i}]trans_value") ?>
                            </div>
                        </td>
                        <td><?= $detail->product->code ?></td>
                        <td><?= $detail->product->name ?></td>
                        <td><?= $detail->avaliable ?></td>
                        <td><?= ($detail->avaliable > 0) ? Html::activeTextInput($detail, "[{$i}]qty",['style'=>'text-align:right;']) : Html::activeTextInput($detail, "[{$i}]qty", ['disabled' => 'disabled']) ?></td>
                        <td><?= $detail->uom->code ?></td>
                    </tr>
                    <?php
                    $i++;
                    ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div> 