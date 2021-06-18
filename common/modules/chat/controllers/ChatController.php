<?php

namespace common\modules\chat\controllers;

use Yii;
use common\modules\chat\models\Chat;
use common\modules\chat\models\Chat_search;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;


/**
 * ChatController implements the CRUD actions for Chat model.
 */
class ChatController extends BasicController
{
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

    /**
     * Отображение greedView формы
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new Chat_search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /***
     * Обновить сообщение
     *
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->user && $this->user->isAdmin && $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Chat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
