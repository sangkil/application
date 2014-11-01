<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\master\Price */

$this->title = 'Create Price';
$this->params['breadcrumbs'][] = ['label' => 'Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
