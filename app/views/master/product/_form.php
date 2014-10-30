<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\master\ProductGroup;
use app\models\master\Category;

/* @var $this yii\web\View */
/* @var $model app\models\master\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(ProductGroup::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 13]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
