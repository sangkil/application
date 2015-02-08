<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
?>

<div class="box box-primary">
    <div class="box-body no-padding">
        <?php
        echo yii\grid\GridView::widget([
            'tableOptions' => ['class' => 'table table-striped'],
            'layout' => '{items}',
            'dataProvider' => new \yii\data\ActiveDataProvider([
                'query' => $model->getGoodsMovementDtls(),
                'sort' => false,
                'pagination' => false,
                    ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'product.code',
                'product.name',
                'qty',
                'uom.code'
            ]
        ]);
        ?>
    </div>
</div>