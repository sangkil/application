<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\inventory\Transfer */

$this->title = 'Update Transfer: ' . ' ' . $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="transfer-update">
    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ]) ?>
</div>
