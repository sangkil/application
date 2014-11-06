<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\inventory\GoodMovement */

$this->title = 'Update Good Movement: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Good Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="good-movement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details
    ])
    ?>

</div>
