<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\accounting\GlHeader */

$this->title = 'Create Gl Header';
$this->params['breadcrumbs'][] = ['label' => 'Gl Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gl-header-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
