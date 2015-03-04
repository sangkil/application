<?php

use app\components\Toolbar;
use app\components\ActionToolbar;

/*
 * Create By Mujib Masyhudi <mujib.masyhudi@gmail.com>
 * Create at {date('now')}
 */
?>
<?php
$toolbar_items = ($model->isNewRecord) ?
        [['label' => 'Create', 'linkOptions' => ['id' => 'create', 'class' => 'btn btn-success btn-sm']]] : [];
//$toolbar_items = (!$model->isNewRecord && $model->status == Purchase::STATUS_DRAFT && $this->context->action->id == 'update' ) ?
//        array_merge($toolbar_items, [['label' => 'Save Update', 'linkOptions' => ['id' => 'save', 'class' => 'btn btn-success btn-sm']]]) :
//        array_merge($toolbar_items, [['label' => 'Save Update', 'linkOptions' => ['id' => 'save', 'class' => 'btn btn-primary btn-sm disabled']]]);
//$toolbar_items = (!$model->isNewRecord && $model->status == Purchase::STATUS_DRAFT && $this->context->action->id == 'view') ?
//        array_merge($toolbar_items, [['label' => 'Confirm', 'linkOptions' => ['id' => 'confirm', 'class' => 'btn btn-success btn-sm']]]) :
//        array_merge($toolbar_items, [['label' => 'Confirm', 'linkOptions' => ['id' => 'confirm', 'class' => 'btn btn-primary btn-sm disabled']]]);
//$toolbar_items = (!$model->isNewRecord && $model->status > Purchase::STATUS_DRAFT && $model->status < Purchase::STATUS_PROCESS ) ?
//        array_merge($toolbar_items, [['label' => 'Deliver', 'url' => ['/inventory/movement/create', 'type' => 100, 'id' => $model->id], 'linkOptions' => ['id' => 'deliver', 'class' => 'btn btn-success btn-sm']]]) :
//        array_merge($toolbar_items, [['label' => 'Deliver', 'linkOptions' => ['id' => 'deliver', 'class' => 'btn btn-primary btn-sm disabled']]]);
//$toolbar_items = (!$model->isNewRecord && $model->status == Purchase::STATUS_PROCESS) ?
//        array_merge($toolbar_items, [['label' => 'Invoice', 'url' => ['/accounting/invoice/create', 'type' => 100, 'id' => $model->id], 'linkOptions' => ['id' => 'invoice', 'class' => 'btn btn-success btn-sm']]]) :
//        array_merge($toolbar_items, [['label' => 'Invoice', 'linkOptions' => ['id' => 'invoice', 'class' => 'btn btn-primary btn-sm disabled']]]);
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
            <?= $form->field($model, 'number')->textInput(['readonly' => true]) ?>
            <?=
            $form->field($model, 'Date')->widget('yii\jui\DatePicker', [
                'options' => ['class' => 'form-control']
            ])
            ?>
            <?=
            $form->field($model, 'DueDate')->widget('yii\jui\DatePicker', [
                'options' => ['class' => 'form-control']
            ])
            ?>
        </div>
        <div class="col-lg-6">            
            <?= $form->field($model, 'vendor_id')->textInput() ?>
            <div class="form-group field-goodsmovement-number">
                <label class="control-label">Reference</label>
                <span class="form-text"><?= $model->NmReffType ?>/<?= $model->reffLink ?></span>
            </div>
        </div>
    </div>
</div>
