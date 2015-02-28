<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\inventory\Transfer */

$this->title = 'New Stock Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row transfer-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'gmovement' => $gmovement
    ])
    ?>
</div>
