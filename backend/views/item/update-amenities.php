<?php

use yii\helpers\Html;

use common\components\widgets\junction_loader\JunctionLoader;

/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = Yii::t('app', 'Update Amenities: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Amenities');
?>

<div class="item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= JunctionLoader::widget([
        'model' => $model,
        'attribute' => $attribute,
        'columns' => ['amenity.label','value','unit_label'],
    ])?>

</div>
