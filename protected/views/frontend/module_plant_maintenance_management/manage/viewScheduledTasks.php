<script type="text/javascript">
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
      oForm.action += '&nIdRegion=&nIdEquipment=&sIdComponents=' + $('#MaintenanceScheduledTasks_sComponents').val() + '&sIdDepartments=' + $('#MaintenanceScheduledTasks_sDepartments').val();
      
      return !hasError;
   }
</script>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/scheduled_tasks.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PLANT_MAINTENANCE_MANAGEMENT_HEADER_LINE_SCHEDULED_TASKS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWSCHEDULEDTASKS_DESCRIPTION'); ?>
</div>

<?php $sRefreshRegionsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/refreshScheduledTasksRegions');
      $sRefreshEquipmentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/refreshScheduledTasksEquipments');
      $sRefreshComponentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/refreshScheduledTasksComponents');
      $sJsRefreshComponentClear = '$(\'#MaintenanceScheduledTasks_sComponents option\').remove()';  
?>

<div class="form">
   <?php $formMaintenanceScheduledTask = $this->beginWidget('CActiveForm', array(
      'id'=>'maintenance-scheduled-task-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewScheduledTasks'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:submit_form',
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>

   <div class="form_expand_collapse" >
      <?php if ($bRefreshPage) { ?>
      <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" style="background: url('images/generic/24x24/btn_minus.png') no-repeat;" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
      </div>
      <?php } else { ?>
      <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
      </div>
      <?php } ?>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWSCHEDULEDTASKS_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
   
   <?php if ($bRefreshPage) { ?>
      <div id="id_form_content_expand_collapse" class="form_content_expand_collapse" style="display:block">
   <?php } else { ?>
      <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
   <?php } ?>
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWSCHEDULEDTASKS_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWSCHEDULEDTASKS_FORM_HEADER_MAIN'); ?>
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
                <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'execution_date', true, 'strtotime()', FString::STRING_EMPTY, '15', '45', true, false, '130px', FString::STRING_EMPTY, FString::STRING_EMPTY, 'id_scheduled_task_form_execution_date_field')); ?>
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
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWSCHEDULEDTASKS_FORM_HEADER_PERIODICITY'); ?>
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
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWSCHEDULEDTASKS_FORM_HEADER_REGIONS'); ?>
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

<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWSCHEDULEDTASKS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('maintenanceScheduledTasks', FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT, 'MaintenanceScheduledTasks', FString::STRING_EMPTY, 'repeat_minutes,repeat_hours,repeat_days,repeat_months,repeat_years', $this, true); ?>
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
   'columns'=>array(
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>185),
      ),
      array(
         'name'=>'execution_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->execution_date, true)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormFilters, 'execution_date', false, 'strtotime()', FString::STRING_EMPTY), true), 
         'htmlOptions'=>array('width'=>130),
      ),
      array(
         'name'=>'id_zone',
         'value'=>'Zones::getZoneName($data->id_zone)',  
         'filter'=>CHtml::listData(Zones::getZones(), 'id', 'name'),
         'htmlOptions'=>array('width'=>95),
      ),
      array(
         'name'=>'id_region',
         'value'=>'Regions::getRegionName($data->id_region)',  
         'filter'=>CHtml::listData(Regions::getRegions(), 'id', 'name'),
         'htmlOptions'=>array('width'=>95),
      ),
      array(
         'name'=>'id_equipment',                         
         'value'=>'Equipments::getEquipmentName($data->id_equipment)',  
         'filter'=>CHtml::listData(Equipments::getEquipments(), 'id', 'name'),
         'htmlOptions'=>array('width'=>95),
      ),
      array(
         'name'=>'priority',
         'filter'=>CHtml::listData(MaintenancePriorities::getMaintenancePriorities(), 'description', 'description'),
         'htmlOptions'=>array('width'=>85),
      ),
      FGrid::getAttachmentButton('Yii::app()->controller->createUrl("viewAttachmentScheduledTask", array("nIdForm"=>$data->primaryKey))', '(!FString::isNullOrEmpty($data->attachment))'),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateScheduledTask", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailScheduledTask", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteScheduledTask", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?>