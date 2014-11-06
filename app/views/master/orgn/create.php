<?php 
use app\components\SideMenu;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\master\Orgn */

$this->title = 'Create Orgn';
$this->params['bread'][] = ['label' => 'Orgns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-8 orgn-create">
    <div class="btn-group">
        <?php  
            $action = $this->context->action->id;
            $visible_create = in_array($action, array('update','view','index'));
            $visible_delete = in_array($action, array('update','view'));
            $visible_list = in_array($action, array('create','update','view'));
            $visible_view = in_array($action, array('update'));
            $visible_update = in_array($action, array('view'));
        ?>
        <?= ($visible_create)? Html::a('<i class="fa fa-plus-square"></i> Create', ['create'], ['class' => 'btn btn-success btn-sm']):''; ?> 
        <?= ($visible_view)? Html::a('<i class="fa fa-search"></i> Detail', ['view','id'=>$model->id], ['class' => 'btn bg-navy btn-sm']):'' ?> 
        <?= ($visible_update)? Html::a('<i class="fa fa-pencil"></i> Update', ['update','id'=>$model->id], ['class' => 'btn btn-warning btn-sm']):'' ?> 
        <?= ($visible_delete) ? Html::a('Delete', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]) : '' ?> 
        <?= ($visible_list)? Html::a('<i class="fa fa-list"></i> List', ['index'], ['class' => 'btn btn-info btn-sm']):'' ?>
    </div> 
    <br>    
    <?= SideMenu::widget(['items'=>['label'=>'Create','url'=>['create','id'=>'2']]]); ?>
    <br>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
