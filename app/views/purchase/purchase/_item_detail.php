<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<td style="width: 50px">
    <a data-action="delete" title="Delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
    <?= Html::activeTextInput($model, $attribute) ?>
    <?= Html::hiddenInput("id_product", '', ['data-field' => 'id_product', 'id' => false]) ?>
</td>
<td class="items" style="width: 45%">
    <ul class="nav nav-list">
        <li>
            Jumlah <?=
            Html::textInput("purch_qty", '', [
                'data-field' => 'purch_qty',
                'size' => 5, 'id' => false,
                'required' => true])
            ?>
            <?= Html::dropDownList("id_uom", '', [], ['data-field' => 'id_uom', 'id' => false]) ?>
        </li>
        <li>
        </li>
    </ul>
</td>
<td class="selling" style="width: 40%">
    <ul class="nav nav-list">
        <li>Selling Price</li>
        <li>
        </li>
        <li>
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
