<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\purchase\PurchaseDtl */
/* @var $key string */
?>
<div class="table-cell" style="width: 20%;">
    <span class="product"></span>
</div>
<div class="table-cell" style="width: 40%;">
    <?= Html::activeTextInput($model, "[$key]qty", ['data-field' => 'qty', 'size' => 5, 'id' => false, 'required' => true]) ?>
    <?= Html::activeDropDownList($model, "[$key]uom_id", [], ['data-field' => 'uom_id', 'id' => false]) ?>
</div>
<div class="table-cell" style="width: 15%;">
    <?= Html::activeTextInput($model, "[$key]price", ['data-field' => 'price', 'size' => 16, 'id' => false, 'required' => true]) ?>
</div>
<div class="table-cell" style="width: 20%;">
    <input type="hidden" data-field="total_price"><span class="total-price"></span>
</div>
<div class="table-cell" style="width: 5%;">
    <a data-action="delete" title="Delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
    <?= Html::activeHiddenInput($model, "[$key]product_id", ['data-field' => 'product_id', 'id' => false]) ?>
    <?= Html::activeHiddenInput($model, "[$key]uom_id", ['data-field' => 'sel_uom_id', 'id' => false, 'name' => false]) ?>
</div>
