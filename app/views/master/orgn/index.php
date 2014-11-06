<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\master\searchs\Orgn */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orgns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-index">
    <div class="btn-group">
        <?php  
            $action = $this->context->action->id;
            $visible_create = in_array($action, array('update','view','index'));
            $visible_delete = in_array($action, array('update','view'));
            $visible_list = in_array($action, array('create','update','view'));
            $visible_view = in_array($action, array('update'));
            $visible_update = in_array($action, array('view'));
        ?>
        <?= ($visible_create)? Html::a('<i class="fa fa-plus-square"></i> Create', ['create'], ['class' => 'btn btn-success btn-sm']):''; ?> 
        <?= ($visible_view)? Html::a('<i class="fa fa-search"></i> Detail', ['view','id'=>$model->id], ['class' => 'btn bg-navy btn-sm']):'' ?> 
        <?= ($visible_update)? Html::a('<i class="fa fa-pencil"></i> Update', ['update','id'=>$model->id], ['class' => 'btn btn-warning btn-sm']):'' ?> 
        <?= ($visible_delete) ? Html::a('<i class="fa fa-trash-o"></i> Delete', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]) : '' ?> 
        <?= ($visible_list)? Html::a('<i class="fa fa-list"></i> List', ['index'], ['class' => 'btn btn-info btn-sm']):'' ?>
    </div> 
    <br><br>
    <div class="box box-info">
        <div class="box-body no-padding">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}",
                'tableOptions' => ['class' => 'table table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'code',
                    'name',
                    'created_at',
                    'created_by',
                    // 'updated_at',
                    // 'updated_by',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>


    </div>
</div>
