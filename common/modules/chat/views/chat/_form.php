<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\modules\chat\models\Chat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chat-form">

    <?php $form = ActiveForm::begin(); ?>

    <label>Имя пользователя</label>
    <?= $model->user->username ?>
    <br>

    <?= $form->field($model, 'msg')->textarea(['rows' => 6,'disabled' => 'disabled']) ?>

    <?= $form->field($model, 'date_add')->textInput(['disabled' => 'disabled']) ?>

    <div style="margin-bottom: 15px;">
        <label class="control-label">Статус</label>
        <?= Select2::widget([
            'model' => $model,
            'attribute' => 'status',
            'data' => \common\modules\chat\models\Chat::getMsgArray(),
            'theme' => Select2::THEME_BOOTSTRAP,
            'hideSearch' => false,
            'maintainOrder' => true,
            'options' => [
                'placeholder' => 'Выберите статус...',
                'multiple' => false,
            ],
        ]);
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style type="text/css">
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left:0;
        padding-right:0;
        height:auto;
        margin-top:0px !important;
    }
</style>