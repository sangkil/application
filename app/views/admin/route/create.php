<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\Toolbar;

/**
 * @var yii\web\View $this
 * @var mdm\admin\models\Route $model
 * @var ActiveForm $form
 */
$this->title = 'Create Route';
$this->params['breadcrumbs'][] = ['label' => 'Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-lg-8 create">
    <?php
    echo Toolbar::widget(['items' => [
            //['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
            //['label' => 'Detail', 'url' => ['view', 'id' => $model->id],'icon' => 'fa fa-search', 'linkOptions' => ['class' => 'btn bg-navy btn-sm']],
            //['label' => 'Update', 'url' => ['update', 'id' => $model->id],'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
            //['label' => 'Delete', 'url' => ['delete', 'id' => $model->id],'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
            ['label' => 'List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-info btn-sm']]
    ]]);
    ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-info">
        <div class="box-body">
            <?= $form->field($model, 'route') ?>
        </div>
        <div class="box-footer">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- create -->

