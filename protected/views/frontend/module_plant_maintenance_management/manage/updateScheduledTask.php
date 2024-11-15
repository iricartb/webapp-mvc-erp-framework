<script type="text/javascript">
   <?php 
   if (count($oModelFormComponents) > 0) { ?>
      $(document).ready(function() {
         $('#MaintenanceScheduledTasks_sComponents option').each(function() {
            <?php 
            foreach($oModelFormComponents as $oModelFormComponent) {              
               $oComponent = Components::getComponent($oModelFormComponent->id_component);
               if (!is_null($oComponent)) {
                  echo 'if ($(this).text() == \'' . $oComponent->name . '\') {';
                  echo '$(this).prop(\'selected\', \'true\');';
                  echo '}'; 
               }
            } ?>  
         });
      });
   <?php
   } ?>
   
   <?php 
   if (count($oModelFormDepartments) > 0) { ?>
      $(document).ready(function() {
         $('#MaintenanceScheduledTasks_sDepartments option').each(function() {  
            <?php 
            foreach($oModelFormDepartments as $oModelFormDepartment) {
               echo 'if ($(this).val() == \'' . $oModelFormDepartment->name . '\') {';
               echo '$(this).prop(\'selected\', \'true\');';
               echo '}'; 
            } ?>  
         });
      });
   <?php
   } ?>
   
   $(document).ready(function(){
      $('#MaintenanceScheduledTasks_sComponents').MultiSelect({
         size: 6,
         css_class_selected: 'multiselect_option_selected'
      });
      
      $('#MaintenanceScheduledTasks_sDepartments').MultiSelect({
         size: 4,
         css_class_selected: 'multiselect_option_selected'
      });
   });
       
   function submit_form(form, data, hasError) {
      var oForm = document.getElementById('maintenance-scheduled-task-form');
      oForm.action += '&sIdComponents=' + $('#MaintenanceScheduledTasks_sComponents').val() + '&sIdDepartments=' + $('#MaintenanceScheduledTasks_sDepartments').val();
      
      return !hasError;
   }
</script>

<?php $sRefreshRegionsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/refreshScheduledTasksRegions');
      $sRefreshEquipmentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/refreshScheduledTasksEquipments');
      $sRefreshComponentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/refreshScheduledTasksComponents');
      $sJsRefreshComponentClear = '$(\'#MaintenanceScheduledTasks_sComponents option\').remove()';  
?>

