<?php

use yii\web\JsExpression;
use yii\jui\AutoComplete;
use yii\helpers\Html;
use app\models\inventory\TransferDtl;
use mdm\widgets\TabularInput;
use app\models\inventory\Transfer;
use yii\widgets\ListView;

/* @var $details SalesDtl[] */
/* @var $model app\models\sales\Sales */
/* @var $this yii\web\View */
?>
<?php
$allow_edit = ($model->status == Transfer::STATUS_DRAFT && ($this->context->action->id == 'create' || $this->context->action->id == 'update')) ? true : false;
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
                <div class="col-xs-8">
                    Product :
                    <?php
                    echo AutoComplete::widget([
                        'name' => 'product',
                        'id' => 'product',
                        'clientOptions' => [
                            'source' => new JsExpression('biz.master.sourceProduct'),
                            'select' => new JsExpression('biz.transfer.onProductSelect'),
                            'delay' => 100,
                        ], 'options' => ['class' => 'form-control'],
                    ]);
                    ?>
                </div>
            </div>
            <div class="detail-pane-body col-lg-12">
                <table class="tabular table-striped">
                    <thead>
                    <th class="col-lg-4">Product</th>
                    <th class="col-lg-1">Qty Trans</th>
                    <?php if (!($model->isNewRecord)) { ?>
                        <th class="col-lg-1">Issued</th>
                        <th class="col-lg-1">Received</th>
                    <?php } ?>
                    <th class="col-lg-2">Uom</th>
                    <th class="col-lg-1">&nbsp;</th>
                    </thead>
                    <?=
                    TabularInput::widget([
                        'id' => 'detail-grid',
                        'allModels' => $details,
                        'modelClass' => TransferDtl::className(),
                        'options' => ['tag' => 'tbody'],
                        'itemOptions' => ['tag' => 'tr'],
                        'itemView' => '_item_detail',
                        'clientOptions' => [
                        ]
                    ])
                    ?>
                </table>
            </div>
        </div>
        <div class="tab-pane col-lg-12" id="delivery-pane">
            <div class="box box-solid">
                <?php
                echo ListView::widget([
                    'dataProvider' => $gmovement,
                    'layout' => '{items}',
                    'itemView' => '_gissue',
                        //'options' => ['class' => 'box-body']
                ]);
                ?>
            </div>            
        </div>        
    </div>
</div>