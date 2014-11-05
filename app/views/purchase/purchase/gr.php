<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\purchase\Purchase;


/* @var $this yii\web\View */
/* @var $model app\models\purchase\Purchase */
$this->title = $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Purchase', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="col-lg-12" style="padding-left: 0px;">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Purchase Header
        </div>
        <?php
        echo DetailView::widget([
            'options' => ['class' => 'table table-striped detail-view', 'style' => 'padding:0px;'],
            'model' => $model,
            'attributes' => [
                'number',
                'nmSupplier',
                'Date',
                'value',
                'nmStatus',
            ],
        ]);
        ?>
    </div>
</div>
<div class="col-lg-12">
    <?php
    echo yii\grid\GridView::widget([
        'tableOptions' => ['class' => 'table table-striped'],
        'layout' => '{items}',
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getGrs(),
            'sort' => false,
            'pagination' => false,
            ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'product.name',
            'qty',
            'price',
            'uom.name',
        ]
    ]);
    ?>
</div>
