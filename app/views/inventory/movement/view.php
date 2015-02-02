<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\inventory\GoodsMovement;
use app\components\Toolbar;

/* @var $this yii\web\View */
/* @var $model GoodsMovement */

$this->title = '#'.$model->number;
$this->params['breadcrumbs'][] = ['label' => 'Good Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-movement-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => [],
        'config' => [],
    ])
    ?>
</div>
