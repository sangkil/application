<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\components\Toolbar;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */

$this->title = 'Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12 assignment-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <?=
    Toolbar::widget(['items' => [
            ['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
        //['label' => 'Detail', 'url' => ['view', 'id' => $model->id], 'icon' => 'fa fa-search', 'linkOptions' => ['class' => 'btn bg-navy btn-sm']],
        //['label' => 'Update', 'url' => ['update', 'id' => $model->id],'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
        //['label' => 'Delete', 'url' => ['delete', 'id' => $model->id], 'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
        //['label' => 'List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-info btn-sm']]
    ]]);
    ?>
    <div class="box box-info">
        <div class="box-body no-padding">
            <?php
            Pjax::begin([
                'enablePushState' => false,
            ]);
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}",
                'tableOptions' => ['class' => 'table table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'attribute' => $usernameField,
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}'
                    ],
                ],
            ]);
            Pjax::end();
            ?>

        </div>
    </div>
</div>
