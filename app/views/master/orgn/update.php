<?php

use yii\helpers\Html;
use app\components\Toolbar;

/* @var $this yii\web\View */
/* @var $model app\models\master\Orgn */

$this->title = 'Update Orgn: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Orgns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-lg-8 orgn-update">
    <?php
    echo Toolbar::widget();
    ?>
    <br><br>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
