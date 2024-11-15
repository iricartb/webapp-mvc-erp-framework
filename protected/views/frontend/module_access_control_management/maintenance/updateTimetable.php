<?php
$sJsChangeTypeTimetable = 'function onChangeTypeTimetable() {
                              if (document.getElementById("AccessControlTimetables_type_0").checked) {
                                 document.getElementsByName("AccessControlTimetables[hour1_t2]")[0].value = "";
                                 document.getElementsByName("AccessControlTimetables[hour2_t2]")[0].value = "";
                                 document.getElementsByName("AccessControlTimetables[hour1_t2]")[0].disabled = true;
                                 document.getElementsByName("AccessControlTimetables[hour2_t2]")[0].disabled = true;   
                              }
                              else {
                                 document.getElementsByName("AccessControlTimetables[hour1_t2]")[0].disabled = false;
                                 document.getElementsByName("AccessControlTimetables[hour2_t2]")[0].disabled = false;
                              }
                           };';
?>

<div class="form">
   <?php $formTimetable = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-timetable-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/updateTimetable', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATETIMETABLE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'name', array('style'=>'width:230px;')); ?>
               <?php echo $formTimetable->textField($oModelForm, 'name', array('style'=>'width:230px;')); ?>
               <?php echo $formTimetable->error($oModelForm, 'name', array('style'=>'width:230px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'abbreviation', array('style'=>'width:130px;')); ?>
               <?php echo $formTimetable->textField($oModelForm, 'abbreviation', array('style'=>'width:130px;')); ?>
               <?php echo $formTimetable->error($oModelForm, 'abbreviation', array('style'=>'width:230px;')); ?>
            </div>
         </div>
         <div class="row">   
            <?php if (is_null($oModelForm->type)) $oModelForm->type = FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS; ?> 
            <?php $sDisableHours = FString::STRING_EMPTY; 
                  if ($oModelForm->type == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
                     $sDisableHours = 'disabled';
                  } ?>    
            <div class="last_cell">
               <?php
               $oTypeTimetableList = array(FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWTIMETABLES_FORM_TYPE_CONTINUOUS'), FModuleAccessControlManagement::TYPE_TIMETABLE_SHIFT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWTIMETABLES_FORM_TYPE_SHIFT'));
               echo $formTimetable->radioButtonList($oModelForm, 'type', $oTypeTimetableList, array('separator'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp', 'onclick'=>$sJsChangeTypeTimetable . 'onChangeTypeTimetable();', 'labelOptions'=>array('class'=>'label_rb')));
               ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'hour1_t1', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getTimePickerAttributes($oModelForm, 'hour1_t1', true, false, '130px', FString::STRING_EMPTY, null)); ?>
               <?php echo $formTimetable->error($oModelForm, 'hour1_t1', array('style'=>'width:130px;')); ?>       
            </div>
            <div class="cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'hour2_t1', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getTimePickerAttributes($oModelForm, 'hour2_t1', true, false, '130px', FString::STRING_EMPTY, null)); ?>
               <?php echo $formTimetable->error($oModelForm, 'hour2_t1', array('style'=>'width:130px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'hour1_t2', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getTimePickerAttributes($oModelForm, 'hour1_t2', true, ($sDisableHours == 'disabled'), '130px', FString::STRING_EMPTY, null)); ?>
               <?php echo $formTimetable->error($oModelForm, 'hour1_t2', array('style'=>'width:130px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'hour2_t2', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getTimePickerAttributes($oModelForm, 'hour2_t2', true, ($sDisableHours == 'disabled'), '130px', FString::STRING_EMPTY, null)); ?>
               <?php echo $formTimetable->error($oModelForm, 'hour2_t2', array('style'=>'width:130px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'tolerance', array('style'=>'width:130px;')); ?>
               <?php echo $formTimetable->textField($oModelForm, 'tolerance', array('style'=>'width:130px;')); ?>
               <?php echo $formTimetable->error($oModelForm, 'tolerance', array('style'=>'width:250px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>

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