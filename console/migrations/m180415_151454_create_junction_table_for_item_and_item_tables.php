<?php

use yii\db\Migration;

/**
 * Handles the creation of table `item_relation`.
 * Has foreign keys to the tables:
 *
 * - `item`
 */
class m180415_151454_create_junction_table_for_item_and_item_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('item_relation', [
            'item_id' => $this->integer(),
            'parent_id' => $this->integer(),
            'PRIMARY KEY(item_id, parent_id)',
        ]);

        // creates index for column `item_id`
        $this->createIndex(
            'idx-item_relation-item_id',
            'item_relation',
            'item_id'
        );

        // creates index for column `parent_id`
        $this->createIndex(
            'idx-item_relation-parent_id',
            'item_relation',
            'parent_id'
        );

        // add foreign key for table `item`
        $this->addForeignKey(
            'fk-item_relation-item_id',
            'item_relation',
            'item_id',
            'item',
            'id',
            'CASCADE'
        );

        // add foreign key for table `parent` / `item`
        $this->addForeignKey(
            'fk-item_relation-parent_id',
            'item_relation',
            'parent_id',
            'item',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `item`
        $this->dropForeignKey(
            'fk-item_relation-item_id',
            'item_relation'
        );

        // drops foreign key for table `item`
        $this->dropForeignKey(
            'fk-item_relation-parent_id',
            'item_relation'
        );

        // drops index for column `item_id`
        $this->dropIndex(
            'idx-item_relation-item_id',
            'item_relation'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            'idx-item_relation-parent_id',
            'item_relation'
        );



        $this->dropTable('item_relation');
    }
}
