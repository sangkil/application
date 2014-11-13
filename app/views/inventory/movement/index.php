<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\inventory\GoodMovement;

/* @var $this yii\web\View */
/* @var $searchModel app\models\inventory\searchs\GoodMovement */
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
                    GoodMovement::TYPE_RECEIVE => 'Receive',
                    GoodMovement::TYPE_ISSUE => 'Issue',
                ]
            ],
            [
                'attribute' => 'reff_type',
                'value' => 'nmReffType',
            ],
            [
                'label' => 'Reference',
                'value' => 'reffLink',
                'format'=>'html'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
