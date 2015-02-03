<?php

use yii\web\JsExpression;
use yii\jui\AutoComplete;
use yii\helpers\Html;
use app\models\purchase\PurchaseDtl;
use mdm\widgets\TabularInput;
use app\models\purchase\Purchase;
use yii\widgets\ListView;

/* @var $details PurchaseDtl[] */
/* @var $model app\models\purchase\Purchase */
/* @var $this yii\web\View */
?>
<?php
$allow_edit = ($model->status == Purchase::STATUS_DRAFT && ($this->context->action->id == 'create' || $this->context->action->id == 'update')) ? true : false;
$allow_edit = ($model->isNewRecord) ? true : $allow_edit;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#detail-pane" data-toggle="tab">Detail Items</a></li>
        <li><a href="#delivery-pane" data-toggle="tab">Deliveries</a></li>
        <li><a href="#payments-pane" data-toggle="tab">Invoice & Payments</a></li>
    </ul>
    <div class="tab-content"  style="min-height: 20em;">
        <div class="tab-pane active" id="detail-pane" style="min-height: 10em;">
            <div class="detail-pane-head col-lg-12" style="padding: 10px; padding-left: 0px;">
                <div class="col-xs-10">
                    Product :
                    <?php
                    echo AutoComplete::widget([
                        'name' => 'product',
                        'id' => 'product',
                        'clientOptions' => [
                            'source' => new JsExpression('biz.master.sourceProduct'),
                            'select' => new JsExpression('biz.purchase.onProductSelect'),
                            'delay' => 100,
                        ], 'options' => ['class' => 'form-control', 'readOnly' => !$allow_edit],
                    ]);
                    ?>
                </div>
                <div class="col-xs-2">
                    Item Discount:
                    <?= Html::activeTextInput($model, 'discount', [ 'id' => 'item-discount', 'class' => 'form-control', 'readOnly' => !$allow_edit]); ?>
                </div>
            </div>
            <div class="detail-pane-body col-lg-12">
                <table class="tabular table-striped col-lg-12">
                    <thead style="background-color: #9d9d9d;">
                    <th class="col-lg-4">Product</th>
                    <th class="col-lg-1">Qty</th>
                    <th class="col-lg-2">Uom</th>
                    <th class="col-lg-2">@Price</th>
                    <?php if ($allow_edit) { ?>                    
                        <th class="col-lg-2">Sub Total</th>
                        <th class="col-lg-1">&nbsp;</th>
                    <?php }else{ ?>                               
                        <th class="col-lg-3">Sub Total</th>
                    <?php } ?>
                    </thead>
                    <?=
                    TabularInput::widget([
                        'id' => 'detail-grid',
                        'allModels' => $details,
                        'modelClass' => PurchaseDtl::className(),
                        'options' => ['tag' => 'tbody'],
                        'itemOptions' => ['tag' => 'tr'],
                        'itemView' => '_item_detail',
                        'clientOptions' => [
                        ]
                    ])
                    ?>
                </table>
                <?= Html::activeHiddenInput($model, 'value', ['id' => 'purchase-value']); ?>
            </div>
        </div>
        <div class="tab-pane col-lg-12" id="delivery-pane">
            <div class="box box-solid">
                <?php
                echo ListView::widget([
                    'dataProvider' => $greceipt,
                    'layout' => '{items}',
                    'itemView' => '_greceipt',
                    //'options' => ['class' => 'box-body']
                ]);
                ?>
            </div>            
        </div>
        <div class="tab-pane col-lg-12" id="payments-pane">
            Payments
        </div>
    </div>
</div>