<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\base\DynamicModel */
/* @var $schema app\models\master\GlobalConfig */

$this->title = 'Update ' . $schema->name . ': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $schema->name, 'url' => ['index', 'group' => $group]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'group' => $group, 'name' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="global-config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'group' => $group,
        'schema' => $schema
    ])
    ?>

</div>
