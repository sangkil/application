<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\master\GlobalConfig */
/* @var $schema app\models\master\GlobalConfig */

$this->title = $schema->name . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $schema->name, 'url' => ['index', 'group' => $group]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="global-config-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'group' => $model->group, 'name' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'group' => $model->group, 'name' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <?php
    $attributes = ['name', 'description',];
    foreach ($schema->serializeValue as $col) {
        $attributes[] = 'serializeValue.' . $col . ':text:' . $col;
    }
    ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ])
    ?>

</div>
