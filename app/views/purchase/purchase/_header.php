<?php

use yii\web\JsExpression;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\purchase\Purchase */
?>

<?= $form->field($model, 'number')->textInput(['maxlength' => 16, 'readonly' => true]); ?>
<?=
    $form->field($model, 'supplier')
    ->widget('yii\jui\AutoComplete', [
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'source' => new JsExpression("biz.master.suppliers"),
        ]
    ]);
?>
<?=
    $form->field($model, 'Date')
    ->widget('yii\jui\DatePicker', [
        'options' => ['class' => 'form-control', 'style' => 'width:50%'],
        'dateFormat' => 'php:d-m-Y',
    ]);
?>

<div class="panel-footer" style="text-align: right;">
    <?php
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ?>
</div>
