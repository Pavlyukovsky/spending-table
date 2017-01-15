<?php

use yii\db\Migration;

class m170115_160936_init_spending_project extends Migration
{
    const BILL_TABLE_NAME = '{{%bill}}';
    const BILL_CATEGORY_TABLE_NAME = '{{%bill_category}}';

    public function up()
    {

        $tableOptions = null;
        $tableOptionsMyISAM = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
            $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';
        }

        $this->createTable($this::BILL_TABLE_NAME,[
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price' => $this->double()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp(),
            'deleted' => $this->integer(1)->notNull(),
        ],$tableOptions);


        $this->createTable($this::BILL_CATEGORY_TABLE_NAME,[
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->timestamp(),
            'deleted' => $this->integer(1)->notNull(),
        ],$tableOptions);

//        $this->addForeignKey('fk_christmas_tree_to_user', $this::LIST_TABLE_NAME, 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_bill_to_bill_category', $this::BILL_TABLE_NAME, 'category_id', $this::BILL_CATEGORY_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');

        return true;
    }

    public function down()
    {
        $this->dropForeignKey('fk_bill_to_bill_category', $this::BILL_TABLE_NAME);

        $this->dropTable($this::BILL_CATEGORY_TABLE_NAME);
        $this->dropTable($this::BILL_TABLE_NAME);
        return true;
    }
}
