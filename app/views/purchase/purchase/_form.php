<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\web\View;
use app\components\Toolbar;
use app\components\ActionToolbar;
use app\models\purchase\Purchase;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\purchase\Purchase */
?>

<?php
$form = ActiveForm::begin(['id' => 'purchase-form']);
?>
<?php
$models = $details;
$models[] = $model;
echo $form->errorSummary($models)
?>    
<section class="col-lg-12">
    <?= $this->render('_header', ['form' => $form, 'model' => $model]); ?> 
</section>
<section class="col-lg-12">
    <?= $this->render('_detail', ['model' => $model, 'details' => $details, 'greceipt' => $greceipt]); ?>            
</section> 
<?php ActiveForm::end(); ?>
<?php
app\assets\BizWidget::widget([
    'config' => [
        'masters' => ['products', 'suppliers', 'barcodes'],
        'storageClass' => new JsExpression('DLocalStorage')
    ],
    'scripts' => [
        View::POS_END => $this->render('_script'),
        View::POS_READY => 'biz.purchase.onReady();'
    ]
]);

