<?php

use yii\web\JsExpression;
use yii\helpers\Html;
use app\components\Toolbar;
use app\components\ActionToolbar;
use app\models\sales\Sales;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model Sales */
?>

<?php
$toolbar_items = [];
// submit button
$btn = [
    'label' => $model->isNewRecord ? 'Create' : 'Save Update',
    'linkOptions' => ['class' => 'btn btn-success btn-sm'],
];
if ($this->context->action->id == 'view') {
    Html::addCssClass($btn['linkOptions'], 'disabled');
} else {
    $btn['linkOptions']['data-method'] = 'post';
}
$toolbar_items[] = $btn;

// confirm button
$btn = [
    'label' => 'Confirm',
    'linkOptions' => ['class' => 'btn btn-success btn-sm'],
];
if ($this->context->action->id == 'view' && $model->status == Sales::STATUS_DRAFT) {
    $btn['linkOptions']['data-method'] = 'post';
    $btn['url'] = ['confirm', 'id' => $model->id];
} else {
    Html::addCssClass($btn['linkOptions'], 'disabled');
}
$toolbar_items[] = $btn;

// deliver button
$btn = [
    'label' => 'Deliver',
    'linkOptions' => ['class' => 'btn btn-success btn-sm'],
];
if ($this->context->action->id == 'view' && $model->status > Sales::STATUS_DRAFT && $model->status < Sales::STATUS_PROCESS) {
    $btn['url'] = ['/inventory/movement/create','type'=>200, 'id' => $model->id];
} else {
    Html::addCssClass($btn['linkOptions'], 'disabled');
}
$toolbar_items[] = $btn;

// invoice button
$btn = [
    'label' => 'Invoice',
    'linkOptions' => ['class' => 'btn btn-success btn-sm'],
];
if ($this->context->action->id == 'view' && $model->status == Sales::STATUS_PROCESS) {
    $btn['url'] = ['/accounting/invoice/create','type'=>200, 'id' => $model->id];
} else {
    Html::addCssClass($btn['linkOptions'], 'disabled');
}
$toolbar_items[] = $btn;

echo Toolbar::widget(['items' => $toolbar_items]) . '&nbsp;&nbsp;';
echo Toolbar::widget(['items' => [
        ['label' => '', 'url' => ['print-html'], 'icon' => 'fa fa-print', 'linkOptions' => ['class' => 'btn btn-default btn-sm disabled', 'target' => '_blank', 'title' => 'Html Print']],
        ['label' => '', 'url' => ['print-pdf'], 'icon' => 'fa fa-file', 'linkOptions' => ['class' => 'btn btn-default btn-sm disabled', 'target' => '_blank', 'title' => 'Export to Pdf']],
        ['label' => '', 'url' => ['print-xsl'], 'icon' => 'fa fa-table', 'linkOptions' => ['class' => 'btn btn-default btn-sm disabled', 'target' => '_blank', 'title' => 'Export to Excel']],
]]) . '&nbsp;&nbsp;';
echo ActionToolbar::widget(['items' => [
        ['label' => 'Create New', 'url' => ['create'], 'icon' => 'fa fa-plus-square'],
        ['label' => 'Update', 'url' => ['update', 'id' => $model->id], 'icon' => 'fa fa-pencil'],
        ['label' => 'Delete', 'url' => ['delete', 'id' => $model->id], 'icon' => 'fa fa-trash-o', 'linkOptions' => ['data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
        ['label' => 'PO List', 'url' => ['index'], 'icon' => 'fa fa-list']
]]);
?>
<div class="box box-primary" style="min-height: 160px; margin-bottom: 20px; padding-top: 20px;">
    <div class="box-body">
        <div class="col-lg-6">
            <?= $form->field($model, 'number')->textInput(['maxlength' => 16, 'readonly' => true, 'style' => 'width:25%']); ?>
            <?=
                $form->field($model, 'nmCustomer')
                ->widget('yii\jui\AutoComplete', [
                    'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                        'source' => new JsExpression("biz.master.customers"),
                    ]
            ]);
            ?>
            <?= $form->field($model, 'nmStatus')->textInput(['maxlength' => 16, 'readonly' => true, 'style' => 'width:20%']); ?>
        </div>
        <div class="col-lg-6">                
            <?=
                $form->field($model, 'Date')
                ->widget('yii\jui\DatePicker', [
                    'options' => ['class' => 'form-control', 'style' => 'width:25%;'],
                    //'dateFormat' => 'php:d-m-Y',
            ]);
            ?>
            <h4 id="bfore" style="display: none; padding-left: 135px;">Rp<span id="sales-val">0</span>-<span id="disc-val">0</span></h4>         
            <h2 style="padding-left: 133px; margin-top: 0px;">Rp<span id="total-price"></span></h2>
        </div>        
    </div>
    <!--    <div class="col-lg-12 footer">                -->
    <?php
    //echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ?>
    <!--    </div>-->
</div>
