<?php
use yii\helpers\Html;


$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->getCsrfToken();

$script = <<< JS
    const this_host = window.location.protocol + "//" + window.location.hostname;

    function send_msg()
    {
        let data_send = { };
        data_send['$csrfParam'] = '$csrfToken';
        data_send['msg'] = $("#text_p").val();
        $.ajax({
            url: this_host + "/chat/index/set_message",
            async: false,
            type: 'POST',
            dataType: 'JSON',
            data: data_send,
            cache: false,
            success: function (msg) {
                if (msg.error == 'no') {
                    $("#text_p").val('');
                    get_msg();
                }
            },
        });
    }
    
    function get_msg()
    {
        let data_send = { };
        data_send['$csrfParam'] = '$csrfToken';
        $.ajax({
            url: this_host + "/chat/index/get_message",
            async: false,
            type: 'POST',
            dataType: 'JSON',
            data: data_send,
            cache: false,
            success: function (msg) {
                if (msg.error == 'no') {
                    $("#chat_table").text('')
                    $("#chat_table").html(msg.data);
                }
            },
        });
    }
    
    
    $(function(){
        $("#btn_send_mess").on('click',function(e) {
            e.preventDefault();
            send_msg();
            return false;
        });
        
        setInterval(()=>{get_msg()},2000);
    });
JS;

$this->registerJs($script, yii\web\View::POS_LOAD);


?>

<?php $this->title = 'Чат'; ?>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?> : <?= (Yii::$app->user->isGuest) ? 'Гость' : Yii::$app->user->identity->username ?></h1>

    <?php if (Yii::$app->user->isGuest) { ?>
        <h5>Авторизируйтесь, что бы иметь возможность вводить сообщения</h5>
    <?php } ?>

    <div class="row">
        <?php if  (!Yii::$app->user->isGuest) { ?>
            <form>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Введите текст" id="text_p">
                    <div class="input-group-btn">
                        <button class="btn btn-success" id="btn_send_mess" >Ввод</button>
                    </div>
                </div>
            </form>

        <?php } ?>

        <div style="width: 100%">
            <table class="table table-dark">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Текст сообщения</th>
                </tr>
                </thead>
                <tbody id="chat_table">
                </tbody>
            </table>
        </div>


    </div>
</div>

<style type="text/css">
    .msg_admin {
        background-color: greenyellow;
    }
    .msg_user {
        background-color: white;
    }
    .bad {
        background-color: rgba(248, 0, 0, 0.4);
    }
</style>


