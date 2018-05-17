<?php 
use yii\helpers\Html;

?>
<div class="modal" id="add_new_junction_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span></span>Add New <?=$attribute_class_name?></h4>
            </div>
            <form class="form form-horizontal" id="add_new_junction_form" data-url="/<?=$junction_ID?>/create">
                <?= Html::hiddenInput($junction . '[' . $model_primary_key . ']', $model->id);?>
                <!-- should write something like "ItemAmenity[item_id]", with value => $model->id -->
                <div class="modal-body">
                    <!-- put the attribute ID as dropdownlist  -->
                    <div class="form-group">
                        <label class="control-label col-md-4"><?=$attribute_class_name?></label>
                        <div class="col-md-6">
                            <?= Html::dropdownList($junction . '['. $attribute_ID . '_id]', '', $attribute_model::getLabelAsList(), [
                                'class' => 'form-control',
                                'prompt' => Yii::t('app', 'Select ' . $attribute_class_name)
                            ]) ?>
                        </div>
                    </div>
                    <?php foreach ($columns as $key => $junction_column) :
                    if (empty($columns_meta[$junction_column]))
                        continue;
                    ?>
                    <div class="form-group">
                        <label class="control-label col-md-4"><?=($junction_model->getAttributeLabel($junction_column));?></label>
                        <div class="col-md-6">
                            <?php switch ($columns_meta[$junction_column]->type) {
                                case 'float' : 
                                case 'decimal' : 
                                    echo Html::textInput($junction . '[' . $junction_column. ']', '', ['class' => 'form-control', 'type' => 'number', 'step' => '0.01']);
                                    break;

                                case 'smallint' : 
                                case 'bigint' : 
                                case 'integer' : 
                                    echo Html::textInput($junction . '[' . $junction_column. ']', $columns_meta[$junction_column]->defaultValue, ['id' => "junction_add_field_" . $key, 'class' => 'form-control', 'type' => 'number']);
                                    break;
                                
                                case 'text':
                                    echo Html::textArea($junction . '[' . $junction_column. ']', $columns_meta[$junction_column]->defaultValue, ['id' => "junction_add_field_" . $key, 'class' => 'form-control']);
                                    break;
                                
                                default:
                                    echo Html::textInput($junction . '[' . $junction_column. ']', $columns_meta[$junction_column]->defaultValue, ['id' => "junction_add_field_" . $key, 'class' => 'form-control']);
                                    break;
                            }?>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Submit"/>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="edit_junction_modal" tabindex="-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span></span>Edit <?= $attribute_class_name?></h4>
            </div>
            <form class="form form-horizontal" id="edit_junction_form" data-url="/<?= $junction_ID?>/update">
                <div class="modal-body">
                    <?php foreach ($columns as $key => $junction_column) :
                    if (empty($columns_meta[$junction_column]))
                        continue;
                    ?>
                    <div class="form-group">
                        <label class="control-label col-md-4"><?=($junction_model->getAttributeLabel($junction_column));?></label>
                        <div class="col-md-6">
                            <?php switch ($columns_meta[$junction_column]->type) {
                                case 'float' : 
                                case 'decimal' : 
                                    echo Html::textInput($junction . '[' . $junction_column. ']', '', ['class' => 'form-control', 'type' => 'number', 'step' => '0.01', 'data-column-index' => $key]);
                                    break;
                                case 'smallint' : 
                                case 'bigint' : 
                                case 'integer' : 
                                    echo Html::textInput($junction . '[' . $junction_column. ']', '', ['class' => 'form-control', 'type' => 'number', 'data-column-index' => $key]);
                                    break;
                                
                                case 'text':
                                    echo Html::textArea($junction . '[' . $junction_column. ']', '', ['class' => 'form-control', 'data-column-index' => $key]);
                                    break;
                                
                                default:
                                    echo Html::textInput($junction . '[' . $junction_column. ']', '', ['class' => 'form-control', 'data-column-index' => $key]);
                                    break;
                            }?>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Update"/>
                </div>
            </form>
        </div>
    </div>
</div>