<?php

use yii\db\Migration;

class m170114_125248_init_list_table extends Migration
{
    const LIST_TABLE_NAME = '{{%list}}';

    public function up()
    {

        $tableOptions = null;
        $tableOptionsMyISAM = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
            $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';
        }


        $this->createTable($this::LIST_TABLE_NAME,[
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
        ],$tableOptions);

//        $this->addForeignKey('fk_christmas_tree_to_user', $this::LIST_TABLE_NAME, 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        return true;
    }

    public function down()
    {
//        $this->dropForeignKey('fk_christmas_tree_to_user', $this::LIST_TABLE_NAME);
        $this->dropTable($this::LIST_TABLE_NAME);
        return true;
    }

}
