<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\Toolbar;

/**
 * @var yii\web\View $this
 * @var mdm\admin\models\AuthItem $model
 */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12 auth-item-view">
    <?=
    Toolbar::widget(['items' => [
            ['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
            ['label' => 'Update', 'url' => ['update', 'id' => $model->name], 'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
            ['label' => 'Delete', 'url' => ['delete', 'id' => $model->name], 'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
    ]]);
    ?> 

    <div class="box box-info">
        <div class="box-body no-padding">
            <?php
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'description:ntext',
                    'ruleName',
                    'data:ntext',
                ],
            ]);
            ?> 
        </div>
    </div>
</div>
<div class="col-lg-5">
    <div class="box box-info menu-view">
        <div class="box-header">
            Avaliable:
            <?php
            echo Html::textInput('search_av', '', ['class' => 'role-search', 'data-target' => 'avaliable']) . '<br>';
            ?>
        </div>
        <div class="box-body no-padding">
            <?php
            echo Html::listBox('roles', '', $avaliable, [
                'id' => 'avaliable',
                'multiple' => true,
                'size' => 20,
                'style' => 'width:100%']);
            ?>
        </div>
    </div>
</div>    
<div class="col-lg-2" style="text-align: center;">
    <?php
    echo Html::a('>>', '#', ['class' => 'btn btn-success', 'data-action' => 'assign']) . '<br>';
    echo Html::a('<<', '#', ['class' => 'btn btn-success', 'data-action' => 'delete']) . '<br>';
    ?>
</div>
<div class="col-lg-5">
    <div class="box box-info menu-view">
        <div class="box-header">
            Assigned:
            <?php
            echo Html::textInput('search_asgn', '', ['class' => 'role-search', 'data-target' => 'assigned']) . '<br>';
            ?>
        </div>
        <div class="box-body no-padding">
            <?php
            echo Html::listBox('roles', '', $assigned, [
                'id' => 'assigned',
                'multiple' => true,
                'size' => 20,
                'style' => 'width:100%']);
            ?>
        </div>
    </div>
</div>
<?php
$this->render('_script', ['name' => $model->name]);
