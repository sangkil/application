<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\accounting\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <?php $form = ActiveForm::begin(); ?>
        <div class="box-header">
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

            <?= $form->field($model, 'vendor_id')->textInput() ?>
        </div>
        <div class="box-body">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
