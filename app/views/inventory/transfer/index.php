<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\Toolbar;
use app\models\master\Branch;
use app\components\ActionToolbar;

/* @var $this yii\web\View */
/* @var $searchModel app\models\inventory\searchs\Transfer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Transfer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-index">
    <?php
    echo Toolbar::widget(['items' => [
            ['label' => '', 'url' => ['print-html'], 'icon' => 'fa fa-print', 'linkOptions' => ['class' => 'btn btn-default btn-sm disabled', 'target' => '_blank', 'title' => 'Html Print']],
            ['label' => '', 'url' => ['print-pdf'], 'icon' => 'fa fa-file', 'linkOptions' => ['class' => 'btn btn-default btn-sm disabled', 'target' => '_blank', 'title' => 'Export to Pdf']],
            ['label' => '', 'url' => ['print-xsl'], 'icon' => 'fa fa-table', 'linkOptions' => ['class' => 'btn btn-default btn-sm disabled', 'target' => '_blank', 'title' => 'Export to Excel']],
]]) . '&nbsp;&nbsp;';
    echo ActionToolbar::widget(['items' => [
            ['label' => 'Create New', 'url' => ['create'], 'icon' => 'fa fa-plus-square'],
            ['label' => 'Update', 'url' => ['update'], 'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'disabled']],
            ['label' => 'Delete', 'url' => ['delete'], 'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'disabled', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
            ['label' => 'Stock Transfer List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'disabled']]
    ]]);
    ?>
    <div class="box box-info">
        <div class="box-body no-padding">
            <?php \yii\widgets\Pjax::begin(['enablePushState'=>false]); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}",
                'tableOptions' => ['class' => 'table table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'number',
                    [
                        'attribute' => 'branch_id',
                        'value' => 'branch.name',
                        'filter' => Branch::selectOptions(),
                    ],
                    [
                        'attribute' => 'branch_dest_id',
                        'value' => 'destBranch.name',
                        'filter' => Branch::selectOptions(),
                    ],
                    'date:date',
                    [
                        'attribute' => 'status',
                        'value' => 'nmStatus'
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </div>
</div>

