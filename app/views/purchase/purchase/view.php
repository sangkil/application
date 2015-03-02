<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\web\View;
use app\models\master\Warehouse;
use app\models\inventory\GoodsMovement;

/**
 * @var yii\web\View $this
 * @var app\models\purchase\Purchase $model
 */
$this->title = '#' . $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Purchase', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$form = ActiveForm::begin(['id' => 'purchase-form']);
?>
<?php
$models = $details;
$models[] = $model;
echo $form->errorSummary($models)
?> 
<div class="row purchase-view">
    <section class="col-lg-12">
        <?= $this->render('_header', ['form' => $form, 'model' => $model]); ?> 
    </section>
    <section class="col-lg-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#detail-pane" data-toggle="tab">Detail Items</a></li>
                <li><a href="#delivery-pane" data-toggle="tab">Deliveries</a></li>
                <li><a href="#payments-pane" data-toggle="tab">Invoice & Payments</a></li>
            </ul>
            <div class="tab-content" style=" min-height: 200px;">
                <div class="tab-pane active" id="detail-pane" style="min-height: 10em;">
                    <?php
                    echo yii\grid\GridView::widget([
                        'tableOptions' => ['class' => 'table table-striped'],
                        'layout' => '{items}',
                        'dataProvider' => new \yii\data\ActiveDataProvider([
                            'query' => $model->getPurchaseDtls(),
                            'sort' => false,
                            'pagination' => false,
                                ]),
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'product.name',
                            'qty',
                            'total_receive',
                            'price',
                            'uom.name',
                        ]
                    ]);
                    ?>
                </div>
                <div class="tab-pane col-lg-12" id="delivery-pane">
                    <div class="box box-solid">
                        <?php
//                        echo ListView::widget([
//                            'dataProvider' => $greceipt,
//                            'layout' => '{items}',
//                            'itemView' => '_greceipt',
//                                //'options' => ['class' => 'box-body']
//                        ]);
                        ?>
                        <?php
                        echo yii\grid\GridView::widget([
                            'tableOptions' => ['class' => 'table table-striped'],
                            'layout' => '{items}',
                            'dataProvider' => $greceipt,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'label' => 'Receipt Number',
                                    'format' => 'raw',
                                    'value' => function($data) {
                                        return Html::a($data->number, ['inventory/movement/view', 'id'=>$data->id]);
                                    }
                                ],
                                'date:date',
                                [
                                    'attribute' => 'warehouse_id',
                                    'value' => 'warehouse.name',
                                    'filter' => Warehouse::selectOptions(),
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'raw',
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
                            ]
                        ]);
                        ?>
                    </div>            
                </div>
                <div class="tab-pane col-lg-12" id="payments-pane">
                    Payments
                </div>
            </div>
        </div>
    </section>
</div>
<?php ActiveForm::end(); ?>
<?php
app\assets\BizWidget::widget([
    'config' => [
        'masters' => ['suppliers'],
//        'masters' => ['products', 'suppliers', 'barcodes'],
//        'storageClass' => new JsExpression('DLocalStorage')
    ],
    'scripts' => [
        View::POS_END => $this->render('_script'),
        View::POS_READY => 'biz.purchase.onComplete();'
    ]
]);
