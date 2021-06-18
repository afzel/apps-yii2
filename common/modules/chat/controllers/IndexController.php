<?php
namespace common\modules\chat\controllers;
use common\modules\chat\models\Chat;
use yii;


class IndexController extends BasicController
{
    public function actionIndex()
    {
        return $this->render('form');
    }

    public function actionGet_message()
    {
        $this->init_ajax();
        if ($this->user && $this->user->isAdmin) {
            $models = Chat::find()->orderBy('id DESC')->all();
        } else {
            $models = Chat::find()->where(['status'=>Chat::STATUS_CORRECT])->orderBy('id DESC')->all();
        }
        $this->error = 'no';
        $this->data = Yii::$app->view->renderAjax('@common/modules/chat/views/index/table_mess.php',['models'=>$models]);
        return $this->out();
    }

    public function actionSet_message()
    {
        $this->init_ajax();
        $model = new Chat();
        $model->msg = trim(Yii::$app->request->post('msg'));
        $model->user_id = Yii::$app->user->identity->id;
        if ($model->msg == '') {
            $this->error = 'yes';
            $this->msg = 'Пустое сообщение не передается';
        }
        if ($model->validate()) {
            $model->save();
            $this->error = 'no';
            $this->msg = 'Сообщение успешно отправлено';

        } else {
            $errors = '';
            foreach ($model->getErrors() as $key => $value) {
                $errors = $key.': '.$value[0];
            }
            $this->error = 'yes';
            $this->msg = $errors;
        }
        return $this->out();
    }

}