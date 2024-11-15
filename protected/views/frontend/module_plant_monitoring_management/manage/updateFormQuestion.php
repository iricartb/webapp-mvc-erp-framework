<?php
$sFieldTypeStateDisabled = FString::STRING_EMPTY;
if ($oModelForm->field_type == FModulePlantMonitoringManagement::TYPE_QUESTION_FIELD_BIT) { $sFieldTypeStateDisabled = 'true'; }

$sRepeatWeeklyStateDisabled = FString::STRING_EMPTY;
$sRepeatMonthlyStateDisabled = FString::STRING_EMPTY;
if (($oModelForm->repeat == FModulePlantMonitoringManagement::TYPE_QUESTION_REPEAT_DIALY) || ($oModelForm->repeat == FModulePlantMonitoringManagement::TYPE_QUESTION_REPEAT_MONTHLY)) { $sRepeatWeeklyStateDisabled = 'true'; }
if (($oModelForm->repeat == FModulePlantMonitoringManagement::TYPE_QUESTION_REPEAT_DIALY) || ($oModelForm->repeat == FModulePlantMonitoringManagement::TYPE_QUESTION_REPEAT_WEEKLY)) { $sRepeatMonthlyStateDisabled = 'true'; }

$sJsChangeFieldType = 'function changeFieldType() {
                          if ((document.getElementById("MonitoringFormsQuestions_field_type_0").checked) || (document.getElementById("MonitoringFormsQuestions_field_type_1").checked)) {
                             document.getElementById("MonitoringFormsQuestions_field_value_options").disabled = false;
                             document.getElementById("MonitoringFormsQuestions_field_required").disabled = false;
                          }
                          else {
                             document.getElementById("MonitoringFormsQuestions_field_value_options").disabled = true;
                             document.getElementById("MonitoringFormsQuestions_field_required").disabled = true;
                          }
                       };';
                       
$sJsChangeRepeat = 'function changeRepeat() {
                       var bDisableWeekly = false;
                       var bDisableMonthly = false;
                       
                       if (document.getElementById("MonitoringFormsQuestions_repeat_0").checked) {
                          bDisableWeekly = true;
                          bDisableMonthly = true;
                       }
                       else if (document.getElementById("MonitoringFormsQuestions_repeat_1").checked) bDisableMonthly = true;
                       else bDisableWeekly = true; 
                       
                       document.getElementById("MonitoringFormsQuestions_repeat_weekly_monday").disabled = bDisableWeekly;
                       document.getElementById("MonitoringFormsQuestions_repeat_weekly_tuesday").disabled = bDisableWeekly;
                       document.getElementById("MonitoringFormsQuestions_repeat_weekly_wednesday").disabled = bDisableWeekly;
                       document.getElementById("MonitoringFormsQuestions_repeat_weekly_thursday").disabled = bDisableWeekly;
                       document.getElementById("MonitoringFormsQuestions_repeat_weekly_friday").disabled = bDisableWeekly;
                       document.getElementById("MonitoringFormsQuestions_repeat_weekly_saturday").disabled = bDisableWeekly;
                       document.getElementById("MonitoringFormsQuestions_repeat_weekly_sunday").disabled = bDisableWeekly;
                      
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_1").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_2").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_3").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_4").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_5").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_6").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_7").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_8").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_9").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_10").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_11").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_12").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_13").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_14").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_15").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_16").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_17").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_18").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_19").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_20").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_21").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_22").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_23").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_24").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_25").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_26").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_27").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_28").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_29").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_30").disabled = bDisableMonthly;
                       document.getElementById("MonitoringFormsQuestions_repeat_monthly_day_31").disabled = bDisableMonthly;
                    };';
?>

