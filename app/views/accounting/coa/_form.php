<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\accounting\Coa */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="box box-warning">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">

        <?= $form->field($model, 'parent_id')->textInput() ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => 16]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

        <?= $form->field($model, 'type')->textInput() ?>

        <?= $form->field($model, 'normal_balance')->textInput(['maxlength' => 1]) ?>

        <?= $form->field($model, 'created_at')->textInput() ?>

        <?= $form->field($model, 'created_by')->textInput() ?>

        <?= $form->field($model, 'updated_at')->textInput() ?>

        <?= $form->field($model, 'updated_by')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
