<?php

use yii\helpers\Html;
use app\models\inventory\GoodsMovement;

/* @var $this yii\web\View */
/* @var $model app\models\inventory\GoodsMovement */

$this->title = ($model->isNewRecord)? 'New Good ': 'Update ';
$this->title .= ($model->isNewRecord)? ($config['type'] == GoodsMovement::TYPE_RECEIVE ? 'Receive' : 'Issue'):
    ($config['type'] == GoodsMovement::TYPE_RECEIVE ? 'Receive' : 'Issue').' #'.$model->number;
$this->params['breadcrumbs'][] = ['label' => 'Good Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-movement-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'config' => $config,
    ])
    ?>
</div>
