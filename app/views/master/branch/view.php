<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\master\Branch */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Branches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-view">
    <div class="btn-group pull-right">
        <?php
        $action = $this->context->action->id;
        $visible_create = in_array($action, array('update', 'view', 'index'));
        $visible_delete = in_array($action, array('update', 'view'));
        $visible_list = in_array($action, array('create', 'update', 'view'));
        $visible_view = in_array($action, array('update'));
        $visible_update = in_array($action, array('view'));
        ?>
        <?= ($visible_create) ? Html::a('<i class="fa fa-plus-square"></i> Create', ['create'], ['class' => 'btn btn-success btn-sm']) : ''; ?> 
        <?= ($visible_view) ? Html::a('<i class="fa fa-search"></i> Detail', ['view', 'id' => $model->id], ['class' => 'btn bg-navy btn-sm']) : '' ?> 
        <?= ($visible_update) ? Html::a('<i class="fa fa-pencil"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']) : '' ?> 
        <?= ($visible_delete) ? Html::a('Delete', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]) : '' ?> 
        <?= ($visible_list) ? Html::a('<i class="fa fa-list"></i> List', ['index'], ['class' => 'btn btn-info btn-sm']) : '' ?>
    </div>  
    <br><br>
    <div class="box box-info orgn-view">
        <div class="box-body no-padding">
            <?=
            DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped detail-view'],
                'attributes' => [
                    'orgn.name',
                    'code',
                    'name',
                ],
            ])
            ?>
        </div>
    </div>

</div>
