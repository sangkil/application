<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\admin\models\Menu;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="box box-info menu-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>
        <?=
        $form->field($model, 'parent_name')->widget('yii\jui\AutoComplete', [
            'options' => ['class' => 'form-control'],
            'clientOptions' => [
                'source' => Menu::find()->select(['name'])->column()
            ]
        ])
        ?>

        <?=
        $form->field($model, 'route')->widget('yii\jui\AutoComplete', [
            'options' => ['class' => 'form-control'],
            'clientOptions' => [
                'source' => Menu::getSavedRoutes()
            ]
        ])
        ?>
        <?= $form->field($model, 'order')->input('number') ?>
        <?= $form->field($model, 'data')->textInput(['maxlength' => 256]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>



