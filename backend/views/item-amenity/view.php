<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ItemAmenity */

$this->title = $model->item_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item Amenities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-amenity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'item_id' => $model->item_id, 'amenity_id' => $model->amenity_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'item_id' => $model->item_id, 'amenity_id' => $model->amenity_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'item_id',
            'amenity_id',
            'value',
            'unit_label',
        ],
    ]) ?>

</div>
