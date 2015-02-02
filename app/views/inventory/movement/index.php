<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\inventory\GoodsMovement;
use biz\core\base\Configs;
use app\components\Toolbar;
use app\models\master\Warehouse;
use app\components\ActionToolbar;

/* @var $this yii\web\View */
/* @var $searchModel app\models\inventory\searchs\GoodsMovement */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Good Movements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12 purchase-index">
    <?php
    echo Toolbar::widget(['items' => [
            ['label' => '', 'url' => ['print-html'], 'icon' => 'fa fa-print', 'linkOptions' => ['class' => 'btn btn-default btn-sm disabled', 'target' => '_blank', 'title' => 'Html Print']],
            ['label' => '', 'url' => ['print-pdf'], 'icon' => 'fa fa-file', 'linkOptions' => ['class' => 'btn btn-default btn-sm disabled', 'target' => '_blank', 'title' => 'Export to Pdf']],
            ['label' => '', 'url' => ['print-xsl'], 'icon' => 'fa fa-table', 'linkOptions' => ['class' => 'btn btn-default btn-sm disabled', 'target' => '_blank', 'title' => 'Export to Excel']],
]]) . '&nbsp;&nbsp;';
    echo ActionToolbar::widget(['items' => [
            ['label' => 'Create New', 'url' => ['create', 'type' => 100], 'icon' => 'fa fa-plus-square'],
            ['label' => 'Update', 'url' => ['update'], 'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'disabled']],
            ['label' => 'Delete', 'url' => ['delete'], 'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'disabled', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
            ['label' => 'PO List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'disabled']]
    ]]);
    ?>
    <div class="box box-info">
        <div class="box-body no-padding">
            <?php
            $filterRef = [];
            foreach (Configs::movement() as $key => $value) {
                $filterRef[$key] = isset($value['name']) ? $value['name'] : $key;
            }
            ?>
            <?php \yii\widgets\Pjax::begin(['enablePushState' => false]); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}",
                'tableOptions' => ['class' => 'table table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'number',
                    'date:date',
                    [
                        'attribute' => 'type',
                        'value' => 'nmType',
                        'filter' => [
                            GoodsMovement::TYPE_RECEIVE => 'Receive',
                            GoodsMovement::TYPE_ISSUE => 'Issue',
                        ]
                    ],
                    [
                        'attribute' => 'reff_type',
                        'value' => 'nmReffType',
                        'filter' => $filterRef,
                    ],
                    [
                        'label' => 'Reference',
                        'value' => 'reffLink',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'warehouse_id',
                        'value' => 'warehouse.name',
                        'filter' => Warehouse::selectOptions(),
                    ],
                    [
                        'attribute' => 'status',
                        'format'=>'raw',
                        'filter' => [
                            GoodsMovement::STATUS_DRAFT => 'Draft',
                            GoodsMovement::STATUS_PROCESS => 'Proccess',
                            GoodsMovement::STATUS_CLOSE => 'Closed',
                        ],
                        'value' => function($data) {
                            $color = ($data->status == GoodsMovement::STATUS_DRAFT) ? 'danger' : 'success';
                            $color = ($data->status == GoodsMovement::STATUS_PROCESS) ? 'info' : $color;
                            $color = ($data->status == GoodsMovement::STATUS_CLOSE) ? 'success' : $color;

                            return Html::tag('small', $data->nmStatus, ['class' => 'label label-' . $color]);
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{update}{delete}{apply}',
                    ],
                ],
            ]);
            ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </div>
</div>