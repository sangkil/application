<?php

use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var app\models\sales\Sales $model
 */
$this->title = '#'.$model->number;
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sales-view">
    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ]) ?>
</div>