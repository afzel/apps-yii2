<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">AP</span><span class="logo-lg">Amin PANEL</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu" style="padding: 8px; 8px;">
            <div class="align-middle">
                <span style="padding: 8px 20px; font-size: 20px; color: white; margin-top: 2px;"><?= Yii::$app->user->identity->username ?></span>
                <?= Html::a('Logout', ['//site/logout'],['class' => 'btn btn-success', 'data-method'=>'post']) ?>


            </div>
        </div>
    </nav>
</header>
