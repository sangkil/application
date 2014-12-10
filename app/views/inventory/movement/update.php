<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\inventory\GoodsMovement */

$this->title = 'Update Good Movement: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Good Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="good-movement-update">
    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details
    ])
    ?>

</div>
