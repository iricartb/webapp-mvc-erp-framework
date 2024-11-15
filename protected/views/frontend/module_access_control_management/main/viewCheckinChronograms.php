<?php
   $oAccessControlModuleParameters = AccessControlModuleParameters::getAccessControlModuleParameters();   
?>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/checkin_chronograms.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_ACCESS_CONTROL_MANAGEMENT_HEADER_LINE_CHECKIN_CHRONOGRAMS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINCHRONOGRAMS_DESCRIPTION'); ?>
</div>

<script type="text/javascript">
function onEventCustomAfterValidate(form, data, hasError) {
   var sStartDate = document.getElementById('AccessControlCheckInChronogramForm_startDate').value;
   var sEndDate = document.getElementById('AccessControlCheckInChronogramForm_endDate').value;
   var nIdEmployee = document.getElementById('AccessControlCheckInChronogramForm_employee').value;
   var bAllEmployees = document.getElementById('AccessControlCheckInChronogramForm_allEmployees').checked;
       
   if ((sStartDate.length > 0) && (sEndDate.length > 0) && ((nIdEmployee.length > 0) || (bAllEmployees))) {    
      if (!hasError) {
         if (document.getElementById('AccessControlCheckInChronogramForm_sourceData').value == '<?php echo FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE; ?>') {
            if (confirm('<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINCHRONOGRAMS_FORM_SUBMIT_SYNCHRONIZE_CONFIRMATION'); ?>')) {
               aj('<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/main/viewSynchronize');?>', null, 'id_synchronize_status', null, null, 'document.getElementById(\'access-control-checkinchronogram-form\').submit()', null, '<?php echo FAjax::TYPE_METHOD_CONTENT_REPLACE;?>', '<?php echo FAjax::TYPE_METHOD_CONTENT_DECORATION_FADE;?>', 500, true, true, '<?php echo Yii::app()->params['paramShowLoading'];?>');
               return false;
            }
            else {
               return true;
            }
         }
         else {
            return true;
         }
      }
   }
   else { alert("ERR"); return true; }
   
   return false;
}
</script>

<div class="form">
   <?php $formCheckinChronogram = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-checkinchronogram-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/main/viewCheckinChronograms'),
      'enableAjaxValidation'=>false,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventCustomAfterValidate',
      ),
   ));
   ?>

   <div id="id_form_content">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINCHRONOGRAMS_FORM_LIST_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formCheckinChronogram->labelEx($oModelForm, 'employee', array('style'=>'width:300px;')); ?>
               
               <?php $oEmployee = Users::getEmployeeByIdUser(Yii::app()->user->id); 
                     if ((!is_null($oEmployee)) && (!Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT))) {
                        echo $formCheckinChronogram->dropDownList($oModelForm, 'employee', CHtml::listData(array($oEmployee), 'identification', 'full_name'), array('style'=>'width:300px;'));   
                        //echo FForm::textFieldAutoComplete($oModelForm, 'employee', CHtml::listData(array($oEmployee), 'identification', 'full_name'), array('style'=>'width:300px;'));
                     }
                     else {
                        echo $formCheckinChronogram->dropDownList($oModelForm, 'employee', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT)), 'identification', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;'));
                        //echo FForm::textFieldAutoComplete($oModelForm, 'employee', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT)), 'identification', 'full_name'), array('style'=>'width:300px;'));
                     } ?>
                     
               <?php echo $formCheckinChronogram->error($oModelForm, 'employee', array('style'=>'width:300px;')); ?>             
            </div>
            <div class="last_cell">
               <?php echo $formCheckinChronogram->labelEx($oModelForm, 'allEmployees', array('style'=>'width:180px;')); ?>
               <?php echo $formCheckinChronogram->checkBox($oModelForm, 'allEmployees', array('style'=>'width:20px;')); ?>
               <?php echo $formCheckinChronogram->error($oModelForm, 'allEmployees', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formCheckinChronogram->labelEx($oModelForm, 'startDate', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'startDate', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '130px')); ?>
               <?php echo $formCheckinChronogram->error($oModelForm, 'startDate', array('style'=>'width:130px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formCheckinChronogram->labelEx($oModelForm, 'endDate', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'endDate', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '130px')); ?>
               <?php echo $formCheckinChronogram->error($oModelForm, 'endDate', array('style'=>'width:130px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formCheckinChronogram->labelEx($oModelForm, 'sourceData', array('style'=>'width:133px;')); ?>
               <?php if ((Modules::getIsAvaliableModuleByName(FApplication::MODULE_VISITORS_MANAGEMENT)) && (!is_null($oAccessControlModuleParameters)) && ($oAccessControlModuleParameters->show_checkin_manual)) {
                        echo $formCheckinChronogram->dropDownList($oModelForm, 'sourceData', array(FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINCHRONOGRAM_FIELD_SOURCEDATA_VALUE_MACHINE'), FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MANUAL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINCHRONOGRAM_FIELD_SOURCEDATA_VALUE_MANUAL')), array('style'=>'width:133px;'));
                     }
                     else {
                        echo $formCheckinChronogram->dropDownList($oModelForm, 'sourceData', array(FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINCHRONOGRAM_FIELD_SOURCEDATA_VALUE_MACHINE')), array('style'=>'width:133px;'));   
                     } ?>
               <?php echo $formCheckinChronogram->error($oModelForm, 'sourceData', array('style'=>'width:133px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formCheckinChronogram->labelEx($oModelForm, 'docDetailInformation', array('style'=>'width:210px;')); ?>
               <?php echo $formCheckinChronogram->dropDownList($oModelForm, 'docDetailInformation', array(FApplication::DETAIL_INFORMATION_SUMMARY=>Yii::t('system', 'SYS_DOCUMENT_INFORMATION_SUMMARY'), FApplication::DETAIL_INFORMATION_DETAILED=>Yii::t('system', 'SYS_DOCUMENT_INFORMATION_DETAILED'), FApplication::DETAIL_INFORMATION_VERY_DETAILED=>Yii::t('system', 'SYS_DOCUMENT_INFORMATION_VERY_DETAILED')), array('style'=>'width:210px;')); ?>
               <?php echo $formCheckinChronogram->error($oModelForm, 'docDetailInformation', array('style'=>'width:210px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formCheckinChronogram->labelEx($oModelForm, 'docFormat', array('style'=>'width:300px;')); ?>
               <?php echo $formCheckinChronogram->dropDownList($oModelForm, 'docFormat', array(FFile::FILE_XLS_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL'), FFile::FILE_XLSX_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL_2007'), FFile::FILE_PDF_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_PDF')), array('style'=>'width:373px;')); ?>
               <?php echo $formCheckinChronogram->error($oModelForm, 'docFormat', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">

         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_LIST'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>                                                             
     
   <?php $this->endWidget(); ?>
</div>

<div id="id_synchronize_status">
</div>