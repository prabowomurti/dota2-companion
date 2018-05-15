<?php 
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12 junction">
        <p><span class="btn btn-success" data-toggle="modal" data-target="#add_new_junction_modal"><?= Yii::t('app', 'Create ' . $attribute_class_name)?></span></p>
    <?php Pjax::begin(['id' => 'junction-list', 'enablePushState' => false, 'timeout' => false]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-hover table-striped table-bordered', 'style' => 'margin-bottom: 0px'],
            'summary' => false,
            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '&mdash;'],
            'columns' => array_merge(
                $columns, 
                [[
                    'class' => 'yii\grid\ActionColumn',
                    'controller' => $junction_ID,
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url)
                        {
                            return Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>',
                                false,
                                [
                                    'class'          => 'junction-update',
                                    'pjax-container' => 'junction-list',
                                    'data-pjax'      => 'junction-list',
                                    'title'          => Yii::t('app', 'Edit'),
                                    'style'          => 'cursor: pointer',
                                    'data-target'    => '#edit_junction_modal',
                                    'data-toggle'    => 'modal',
                                ]
                            );
                        },
                        'delete' => function ($url) 
                        {
                            return Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>',
                                false,
                                [
                                    'class'     => 'junction-delete',
                                    'data-pjax' => 'junction-list',
                                    'title'     => Yii::t('app', 'Delete'),
                                    'style'     => 'cursor: pointer',
                                    'onclick'   => "
                                        if (confirm('Are you sure to delete this item?')) {
                                            $.ajax('$url', {
                                                type: 'POST'}).done(function(data) {
                                                $.pjax.reload({container: '#junction-list'});
                                            });
                                        }
                                        return false;
                                    "
                                ]
                            );
                        }
                    ]
                ]]
            ),
        ]); ?>
        
        <?php Pjax::end(); ?>
    </div>
</div>