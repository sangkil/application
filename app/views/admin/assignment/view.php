<?php

use yii\helpers\Html;
use app\components\Toolbar;

/* @var $this yii\web\View */
/* @var $model yii\web\IdentityInterface */

$this->title = 'Assignments for ' . $model->{$usernameField};
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12 menu-view">
    <?= ''//Html::a('Users', ['index'], ['class'=>'btn btn-success']) ?>
<!--    <h1>User: <?= ''//$model->{$usernameField}     ?></h1>-->
    <?=
    Toolbar::widget(['items' => [
            ['label' => 'Users', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-success btn-sm']]
    ]]);
    ?>        
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
    echo Html::a('<<', '#', ['class' => 'btn btn-success', 'data-action' => 'delete']) . '&nbsp;';
    echo Html::a('>>', '#', ['class' => 'btn btn-success', 'data-action' => 'assign']);
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
$this->render('_script', ['id' => $model->{$idField}]);
