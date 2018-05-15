<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ItemAmenity */

$this->title = Yii::t('app', 'Update Item Amenity: {nameAttribute}', [
    'nameAttribute' => $model->item_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item Amenities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_id, 'url' => ['view', 'item_id' => $model->item_id, 'amenity_id' => $model->amenity_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="item-amenity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
