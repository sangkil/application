<?php

use yii\helpers\Html;
use app\components\Toolbar;

/**
 * @var yii\web\View $this
 */
$this->title = 'Routes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12 menu-view">
    <?=
    Toolbar::widget(['items' => [
            ['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']]
    ]]);
    ?>        
</div>
<div class="col-lg-5">
    <div class="box box-info menu-view">
        <div class="box-header">
            Avaliable:
            <?php
            echo Html::textInput('search_av', '', ['class' => 'role-search', 'data-target' => 'new']).' ';
            ?>
        </div>
        <div class="box-body no-padding">
            <?php
            echo Html::listBox('routes', '', $new, [
            'id' => 'new',
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
            echo Html::textInput('search_asgn', '', ['class' => 'role-search', 'data-target' => 'exists']) . '<br>';
        ?>
        </div>
        <div class="box-body no-padding">
            <?php
            echo Html::listBox('routes', '', $exists, [
            'id' => 'exists',
            'multiple' => true,
            'size' => 20,
            'style' => 'width:100%',
            'options' => $existsOptions]);
            ?>
        </div>
    </div>
</div>
<?php
$this->render('_script');
