<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Чат';
?>
<div class="site-index">
        <h1><?= Html::encode($this->title) ?> : <?= (Yii::$app->user->isGuest) ? 'Гость' : Yii::$app->user->identity->username ?></h1>

        <?php if (Yii::$app->user->isGuest) { ?>
            <h5>Авторизируйтесь, что бы иметь возможность вводить сообщения</h5>
        <?php } ?>

        <div class="row">

        </div>
</div>
