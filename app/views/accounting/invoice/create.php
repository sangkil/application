<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\accounting\Invoice */

$this->title = 'Create Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row invoice-create">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
