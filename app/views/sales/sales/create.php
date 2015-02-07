<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sales\Sales */

$this->title = 'Create Sales';
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sales-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ])
    ?>
</div>
