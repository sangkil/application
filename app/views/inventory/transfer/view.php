<?php

use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var app\models\inventory\Transfer $model
 */
$this->title = '#'.$model->number;
$this->params['breadcrumbs'][] = ['label' => 'Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="transfer-view">
    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ]) ?>
</div>