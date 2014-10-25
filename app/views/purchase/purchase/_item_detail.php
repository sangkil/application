<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<td style="width: 50px">
    <a data-action="delete" title="Delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
    <?= Html::activeHiddenInput($model, "[$key]product_id", ['data-field' => 'product_id', 'id' => false]) ?>
</td>
<td class="items" style="width: 45%">
    <ul class="nav nav-list">
        <li><span class="cd_product"></span>
            - <span class="nm_product"></span></li>
        <li>
            Jumlah <?=
            Html::activeTextInput($model, "[$key]qty", [
                'data-field' => 'qty',
                'size' => 5, 'id' => false,
                'required' => true])
            ?>
            <?= Html::activeDropDownList($model, "[$key]uom_id", [], ['data-field' => 'id_uom', 'id' => false]) ?>
        </li>
        <li>
            Price Rp <?=
            Html::activeTextInput($model, "[$key]price", [
                'data-field' => 'price',
                'size' => 16, 'id' => false,
                'required' => true])
            ?>
        </li>
    </ul>
</td>
<td class="selling" style="width: 40%">
    <ul class="nav nav-list">
        
        <li>
            Price Rp <?=
            Html::activeTextInput($model, "[$key]price", [
                'data-field' => 'sales_price',
                'size' => 16, 'id' => false,
                'required' => true])
            ?>
        </li>
    </ul>
</td>
<td class="total-price">
    <ul class="nav nav-list">
        <li>&nbsp;</li>
        <li>
            <input type="hidden" data-field="total_price"><span class="total-price"></span>
        </li>
    </ul>
</td>
