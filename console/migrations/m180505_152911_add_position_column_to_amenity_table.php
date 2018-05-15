<?php

use yii\db\Migration;

/**
 * Handles adding position to table `amenity`.
 */
class m180505_152911_add_position_column_to_amenity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('amenity', 'position', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('amenity', 'position');
    }
}
