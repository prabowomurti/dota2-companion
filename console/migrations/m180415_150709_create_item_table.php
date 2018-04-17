<?php

use yii\db\Migration;

/**
 * Handles the creation of table `item`.
 */
class m180415_150709_create_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('item', [
            'id'           => $this->primaryKey(),
            'name'         => $this->string()->notNull(),
            'price'        => $this->integer()->defaultValue(1),
            'is_recipe'    => $this->boolean()->defaultValue(0),
            'is_orphan'    => $this->boolean()->defaultValue(0),
            'has_no_child' => $this->boolean()->defaultValue(0),
            'description'  => $this->text(),
            'image'        => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('item');
    }
}
