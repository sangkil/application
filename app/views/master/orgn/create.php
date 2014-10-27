<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\master\Orgn */

$this->title = 'Create Orgn';
$this->params['breadcrumbs'][] = ['label' => 'Orgns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orgn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
