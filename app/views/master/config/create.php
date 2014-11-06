<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\base\DynamicModel */
/* @var $schema app\models\master\GlobalConfig */


$this->title = 'Create '.$schema->name;
$this->params['breadcrumbs'][] = ['label' => $schema->name, 'url' => ['index','group'=>$group]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="global-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'group' => $group,
        'schema' => $schema
    ])
    ?>

</div>
