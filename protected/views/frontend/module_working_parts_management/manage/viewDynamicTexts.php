<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/dynamic_texts.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WORKING_PARTS_MANAGEMENT_HEADER_LINE_DYNAMIC_TEXTS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWDYNAMICTEXTS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formEquipmentCondition = $this->beginWidget('CActiveForm', array(
      'id'=>'equipment-condition-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDynamicTexts'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_equipment_condition_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_equipment_condition_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_equipment_condition_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWDYNAMICTEXTS_FORM_EQUIPMENTCONDITION_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_equipment_condition_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWDYNAMICTEXTS_FORM_EQUIPMENTCONDITION_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'description', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->textField($oModelFormEquipmentCondition, 'description', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelFormEquipmentCondition, 'description', array('style'=>'width:480px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'visible_default_working_part', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelFormEquipmentCondition, 'visible_default_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelFormEquipmentCondition, 'visible_default_working_part', array('style'=>'width:140px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'visible_default_maintenance_working_part', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelFormEquipmentCondition, 'visible_default_maintenance_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelFormEquipmentCondition, 'visible_default_maintenance_working_part', array('style'=>'width:160px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'visible_default_special_working_part', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelFormEquipmentCondition, 'visible_default_special_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelFormEquipmentCondition, 'visible_default_special_working_part', array('style'=>'width:140px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'alert', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->textField($oModelFormEquipmentCondition, 'alert', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelFormEquipmentCondition, 'alert', array('style'=>'width:480px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'visible_alert_value_yes', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelFormEquipmentCondition, 'visible_alert_value_yes', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelFormEquipmentCondition, 'visible_alert_value_yes', array('style'=>'width:140px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'visible_alert_value_no', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelFormEquipmentCondition, 'visible_alert_value_no', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelFormEquipmentCondition, 'visible_alert_value_no', array('style'=>'width:140px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'visible_alert_value_np', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelFormEquipmentCondition, 'visible_alert_value_np', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelFormEquipmentCondition, 'visible_alert_value_np', array('style'=>'width:140px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'visible_alert_value_default', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelFormEquipmentCondition, 'visible_alert_value_default', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelFormEquipmentCondition, 'visible_alert_value_default', array('style'=>'width:140px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'information', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->textField($oModelFormEquipmentCondition, 'information', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelFormEquipmentCondition, 'information', array('style'=>'width:480px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>
     
   <?php $this->endWidget(); ?>
</div>

<?php 
if (Yii::app()->user->hasFlash('error-equipment-condition')) { ?>
   <div class="flash-error">
      <?php echo Yii::app()->user->getFlash('error-equipment-condition'); ?>
   </div> <?php
} ?>
  
<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWDYNAMICTEXTS_FORM_EQUIPMENTCONDITION_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('equipmentConditions', FApplication::MODULE_WORKING_PARTS_MANAGEMENT, 'EquipmentConditions', FString::STRING_EMPTY, 'visible_default_working_part, visible_default_special_working_part, visible_default_maintenance_working_part', $this, true); ?>
   </div>
</div>
                                                                                                                        
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView_3',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormEquipmentConditionFilters->search(),
   'filter'=>$oModelFormEquipmentConditionFilters,
   'columns'=>array(
      array(
         'name'=>'description',
         'value'=>'FString::getAbbreviationSentence($data->description, 40)',
         'htmlOptions'=>array('width'=>350),
      ),
      array(
         'name'=>'visible_default_working_part',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_VISIBLEDEFAULTWORKINGPART_ABBREVIATION'),
         'value'=>'($data->visible_default_working_part) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
         'filter'=>array(1=>Yii::t('system', 'SYS_YES'), 0=>Yii::t('system', 'SYS_NO')),
         'htmlOptions'=>array('width'=>120),
      ),
      array(
         'name'=>'visible_default_maintenance_working_part',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_VISIBLEDEFAULTMAINTENANCEWORKINGPART_ABBREVIATION'),
         'value'=>'($data->visible_default_maintenance_working_part) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
         'filter'=>array(1=>Yii::t('system', 'SYS_YES'), 0=>Yii::t('system', 'SYS_NO')),
         'htmlOptions'=>array('width'=>120),
      ),
      array(
         'name'=>'visible_default_special_working_part',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_VISIBLEDEFAULTSPECIALWORKINGPART_ABBREVIATION'),
         'value'=>'($data->visible_default_special_working_part) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
         'filter'=>array(1=>Yii::t('system', 'SYS_YES'), 0=>Yii::t('system', 'SYS_NO')),
         'htmlOptions'=>array('width'=>120),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateEquipmentCondition", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailEquipmentCondition", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteEquipmentCondition", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?>

<div class="form">
   <?php $formMeasure = $this->beginWidget('CActiveForm', array(
      'id'=>'measure-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDynamicTexts'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_measure_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWDYNAMICTEXTS_FORM_MEASURE_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_measure_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWDYNAMICTEXTS_FORM_MEASURE_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formMeasure->labelEx($oModelFormMeasure, 'description', array('style'=>'width:480px;')); ?>
               <?php echo $formMeasure->textField($oModelFormMeasure, 'description', array('style'=>'width:480px;')); ?>
               <?php echo $formMeasure->error($oModelFormMeasure, 'description', array('style'=>'width:480px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formMeasure->labelEx($oModelFormMeasure, 'visible_default_working_part', array('style'=>'width:140px;')); ?>
               <?php echo $formMeasure->checkBox($oModelFormMeasure, 'visible_default_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formMeasure->error($oModelFormMeasure, 'visible_default_working_part', array('style'=>'width:140px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formMeasure->labelEx($oModelFormMeasure, 'visible_default_maintenance_working_part', array('style'=>'width:160px;')); ?>
               <?php echo $formMeasure->checkBox($oModelFormMeasure, 'visible_default_maintenance_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formMeasure->error($oModelFormMeasure, 'visible_default_maintenance_working_part', array('style'=>'width:160px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formMeasure->labelEx($oModelFormMeasure, 'visible_default_special_working_part', array('style'=>'width:140px;')); ?>
               <?php echo $formMeasure->checkBox($oModelFormMeasure, 'visible_default_special_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formMeasure->error($oModelFormMeasure, 'visible_default_special_working_part', array('style'=>'width:140px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formMeasure->labelEx($oModelFormMeasure, 'alert', array('style'=>'width:480px;')); ?>
               <?php echo $formMeasure->textField($oModelFormMeasure, 'alert', array('style'=>'width:480px;')); ?>
               <?php echo $formMeasure->error($oModelFormMeasure, 'alert', array('style'=>'width:480px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formMeasure->labelEx($oModelFormMeasure, 'visible_alert_value_yes', array('style'=>'width:140px;')); ?>
               <?php echo $formMeasure->checkBox($oModelFormMeasure, 'visible_alert_value_yes', array('style'=>'width:10px;')); ?>
               <?php echo $formMeasure->error($oModelFormMeasure, 'visible_alert_value_yes', array('style'=>'width:140px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formMeasure->labelEx($oModelFormMeasure, 'visible_alert_value_no', array('style'=>'width:140px;')); ?>
               <?php echo $formMeasure->checkBox($oModelFormMeasure, 'visible_alert_value_no', array('style'=>'width:10px;')); ?>
               <?php echo $formMeasure->error($oModelFormMeasure, 'visible_alert_value_no', array('style'=>'width:140px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formMeasure->labelEx($oModelFormMeasure, 'visible_alert_value_np', array('style'=>'width:140px;')); ?>
               <?php echo $formMeasure->checkBox($oModelFormMeasure, 'visible_alert_value_np', array('style'=>'width:10px;')); ?>
               <?php echo $formMeasure->error($oModelFormMeasure, 'visible_alert_value_np', array('style'=>'width:140px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formMeasure->labelEx($oModelFormMeasure, 'visible_alert_value_default', array('style'=>'width:140px;')); ?>
               <?php echo $formMeasure->checkBox($oModelFormMeasure, 'visible_alert_value_default', array('style'=>'width:10px;')); ?>
               <?php echo $formMeasure->error($oModelFormMeasure, 'visible_alert_value_default', array('style'=>'width:140px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formMeasure->labelEx($oModelFormMeasure, 'required_grade_preventive_action', array('style'=>'width:200px;')); ?>
               <?php echo $formMeasure->checkBox($oModelFormMeasure, 'required_grade_preventive_action', array('style'=>'width:10px;')); ?>
               <?php echo $formMeasure->error($oModelFormMeasure, 'required_grade_preventive_action', array('style'=>'width:200px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formMeasure->labelEx($oModelFormMeasure, 'information', array('style'=>'width:480px;')); ?>
               <?php echo $formMeasure->textField($oModelFormMeasure, 'information', array('style'=>'width:480px;')); ?>
               <?php echo $formMeasure->error($oModelFormMeasure, 'information', array('style'=>'width:480px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>
     
   <?php $this->endWidget(); ?>
</div>

<?php 
if (Yii::app()->user->hasFlash('error-measure')) { ?>
   <div class="flash-error">
      <?php echo Yii::app()->user->getFlash('error-measure'); ?>
   </div> <?php
} ?>
  
<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWDYNAMICTEXTS_FORM_MEASURE_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('measures', FApplication::MODULE_WORKING_PARTS_MANAGEMENT, 'Measures', FString::STRING_EMPTY, 'visible_default_working_part, visible_default_special_working_part, visible_default_maintenance_working_part', $this, true); ?>
   </div>
</div>
                                                                                                                        
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormMeasureFilters->search(),
   'filter'=>$oModelFormMeasureFilters,
   'columns'=>array(
      array(
         'name'=>'description',
         'value'=>'FString::getAbbreviationSentence($data->description, 40)',
         'htmlOptions'=>array('width'=>350),
      ),
      array(
         'name'=>'visible_default_working_part',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_MEASURES_FIELD_VISIBLEDEFAULTWORKINGPART_ABBREVIATION'),
         'value'=>'($data->visible_default_working_part) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
         'filter'=>array(1=>Yii::t('system', 'SYS_YES'), 0=>Yii::t('system', 'SYS_NO')),
         'htmlOptions'=>array('width'=>120),
      ),
      array(
         'name'=>'visible_default_maintenance_working_part',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_MEASURES_FIELD_VISIBLEDEFAULTMAINTENANCEWORKINGPART_ABBREVIATION'),
         'value'=>'($data->visible_default_maintenance_working_part) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
         'filter'=>array(1=>Yii::t('system', 'SYS_YES'), 0=>Yii::t('system', 'SYS_NO')),
         'htmlOptions'=>array('width'=>120),
      ),
      array(
         'name'=>'visible_default_special_working_part',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_MEASURES_FIELD_VISIBLEDEFAULTSPECIALWORKINGPART_ABBREVIATION'),
         'value'=>'($data->visible_default_special_working_part) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
         'filter'=>array(1=>Yii::t('system', 'SYS_YES'), 0=>Yii::t('system', 'SYS_NO')),
         'htmlOptions'=>array('width'=>120),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateMeasure", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailMeasure", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteMeasure", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?>