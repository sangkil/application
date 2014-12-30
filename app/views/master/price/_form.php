<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\master\Price */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-warning price-category-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'product_id')->textInput() ?>

        <?= $form->field($model, 'price_category_id')->dropDownList(\app\models\master\PriceCategory::selectOptions(), ['style' => 'width:150px;']) ?>

        <?= $form->field($model, 'price')->input('number', ['style' => 'width:200px;']) ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
app\assets\BizWidget::widget([
    'config' => [
        'masters' => ['products', 'barcodes'],
        'storageClass' => new JsExpression('DLocalStorage')
    ],
//    'scripts' => [
//        View::POS_END => $this->render('_script'),
//        View::POS_READY => 'biz.price.onReady();'
//    ]
]);
