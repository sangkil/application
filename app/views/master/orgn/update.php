<?php

use yii\helpers\Html;
use app\components\Toolbar;

/* @var $this yii\web\View */
/* @var $model app\models\master\Orgn */

$this->title = 'Update Orgn: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Orgns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-lg-8 orgn-update">
    <div class="btn-group">
        <?php
        $action = $this->context->action->id;
        $visible_create = in_array($action, array('update', 'view', 'index'));
        $visible_delete = in_array($action, array('update', 'view'));
        $visible_list = in_array($action, array('create', 'update', 'view'));
        $visible_view = in_array($action, array('update'));
        $visible_update = in_array($action, array('view'));
        ?>
        <?= ''//($visible_create) ? Html::a('<i class="fa fa-plus-square"></i> Create', ['create'], ['class' => 'btn btn-success btn-sm']) : ''; ?> 
        <?= ''//($visible_view) ? Html::a('<i class="fa fa-search"></i> Detail', ['view', 'id' => $model->id], ['class' => 'btn bg-navy btn-sm']) : '' ?> 
        <?= ''//($visible_update) ? Html::a('<i class="fa fa-pencil"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']) : '' ?> 
        <?= ''//($visible_delete) ? Html::a('<i class="fa fa-trash-o"></i> Delete', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]) : '' ?> 
        <?= ''//($visible_list) ? Html::a('<i class="fa fa-list"></i> List', ['index'], ['class' => 'btn btn-info btn-sm']) : '' ?>
    </div> 
    <?php
    echo Toolbar::widget([
        'items' => [
            // Important: you need to specify url as 'controller/action',
            // not just as 'controller' even if default action is used.
            ['label' => 'Home', 'url' => ['site/index']],
            // 'Products' menu item will be selected as long as the route is 'product/index'
            ['label' => 'Products', 'url' => ['product/index'], 'items' => [
                    ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
                    ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
                ]],
            ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
        ],
    ]);
    ?>
    <br><br>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
