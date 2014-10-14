<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\purchase\Purchase */
/* @var $form ActiveForm */
?>
<div class="purchase">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id_purchase') ?>
        <?= $form->field($model, 'purchase_num') ?>
        <?= $form->field($model, 'status') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- purchase -->
