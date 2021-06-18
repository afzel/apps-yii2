<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\User;

$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->getCsrfToken();

?>
<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'username') ?>

    <div style="margin-bottom: 15px;">
        <label class="control-label">Статус</label>
        <?= Select2::widget([
            'model' => $model,
            'attribute' => 'status',
            'data' => $model->statusesArray,
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

    <div style="margin-bottom: 15px;">
        <label class="control-label">Роль</label>
        <?= Select2::widget([
            'model' => $model,
            'attribute' => 'role',
            'data' => $model->roleArray,
            'theme' => Select2::THEME_BOOTSTRAP,
            'hideSearch' => false,
            'maintainOrder' => true,
            'options' => [
                'placeholder' => 'Выберите роль...',
                'multiple' => false,
            ],
        ]);
        ?>
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


