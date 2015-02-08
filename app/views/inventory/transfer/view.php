<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\inventory\Transfer;

/* @var $this yii\web\View */
/* @var $model Transfer */

$this->title = 'Transfer #'.$model->number;
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'gmovement' => $gmovement
    ])
    ?>
</div> 