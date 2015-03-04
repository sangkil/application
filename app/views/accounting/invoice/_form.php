<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\accounting\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<section class="col-lg-12">
    <?= $this->render('_header', ['form' => $form, 'model' => $model]); ?> 
</section>
<section class="col-lg-12">
    <?= ''//$this->render('_detail', ['model' => $model, 'details' => $details, 'greceipt' => $greceipt]); ?>            
</section> 
<?php ActiveForm::end(); ?>
