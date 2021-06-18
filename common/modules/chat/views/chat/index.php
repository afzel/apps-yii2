<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\chat\models\Chat_search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';

$user = [
    'attribute'=>'user_id',
    'headerOptions' => ['width' => '40'],
    'content'=>function($data){
        return $data->user->username;
    }
];


$user = [
    'attribute'=>'user_id',
    'headerOptions' => ['width' => '30%'],
    'format' => 'html',
    'filter' => Select2::widget([
        'model' => $searchModel,
        'attribute' => 'user_id',
        'data' => ArrayHelper::map(\common\models\User::find()->asArray()->all(), 'id', 'username'),
        'theme' => Select2::THEME_BOOTSTRAP,
        'hideSearch' => false,
        'options' => [
            'placeholder' => '',
            'multiple' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]),

    'content'=>function($data){
        return $data->user->username;
    }
];


$status = [
    'attribute'=>'status',
    'headerOptions' => ['width' => '30%'],
    'format' => 'html',
    'filter' => Select2::widget([
        'model' => $searchModel,
        'attribute' => 'status',
        'data' => \common\modules\chat\models\Chat::getMsgArray(),
        'theme' => Select2::THEME_BOOTSTRAP,
        'hideSearch' => false,
        'options' => [
            'placeholder' => '',
            'multiple' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]),

    'content'=>function($data){
        return $data->statusName;
    }
];
if ($this->context->user && $this->context->user->isAdmin) {
    $element = [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Действия',
        'headerOptions' => ['width' => '80'],
        'template' => '<div style="text-align: center"><table><tr><td>{update}</td></tr></table></div>',
        'buttons' => [
            'update' => function ($url) {
                return '<a href="' . $url . '" style="padding-left: 6px; padding-right: 6px;"><span class="glyphicon glyphicon-pencil"></span></a>';
            },
        ],
    ];
} else {
    $element = [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Действия',
        'headerOptions' => ['width' => '80'],
        'template' => '<div style="text-align: center"><table><tr><td>{update}</td></tr></table></div>',
        'buttons' => [
            'update' => function ($url) {
                return '-';
            },
        ],
    ];
}

?>
<div class="chat-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="chat-update">

        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-body">

                        <div style="font-weight: 500; font-size: 22px; margin-bottom: 15px;">
                            <div class="col-md-3">
                                <div style="margin-bottom: 10px;">Чат</div>
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

                <div class="box">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            $user,
                            'msg:ntext',
                            'date_add',
                            $status,
                            $element,
                        ],
                    ]); ?>
                </div>

            </div>
        </div>


    </div>

</div>
<style type="text/css">
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left:0;
        padding-right:0;
        height:auto;
        margin-top:0px !important;
    }
</style>