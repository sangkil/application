<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var yii\web\View $this */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\purchase\Purchase */
?>

<div class="purchase-hdr-form">
    <?php
    $form = ActiveForm::begin([
            'id' => 'purchase-form',
    ]);
    ?>
    <?php
    $models = $details;
    $models[] = $model;
    echo $form->errorSummary($models)
    ?>
    <div class="col-lg-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Purchase Header
            </div>
            <div class="panel-body">
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
                        'clientOptions' => [
                            'dateFormat' => 'dd-mm-yy'
                        ],
                ]);
                ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php
                echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                ?>
            </div>
        </div>
    </div>
    <?=
    $this->render('_detail', [
        'model' => $model,
        'details' => $details
    ])
    ?>
    <?php ActiveForm::end(); ?>
</div>
<?php

app\assets\BizWidget::widget([
    'config' => [
        'masters' => ['product', 'supplier']
    ],
    'scripts' => [
        \yii\web\View::POS_END => '_script'
    ]
]);
