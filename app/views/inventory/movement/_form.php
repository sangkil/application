<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\master\Warehouse;

/* @var $this yii\web\View */
/* @var $model app\models\inventory\GoodsMovement */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->errorSummary($model); ?>
<?= (!$model->getErrors()) ? $form->errorSummary($details) : ''; ?>
<div class="col-lg-8">
    <div class="box box-primary">
        <div class="box-body">
            <?= $form->field($model, 'number')->textInput(['readonly' => true]) ?>

            <?= $form->field($model, 'warehouse_id')->dropDownList(Warehouse::selectOptions()) ?>

            <?= $form->field($model, 'Date')->widget('yii\jui\DatePicker', ['options' => ['class' => 'form-control', 'style' => 'width:150px;']]) ?>

            <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> 
        </div>
    </div>
</div>
<div class="col-lg-12">  
    <div class="box box-info">
        <div class="box-body no-padding">
            <table class="table table-striped">
                <tbody>
                    <?php
                    /* @var $detail app\models\inventory\GoodsMovementDtl */
                    $i = 0;
                    ?>
                    <?php foreach ($details as $detail): ?>
                        <tr>
                            <td><?= $i + 1; ?>
                                <div style="display: none;">
                                    <?= Html::activeHiddenInput($detail, "[{$i}]product_id") ?>
                                    <?= Html::activeHiddenInput($detail, "[{$i}]trans_value") ?>
                                </div>
                            </td>
                            <td><?= $detail->product->name ?></td>
                            <td><?= $detail->avaliable ?></td>
                            <td><?= Html::activeTextInput($detail, "[{$i}]qty") ?></td>
                            <td><?= $detail->uom->name ?></td>
                        </tr>
                        <?php
                        $i++;
                        ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>  
</div>
<?php ActiveForm::end(); ?>
