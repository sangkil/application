<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $code string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="error-page">
    <h2 class="headline text-info" style="padding: 10px;"><?= '#'.$exception->statusCode ?></h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Oops! <?= nl2br(Html::encode($message)) ?></h3>
        <p>
            We could not find the page you were looking for or another error happen.
            Meanwhile, you may <a href='#'>return to dashboard</a> or try using the search form.
        </p>
        <form class='search-form'>
            <div class='input-group'>
                <input type="text" name="search" class='form-control' placeholder="Search"/>
                <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-primary form-control"><i class="fa fa-search"></i></button>
                </div>
            </div><!-- /.input-group -->
        </form>
    </div><!-- /.error-content -->
</div><!-- /.error-page -->