<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\inventory\GoodMovement;

/* @var $this yii\web\View */
/* @var $model GoodMovement */

$this->title = $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Good Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-movement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($model->status == GoodMovement::STATUS_DRAFT): ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
            <?=
            Html::a('Apply', ['apply', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        <?php endif; ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'number',
            'Date',
            'nmType',
            'nmReffType',
            'reffLink:raw:Reference',
            'description',
            'nmStatus',
        ],
    ])
    ?>

</div>

<div class="col-lg-9">
    <?php
    echo yii\grid\GridView::widget([
        'tableOptions' => ['class' => 'table table-striped'],
        'layout' => '{items}',
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getGoodMovementDtls(),
            'sort' => false,
            'pagination' => false,
            ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'product.name',
            'qty',
        ]
    ]);
    ?>
</div>
