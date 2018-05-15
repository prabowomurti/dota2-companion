<?php

namespace common\models\activequery;

/**
 * This is the ActiveQuery class for [[\common\models\Amenity]].
 *
 * @see \common\models\Amenity
 */
class AmenityQuery extends \common\components\coremodels\ZeedActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Amenity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Amenity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}