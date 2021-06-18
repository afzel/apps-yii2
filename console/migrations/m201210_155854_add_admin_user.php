<?php
use yii\db\Migration;
use common\models\User;

/**
 * Class m201210_155854_add_admin_user
 */
class m201210_155854_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'role', $this->smallInteger()->after('email')->defaultValue(1)->comment('Роль для пользователя, 10 - Администратор, 1 - Пользователь'));

        $user = new User();
        $user->username = 'admin';
        $user->email = 'axe_dream@mail.ru';
        $user->setPassword('tomas4321');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = 10;
        $user->role = 10;
        return $user->save();



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'role');
        $model_user_from_delete = User::find()->where(['username'=>'admin'])->one();
        $model_user_from_delete->delete();
    }

}
