<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $schema app\models\master\GlobalConfig */
/* @var $model yii\base\DynamicModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="global-config-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <?php foreach ($schema->serializeValue as $col): ?>
        <?= $form->field($model, $col)->textInput() ?>
    <?php endforeach; ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
