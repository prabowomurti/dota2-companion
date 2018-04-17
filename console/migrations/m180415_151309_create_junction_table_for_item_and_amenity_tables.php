<?php

use yii\db\Migration;

/**
 * Handles the creation of table `item_amenity`.
 * Has foreign keys to the tables:
 *
 * - `item`
 * - `amenity`
 */
class m180415_151309_create_junction_table_for_item_and_amenity_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('item_amenity', [
            'item_id' => $this->integer(),
            'amenity_id' => $this->integer(),
            'value' => $this->decimal(4,2),
            'unit_label' => $this->string(20),
            'PRIMARY KEY(item_id, amenity_id)',
        ]);

        // creates index for column `item_id`
        $this->createIndex(
            'idx-item_amenity-item_id',
            'item_amenity',
            'item_id'
        );

        // add foreign key for table `item`
        $this->addForeignKey(
            'fk-item_amenity-item_id',
            'item_amenity',
            'item_id',
            'item',
            'id',
            'CASCADE'
        );

        // creates index for column `amenity_id`
        $this->createIndex(
            'idx-item_amenity-amenity_id',
            'item_amenity',
            'amenity_id'
        );

        // add foreign key for table `amenity`
        $this->addForeignKey(
            'fk-item_amenity-amenity_id',
            'item_amenity',
            'amenity_id',
            'amenity',
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
            'fk-item_amenity-item_id',
            'item_amenity'
        );

        // drops index for column `item_id`
        $this->dropIndex(
            'idx-item_amenity-item_id',
            'item_amenity'
        );

        // drops foreign key for table `amenity`
        $this->dropForeignKey(
            'fk-item_amenity-amenity_id',
            'item_amenity'
        );

        // drops index for column `amenity_id`
        $this->dropIndex(
            'idx-item_amenity-amenity_id',
            'item_amenity'
        );

        $this->dropTable('item_amenity');
    }
}