<div class="form">
   <?php $formFormQuestion = $this->beginWidget('CActiveForm', array(
      'id'=>'monitoring-form-question-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/manage/updateFormQuestion', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_UPDATEFORMQUESTION_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_UPDATEFORMQUESTION_FORM_HEADER_MAIN'); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formFormQuestion->labelEx($oModelForm, 'id_form', array('style'=>'width:300px;')); ?>
               <?php echo $formFormQuestion->dropDownList($oModelForm, 'id_form', CHtml::listData(MonitoringForms::getFullMonitoringForms(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formFormQuestion->error($oModelForm, 'id_form', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formFormQuestion->labelEx($oModelForm, 'description', array('style'=>'width:480px;')); ?>
               <?php echo $formFormQuestion->textField($oModelForm, 'description', array('style'=>'width:480px;')); ?>
               <?php echo $formFormQuestion->error($oModelForm, 'description', array('style'=>'width:480px;')); ?>
            </div>
         </div>
         <br/>
         <div class="row"> 
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_UPDATEFORMQUESTION_FORM_HEADER_PROPERTIES'); ?>
            </div>
         </div>
         <div class="row"> 
            <div class="last_cell">    
               <?php
               $oFieldTypeList = array(FModulePlantMonitoringManagement::TYPE_QUESTION_FIELD_NUMERIC=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_FIELDTYPE_VALUE_NUMERIC'), FModulePlantMonitoringManagement::TYPE_QUESTION_FIELD_ALFANUMERIC=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_FIELDTYPE_VALUE_ALFANUMERIC'), FModulePlantMonitoringManagement::TYPE_QUESTION_FIELD_BIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_FIELDTYPE_VALUE_BIT'));
               echo $formFormQuestion->radioButtonList($oModelForm, 'field_type', $oFieldTypeList, array('labelOptions'=>array('style'=>'display:inline'), 'separator'=>'<div style="display:inline;padding-left:55px"></div>', 'onclick'=>$sJsChangeFieldType . 'changeFieldType();'));
               ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formFormQuestion->labelEx($oModelForm, 'field_value_default', array('style'=>'width:200px;')); ?>
               <?php echo $formFormQuestion->textField($oModelForm, 'field_value_default', array('style'=>'width:200px;')); ?>
               <?php echo $formFormQuestion->error($oModelForm, 'field_value_default', array('style'=>'width:200px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formFormQuestion->labelEx($oModelForm, 'field_value_options', array('style'=>'width:200px;')); ?>
               <?php echo $formFormQuestion->textField($oModelForm, 'field_value_options', array('style'=>'width:200px;', 'disabled'=>$sFieldTypeStateDisabled)); ?>
               <?php echo $formFormQuestion->error($oModelForm, 'field_value_options', array('style'=>'width:200px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formFormQuestion->labelEx($oModelForm, 'field_unit', array('style'=>'width:120px;')); ?>
               <?php echo $formFormQuestion->textField($oModelForm, 'field_unit', array('style'=>'width:120px;')); ?>
               <?php echo $formFormQuestion->error($oModelForm, 'field_unit', array('style'=>'width:120px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formFormQuestion->labelEx($oModelForm, 'field_required', array('style'=>'width:140px;')); ?>
               <?php echo $formFormQuestion->checkBox($oModelForm, 'field_required', array('style'=>'width:10px;', 'disabled'=>$sFieldTypeStateDisabled)); ?>
               <?php echo $formFormQuestion->error($oModelForm, 'field_required', array('style'=>'width:140px;')); ?>
            </div>
         </div>
         <br/>
         <div class="row"> 
            <div class="cell_header">                                                                                                          
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_UPDATEFORMQUESTION_FORM_HEADER_REPEAT'); ?>
            </div>
         </div>
         <div class="row"> 
            <div class="last_cell">    
               <?php
               $oTypeRepeatList = array(FModulePlantMonitoringManagement::TYPE_QUESTION_REPEAT_DIALY=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEAT_VALUE_DIALY'), FModulePlantMonitoringManagement::TYPE_QUESTION_REPEAT_WEEKLY=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEAT_VALUE_WEEKLY'), FModulePlantMonitoringManagement::TYPE_QUESTION_REPEAT_MONTHLY=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEAT_VALUE_MONTHLY'));
               echo $formFormQuestion->radioButtonList($oModelForm, 'repeat', $oTypeRepeatList, array('labelOptions'=>array('style'=>'display:inline'), 'separator'=>'<div style="display:inline;padding-left:175px"></div>', 'onclick'=>$sJsChangeRepeat . 'changeRepeat();'));
               ?>
            </div>
         </div>
         <div class="row"> 
            <div class="cell" style="width:200px;">
            </div>
            <div class="cell" style="width:210px;">
               <div style="display:table-cell;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_weekly_monday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_weekly_monday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_weekly_tuesday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_weekly_tuesday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_weekly_wednesday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_weekly_wednesday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_weekly_thursday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_weekly_thursday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_weekly_friday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_weekly_friday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_weekly_saturday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_weekly_saturday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_weekly_sunday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_weekly_sunday', array('style'=>'width:10px;', 'disabled'=>$sRepeatWeeklyStateDisabled)); ?>
               </div>
            </div>  
            <div class="last_cell">
               <div style="display:table-cell;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_1', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_1', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_2', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_2', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_3', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_3', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_4', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_4', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_5', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_5', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_6', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_6', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_7', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_7', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_8', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_8', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_9', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_9', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
            </div>
         </div> 
         <div class="first_row"> 
            <div class="cell" style="width:200px;">
            </div>
            <div class="cell" style="width:210px;">
            </div>  
            <div class="last_cell">
               <div style="display:table-cell;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_10', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_10', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_11', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_11', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_12', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_12', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_13', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_13', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_14', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_14', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_15', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_15', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_16', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_16', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_17', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_17', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_18', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_18', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
            </div> 
         </div>
         <div class="first_row"> 
            <div class="cell" style="width:200px;">
            </div>
            <div class="cell" style="width:210px;">
            </div>  
            <div class="last_cell">
               <div style="display:table-cell;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_19', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_19', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_20', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_20', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_21', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_21', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_22', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_22', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_23', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_23', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_24', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_24', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_25', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_25', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_26', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_26', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_27', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_27', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
            </div> 
         </div>
         <div class="first_row"> 
            <div class="cell" style="width:200px;">
            </div>
            <div class="cell" style="width:210px;">
            </div>  
            <div class="last_cell">
               <div style="display:table-cell;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_28', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_28', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_29', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_29', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_30', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_30', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
               <div style="display:table-cell; padding-left:10px;">
                  <?php echo $formFormQuestion->labelEx($oModelForm, 'repeat_monthly_day_31', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
                  <?php echo $formFormQuestion->checkBox($oModelForm, 'repeat_monthly_day_31', array('style'=>'width:10px;', 'disabled'=>$sRepeatMonthlyStateDisabled)); ?>
               </div>
            </div> 
         </div>
         <div class="row">
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_UPDATEFORMQUESTION_FORM_HEADER_TIME'); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formFormQuestion->labelEx($oModelForm, 'start_hour', array('style'=>'width:100px;')); ?>
               <?php echo $formFormQuestion->widget('CJuiDateTimePicker', FForm::getTimePickerAttributes($oModelForm, 'start_hour', true), true); ?>
               <?php echo $formFormQuestion->error($oModelForm, 'start_hour', array('style'=>'width:100px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formFormQuestion->labelEx($oModelForm, 'end_hour', array('style'=>'width:100px;')); ?>
               <?php echo $formFormQuestion->widget('CJuiDateTimePicker', FForm::getTimePickerAttributes($oModelForm, 'end_hour', true), true); ?>
               <?php echo $formFormQuestion->error($oModelForm, 'end_hour', array('style'=>'width:100px;')); ?>   
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>

<div class="separator_10"></div>
<?php 
if (Yii::app()->user->hasFlash('error')) { ?>
   <div class="flash-error">
      <?php echo Yii::app()->user->getFlash('error'); ?>
   </div> <?php 
} ?>