<?php

namespace common\modules\chat\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\chat\models\Chat;
use Yii;

/**
 * Chat_search represents the model behind the search form of `common\modules\chat\models\Chat`.
 */
class Chat_search extends Chat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status'], 'integer'],
            [['msg', 'date_add'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Chat::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date_add' => $this->date_add,
            'status' => $this->status,
        ]);

        if (Yii::$app->user->identity->isUser()) {
            $query->andFilterWhere(['user_id'=>Yii::$app->user->identity->id]);
        }

        $query->andFilterWhere(['like', 'msg', $this->msg]);

        return $dataProvider;
    }
}
