<?php

use yii\web\JsExpression;
use yii\helpers\Html;
use app\models\master\Branch;
use app\models\inventory\Transfer;
use app\components\Toolbar;
use app\components\ActionToolbar;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\inventory\Transfer */
?>
<?php
$toolbar_items = ($model->isNewRecord) ?
        [['label' => 'Create', 'linkOptions' => ['id' => 'create', 'class' => 'btn btn-success btn-sm']]] : [];
$toolbar_items = (!$model->isNewRecord && $model->status == Transfer::STATUS_DRAFT && $this->context->action->id == 'update' ) ?
        array_merge($toolbar_items, [['label' => 'Save Update', 'linkOptions' => ['id' => 'save', 'class' => 'btn btn-success btn-sm']]]) :
        array_merge($toolbar_items, [['label' => 'Save Update', 'linkOptions' => ['id' => 'save', 'class' => 'btn btn-primary btn-sm disabled']]]);
$toolbar_items = (!$model->isNewRecord && $model->status >= Transfer::STATUS_DRAFT && $model->status < Transfer::STATUS_ISSUED && $this->context->action->id == 'view') ?
        array_merge($toolbar_items, [['label' => 'Release', 'url' => ['/inventory/movement/create', 'type' => 300, 'id' => $model->id], 'linkOptions' => ['id' => 'release', 'class' => 'btn btn-success btn-sm']]]) :
        array_merge($toolbar_items, [['label' => 'Release', 'linkOptions' => ['id' => 'release', 'class' => 'btn btn-primary btn-sm disabled']]]);
$toolbar_items = (!$model->isNewRecord && $model->status >= Transfer::STATUS_ISSUED && $model->status < Transfer::STATUS_RECEIVED ) ?
        array_merge($toolbar_items, [['label' => 'Receipt', 'url' => ['/inventory/movement/create', 'type' => 400, 'id' => $model->id], 'linkOptions' => ['id' => 'receipt', 'class' => 'btn btn-success btn-sm']]]) :
        array_merge($toolbar_items, [['label' => 'Receipt', 'linkOptions' => ['id' => 'receipt', 'class' => 'btn btn-primary btn-sm disabled']]]);
$toolbar_items = (!$model->isNewRecord && $model->status == Transfer::STATUS_RECEIVED) ?
        array_merge($toolbar_items, [['label' => 'Invoice', 'url' => ['/accounting/invoice/create', 'type' => 300, 'id' => $model->id], 'linkOptions' => ['id' => 'invoice', 'class' => 'btn btn-success btn-sm']]]) :
        array_merge($toolbar_items, [['label' => 'Invoice', 'linkOptions' => ['id' => 'invoice', 'class' => 'btn btn-primary btn-sm disabled']]]);
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
        ['label' => 'Stock Transfer List', 'url' => ['index'], 'icon' => 'fa fa-list']
]]);
?>
<div class="box box-primary" style="min-height: 160px; margin-bottom: 20px; padding-top: 20px;">
    <div class="box-body">
        <div class="col-lg-6">
            <?= $form->field($model, 'number')->textInput(['maxlength' => 16, 'readonly' => true, 'style' => 'width:30%']); ?>
            <?= $form->field($model, 'branch_dest_id')->dropDownList(Branch::selectOptions()); ?>
        </div>
        <div class="col-lg-6">                
            <?=
                    $form->field($model, 'Date')
                    ->widget('yii\jui\DatePicker', [
                        'options' => ['class' => 'form-control', 'style' => 'width:20%'],
                            //'dateFormat' => 'php:d-m-Y',
            ]);
            ?>
            <?= $form->field($model, 'nmStatus')->textInput(['maxlength' => 24, 'readonly' => true, 'style' => 'width:20%']);?>
        </div>
    </div>
</div>            

