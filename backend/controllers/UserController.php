<?php
namespace backend\controllers;

use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class UserController extends BasicController
{

    public $only_action = ['index','get_table_content','get_data_user','set_data_user'];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    return $this->goHome();
                },
                'rules' => [
                    [
                        'allow' => TRUE,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function runAction($id, $params = [])
    {
        if (!in_array($id,$this->only_action) && (Yii::$app->request->isPost || Yii::$app->request->isAjax)) {
            $id = 'index';
        }
        return parent::runAction($id, $params);
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Сохранение данных пользователя
     *
     * @return array
     */
    public function actionSet_data_user()
    {
        $this->init_ajax();
        $id = Yii::$app->request->post('id');
        $role = Yii::$app->request->post('role');
        $status = Yii::$app->request->post('status');
        $login = Yii::$app->request->post('login');
        if ($this->user->isAdmin && $id && User::find()->where(['id'=>$id])->exists()) {
            $model_user = User::findOne($id);
            if ($model_user->username!='admin') {
                $this->error= 'no';
                $model_user->role = $role;
                $model_user->status = $status;
                $model_user->username = $login;
                if ($model_user->validators) {
                    $this->error = 'no';
                    $this->msg = 'Пользователь успешно отредактирован';
                    $model_user->save();
                } else {
                    $this->error = 'no';
                    $this->msg = 'Ошибка редактирования пользователя';
                }

            } else {
                $this->error = 'no';
                $this->msg = 'Главного пользователя нелья редактировать';
            }

        } else {
            $this->error = 'no';
            $this->data = 'Ошибка доступа';

        }
        return $this->out();
    }


    /**
     * Получения данных по конкретному пользователю
     *
     * @return array
     */
    public function actionGet_data_user() {
        $this->init_ajax();
        $id = Yii::$app->request->post('id');
        if ($this->user->isAdmin && $id && User::find()->where(['id'=>$id])->exists()) {
            $model_user = User::findOne($id);
            $this->error= 'no';
            $this->data = Yii::$app->view->renderAjax('@app/views/user/data_user.php',['model'=>$model_user]);

        } else {
            $this->error = 'no';
            $this->data = 'Ошибка доступа';

        }
        return $this->out();
    }

    /**
     * Получение данных по всем пользователям
     *
     * @return array
     */
    public function actionGet_table_content()
    {
        $this->init_ajax();
        if ($this->user->isAdmin) {
            $model_users = User::find()->all();
            $this->error= 'no';
            $this->data = Yii::$app->view->renderAjax('@app/views/user/table_users.php',['models'=>$model_users]);
        } else {
            $this->error = 'no';
            $this->data = 'Ошибка доступа';
        }
        return $this->out();
    }



}
