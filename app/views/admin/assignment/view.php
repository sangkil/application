<?php

use yii\helpers\Html;
use app\components\Toolbar;

/* @var $this yii\web\View */
/* @var $model yii\web\IdentityInterface */

$this->title = 'Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12 menu-view">
    <?= ''//Html::a('Users', ['index'], ['class'=>'btn btn-success']) ?>
<!--    <h1>User: <?= ''//$model->{$usernameField}   ?></h1>-->
    <?=
    Toolbar::widget(['items' => [
            ['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
            //['label' => 'Detail', 'url' => ['view', 'id' => $model->id], 'icon' => 'fa fa-search', 'linkOptions' => ['class' => 'btn bg-navy btn-sm']],
            ['label' => 'Update', 'url' => ['update', 'id' => $model->id], 'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
            ['label' => 'Delete', 'url' => ['delete', 'id' => $model->id], 'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
            ['label' => 'List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-info btn-sm']]
    ]]);
    ?>
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
    <div class="col-lg-2">
        &nbsp;<br><br>
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
</div>
<?php
$this->render('_script', ['id' => $model->{$idField}]);
