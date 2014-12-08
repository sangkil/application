<?php

use yii\web\JsExpression;
use yii\jui\AutoComplete;
use yii\helpers\Html;
use app\models\purchase\PurchaseDtl;
use mdm\widgets\TabularInput;

/* @var $details PurchaseDtl[] */
/* @var $model app\models\purchase\Purchase */
/* @var $this yii\web\View */
?>
<div class="box box-info">
    <div class="box-body no-padding">
        <div class="row" style="padding: 10px;">
            <div class="col-xs-8">
                Product :
                <?php
                echo AutoComplete::widget([
                    'name' => 'product',
                    'id' => 'product',
                    'clientOptions' => [
                        'source' => new JsExpression('biz.master.sourceProduct'),
                        'select' => new JsExpression('biz.purchase.onProductSelect'),
                        'delay' => 100,
                    ], 'options' => ['class' => 'form-control'],
                ]);
                ?>
            </div>
            <div class="col-xs-4">
                Item Discount:
                <?= Html::activeTextInput($model, 'discount', [ 'id' => 'item-discount', 'class' => 'form-control']); ?>
            </div>
        </div> 
        <table class="tabular table-striped">
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
    </div>
    <div class="box-footer"> 
        <div class="col-lg-9">
            <?= Html::activeHiddenInput($model, 'value', ['id' => 'purchase-value']); ?>
            <h4 id="bfore" style="display: none;">Rp <span id="purchase-val">0</span>-<span id="disc-val">0</span></h4>         
        </div>
        <div class="col-lg-3">            
            <h2>Rp <span id="total-price"></span></h2>
        </div>
    </div>
</div>  