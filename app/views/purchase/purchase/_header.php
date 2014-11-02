<?php

use yii\web\JsExpression;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\purchase\Purchase */
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1-1" data-toggle="tab">Header</a></li>
        <li><a href="#tab_2-2" data-toggle="tab"><i class="fa fa-money"></i> Finance & Costing</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1" style="height: 14em;">
            <div class="col-lg-6">
                <?= $form->field($model, 'number')->textInput(['maxlength' => 16, 'readonly' => true, 'style'=>'width:50%']); ?>
                <?=
                        $form->field($model, 'supplier')
                        ->widget('yii\jui\AutoComplete', [
                            'options' => ['class' => 'form-control'],
                            'clientOptions' => [
                                'source' => new JsExpression("biz.master.suppliers"),
                            ]
                ]);
                ?>
            </div>
            <div class="col-lg-6">                
                <?=
                        $form->field($model, 'Date')
                        ->widget('yii\jui\DatePicker', [
                            'options' => ['class' => 'form-control', 'style' => 'width:50%'],
                            //'dateFormat' => 'php:d-m-Y',
                ]);
                ?>
                Display Total, dll
            </div>
            <div class="col-lg-12 footer">                
                <?php
                echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                ?>
            </div>
        </div>
        <div class="tab-pane" id="tab_2-2">
            Shipping Cost, dll.
        </div>
    </div>
</div>
<?php
                Yii::$app->formatter->locale;