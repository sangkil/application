<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\Toolbar;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 */
$this->title = Yii::t('user', 'Update user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-8">
    <div class="alert alert-info">        
        <?= Yii::t('user', 'Registered at {0, date, MMMM dd, YYYY HH:mm} from {1}', [$model->created_at, is_null($model->registration_ip) ? 'N/D' : long2ip($model->registration_ip)]) ?>
        <br/>
        <?php if (Yii::$app->getModule('user')->enableConfirmation && $model->getIsConfirmed()): ?>
            <?= Yii::t('user', 'Confirmed at {0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]) ?>
            <br/>
        <?php endif; ?>
        <?php if ($model->getIsBlocked()): ?>
            <?= Yii::t('user', 'Blocked at {0, date, MMMM dd, YYYY HH:mm}', [$model->blocked_at]) ?>
        <?php endif; ?>
    </div>
    <?php echo $this->render('flash') ?>
    <?php
    $dItem = [];
    if (!$model->getIsConfirmed()) {
        $dItem[] = ['label' => Yii::t('user', 'Confirm'), 'url' => ['confirm', 'id' => $model->id], 'icon' => 'fa fa-question-circle', 'linkOptions' => ['class' => 'btn btn-success btn-xs', 'data-method' => 'post']];
    }
    if ($model->getIsBlocked()) {
        $dItem[] = ['label' => Yii::t('user', 'Unblock'), 'url' => ['block', 'id' => $model->id], 'icon' => 'fa fa-check-square-o', 'linkOptions' => ['class' => 'btn btn-success btn-xs', 'data-method' => 'post', 'data-confirm' => Yii::t('user', 'Are you sure to block this user?')]];
    } else {
        $dItem[] = ['label' => Yii::t('user', 'Block'), 'url' => ['block', 'id' => $model->id], 'icon' => 'fa fa-ban', 'linkOptions' => ['class' => 'btn btn-danger btn-xs', 'data-method' => 'post', 'data-confirm' => Yii::t('user', 'Are you sure to block this user?')]];
    }
    echo Toolbar::widget(['items' => $dItem]);
    ?>
    <div class="box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-header">
            <i class="fa fa-user"></i>
            <?= Html::encode($model->username) ?>
        </div>
        <div class="box-body">

            <?= $form->field($model, 'username')->textInput(['maxlength' => 25]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

        </div>
        <div class="box-footer">
            <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

