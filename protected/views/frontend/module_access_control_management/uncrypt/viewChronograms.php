<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/chronograms.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_ACCESS_CONTROL_MANAGEMENT_HEADER_LINE_CHRONOGRAMS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHRONOGRAMS_DESCRIPTION'); ?>
</div>

<?php
$oCalendar = $oModelCalendar->getObject();
$sJsParameters = 'function createUrlParameters() {
                    var sEmployee = "&employee=";
                    sEmployee += document.getElementById("AccessControlChronogramForm_employee").value;
                    
                    var sDate = "&date=' . $oCalendar->year . '-' . $oCalendar->month . '";
                    
                    return sEmployee + sDate;
                 };';
?>

<div class="form">
   <?php $formChronogram = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-chronogram-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/uncrypt/viewChronograms'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_element"> 
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formChronogram->labelEx($oModelForm, 'employee', array('style'=>'width:300px;')); ?>
               <?php echo $formChronogram->dropDownList($oModelForm, 'employee', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, FApplication::EMPLOYEE_ACCESS_CODE_NOT_NULL, true), 'identification', 'full_name'), array('id'=>'AccessControlChronogramForm_employee', 'empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/uncrypt/viewChronograms') . '\' + createUrlParameters()')); ?>
               <?php echo $formChronogram->error($oModelForm, 'employee', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>     
   </div>
   
   <?php echo $formChronogram->hiddenField($oModelForm, 'action', array('style'=>'width:180px;')); ?>
   
   <div class="form_expand_collapse" >
      <div id="id_form_add_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_add_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_add_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHRONOGRAMS_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
   
   <div id="id_form_add_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHRONOGRAMS_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formChronogram->labelEx($oModelForm, 'startDateAdd', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'startDateAdd', false, null, null, null, null, true, false, '130px', 'document.getElementById(\'AccessControlChronogramForm_endDateAdd\').value = this.value;')); ?>
               <?php echo $formChronogram->error($oModelForm, 'startDateAdd', array('style'=>'width:130px;')); ?>       
            </div>
            <div class="cell">
               <?php echo $formChronogram->labelEx($oModelForm, 'endDateAdd', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'endDateAdd', false, null, null, null, null, true, false, '130px')); ?>
               <?php echo $formChronogram->error($oModelForm, 'endDateAdd', array('style'=>'width:130px;')); ?>       
            </div>
            <div class="cell">
               <?php if (strlen($oModelForm->employee) > 0) { 
                        echo $formChronogram->labelEx($oModelForm, 'typeAdd', array('style'=>'width:160px;'));
                        echo $formChronogram->dropDownList($oModelForm, 'typeAdd', array(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_WORKING'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_PAUSE'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_VACATION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_VACATION'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_PERSONAL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERSONAL'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_TEMPORARY_DISABILITY=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_TEMPORARY_DISABILITY'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_PERMISSION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERMISSION'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_LEAVE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_LEAVE')), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:160px;', 'onchange'=>'jquerySimpleAnimationFadeAppearDisappearTableCell(\'#id_chronogram_timetableAdd\', (this.value == \'WORKING\'), 1.0, 1000);'));
                        echo $formChronogram->error($oModelForm, 'typeAdd', array('style'=>'width:160px;'));
                     } else {
                        echo $formChronogram->labelEx($oModelForm, 'typeAdd', array('style'=>'width:160px;'));
                        echo $formChronogram->dropDownList($oModelForm, 'typeAdd', array(FModuleAccessControlManagement::TYPE_CHRONOGRAM_HOLIDAY=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_HOLIDAY')), array('style'=>'width:160px;'));
                        echo $formChronogram->error($oModelForm, 'typeAdd', array('style'=>'width:160px;'));
                     } ?>
            </div>
            <div id="id_chronogram_timetableAdd" class="last_cell_content_expand_collapse_hidden">
               <?php echo $formChronogram->labelEx($oModelForm, 'timetableAdd', array('style'=>'width:160px;')); ?>
               <?php echo $formChronogram->dropDownList($oModelForm, 'timetableAdd', CHtml::listData(AccessControlTimetables::getAccessControlTimetables(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:160px;')); ?>
               <?php echo $formChronogram->error($oModelForm, 'timetableAdd', array('style'=>'width:160px;')); ?>       
            </div>
         </div>                            
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit', 'onclick'=>'document.getElementById(\'AccessControlChronogramForm_action\').value = \'' . FApplication::FORM_ACTION_SAVE . '\';')); ?>
      </div>     
   </div>
   
   <br>
      
   <div class="form_expand_collapse" >
      <div id="id_form_del_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_del_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_del_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHRONOGRAMS_FORM_DELETE_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
   
   <div id="id_form_del_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHRONOGRAMS_FORM_DELETE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formChronogram->labelEx($oModelForm, 'startDateDel', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'startDateDel', false, null, null, null, null, true, false, '130px', 'document.getElementById(\'AccessControlChronogramForm_endDateDel\').value = this.value;')); ?>
               <?php echo $formChronogram->error($oModelForm, 'startDateDel', array('style'=>'width:130px;')); ?>       
            </div>
            <div class="cell">
               <?php echo $formChronogram->labelEx($oModelForm, 'endDateDel', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'endDateDel', false, null, null, null, null, true, false, '130px')); ?>
               <?php echo $formChronogram->error($oModelForm, 'endDateDel', array('style'=>'width:130px;')); ?>       
            </div>
            <div class="last_cell">
               <?php if (strlen($oModelForm->employee) > 0) { 
                        echo $formChronogram->labelEx($oModelForm, 'typeDel', array('style'=>'width:160px;'));
                        echo $formChronogram->dropDownList($oModelForm, 'typeDel', array(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_WORKING'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_PAUSE'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_VACATION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_VACATION'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_PERSONAL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERSONAL'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_TEMPORARY_DISABILITY=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_TEMPORARY_DISABILITY'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_PERMISSION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERMISSION'), FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_LEAVE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_LEAVE')), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:160px;'));
                        echo $formChronogram->error($oModelForm, 'typeDel', array('style'=>'width:160px;'));
                     } else {
                        echo $formChronogram->labelEx($oModelForm, 'typeDel', array('style'=>'width:160px;'));
                        echo $formChronogram->dropDownList($oModelForm, 'typeDel', array(FModuleAccessControlManagement::TYPE_CHRONOGRAM_HOLIDAY=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_HOLIDAY')), array('style'=>'width:160px;'));
                        echo $formChronogram->error($oModelForm, 'typeDel', array('style'=>'width:160px;'));
                     } ?>
            </div>
         </div>                            
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_DELETE'), array('class'=>'form_button_submit', 'onclick'=>'document.getElementById(\'AccessControlChronogramForm_action\').value = \'' . FApplication::FORM_ACTION_DELETE . '\';')); ?>
      </div>     
   </div>
   
   <br>
      
   <?php if (strlen($oModelForm->employee) > 0) { ?>
      <div class="form_expand_collapse" >
         <div id="id_form_copy_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_copy_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_copy_content_expand_collapse');" >
         </div>
         <div class="form_expand_collapse_text">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHRONOGRAMS_FORM_COPY_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
      
      <div id="id_form_copy_content_expand_collapse" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHRONOGRAMS_FORM_COPY_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="cell">
                  <?php echo $formChronogram->labelEx($oModelForm, 'startDateCopy', array('style'=>'width:150px;')); ?>
                  <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'startDateCopy', false, null, null, null, null, true, false, '130px', 'document.getElementById(\'AccessControlChronogramForm_endDateCopy\').value = this.value;')); ?>
                  <?php echo $formChronogram->error($oModelForm, 'startDateCopy', array('style'=>'width:130px;')); ?>       
               </div>
               <div class="cell">
                  <?php echo $formChronogram->labelEx($oModelForm, 'endDateCopy', array('style'=>'width:150px;')); ?>
                  <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'endDateCopy', false, null, null, null, null, true, false, '130px')); ?>
                  <?php echo $formChronogram->error($oModelForm, 'endDateCopy', array('style'=>'width:130px;')); ?>       
               </div>
               <div class="cell">
                  <?php echo $formChronogram->labelEx($oModelForm, 'startDatePaste', array('style'=>'width:150px;')); ?>
                  <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'startDatePaste', false, null, null, null, null, true, false, '130px', 'document.getElementById(\'AccessControlChronogramForm_endDatePaste\').value = this.value;')); ?>
                  <?php echo $formChronogram->error($oModelForm, 'startDatePaste', array('style'=>'width:130px;')); ?>       
               </div>
               <div class="last_cell">
                  <?php echo $formChronogram->labelEx($oModelForm, 'endDatePaste', array('style'=>'width:150px;')); ?>
                  <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'endDatePaste', false, null, null, null, null, true, false, '130px')); ?>
                  <?php echo $formChronogram->error($oModelForm, 'endDatePaste', array('style'=>'width:130px;')); ?>       
               </div>
            </div>                            
         </div>
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_COPY'), array('class'=>'form_button_submit', 'onclick'=>'document.getElementById(\'AccessControlChronogramForm_action\').value = \'' . FApplication::FORM_ACTION_COPY_PASTE . '\';')); ?>
         </div>     
      </div>
   
      <br>
      
      <div class="form_expand_collapse" >
         <div id="id_form_copy_chronogram_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_copy_chronogram_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_copy_chronogram_content_expand_collapse');" >
         </div>
         <div class="form_expand_collapse_text">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHRONOGRAMS_FORM_COPY_CHRONOGRAM_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
      
      <div id="id_form_copy_chronogram_content_expand_collapse" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHRONOGRAMS_FORM_COPY_CHRONOGRAM_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="cell">
                  <?php echo $formChronogram->labelEx($oModelForm, 'startDateCopyChronogram', array('style'=>'width:150px;')); ?>
                  <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'startDateCopyChronogram', false, null, null, null, null, null, true, false, '130px', 'document.getElementById(\'AccessControlChronogramForm_endDateCopyChronogram\').value = this.value;')); ?>
                  <?php echo $formChronogram->error($oModelForm, 'startDateCopyChronogram', array('style'=>'width:130px;')); ?>       
               </div>
               <div class="cell">
                  <?php echo $formChronogram->labelEx($oModelForm, 'endDateCopyChronogram', array('style'=>'width:150px;')); ?>
                  <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'endDateCopyChronogram', false, null, null, null, null, null, true, false, '130px')); ?>
                  <?php echo $formChronogram->error($oModelForm, 'endDateCopyChronogram', array('style'=>'width:130px;')); ?>       
               </div>
               <div class="last_cell">
                  <?php echo $formChronogram->labelEx($oModelForm, 'employeeCopyChronogram', array('style'=>'width:300px;')); ?>
                  <?php echo $formChronogram->dropDownList($oModelForm, 'employeeCopyChronogram', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, FApplication::EMPLOYEE_ACCESS_CODE_NOT_NULL, true), 'identification', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
                  <?php echo $formChronogram->error($oModelForm, 'employeeCopyChronogram', array('style'=>'width:300px;')); ?>
               </div>
            </div>                            
         </div>
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_COPY'), array('class'=>'form_button_submit', 'onclick'=>'document.getElementById(\'AccessControlChronogramForm_action\').value = \'' . FApplication::FORM_ACTION_COPY_PASTE_CHRONOGRAM . '\';')); ?>
         </div>     
      </div>
      
      <br> 
   <?php } ?>
            
   <div class="form_element">
      <?php echo $oModelCalendar->show(); ?>
   </div>
     
   <?php $this->endWidget(); ?>
</div>