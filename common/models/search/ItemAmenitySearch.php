<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ItemAmenity;

/**
 * ItemAmenitySearch represents the model behind the search form of `common\models\ItemAmenity`.
 */
class ItemAmenitySearch extends ItemAmenity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'amenity_id'], 'integer'],
            [['value'], 'number'],
            [['unit_label'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ItemAmenity::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'item_id' => $this->item_id,
            'amenity_id' => $this->amenity_id,
            'value' => $this->value,
        ]);

        $query->andFilterWhere(['like', 'unit_label', $this->unit_label]);

        return $dataProvider;
    }
}
