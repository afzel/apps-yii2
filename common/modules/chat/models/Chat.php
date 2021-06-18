<?php

namespace common\modules\chat\models;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $user_id Ссылка на пользователя
 * @property string|null $msg Само сообщение
 * @property string|null $date_add Время добавления сообщения по времени сервера
 * @property int|null $status Статус сообщения
 */
class Chat extends \yii\db\ActiveRecord
{

    const STATUS_CORRECT = 0;
    const STATUS_INCORRECT = 10;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['msg'], 'string'],
            [['date_add'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'msg' => 'Сообщение',
            'date_add' => 'Дата добавления',
            'status' => 'Статус',
        ];
    }

    /**
     * Читаем виды сообщений
     *
     * @return array
     */
    public static function getMsgArray()
    {
        return [
            self::STATUS_CORRECT => 'Корректные сообщения',
            self::STATUS_INCORRECT => 'Некорректные сообщения',
        ];
    }

    /**
     * Получаем тип сообщения
     *
     * @return mixed
     * @throws \Exception
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getMsgArray(), $this->status);
    }

    /**
     * Связь с пользователем
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * Перед сохранением
     *
     * @param bool $insert
     * @return bool
     * @throws \Exception
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_add = self::getNowDateTime();
            $this->status = self::STATUS_CORRECT;
        }
        return parent::beforeSave($insert);
    }

    /**
     * Получаем актуальную дату-время
     *
     * @return string
     * @throws \Exception
     */
    public static function getNowDateTime()
    {
        $dateFile = new \DateTime();
        return $dateFile->format('Y-m-d H:i:s');
    }

    /**
     * Получаем актуальную дату
     *
     * @return string
     * @throws \Exception
     */
    public static function getNowDate()
    {
        $dateFile = new \DateTime();
        return $dateFile->format('Y-m-d');
    }
}
