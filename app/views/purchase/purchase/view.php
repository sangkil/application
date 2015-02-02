<?php

use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var app\models\purchase\Purchase $model
 */
$this->title = '#'.$model->number;
$this->params['breadcrumbs'][] = ['label' => 'Purchase', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="purchase-view">
    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'greceipt' => $greceipt
    ]) ?>
</div>