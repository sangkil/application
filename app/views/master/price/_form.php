<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\master\Price */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-warning price-category-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'product_id')->textInput() ?>
        
        <?= $form->field($model, 'price_category_id')->dropDownList(\app\models\master\PriceCategory::selectOptions()) ?>

        <?= $form->field($model, 'price')->textInput() ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
