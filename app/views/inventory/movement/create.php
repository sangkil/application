<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\inventory\GoodsMovement */

$this->title = 'Create Good Movement';
$this->params['breadcrumbs'][] = ['label' => 'Good Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12 good-movement-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ])
    ?>
</div>
