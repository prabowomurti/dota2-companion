<?php

namespace common\models\activequery;

/**
 * This is the ActiveQuery class for [[\common\models\ItemAmenity]].
 *
 * @see \common\models\ItemAmenity
 */
class ItemAmenityQuery extends \common\components\coremodels\ZeedActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\ItemAmenity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\ItemAmenity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}