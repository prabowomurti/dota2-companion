<?php

use yii\db\Migration;

/**
 * Handles the creation of table `amenity`.
 */
class m180415_151108_create_amenity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('amenity', [
            'id'    => $this->primaryKey(),
            'label' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('amenity');
    }
}
