<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\purchase\Purchase */

$this->title = 'Create Purchase';
$this->params['breadcrumbs'][] = ['label' => 'Purchases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details
    ])
    ?>

</div>