<div class="form"> 
   <?php $formMaintenanceScheduledTask = $this->beginWidget('CActiveForm', array(
      'id'=>'maintenance-scheduled-task-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/updateScheduledTask', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:submit_form',
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>

   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATESCHEDULEDTASKS_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATESCHEDULEDTASKS_FORM_HEADER_MAIN'); ?>
            </div>  
         </div>
         <div class="row">
            <div class="cell">
                <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'name'); ?>
                <?php echo $formMaintenanceScheduledTask->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
                <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'name'); ?>
            </div>
            <div class="cell">
                <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'execution_date'); ?>
                <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'execution_date', true, 'strtotime()', FString::STRING_EMPTY, '15', '45', true, false, '130px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate($oModelForm->execution_date, true), 'id_scheduled_task_form_execution_date_field')); ?>
                <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'execution_date'); ?>
            </div>
            <div class="last_cell">
               <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'alarm', array('style'=>'width:160px;')); ?>
               <?php echo $formMaintenanceScheduledTask->checkBox($oModelForm, 'alarm', array('style'=>'width:10px;')); ?>
               <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'alarm', array('style'=>'width:160px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'priority', array('style'=>'width:300px;')); ?>
               <?php echo $formMaintenanceScheduledTask->dropDownList($oModelForm, 'priority', CHtml::listData(MaintenancePriorities::getMaintenancePriorities(), 'description', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'priority', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'type_task', array('style'=>'width:140px;')); ?>
               <?php echo $formMaintenanceScheduledTask->dropDownList($oModelForm, 'type_task', array(FModulePlantMaintenanceManagement::TYPE_TASK_REVISION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_TYPETASK_VALUE_REVISION'), FModulePlantMaintenanceManagement::TYPE_TASK_REPAIR=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_TYPETASK_VALUE_REPAIR'), FModulePlantMaintenanceManagement::TYPE_TASK_OTHERS=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_TYPETASK_VALUE_OTHERS')), array('style'=>'width:140px;')); ?>
               <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'type_task', array('style'=>'width:140px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'task', array('style'=>'width:465px;')); ?>
               <?php echo $formMaintenanceScheduledTask->textArea($oModelForm, 'task', array('style'=>'width:465px; height:40px; overflow:auto; resize:none')); ?>
               <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'task', array('style'=>'width:465px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'sDepartments', array('style'=>'width:465px;')); ?>
               <div id="id_departments">
                  <?php       
                     echo $formMaintenanceScheduledTask->listBox($oModelForm, 'sDepartments', FModulePlantMaintenanceManagement::getDepartments(), array('style'=>'width:465px;', 'multiple'=>'multiple', 'size'=>'4'));  
                  ?>
               </div>
               <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'sDepartments', array('style'=>'width:465px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'attachment', array('style'=>'width:465px;')); ?>
               <?php echo $formMaintenanceScheduledTask->fileField($oModelForm, 'attachment', array('style'=>'width:465px;')); ?>      
               <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'attachment', array('style'=>'width:465px;')); ?>
            </div>
         </div>
         <br/>
         <div class="row">
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATESCHEDULEDTASKS_FORM_HEADER_PERIODICITY'); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
                <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm,'repeat_years'); ?>
                <?php echo $formMaintenanceScheduledTask->dropdownlist($oModelForm, 'repeat_years', array(0=>'00', 1=>'01', 2=>'02', 3=>'03', 4=>'04', 5=>'05', 6=>'06', 7=>'07', 8=>'08', 9=>'09'), array('style'=>'width:45px;')); ?>
                <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'repeat_years'); ?>
            </div>
            <div class="cell">
                <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm,'repeat_months'); ?>
                <?php echo $formMaintenanceScheduledTask->dropdownlist($oModelForm, 'repeat_months', array(0=>'00', 1=>'01', 2=>'02', 3=>'03', 4=>'04', 5=>'05', 6=>'06', 7=>'07', 8=>'08', 9=>'09', 10=>'10', 11=>'11'), array('style'=>'width:45px;')); ?>
                <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'repeat_months'); ?>
            </div>
            <div class="cell">                                                      
                <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm,'repeat_days'); ?>
                <?php echo $formMaintenanceScheduledTask->dropdownlist($oModelForm, 'repeat_days', array(0=>'00', 1=>'01', 2=>'02', 3=>'03', 4=>'04', 5=>'05', 6=>'06', 7=>'07', 8=>'08', 9=>'09', 10=>'10', 11=>'11', 12=>'12', 13=>'13', 14=>'14', 15=>'15', 16=>'16', 17=>'17', 18=>'18', 19=>'19', 20=>'20', 21=>'21', 22=>'22', 23=>'23', 24=>'24', 25=>'25', 26=>'26', 27=>'27', 28=>'28', 29=>'29', 30=>'30'), array('style'=>'width:45px;')); ?>
                <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'repeat_days'); ?>
            </div>
            <div class="cell">
                <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm,'repeat_hours'); ?>
                <?php echo $formMaintenanceScheduledTask->dropdownlist($oModelForm, 'repeat_hours', FForm::getCbHours(), array('style'=>'width:45px;')); ?>
                <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'repeat_hours'); ?>
            </div>
            <div class="cell">
                <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'repeat_minutes'); ?>
                <?php echo $formMaintenanceScheduledTask->dropdownlist($oModelForm, 'repeat_minutes', array(0=>'00', 15=>'15', 30=>'30', 45=>'45'), array('style'=>'width:45px;')); ?>
                <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'repeat_minutes'); ?>
            </div>
         </div>
         <br/>
         <div class="row">
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATESCHEDULEDTASKS_FORM_HEADER_REGIONS'); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'id_zone', array('style'=>'width:300px;')); ?>                                                                                                                                                     
               <?php echo $formMaintenanceScheduledTask->dropDownList($oModelForm, 'id_zone', CHtml::listData(Zones::getZones(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>';aj(\'' . $sRefreshRegionsUrl . '&nIdZone=\' + this.value, null, \'id_region\');' . ';aj(\'' . $sRefreshEquipmentsUrl . '&nIdZone=&nIdRegion=\', null, \'id_equipment\');' . $sJsRefreshComponentClear)); ?>           
               <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'id_zone', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>
               <div id="id_region">
                  <?php 
                     if (!FString::isNullOrEmpty($oModelForm->id_zone)) {                       
                        echo $formMaintenanceScheduledTask->dropDownList($oModelForm, 'id_region', CHtml::listData(Regions::getRegions($oModelForm->id_zone), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>';aj(\'' . $sRefreshEquipmentsUrl . '&nIdRegion=\' + this.value, null, \'id_equipment\');' . $sJsRefreshComponentClear));                       
                     } else { 
                        echo $formMaintenanceScheduledTask->dropDownList($oModelForm, 'id_region', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); 
                     } 
                  ?>
               </div>
               <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
               <div id="id_equipment">
                  <?php 
                     if ((!FString::isNullOrEmpty($oModelForm->id_zone)) && (!FString::isNullOrEmpty($oModelForm->id_region))) {
                        echo $formMaintenanceScheduledTask->dropDownList($oModelForm, 'id_equipment', CHtml::listData(Equipments::getEquipments($oModelForm->id_region), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>';aj(\'' . $sRefreshComponentsUrl . '&nIdEquipment=\' + this.value, null, \'MaintenanceScheduledTasks_sComponents\');'));  
                     } else { 
                        echo $formMaintenanceScheduledTask->dropDownList($oModelForm, 'id_equipment', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); 
                     } 
                  ?>
               </div>
               <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
            </div>
         </div>
         
         <div class="row">
            <div class="first_row">
               <div class="cell">
                  <?php echo $formMaintenanceScheduledTask->labelEx($oModelForm, 'sComponents', array('style'=>'width:300px;')); ?>
                  <div id="id_components">
                     <?php       
                     if ((!FString::isNullOrEmpty($oModelForm->id_zone)) && (!FString::isNullOrEmpty($oModelForm->id_region)) && (!FString::isNullOrEmpty($oModelForm->id_equipment))) {  
                        echo $formMaintenanceScheduledTask->listBox($oModelForm, 'sComponents', CHtml::listData(Components::getComponents($oModelForm->id_equipment), 'id', 'name'), array('style'=>'width:630px;', 'multiple'=>'multiple', 'size'=>'6'));    
                     } else {
                        echo $formMaintenanceScheduledTask->listBox($oModelForm, 'sComponents', array(), array('style'=>'width:630px;', 'multiple'=>'multiple'));   
                     } 
                     ?>
                  </div>
                  <?php echo $formMaintenanceScheduledTask->error($oModelForm, 'sComponents', array('style'=>'width:300px;')); ?>
               </div>
            </div> 
         </div>
      </div>   
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>
   
   <?php $this->endWidget(); ?>
   
   <?php
   if (Yii::app()->user->hasFlash('error')) { ?>
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error'); ?>
      </div> 
   <?php 
   } else if (Yii::app()->user->hasFlash('notice')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice'); ?>
      </div>  <?php
   } ?>
</div>