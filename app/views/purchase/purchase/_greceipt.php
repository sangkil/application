<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\models\inventory\GoodsMovement;

/*
 * Create By Mujib Masyhudi <mujib.masyhudi@gmail.com>
 * Create at {date('now')}
 */
$ico_color = ($model->status == GoodsMovement::STATUS_DRAFT) ? 'maroon' : 'olive';
$ico_color = ($model->status == GoodsMovement::STATUS_PROCESS) ? 'orange' : $ico_color;
$ico_color = ($model->status == GoodsMovement::STATUS_CLOSE) ? 'olive' : $ico_color;

$label_color = ($model->status == GoodsMovement::STATUS_DRAFT) ? 'danger' : 'success';
$label_color = ($model->status == GoodsMovement::STATUS_PROCESS) ? 'warning' : $label_color;
$label_color = ($model->status == GoodsMovement::STATUS_CLOSE) ? 'success' : $label_color;
?>
<div class="col-md-5 col-sm-6 col-xs-12">
    <div class="info-box bg-gray">
        <span class="info-box-icon bg-<?= $ico_color ?>"><i class="fa fa-truck"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">
                <small class="label bg-<?= $ico_color ?>"><?= $model->nmStatus ?></small>
            </span>
            <span class="info-box-number">
                <?= Html::a($model->number, ['inventory/movement/view', 'id' => $model->id], ['class' => 'name']) ?>
            </span>
            <div class="progress"></div>
            <span class="progress-description">
                <?= $model->warehouse->name.', Create on ' . $model->date ?>
            </span>
        </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
</div><!-- /.col -->