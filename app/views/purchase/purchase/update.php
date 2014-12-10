<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\purchase\Purchase */

$this->title = 'Update Purchase: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchase-update">
    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ]) ?>

</div>
