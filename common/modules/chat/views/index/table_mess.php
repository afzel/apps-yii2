<?php if ($models) foreach ($models as $model) { ?>
        <tr class="<?= ($model->user->isAdmin) ? 'msg_admin' : 'msg_user' ?> <?= ($model->status == \common\modules\chat\models\Chat::STATUS_INCORRECT) ? 'bad' : '';?>" >
            <td><?= $model->user->username ?></td>
            <td><?= \yii\helpers\Html::encode($model->msg) ?></td>
        </tr>
<?php } ?>
