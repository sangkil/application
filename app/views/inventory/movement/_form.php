<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\master\Warehouse;

/* @var $this yii\web\View */
/* @var $model app\models\inventory\GoodMovement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="good-movement-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model); ?>
    <?= $form->errorSummary($details); ?>

    <?= $form->field($model, 'number')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'warehouse_id')->dropDownList(Warehouse::selectOptions()) ?>

    <?= $form->field($model, 'Date')->widget('yii\jui\DatePicker') ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <table class="table table-striped">
        <tbody>
            <?php
            /* @var $detail app\models\inventory\GoodMovementDtl */
            $i = 0;
            ?>
            <?php foreach ($details as $detail): ?>
                <tr>
                    <td><?= $i + 1; ?>
                        <div style="display: none;">
                            <?= Html::activeHiddenInput($detail, "[{$i}]product_id") ?>
                            <?= Html::activeHiddenInput($detail, "[{$i}]trans_value") ?>
                        </div>
                    </td>
                    <td><?= $detail->product->name ?></td>
                    <td><?= $detail->avaliable ?></td>
                    <td><?= Html::activeTextInput($detail, "[{$i}]qty") ?></td>
                </tr>
                <?php
                $i++;
                ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php ActiveForm::end(); ?>

</div>
