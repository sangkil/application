<?php

use yii\helpers\Html;
use app\components\Toolbar;
use app\models\inventory\GoodsMovement;

/* @var $this yii\web\View */
/* @var $model GoodsMovement */

$type = $config['type'] == GoodsMovement::TYPE_RECEIVE ? 'Receive' : 'Issue';
$this->title = "Update Good {$type}: {$model->number}";
$this->params['breadcrumbs'][] = ['label' => 'Good ' . $type, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="good-movement-update">
    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'config'=>$config,
    ])
    ?>
</div>
