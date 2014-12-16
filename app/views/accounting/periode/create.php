<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\accounting\AccPeriode */

$this->title = 'Create Acc Periode';
$this->params['breadcrumbs'][] = ['label' => 'Acc Periodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-periode-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
