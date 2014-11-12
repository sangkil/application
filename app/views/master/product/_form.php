<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\master\ProductGroup;
use app\models\master\Category;

/* @var $this yii\web\View */
/* @var $model app\models\master\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_id')->dropDownList(ProductGroup::selectOptions()) ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::selectOptions()) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 13]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
