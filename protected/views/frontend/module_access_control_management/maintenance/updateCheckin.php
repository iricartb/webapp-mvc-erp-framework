<div class="form">
   <?php $formCheckin = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-checkin-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/updateCheckin', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,   
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATECHECKIN_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formCheckin->labelEx($oModelForm, 'employee_identification', array('style'=>'width:300px;')); ?>
               <?php //echo $formCheckin->dropDownList($oModelForm, 'employee_identification', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, null, true), 'identification', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo FForm::textFieldAutoComplete($oModelForm, 'employee_identification', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, null, true), 'identification', 'full_name'), array('style'=>'width:300px;')); ?>
               <?php echo $formCheckin->error($oModelForm, 'employee_identification', array('style'=>'width:300px;')); ?>      
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formCheckin->labelEx($oModelForm, 'date', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'date', true, '0', null, null, null, true, false, '130px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate($oModelForm->date, true))); ?>
               <?php echo $formCheckin->error($oModelForm, 'date', array('style'=>'width:130px;')); ?>      
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formCheckin->labelEx($oModelForm, 'type', array('style'=>'width:300px;')); ?>
               <?php echo $formCheckin->dropDownList($oModelForm, 'type', array(FModuleAccessControlManagement::TYPE_MAIN_INPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_MAIN_INPUT), FModuleAccessControlManagement::TYPE_MAIN_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_MAIN_OUTPUT), FModuleAccessControlManagement::TYPE_INPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_INPUT), FModuleAccessControlManagement::TYPE_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_OUTPUT), FModuleAccessControlManagement::TYPE_INPUT_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_INPUT_OUTPUT)), array('style'=>'width:300px;')); ?>
               <?php echo $formCheckin->error($oModelForm, 'type', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formCheckin->labelEx($oModelForm, 'incidence_code', array('style'=>'width:300px;')); ?>
               <?php echo $formCheckin->dropDownList($oModelForm, 'incidence_code', CHtml::listData(AccessControlIncidences::getAccessControlIncidences(), 'code', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formCheckin->error($oModelForm, 'incidence_code', array('style'=>'width:300px;')); ?>      
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>