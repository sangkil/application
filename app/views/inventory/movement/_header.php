<?php

use yii\web\JsExpression;
use yii\helpers\Html;
use app\components\Toolbar;
use app\components\ActionToolbar;
use app\models\master\Warehouse;
use app\models\inventory\GoodsMovement;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\purchase\Purchase */
?>

<?php
$toolbar_items = ($model->isNewRecord) ?
        [['label' => 'Create', 'linkOptions' => ['id' => 'create', 'class' => 'btn btn-success btn-sm']]] : [];
$toolbar_items = (!$model->isNewRecord && $model->status == GoodsMovement::STATUS_DRAFT && ($this->context->action->id == 'create' || $this->context->action->id == 'update') ) ?
        array_merge($toolbar_items, [['label' => 'Save Update', 'linkOptions' => ['id' => 'save', 'class' => 'btn btn-success btn-sm']]]) :
        array_merge($toolbar_items, [['label' => 'Save Update', 'linkOptions' => ['id' => 'save', 'class' => 'btn btn-primary btn-sm disabled']]]);
$toolbar_items = (!$model->isNewRecord && $model->status == GoodsMovement::STATUS_DRAFT && $this->context->action->id == 'view') ?
        array_merge($toolbar_items, [['label' => 'Apply', 'url' => ['apply', 'id' => $model->id], 'linkOptions' => ['id' => 'apply', 'class' => 'btn btn-success btn-sm', 'data' => ['method' => 'post']]]]) :
        array_merge($toolbar_items, [['label' => 'Apply', 'linkOptions' => ['id' => 'apply', 'class' => 'btn btn-primary btn-sm disabled']]]);

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
        ['label' => 'Goods Movement List', 'url' => ['index'], 'icon' => 'fa fa-list']
]]);
?>
<div class="box box-primary" style="min-height: 160px; margin-bottom: 20px; padding-top: 20px;">
    <div class="box-body">
        <div class="col-lg-6">
            <?= $form->field($model, 'number')->textInput(['readonly' => true, 'style' => 'width:30%;']) ?>
            <?php
            if (isset($config['branch_field'])) {
                $branch_id = $model->reffDoc->{$config['branch_field']};
            } else {
                $branch_id = null;
            }
            echo $form->field($model, 'warehouse_id')->dropDownList(Warehouse::selectOptions($branch_id));
            ?>    
            <?= $form->field($model, 'nmStatus')->textInput(['maxlength' => 16, 'readonly' => true, 'style' => 'width:20%;']); ?>       
        </div>
        <div class="col-lg-6">                
            <?= $form->field($model, 'Date')->widget('yii\jui\DatePicker', ['options' => ['class' => 'form-control', 'style' => 'width:150px;']]) ?>
            <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>
            <div class="form-group field-goodsmovement-number">
                <label class="control-label">Reference</label>
                <span class="form-text"><?= $model->NmReffType ?>/<?= $model->reffLink ?></span>
            </div>
        </div>        
    </div>    
</div>
