<?php

use yii\helpers\Html;
use app\components\Toolbar;

/**
 * @var yii\web\View $this
 * @var mdm\admin\models\AuthItem $model
 */
$this->title = 'Create Role';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-8 orgn-create">
    <?php
    echo Toolbar::widget(['items' => [
            //['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
            //['label' => 'Detail', 'url' => ['view', 'id' => $model->id],'icon' => 'fa fa-search', 'linkOptions' => ['class' => 'btn bg-navy btn-sm']],
            //['label' => 'Update', 'url' => ['update', 'id' => $model->id],'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
            //['label' => 'Delete', 'url' => ['delete', 'id' => $model->id],'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
            ['label' => 'List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-info btn-sm']]
    ]]);
    ?>
    <?php
    echo $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
