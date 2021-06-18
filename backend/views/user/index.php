<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;

$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->getCsrfToken();

$script = <<< JS

    /**
    * Получение таблицы сожержимого (пользователей) 
    */
    function get_table_content() {
        let data_send = { };
        data_send[csrfParam] = csrfToken;

        $.ajax({
            url: this_host + "/user/get_table_content",
            async: false,
            type: 'POST',
            dataType: 'JSON',
            data: data_send,
            cache: false,
            success: function (msg) {
                if (msg.error == 'no') {
                    $("#content_table").text('');
                    $("#content_table").html(msg.data);
                }
                
            }
        });

    }

    $(function(){
        const this_host = window.location.protocol + "//" + window.location.hostname;
        const csrfParam = $('meta[name="csrf-param"]').attr("content");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");

        get_table_content();
        
    });
JS;
$this->registerJs($script, yii\web\View::POS_LOAD);


?>
<?= Html::csrfMetaTags() ?>
<div class="row">
    <div class="col-md-12">

        <div class="box">
            <div class="box-body">

                <div style="font-weight: 500; font-size: 22px; margin-bottom: 15px;">
                    <div class="col-md-3">
                        <div style="margin-bottom: 10px;">"Пользователи"</div>
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
            <div class="box-body" id="content_table"></div>
        </div>

    </div>
</div>

<style type="text/css">
    .t_hover:hover {
        background-color: #0cb8ea;
    }
    .t_success {
        background-color: #a0ffac;
    }
    .t_primary {
        background-color: #57bbea;
    }
    .t_warning {
        background-color: #ffdb03;
    }
    .t_warning_2 {
        background-color: #e2c103;
    }
    .t_danger {
        background-color: #ff0006;
    }
</style>