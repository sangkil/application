<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\master\PriceCategory */

$this->title = 'Create Price Category';
$this->params['breadcrumbs'][] = ['label' => 'Price Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
