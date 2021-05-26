<?php

use yii\db\Migration;

/**
 * Class m210526_164007_CreateTableBalanceHistory
 */
class m210526_164007_CreateTableBalanceHistory extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%balance_history}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(32)->notNull(),
            'value' => $this->float()->null(),
            'balance' => $this->float()->null(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk-balance_history-user_id', '{{%balance_history}}', 'user_id', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210526_164007_CreateTableBalanceHistory cannot be reverted.\n";

        return false;
    }
}
