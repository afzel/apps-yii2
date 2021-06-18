<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\chat\models\Chat */

$this->title = 'Редактировать запись: ' . $model->id;
?>
<div class="chat-update">

    <div class="row">
        <div class="col-md-12">

            <div class="box">
                <div class="box-body">

                    <div style="font-weight: 500; font-size: 22px; margin-bottom: 15px;">
                        <div class="col-md-3">
                            <div style="margin-bottom: 10px;"><?= $this->title ?></div>
                            <div style="margin-bottom: 10px;">
                                <!-- <a class="btn btn-default" href="#" id="add_form"><i class="glyphicon glyphicon-plus"></i> Добавить пользователя</a> -->
                            </div>
                        </div>
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-8">
                        </div>
                    </div>

                </div>
            </div>

            <div class="box" style="padding: 20px;">
                <?= $this->render('_form', ['model' => $model]) ?>
            </div>

        </div>
    </div>


</div>
