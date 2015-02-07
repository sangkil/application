<?php

use yii\helpers\Html;
use app\models\inventory\Transfer;

/* @var $this yii\web\View */
/* @var $model app\models\inventory\TransferDtl */
/* @var $parent Transfer */
/* @var $key string */
?>  
<?php
$allow_edit = ($parent->status == Transfer::STATUS_DRAFT && ($this->context->action->id == 'create' || $this->context->action->id == 'update')) ? true : false;
$allow_edit = ($model->isNewRecord) ? true : $allow_edit;
?>
<td class="col-lg-3">
    <span class="product"></span>
</td>
<td class="col-lg-1">
    <?= Html::activeTextInput($model, "[$key]qty", ['data-field' => 'qty', 'size' => 5, 'id' => false, 'class' => 'form-control ', 'readonly' => !$allow_edit, 'style' => 'text-align:right;', 'required' => true]) ?>
</td>
<td class="col-lg-2">
    <?= Html::activeDropDownList($model, "[$key]uom_id", [], ['data-field' => 'uom_id', 'id' => false, 'class' => 'form-control ', 'readonly' => !$allow_edit, 'style' => 'padding-top:0px;']) ?>
</td>
<td  class="col-lg-2" style="text-align: right;">
    <input type="hidden" data-field="total_price"><span class="total-price"></span>
</td>
<?php if ($allow_edit) { ?>
    <td  class="col-lg-1" style="text-align: center">    
        <a data-action="delete" title="Delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
    </td>        
<?php } ?>
<?= Html::activeHiddenInput($model, "[$key]product_id", ['data-field' => 'product_id', 'id' => false]) ?>
<?= Html::activeHiddenInput($model, "[$key]uom_id", ['data-field' => 'sel_uom_id', 'id' => false, 'name' => false]) ?>


