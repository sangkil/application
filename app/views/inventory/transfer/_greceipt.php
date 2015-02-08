<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\models\inventory\GoodsMovement;

/*
 * Create By Mujib Masyhudi <mujib.masyhudi@gmail.com>
 * Create at {date('now')}
 */
/* @var $model GoodsMovement */

$title = $model->type == GoodsMovement::TYPE_ISSUE ? 'issue' : 'receipt';
$label_color = ($model->status == GoodsMovement::STATUS_DRAFT) ? 'danger' : 'success';
$label_color = ($model->status == GoodsMovement::STATUS_PROCESS) ? 'warning' : $label_color;
$label_color = ($model->status == GoodsMovement::STATUS_CLOSE) ? 'success' : $label_color;
?>
<div class="callout callout-<?= $label_color ?>">
    <h5>
        <?= Html::a($model->number, ['inventory/movement/view', 'id' => $model->id], ['class' => 'name']) ?>
    </h5>
    <?= "This {$title} was create on {$model->date} and stored in {$model->warehouse->name}" ?>
    
    <br>
    <small class="label label-<?= $label_color ?>"><?= $model->nmStatus ?></small>
</div>
