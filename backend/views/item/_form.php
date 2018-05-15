<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use common\models\Amenity;
use common\components\helpers\ZeedActiveForm;

use common\components\widgets\junction_loader\JunctionLoader;

/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= JunctionLoader::widget([
        'model' => $model,
        'attribute' => 'amenities',
        'showLinkOnly' => true
    ])?>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>