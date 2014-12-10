<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sales\Sales */

$this->title = 'Create Sales';
$this->params['breadcrumbs'][] = ['label' => 'Purchases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details
    ])
    ?>
</div>
