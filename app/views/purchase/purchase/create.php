<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\purchase\Purchase */
$this->title = 'Create Purchase';
$this->params['breadcrumbs'][] = ['label' => 'Purchase', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=

$this->render('_form', [
    'model' => $model,
    'details' => $details,
])
?>

