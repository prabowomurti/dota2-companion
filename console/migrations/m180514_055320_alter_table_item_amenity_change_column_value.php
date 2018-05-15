<?php

use yii\db\Migration;

/**
 * Class m180514_055320_alter_table_item_amenity_change_column_value
 */
class m180514_055320_alter_table_item_amenity_change_column_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('item_amenity', 'value', $this->decimal(6,2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('item_amenity', 'value', $this->decimal(4,2));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180514_055320_alter_table_item_amenity_change_column_value cannot be reverted.\n";

        return false;
    }
    */
}
