<script type="text/javascript">
   function getFingerprintIdentificationRecord() {
      var sFingerprintIdentificationRecord = '';
       
      try {
          var oTCIBioStarMini = new ActiveXObject("TCI.BioStarMini");
          sFingerprintIdentificationRecord = oTCIBioStarMini.getFingerprintTemplates();
      } catch(oException) { alert(oException); }
      
      return sFingerprintIdentificationRecord;
   }
</script>
       
<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/employees.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_ACCESS_CONTROL_MANAGEMENT_HEADER_LINE_EMPLOYEES')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEES_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formEmployee = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-employee-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewEmployees'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEES_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
           
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEES_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->textField($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
            </div>           
            <div class="cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->textField($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->textField($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->textField($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'num_employee', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->textField($oModelForm, 'num_employee', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'num_employee', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'start_date', array('style'=>'width:180px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'start_date', false, null, 'strtotime()', null, null, true, false, '180px')); ?>
               <?php echo $formEmployee->error($oModelForm, 'start_date', array('style'=>'width:180px;')); ?>      
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'sSearchBusiness', array('style'=>'width:100px;')); ?>
               <?php echo $formEmployee->textField($oModelForm, 'sSearchBusiness', array('style'=>'width:100px;', 'onchange'=>'document.getElementById(\'AccessControlEmployees_id_business\').value = this.value;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'sSearchBusiness', array('style'=>'width:100px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'id_business', array('style'=>'width:480px;')); ?>
               <?php echo $formEmployee->dropDownList($oModelForm, 'id_business', CHtml::listData(Businesses::getBusinesses(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:480px;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'id_business', array('style'=>'width:480px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_48x48 . 'fingerprint.png'; ?>" style="margin-top:15px; cursor:pointer;" onclick="document.getElementById('idAccessCodeFIR').value = getFingerprintIdentificationRecord(); if (document.getElementById('idAccessCodeFIR').value.length > 0) document.getElementById('idImageAccessCodeFIR2').src = '<?php echo FApplication::FOLDER_IMAGES_GENERIC_48x48 . 'fingerprint.png'; ?>'" />
            </div>
            <div class="cell" style="vertical-align:top">
               <?php echo $formEmployee->labelEx($oModelForm, 'access_code_FIR', array('style'=>'width:195px;')); ?>
               <?php echo $formEmployee->textArea($oModelForm, 'access_code_FIR', array('id'=>'idAccessCodeFIR', 'style'=>'width:195px; height:140px; background-color:lightgray; resize:none;', 'readonly'=>'readonly')); ?>
               <?php echo $formEmployee->error($oModelForm, 'access_code_FIR', array('style'=>'width:195px;')); ?>
               
               <div style="position:relative; float:right; right:8px; top:-4px; background-color:white; cursor:pointer; border:1px solid gray;" onclick="document.getElementById('idAccessCodeFIR').value = ''; document.getElementById('idAccessCodeFIR2').value = ''; document.getElementById('idImageAccessCodeFIR2').src = '<?php echo FApplication::FOLDER_IMAGES_GENERIC_48x48 . 'fingerprint_disabled.png'; ?>'">
                  <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16; ?>/sign_no_ok_1.png"/>
               </div>
            </div>
            
            <div class="cell">
               <img id="idImageAccessCodeFIR2" src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_48x48 . 'fingerprint_disabled.png'; ?>" style="margin-top:15px; cursor:pointer;" onclick="if (document.getElementById('idAccessCodeFIR').value.length > 0) document.getElementById('idAccessCodeFIR2').value = getFingerprintIdentificationRecord()" />
            </div>
            <div class="last_cell" style="vertical-align:top">
               <?php echo $formEmployee->labelEx($oModelForm, 'access_code_FIR_2', array('style'=>'width:195px;')); ?>
               <?php echo $formEmployee->textArea($oModelForm, 'access_code_FIR_2', array('id'=>'idAccessCodeFIR2', 'style'=>'width:195px; height:140px; background-color:lightgray; resize:none;', 'readonly'=>'readonly')); ?>
               <?php echo $formEmployee->error($oModelForm, 'access_code_FIR_2', array('style'=>'width:195px;')); ?>
            
               <div style="position:relative; float:right; right:8px; top:-4px; background-color:white; cursor:pointer; border:1px solid gray;" onclick="document.getElementById('idAccessCodeFIR2').value = '';">
                  <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16; ?>/sign_no_ok_1.png"/>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'access_code', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->textField($oModelForm, 'access_code', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'access_code', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'access_information', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->textField($oModelForm, 'access_information', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'access_information', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'access_process_delay', array('style'=>'width:185px;')); ?>
               <?php echo $formEmployee->checkBox($oModelForm, 'access_process_delay', array('style'=>'width:20px;', 'checked'=>'checked', 'onclick'=>'jquerySimpleAnimationFadeAppearDisappearTableCell(\'#id_access_code_tolerance\', this.checked, 1.0, 1000)')); ?>
               <?php echo $formEmployee->error($oModelForm, 'access_process_delay', array('style'=>'width:185px;')); ?>
            </div>
            <div id="id_access_code_tolerance" class="last_cell_content_expand_collapse_show">
               <?php echo $formEmployee->labelEx($oModelForm, 'access_tolerance', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->textField($oModelForm, 'access_tolerance', array('style'=>'width:180px;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'access_tolerance', array('style'=>'width:180px;')); ?>
            </div>
         </div> 
         <div class="row">
            <div class="last_cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'id_group_device', array('style'=>'width:400px;')); ?>
               <?php echo $formEmployee->dropDownList($oModelForm, 'id_group_device', CHtml::listData(AccessControlGroupsDevices::getAccessControlGroupsDevices(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:400px;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'id_group_device', array('style'=>'width:400px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'image', array('style'=>'width:400px;')); ?>
               <?php echo $formEmployee->fileField($oModelForm, 'image', array('style'=>'width:400px;')); ?>      
               <?php echo $formEmployee->error($oModelForm, 'image', array('style'=>'width:400px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEmployee->labelEx($oModelForm, 'show_visual_presence', array('style'=>'width:185px;')); ?>
               <?php echo $formEmployee->checkBox($oModelForm, 'show_visual_presence', array('style'=>'width:20px;')); ?>
               <?php echo $formEmployee->error($oModelForm, 'show_visual_presence', array('style'=>'width:185px;')); ?>
            </div>
         </div>
      </div>   
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>
     
   <?php $this->endWidget(); ?>
</div>
  
<div class="toolbox_table">
   <div class="toolbox_table_cell_description" style="width:50%; vertical-align:bottom;">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEES_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button" style="width:50%; padding-bottom:0px; vertical-align:bottom;">
      <div style="float:right; padding-bottom:8px;"> 
         <?php echo FWidget::showToolboxExporterData('accessControlEmployees', FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT, 'AccessControlEmployees', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
      </div>
      <div style="float:right; margin-right:10px;"> 
         <?php 
         $oAccessControlModuleParameters = AccessControlModuleParameters::getAccessControlModuleParameters();
         
         if ((!is_null($oAccessControlModuleParameters)) && ($oAccessControlModuleParameters->block_synchronization) && (count(AccessControlEmployees::getAccessControlEmployeesByPendingSynchronization(true)) > 0)) { ?>
         <div class="toolbox_table_first_cell_button_left">
            <?php $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('viewEmployeesPendingSynchronization') . '\''; ?>      
            <?php echo FWidget::showIconImageButton('employeesPendingSynchronization', 'caution_alert_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEESPENDINGSYNCHRONIZATION_GOTO_BTN_DESCRIPTION', array('{1}'=>count(AccessControlEmployees::getAccessControlEmployeesByPendingSynchronization(true)))), $sAction); ?>   
         </div>                                        
         <?php 
         } ?>
      </div>
   </div>
</div>
                                                                                                                          
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormFilters->search(),
   'filter'=>$oModelFormFilters,
   'rowCssClassExpression'=>'(!$data->pending_synchronize) ? (($data->active) ? ((!is_null($data->id_biostar)) ? \'completed\' : \'no_completed\') : \'finalized\') : \'pending\'',
   'columns'=>array(
      array(
         'name'=>'full_name',
         'htmlOptions'=>array('width'=>280),
      ),
      array(
         'name'=>'identification',
         'htmlOptions'=>array('width'=>130),
      ),
      array(
         'name'=>'id_business',
         'value'=>'Businesses::getBusinessName($data->id_business)',
         'htmlOptions'=>array('width'=>350),
      ),
      array(
         'name'=>'start_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->start_date)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormFilters, 'start_date', false, null, 'strtotime()', null, null, null, false, false, null, null, 'filter'), true), 
         'htmlOptions'=>array('width'=>140),
      ),
      array(
         'name'=>'id_group_device',
         'value'=>'AccessControlGroupsDevices::getAccessControlGroupDeviceName($data->id_group_device)',
         'filter'=>CHtml::listData(AccessControlGroupsDevices::getAccessControlGroupsDevices(), 'id', 'name'),
         'htmlOptions'=>array('width'=>160),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateEmployeeBiometric", array("nIdForm"=>$data->primaryKey))', '(!$data->pending_synchronize)', true, false, 'biometric_fingerprint_1.png'),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateEmployee", array("nIdForm"=>$data->primaryKey))', '((!$data->pending_synchronize) && ($data->active))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailEmployee", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteEmployee", array("nIdForm"=>$data->primaryKey))', '((!$data->pending_synchronize) && ($data->active))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>

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