<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\inventory\GoodMovement */

$this->title = 'Create Good Movement';
$this->params['breadcrumbs'][] = ['label' => 'Good Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-movement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
