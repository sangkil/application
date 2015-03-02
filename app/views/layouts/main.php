<?php

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\Breadcrumbs;
use app\components\Alert;


/* @var $this \yii\web\View */
/* @var $content string */

//$asset = app\assets\AppAsset::register($this);
$asset = app\assets\AdminLTE2Asset::register($this);
$asset2 = app\assets\AddAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" manifest="<?= isset($this->context->manifestFile) ? $this->context->manifestFile : '' ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?> 
    <body class="skin-blue layout-fixed sidebar-open">
        <div class="wrapper">
            <!-- header logo: style can be found in header.less -->
            <header class="main-header">
                <?php echo $this->render('heading2', ['baseurl' => $asset->baseUrl]); ?>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <?php echo $this->render('sidebar2', ['baseurl' => $asset->baseUrl]); ?>
            </aside>
            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?= Html::encode($this->title) ?>
                        <small><?php echo \Yii::$app->controller->id . '-' . \Yii::$app->controller->action->id; ?></small>
                    </h1>
                    <?php
                    $breadcrumbs = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [];
                    foreach (Yii::$app->controller->modules as $module) {
                        if ($module != Yii::$app) {
                            array_unshift($breadcrumbs, ['label' => Inflector::camel2words($module->id), 'url' => ['/' . $module->uniqueId]]);
                        }
                    }
                    ?>
                    <?=
                    Breadcrumbs::widget([
                        'tag'=>'ol',
                        'encodeLabels'=>false,
                        'homeLink'=>['label'=>'<i class="fa fa-dashboard"></i> Home/Dashboard','url'=>['/site/index']],
                        'links' => $breadcrumbs,
                    ])
                    ?>
                </section>
                <!-- Main content -->
                <section class="content">
                   <?= Alert::widget() ?>
                   <?= $content ?>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 3.0
                </div>
                <strong>Copyright &copy; 2006-2015 <a href="http://sangkilsoft.com">SangkilSoft</a>.</strong> All rights reserved.
            </footer>

        </div><!-- ./wrapper -->

        <!-- Pace 1.0.0 --
        <script src="js/plugins/pace/pace.js" type="text/javascript"></script-->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
        
        <!-- AdminLTE for demo purposes -->
        <!--    <script src="dist/js/demo.js" type="text/javascript"></script>-->
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
