<?php

use yii\db\Migration;

/**
 * Class m201211_110707_chat
 */
class m201211_110707_chat extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%chat}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Ссылка на пользователя'),
            'msg'=> $this->text()->comment('Само сообщение'),
            'date_add'=>$this->dateTime()->comment('Время добавления сообщения по времени сервера'),
            'status'=>$this->integer()->defaultValue(0)->comment('Статус сообщения')
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%chat}}');
    }
}
