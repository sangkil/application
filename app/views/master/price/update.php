<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\master\Price */

$this->title = 'Update Price: ' . ' ' . $model->product_id;
$this->params['breadcrumbs'][] = ['label' => 'Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_id, 'url' => ['view', 'product_id' => $model->product_id, 'price_category_id' => $model->price_category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="price-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
