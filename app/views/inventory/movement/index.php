<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\inventory\GoodsMovement;
use biz\core\base\Configs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\inventory\searchs\GoodsMovement */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Good Movements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-movement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Good Movement', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $filterRef = [];
    foreach (Configs::movement() as $key => $value) {
        $filterRef[$key] = isset($value['name']) ? $value['name'] : $key;
    }
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'number',
            'Date',
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
                'attribute'=>'status',
                'value'=>'nmStatus',
                'filter'=>[
                    GoodsMovement::STATUS_DRAFT => 'Draft',
                    GoodsMovement::STATUS_APPLIED => 'Applied',
                    GoodsMovement::STATUS_INVOICED => 'Invoiced',
                ]
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
