<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_amenity".
 *
 * @property int $item_id
 * @property int $amenity_id
 * @property string $value
 * @property string $unit_label
 *
 * @property Amenity $amenity
 * @property Item $item
 */
class ItemAmenity extends \common\components\coremodels\ZeedActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_amenity';
    }

    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'amenity_id'], 'required'],
            [['item_id', 'amenity_id'], 'integer'],
            [['value'], 'number'],
            [['unit_label'], 'string', 'max' => 20],
            [['item_id', 'amenity_id'], 'unique', 'targetAttribute' => ['item_id', 'amenity_id']],
            [['amenity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Amenity::className(), 'targetAttribute' => ['amenity_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => Yii::t('app', 'Item ID'),
            'amenity_id' => Yii::t('app', 'Amenity ID'),
            'value' => Yii::t('app', 'Value'),
            'unit_label' => Yii::t('app', 'Unit Label'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAmenity()
    {
        return $this->hasOne(Amenity::className(), ['id' => 'amenity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\activequery\ItemAmenityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\activequery\ItemAmenityQuery(get_called_class());
    }
}