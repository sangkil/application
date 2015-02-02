<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\inventory\GoodsMovement */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="goods-movement-form"> 
    <?php $form = ActiveForm::begin(['id' => 'goodsmovement-form']); ?>  
    <?= $form->errorSummary($model); ?>
    <?= (!$model->getErrors()) ? $form->errorSummary($details) : ''; ?>
    <?php
    $models = $details;
    $models[] = $model;
    echo $form->errorSummary($models)
    ?>    
    <div class="col-lg-12">
        <?= $this->render('_header', ['form' => $form, 'model' => $model]); ?>
    </div>
    <div class="col-lg-12">
        <?=
        ($this->context->action->id == 'view') ?
                $this->render('_vdetail', ['model' => $model, 'details' => $details]) : $this->render('_detail', ['model' => $model, 'details' => $details]);
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
app\assets\BizWidget::widget([
    'scripts' => [
        View::POS_END => $this->render('_script'),
        View::POS_READY => 'biz.movement.onReady();'
    ]
]);
