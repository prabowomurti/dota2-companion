<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $is_recipe
 * @property int $is_orphan
 * @property int $has_no_child
 * @property string $description
 * @property string $image
 *
 * @property ItemAmenity[] $itemAmenities
 * @property Amenity[] $amenities
 * @property ItemRelation[] $itemRelations
 * @property ItemRelation[] $itemRelations0
 * @property Item[] $parents
 * @property Item[] $items
 */
class Item extends \common\components\coremodels\ZeedActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
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
            [['name'], 'required'],
            [['price'], 'integer'],
            [['description'], 'string'],
            [['name', 'image'], 'string', 'max' => 255],
            [['is_recipe', 'is_orphan', 'has_no_child'], 'boolean',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app', 'ID'),
            'name'         => Yii::t('app', 'Name'),
            'price'        => Yii::t('app', 'Price'),
            'is_recipe'    => Yii::t('app', 'Is Recipe'),
            'is_orphan'    => Yii::t('app', 'Is Orphan'),
            'has_no_child' => Yii::t('app', 'Has No Child'),
            'description'  => Yii::t('app', 'Description'),
            'image'        => Yii::t('app', 'Image'),
            'item_amenities' => Yii::t('app', 'Item Amenities'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemAmenities()
    {
        return $this->hasMany(ItemAmenity::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAmenities()
    {
        return $this->hasMany(Amenity::className(), ['id' => 'amenity_id'])->viaTable('item_amenity', ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(Item::className(), ['id' => 'parent_id'])->viaTable('item_relation', ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'item_id'])->viaTable('item_relation', ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\activequery\ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\activequery\ItemQuery(get_called_class());
    }
}