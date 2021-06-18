<?php
use common\models\User;
use yii\bootstrap\Modal;

$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->getCsrfToken();

$script = <<< JS

    function save_form()
    {
        let data_send = { };
        data_send[csrfParam] = csrfToken;
        data_send['id'] = $("#user-id").val();
        data_send['status'] = $("#user-status").val();
        data_send['login'] = $("#user-username").val();
        data_send['role'] = $("#user-role").val();
        $.ajax({
            url: this_host + "/user/set_data_user",
            async: false,
            type: 'POST',
            dataType: 'JSON',
            data: data_send,
            cache: false,
            success: function (msg) {
                if (msg.error == 'no') {
                    setTimeout(() => { message(msg.msg,2000);},1000);
                }
            },
            complete: function() {
                $("#modal_form").modal('hide');
                setTimeout(()=> { window.location.reload();},3000);
            }
        });
    }

    /**
    * Получения для данных для модального окна пользователя  
    */
    function get_params_user(id=false) {
        if (id) {
            let data_send = { };
            data_send[csrfParam] = csrfToken;
            data_send['id'] = id;
            $.ajax({
                    url: this_host + "/user/get_data_user",
                    async: false,
                    type: 'POST',
                    dataType: 'JSON',
                    data: data_send,
                    cache: false,
                    success: function (msg) {
                        if (msg.error == 'no') {
                            $("#load_form_content").text('');
                            $("#load_form_content").html(msg.data);
                        }
                    }
            });
        }
    }
    
    $(function(){
        const this_host = window.location.protocol + "//" + window.location.hostname;
        const csrfParam = $('meta[name="csrf-param"]').attr("content");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        
        $(".modal_form_button").on('click',function() {
            $("#modal_form").modal('show');
            get_params_user($(this).attr('row'));
        });
        
    });
JS;

$this->registerJs($script, yii\web\View::POS_LOAD);

?>
<?php if ($models) { ?>
    <table class="table">
        <thead>
            <tr>
                <td>Логин пользователя</td>
                <td>Статус</td>
                <td>Роль</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $models as $model)  { ?>
                <tr row="<?= $model->id ?>" class="modal_form_button">
                    <td><?= $model->username ?></td>
                    <td><?= $model->statusName ?></td>
                    <td><?= $model->roleName ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    Ошибка загрузки данных пользователей
<?php } ?>

<?php
Modal::begin([
    'id' => 'modal_form',
    'header' => '<h3>Пользователь</h3>',
    'size' => 'modal-lg',
    'footer' => '<br>','footer'=>'<button class="btn btn-success text-center" onclick="save_form()">Сохранить</button>']);
?>
    <div class="row">
        <div class="col-xs-11 text-left" id="load_form_content" style="margin-left: 30px;">
        </div>
    </div>
<?php
Modal::end();
?>