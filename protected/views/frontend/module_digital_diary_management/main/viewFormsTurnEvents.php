<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/forms_turn_events.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER_LINE_FORMS_TURN_EVENTS')); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWFORMSTURNEVENTS_DESCRIPTION'); ?>
</div>

<?php if (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) { ?>
   <div class="form">
      <?php $formFormTurnEvent = $this->beginWidget('CActiveForm', array(
         'id'=>'digitaldiary-form-turn-event-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/viewFormsTurnEvents'),
         'enableAjaxValidation'=>true,
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
         ),
      )); ?>
           
      <div class="form_expand_collapse" >
         <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
         </div>
         <div class="form_expand_collapse_text">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWFORMSTURNEVENTS_FORM_NEW_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
       
      <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWFORMSTURNEVENTS_FORM_NEW_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="cell">
                  <?php echo $formFormTurnEvent->labelEx($oModelForm, 'date', array('style'=>'width:180px;')); ?>
                  <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'date', false, 'strtotime(\'-1D\')', 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '180px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate(date("YmdHis")))); ?>
                  <?php echo $formFormTurnEvent->error($oModelForm, 'date', array('style'=>'width:180px;')); ?>      
               </div>
               <div class="last_cell">
                  <?php echo $formFormTurnEvent->labelEx($oModelForm, 'turn', array('style'=>'width:200px;')); ?>
                  <?php 
                     $oTurns = array();
                     $oTurns[FApplication::TYPE_TURN_MORNING] = Yii::t('system', 'SYS_TURN_MORNING'); 
                     $oTurns[FApplication::TYPE_TURN_AFTERNOON] = Yii::t('system', 'SYS_TURN_AFTERNOON'); 
                     $oTurns[FApplication::TYPE_TURN_NIGHT] = Yii::t('system', 'SYS_TURN_NIGHT'); 
                  
                     echo $formFormTurnEvent->dropDownList($oModelForm, 'turn', $oTurns, array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:200px;')); 
                  ?>   
                  <?php echo $formFormTurnEvent->error($oModelForm, 'turn', array('style'=>'width:200px;')); ?>      
               </div>
            </div>
            <div class="row">
               <div class="cell">
                  <?php echo $formFormTurnEvent->labelEx($oModelForm, 'read_last_turn', array('style'=>'width:400px;')); ?>
                  <?php echo $formFormTurnEvent->checkBox($oModelForm, 'read_last_turn', array('style'=>'width:10px;')); ?>
                  <?php echo $formFormTurnEvent->error($oModelForm, 'read_last_turn', array('style'=>'width:400px;')); ?>     
               </div>
            </div>
         </div>
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
         </div>     
      </div>
        
      <?php $this->endWidget(); ?>
   </div>
<?php } ?>
 
<?php 
if ((Yii::app()->user->hasFlash('success')) || (Yii::app()->user->hasFlash('error'))) { ?>
   <?php if (Yii::app()->user->hasFlash('success')) { ?>
      <div class="flash-success">
         <?php echo Yii::app()->user->getFlash('success'); ?>
      </div> 
   <?php } else if (Yii::app()->user->hasFlash('notice')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice'); ?>
      </div>   
   <?php } else { ?>
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error'); ?>
      </div>
   <?php }
} ?>
    
<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWFORMSTURNEVENTS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('digitalDiaryFormsTurnEvents', FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT, 'DigitalDiaryFormsTurnEvents', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>

<?php $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id); ?>

<?php
$oColumns = array(
               array(
                  'name'=>'date',
                  'value'=>'FDate::getTimeZoneFormattedDate($data->date)',
                  'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormFilters, 'date', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, 'filter'), true), 
                  'htmlOptions'=>array('width'=>200),
               ),
               array(
                  'name'=>'turn',
                  'value'=>'Yii::t(\'system\', \'SYS_TURN_\' . substr($data->turn, 2))',
                  'filter'=>array(FApplication::TYPE_TURN_MORNING=>Yii::t('system', 'SYS_TURN_MORNING'), FApplication::TYPE_TURN_AFTERNOON=>Yii::t('system', 'SYS_TURN_AFTERNOON'), FApplication::TYPE_TURN_NIGHT=>Yii::t('system', 'SYS_TURN_NIGHT')),
                  'htmlOptions'=>array('width'=>200),
               ),
               array(
                  'name'=>'owner',
                  'htmlOptions'=>array('width'=>300),
               ),
               FGrid::getSendButton('Yii::app()->controller->createUrl("notifyFormTurnEvent", array("nIdForm"=>$data->primaryKey))', 'FModuleDigitalDiaryManagement::allowNotifyFormTurnEvent($data->primaryKey)'),
               FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormTurnEvent", array("nIdForm"=>$data->primaryKey))', 'true', false),
               FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormTurnEvent", array("nIdForm"=>$data->primaryKey))', 'true'),
            );

if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT)) {
   $oColumnMonitoringFormTurnRound =  array(FGrid::getDetailButton('Yii::app()->controller->createUrl("frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/main/viewDetailFormTurnRound", array("nIdForm"=>MonitoringFormsTurnRounds::getLastMonitoringFormTurnRoundId($data->primaryKey)))', 'FModuleDigitalDiaryManagement::allowViewMonitoringFormTurnRound($data->primaryKey)', true, false, 'document_checklist_1.png'));
      
   $oColumns = array_merge($oColumns, $oColumnMonitoringFormTurnRound);    
}

$oColumns = array_merge($oColumns, array(FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormTurnEvent", array("nIdForm"=>$data->primaryKey))', 'FModuleDigitalDiaryManagement::allowDeleteFormTurnEvent($data->primaryKey)')));  

$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormFilters->search(),
   'filter'=>$oModelFormFilters,
   'rowCssClassExpression'=>'($data->status == FModuleDigitalDiaryManagement::STATUS_FINALIZED) ? \'completed\' : \'no_completed\'',
   'columns'=>$oColumns, 
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>

<div class="row">
   <div class="cell">
      <input type="text" style="height:10px; width:25px; border:1px solid gray; background-color:<?php echo FModuleDigitalDiaryManagement::COLOR_GRID_STATUS_FINALIZED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_STATUS_VALUE_FINALIZED');?>
   </div>
   <div class="cell">
      <input type="text" style="height:10px; width:25px; border:1px solid gray; background-color:<?php echo FModuleDigitalDiaryManagement::COLOR_GRID_STATUS_CREATED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_STATUS_VALUE_CREATED');?>
   </div>
</div>