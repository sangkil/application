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
<div class="panel panel-info">
    <div class="panel-heading">
        Product :
        <?php
        echo AutoComplete::widget([
            'name' => 'product',
            'id' => 'product',
            'clientOptions' => [
                'source' => new JsExpression('biz.master.sourceProduct'),
                'select' => new JsExpression('biz.purchase.onProductSelect'),
                'delay' => 100,
            ]
        ]);
        ?>
        <div class="pull-right">
            Item Discount:
            <?= Html::activeTextInput($model, 'discount', ['style' => 'width:60px;', 'id' => 'item-discount']); ?>
        </div>
    </div>
    <div class="panel-body" style="text-align: right;">
        <?= Html::activeHiddenInput($model, 'value', ['id' => 'purchase-value']); ?>
        <h4 id="bfore" style="display: none;">Rp <span id="purchase-val">0</span>-<span id="disc-val">0</span></h4>
        <h2>Rp <span id="total-price"></span></h2>
    </div>
    <?=
    TabularInput::widget([
        'id' => 'detail-grid',
        'allModels' => $details,
        'modelClass' => PurchaseDtl::className(),
        'options' => ['class' => 'tabular table-striped'],
//            'itemOptions' => ['tag' => 'tr'],
        'itemView' => '_item_detail',
        'clientOptions' => [
        ]
    ])
    ?>
</div>