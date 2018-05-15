<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "amenity".
 *
 * @property int $id
 * @property string $label
 * @property int $position
 *
 * @property ItemAmenity[] $itemAmenities
 * @property Item[] $items
 */
class Amenity extends \common\components\coremodels\ZeedActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'amenity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['position'], 'integer'],
            [['label'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', 'Label'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemAmenities()
    {
        return $this->hasMany(ItemAmenity::className(), ['amenity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'item_id'])->viaTable('item_amenity', ['amenity_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\activequery\AmenityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\activequery\AmenityQuery(get_called_class());
    }
}