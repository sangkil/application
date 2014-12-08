<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var mdm\admin\models\AuthItem $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<div class="box box-warning auth-item-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body" style="min-height: 300px;">
        <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
        <?= $form->field($model, 'description')->textInput(['maxlenght' => 128]) ?>
        <?=
        $form->field($model, 'ruleName')->widget('yii\jui\AutoComplete', [
            'options' => [
                'class' => 'form-control',
            ],
            'clientOptions' => [
                'source' => array_keys(Yii::$app->authManager->getRules()),
            ]
        ])
        ?>
        <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>
    </div>
    <div class="box-footer">
        <?php
        echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
