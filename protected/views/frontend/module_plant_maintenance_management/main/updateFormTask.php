<?php
$oMaintenanceModuleParameters = MaintenanceModuleParameters::getMaintenanceModuleParameters();
$bAllowCreateWorkingPart = false;
if (!is_null($oMaintenanceModuleParameters)) {
   $bAllowCreateWorkingPart = $oMaintenanceModuleParameters->allow_create_working_part;     
}
?>

<script type="text/javascript">     
   <?php 
   if (count($oModelFormComponents) > 0) { ?>
      $(document).ready(function() {
         $('#MaintenanceFormsTasks_sComponents option').each(function() {
            <?php 
            foreach($oModelFormComponents as $oModelFormComponent) {
               echo 'if ($(this).val() == \'' . $oModelFormComponent->id_component . '\') {';
               echo '$(this).prop(\'selected\', \'true\');';
               echo '}'; 
            } ?>  
         });
      });
   <?php
   } ?>
   
   <?php 
   if (count($oModelFormDepartments) > 0) { ?>
      $(document).ready(function() {
         $('#MaintenanceFormsTasks_sDepartments option').each(function() {  
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
   
   $(document).ready(function() {    
      <?php
      if (($oModelForm->data_completed) && (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT))) {
         if ($bAllowCreateWorkingPart) { ?> 
            document.getElementById('MaintenanceFormsTasks_sWorkingPartPost').value = <?php echo $oModelForm->working_part . ';'; ?>
            enable_disable_working_part_elements(<?php echo $oModelForm->working_part;?>);
         <?php
         } else { ?>
            document.getElementById('MaintenanceFormsTasks_sWorkingPartPost').value = <?php echo $oModelForm->working_part . ';'; ?>
            <?php 
            if (!FString::isNullOrEmpty($oModelForm->working_part_number)) { ?>
               document.getElementById('MaintenanceFormsTasks_sWorkingPartNumberPost').value = <?php echo $oModelForm->working_part_number . ';'; ?>
            <?php
            } 
         }   
      } ?>
      
      $('#MaintenanceFormsTasks_sComponents').MultiSelect({
         size: 6,
         css_class_selected: 'multiselect_option_selected'
      });
      
      $('#MaintenanceFormsTasks_sDepartments').MultiSelect({
         size: 4,
         css_class_selected: 'multiselect_option_selected'
      });
   });
   
   function submit_form(form, data, hasError) {
      var oForm = document.getElementById('maintenance-form-task-form');
      oForm.action += '&nAction=0&sIdComponents=' + $('#MaintenanceFormsTasks_sComponents').val() + '&sIdDepartments=' + $('#MaintenanceFormsTasks_sDepartments').val();
      
      return !hasError;
   }
   
   function enable_disable_working_part_elements(nValue) {
      if (nValue == 0) {
         document.getElementById('button_add_working_part').disabled = true;   
      }
      else {
         document.getElementById('button_add_working_part').disabled = false;      
      } 
   }
   
   function enable_disable_finalize_data_elements(sValue) {
      if (sValue == 'REPAIR') $('#id_finalize_data').css('display', 'block');
      else $('#id_finalize_data').css('display', 'none');
   }    
</script>
  
<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/forms_tasks.png' ?>" />
   </div>
   <div class="item-header-text">  
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_HEADER', array('{1}'=>$oModelForm->id))); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_DESCRIPTION'); ?>
</div>

<?php $bFormTaskLocked = (Yii::app()->user->id != $oModelForm->id_user);
      
      $sRefreshRegionsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/refreshFormTaskRegions') . '&nIdForm=' . $oModelForm->id;
      $sRefreshEquipmentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/refreshFormTaskEquipments') . '&nIdForm=' . $oModelForm->id;
      $sRefreshComponentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/refreshFormTaskComponents') . '&nIdForm=' . $oModelForm->id;
      $sJsRefreshComponentClear = '$(\'#MaintenanceFormsTasks_sComponents option\').remove()';
      
      $sRefreshStatusUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/refreshFormTaskStatus') . '&nIdForm=' . $oModelForm->id; 

      $sJsRefreshEquipmentOthers = "$('#MaintenanceFormsTasks_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', this.value == '" . FApplication::EQUIPMENT_OTHERS . "', 1.0, 1000)";
      $sJsRefreshDisappearEquipmentOthers = "$('#MaintenanceFormsTasks_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', false, 1.0, 1000)";
?>

<?php
if ($oModelForm->data_completed) {  
   if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) { ?>
      <div class="form">
         <?php $formFormTaskWorkingPart = $this->beginWidget('CActiveForm', array(
            'id'=>'maintenance-form-task-working-part-form',
            'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/updateFormTask', array('nIdForm'=>$oModelForm->id, 'nAction'=>1)),
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
               'validateOnSubmit'=>true,
            ),
         )); ?>
      
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_FORM_HEADER_WORKING_PARTS'); ?>
         </div>     
         <div class="form_content_background_color_red" style="padding-top:10px; padding-bottom:5px;">
            <?php 
            $bWorkingPartLocked = false;
            if ($bAllowCreateWorkingPart) {
               $oFormsWorkingParts = FormsWorkingParts::getFormsWorkingParts(null, null, null, null, null, $oModelForm->id);
               $oFormsMaintenanceWorkingParts = FormsMaintenanceWorkingParts::getFormsMaintenanceWorkingParts(null, null, null, null, null, $oModelForm->id);
               $oFormsSpecialWorkingParts = FormsSpecialWorkingParts::getFormsSpecialWorkingParts(null, null, $oModelForm->id);

               if ((count($oFormsWorkingParts) > 0) || (count($oFormsMaintenanceWorkingParts) > 0) || (count($oFormsSpecialWorkingParts) > 0)) {
                  $bWorkingPartLocked = true;      
               }  
            }
            
            if ($bAllowCreateWorkingPart) {
               $oTypeWorkingPartList = array(FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NONE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPART_VALUE_0'), FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NORMAL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPART_VALUE_1'), FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_SPECIAL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPART_VALUE_3'));
               echo $formFormTaskWorkingPart->radioButtonList($oModelForm, 'working_part', $oTypeWorkingPartList, array('labelOptions'=>array('style'=>'display:inline'), 'separator'=>'          ', 'onclick'=>'document.getElementById(\'MaintenanceFormsTasks_sWorkingPartPost\').value = this.value; enable_disable_working_part_elements(this.value);', 'disabled'=>$bWorkingPartLocked));  
               
               echo $formFormTaskWorkingPart->hiddenField($oModelForm, 'sWorkingPartPost');
            
               echo CHtml::submitButton(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_FORM_BUTTON_ADD_NEW_WORKINGPART'), array('id'=>'button_add_working_part', 'class'=>'form_button_submit', 'style'=>'margin-left:40px; height:40px', 'disabled'=>$bWorkingPartLocked));
            }
            else {
               $oTypeWorkingPartList = array(FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NONE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPART_VALUE_0'), FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NORMAL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPART_VALUE_1'), FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_SPECIAL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPART_VALUE_3'));
               echo $formFormTaskWorkingPart->radioButtonList($oModelForm, 'working_part', $oTypeWorkingPartList, array('labelOptions'=>array('style'=>'display:inline'), 'separator'=>'          ', 'onclick'=>'document.getElementById(\'MaintenanceFormsTasks_sWorkingPartPost\').value = this.value;'));  
            }
            
            if (($bAllowCreateWorkingPart) && ($bWorkingPartLocked)) { ?>
               <div style="display:inline; margin-left:30px; font-weight:bold; color:red;">
               <?php
                  echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_FORM_WORKINGPART_NUMBER', array('{1}'=>$oModelForm->working_part_number));
               ?>   
               </div>
               <div style="display:inline; margin-left:10px;">
                  <a class="borrar" title="borrar" href="<?php echo Yii::app()->controller->createUrl("deleteFormTaskWorkingPart", array("nIdForm"=>$oModelForm->id))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                     <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" alt="borrar" />
                  </a>
               </div>
               <?php
            } else if (!$bAllowCreateWorkingPart) { ?>
               <div style="display:inline; margin-left:30px;">
                  <?php echo $formFormTaskWorkingPart->textField($oModelForm, 'working_part_number', array('style'=>'width:100px;', 'onchange'=>'document.getElementById(\'MaintenanceFormsTasks_sWorkingPartNumberPost\').value = this.value;')); ?> 
               </div>
               <?php
            }
            ?>

         </div>
      <?php $this->endWidget(); ?>
      </div>
      <br/><br/>
   <?php 
   } 
   
   if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WAREHOUSE_MANAGEMENT)) { 
      $sRefreshSuppliesUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/refreshFormTaskSupplies') . '&nIdForm=' . $oModelForm->id;
      ?>
      <div class="form">
         <?php $formFormTaskSupply = $this->beginWidget('CActiveForm', array(
            'id'=>'maintenance-form-task-supply-form',
            'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/updateFormTask', array('nIdForm'=>$oModelForm->id)),
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
               'validateOnSubmit'=>true,
            ),
         )); ?>
         
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_FORM_SUPPLY_NEW_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="cell">
                  <div class="first_row">
                     <div class="last_cell">
                        <?php echo $formFormTaskSupply->labelEx($oModelFormSupply, 'nIdSubcategory', array('style'=>'width:200px;')); ?> 
                        <?php echo $formFormTaskSupply->dropDownList($oModelFormSupply, 'nIdSubcategory', CHtml::listData(WarehouseArticlesSubcategories::getFullWarehouseArticlesSubcategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:200px;', 'onchange'=>'aj(\'' . $sRefreshSuppliesUrl . '&nIdSubcategory=\' + this.value, null, \'id_supply\');')); ?>
                        <?php echo $formFormTaskSupply->error($oModelFormSupply, 'nIdSubcategory', array('style'=>'width:200px;')); ?>
                     </div>  
                  </div>
                  <div class="row">
                     <div class="cell">
                        <?php echo $formFormTaskSupply->labelEx($oModelFormSupply, 'id_supply', array('style'=>'width:200px;')); ?>
                        <div id="id_supply">
                           <?php 
                              echo $formFormTaskSupply->dropDownList($oModelFormSupply, 'id_supply', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:200px;'));   
                           ?>
                        </div>
                        <?php echo $formFormTaskSupply->error($oModelFormSupply, 'id_supply', array('style'=>'width:200px;')); ?>
                     </div>
                     <div class="last_cell">
                        <?php echo $formFormTaskSupply->labelEx($oModelFormSupply, 'quantity', array('style'=>'width:65px;')); ?>
                        <?php echo $formFormTaskSupply->textField($oModelFormSupply, 'quantity', array('style'=>'width:65px;')); ?>
                        <?php $formFormTaskSupply->error($oModelFormSupply, 'quantity', array('style'=>'width:65px;')); ?>
                     </div>
                  </div>
               </div>
               <div class="cell" class="row buttons" style="vertical-align:top">
                  <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_ADD_ARROW'), array('class'=>'form_button_submit', 'style'=>'height:110px')); ?>
               </div>
               <div class="last_cell" style="vertical-align:top">
                  <?php 
                  $this->widget('zii.widgets.grid.CGridView', array(
                     'id'=>'id_CGridView_1',
                     'template'=>'{items} {pager}',
                     'ajaxUpdate'=>false,
                     'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
                     'pager'=>FGrid::getNavigationButtons(),
                     'dataProvider'=>$oModelFormSupply->search($oModelForm->id),
                     'columns'=> array(
                        array(
                           'name'=>'supply',
                           'htmlOptions'=>array('width'=>300),
                        ),
                        array(
                           'name'=>'quantity',
                           'htmlOptions'=>array('width'=>100),
                        ),
                        FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormTaskSupply", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_task))'),
                     ),
                     'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
                  )); ?>
               </div>
            </div> 
         </div>      
           
         <?php $this->endWidget(); ?>
      </div>
      <br/><br/>
   <?php
   }
   ?>
   
   <div class="form">
      <?php $formFormTaskEmployee = $this->beginWidget('CActiveForm', array(
         'id'=>'maintenance-form-task-employee-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/updateFormTask', array('nIdForm'=>$oModelForm->id)),
         'enableAjaxValidation'=>true,
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
         ),
      )); ?>

      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_FORM_EMPLOYEE_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <?php 
               $oDepartments = array();
               foreach($oModelFormDepartments as $oModelFormDepartment) {
                  $oDepartments = array_merge($oDepartments, array(null, $oModelFormDepartment->name));
               }
            ?>
            <div class="cell">
               <?php echo $formFormTaskEmployee->labelEx($oModelFormEmployee, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formFormTaskEmployee->dropDownList($oModelFormEmployee, 'name', CHtml::listData(Employees::getEmployees(null, array($oDepartments), null, true), 'full_name', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formFormTaskEmployee->error($oModelFormEmployee, 'name', array('style'=>'width:300px;')); ?>
            </div>
            <div class="cell" class="row buttons" style="vertical-align:top">
               <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_ADD_ARROW'), array('class'=>'form_button_submit', 'style'=>'height:60px')); ?>
            </div>
            <div class="last_cell">
               <?php 
               $this->widget('zii.widgets.grid.CGridView', array(
                  'id'=>'id_CGridView_2',
                  'template'=>'{items} {pager}',
                  'ajaxUpdate'=>false,
                  'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
                  'pager'=>FGrid::getNavigationButtons(),
                  'dataProvider'=>$oModelFormEmployee->search($oModelForm->id),
                  'columns'=> array(
                     array(
                        'name'=>'name',
                        'htmlOptions'=>array('width'=>400),
                     ),
                     FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormTaskEmployee", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_task))'),
                  ),
                  'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
               )); ?>
            </div>
         </div> 
      </div>      
        
      <?php $this->endWidget(); ?>
   </div>
   <br/><br/>
   <?php
}
?>
       
<div class="form">       
   <?php $formFormTask = $this->beginWidget('CActiveForm', array(
      'id'=>'maintenance-form-task-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/updateFormTask', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:submit_form',
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>
                      
   <div class="form_content">
      <div class="first_row">
         <div class="cell_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_FORM_HEADER_MAIN'); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_OWNER') . ':' . FString::STRING_SPACE . $oModelForm->owner; ?>
         </div>
      </div>
      <?php if ($oModelForm->data_completed) { ?>
      <div class="row">
         <div class="last_cell">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STARTDATE') . ':' . FString::STRING_SPACE . FDate::getTimeZoneFormattedDate($oModelForm->start_date, true); ?>
         </div>
      </div>
      <?php } ?>

      <div class="row">
         <div class="cell">
             <?php echo $formFormTask->labelEx($oModelForm, 'name'); ?>
             <?php echo $formFormTask->textField($oModelForm, 'name', array('style'=>'width:300px;', 'disabled'=>$bFormTaskLocked)); ?>
             <?php echo $formFormTask->error($oModelForm, 'name'); ?>
         </div>
         <?php 
         if ($oModelForm->id_user == Yii::app()->user->id) { ?>
            <div class="last_cell">
               <?php echo $formFormTask->labelEx($oModelForm, 'bAlarm', array('style'=>'width:160px;')); ?>
               <?php echo $formFormTask->checkBox($oModelForm, 'bAlarm', array('style'=>'width:10px;')); ?>
               <?php echo $formFormTask->error($oModelForm, 'bAlarm', array('style'=>'width:160px;')); ?>
            </div>
         <?php
         }
         ?>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormTask->labelEx($oModelForm, 'priority', array('style'=>'width:300px;')); ?>
            <?php echo $formFormTask->dropDownList($oModelForm, 'priority', CHtml::listData(MaintenancePriorities::getMaintenancePriorities(), 'description', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'disabled'=>$bFormTaskLocked)); ?>
            <?php echo $formFormTask->error($oModelForm, 'priority', array('style'=>'width:300px;')); ?>
         </div>
         <div class="last_cell">
            <?php echo $formFormTask->labelEx($oModelForm, 'type_task', array('style'=>'width:140px;')); ?>
            <?php echo $formFormTask->dropDownList($oModelForm, 'type_task', array(FModulePlantMaintenanceManagement::TYPE_TASK_REVISION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_TYPETASK_VALUE_REVISION'), FModulePlantMaintenanceManagement::TYPE_TASK_REPAIR=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_TYPETASK_VALUE_REPAIR'), FModulePlantMaintenanceManagement::TYPE_TASK_OTHERS=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_TYPETASK_VALUE_OTHERS')), array('style'=>'width:140px;', 'onchange'=>'enable_disable_finalize_data_elements(this.value)', 'disabled'=>$bFormTaskLocked)); ?>
            <?php echo $formFormTask->error($oModelForm, 'type_task', array('style'=>'width:140px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormTask->labelEx($oModelForm, 'task', array('style'=>'width:465px;')); ?>
            <?php echo $formFormTask->textArea($oModelForm, 'task', array('style'=>'width:465px; height:40px; overflow:auto; resize:none', 'disabled'=>$bFormTaskLocked)); ?>
            <?php echo $formFormTask->error($oModelForm, 'task', array('style'=>'width:465px;')); ?>
         </div>
      </div>
      <?php 
      if (!$bFormTaskLocked) { ?>
      <div class="row">
         <div class="cell">
            <?php echo $formFormTask->labelEx($oModelForm, 'sDepartments', array('style'=>'width:465px;')); ?>
            <div id="id_components">
               <?php     
                  if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {  
                     echo $formFormTask->listBox($oModelForm, 'sDepartments', FModulePlantMaintenanceManagement::getDepartments(), array('style'=>'width:465px;', 'multiple'=>'multiple', 'size'=>'4'));  
                  }
                  else {
                     echo $formFormTask->listBox($oModelForm, 'sDepartments', FModulePlantMaintenanceManagement::getDepartmentsByIdUser(Yii::app()->user->id), array('style'=>'width:465px;', 'multiple'=>'multiple', 'size'=>'4'));     
                  }
               ?>
            </div>
            <?php echo $formFormTask->error($oModelForm, 'sDepartments', array('style'=>'width:465px;')); ?>
         </div>
      </div>
      <?php  
      }
      ?>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormTask->labelEx($oModelForm, 'attachment', array('style'=>'width:465px;')); ?>
            <?php echo $formFormTask->fileField($oModelForm, 'attachment', array('style'=>'width:465px;', 'disabled'=>$bFormTaskLocked)); ?>      
            <?php echo $formFormTask->error($oModelForm, 'attachment', array('style'=>'width:465px;')); ?>
         </div>
      </div>
      <br/>   
      <div class="row">
         <div class="cell_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_FORM_HEADER_EQUIPMENT'); ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormTask->labelEx($oModelForm, 'id_zone', array('style'=>'width:300px;')); ?>                                                                                                                                                     
            <?php echo $formFormTask->dropDownList($oModelForm, 'id_zone', CHtml::listData(Zones::getZones(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsRefreshDisappearEquipmentOthers . ';aj(\'' . $sRefreshRegionsUrl . '&nIdZone=\' + this.value, null, \'id_region\');' . ';aj(\'' . $sRefreshEquipmentsUrl . '&nIdRegion=\', null, \'id_equipment\');' . $sJsRefreshComponentClear . ';', 'disabled'=>$bFormTaskLocked)); ?>           
            <?php echo $formFormTask->error($oModelForm, 'id_zone', array('style'=>'width:300px;')); ?>
         </div>
         <div class="last_cell">
            <?php echo $formFormTask->labelEx($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>
            <div id="id_region">
               <?php 
                  if (!FString::isNullOrEmpty($oModelForm->id_zone)) {
                     echo $formFormTask->dropDownList($oModelForm, 'id_region', CHtml::listData(Regions::getRegions($oModelForm->id_zone), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsRefreshDisappearEquipmentOthers . ';' . ';aj(\'' . $sRefreshEquipmentsUrl . '&nIdRegion=\' + this.value, null, \'id_equipment\');' . $sJsRefreshComponentClear . ';', 'disabled'=>$bFormTaskLocked));                       
                  } else { 
                     echo $formFormTask->dropDownList($oModelForm, 'id_region', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'disabled'=>$bFormTaskLocked)); 
                  } 
               ?>
            </div>
            <?php echo $formFormTask->error($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormTask->labelEx($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
            <div id="id_equipment">
               <?php 
                  if ((!FString::isNullOrEmpty($oModelForm->id_zone)) && (!FString::isNullOrEmpty($oModelForm->id_region))) {
                     echo $formFormTask->dropDownList($oModelForm, 'id_equipment', CHtml::listData(Equipments::getEquipments($oModelForm->id_region, null, null, null, true), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsRefreshEquipmentOthers . ';' . ';aj(\'' . $sRefreshComponentsUrl . '&nIdEquipment=\' + this.value, null, \'MaintenanceFormsTasks_sComponents\');', 'disabled'=>$bFormTaskLocked));  
                  } else { 
                     echo $formFormTask->dropDownList($oModelForm, 'id_equipment', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'disabled'=>$bFormTaskLocked)); 
                  } 
               ?>
            </div>
            <?php echo $formFormTask->error($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
         </div>
         <div class="last_cell">
            <div id="id_equipment_others" class="last_cell_content_expand_collapse_<?php if ($oModelForm->id_equipment == FApplication::EQUIPMENT_OTHERS) { echo 'show'; } else { echo 'hidden'; } ?>">
               <?php echo $formFormTask->labelEx($oModelForm, 'equipment', array('style'=>'width:300px;')); ?>
               <?php echo $formFormTask->textField($oModelForm, 'equipment', array('style'=>'width:300px;', 'disabled'=>$bFormTaskLocked)); ?>
               <?php echo $formFormTask->error($oModelForm, 'equipment', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      
      <div class="row">
         <div class="first_row">
            <div class="cell">
               <?php echo $formFormTask->labelEx($oModelForm, 'sComponents', array('style'=>'width:300px;')); ?>
               <div id="id_components">
                  <?php 
                  if ((!FString::isNullOrEmpty($oModelForm->id_zone)) && (!FString::isNullOrEmpty($oModelForm->id_region)) && (!FString::isNullOrEmpty($oModelForm->id_equipment))) { 
                     echo $formFormTask->listBox($oModelForm, 'sComponents', CHtml::listData(Components::getComponents($oModelForm->id_equipment), 'id', 'name'), array('style'=>'width:630px;', 'multiple'=>'multiple', 'size'=>'6', 'disabled'=>$bFormTaskLocked));
                  } else {
                     echo $formFormTask->listBox($oModelForm, 'sComponents', array(), array('style'=>'width:630px;', 'multiple'=>'multiple', 'disabled'=>$bFormTaskLocked));   
                  } 
                  ?>
               </div>
               <?php echo $formFormTask->error($oModelForm, 'sComponents', array('style'=>'width:300px;')); ?>
            </div>
         </div> 
      </div>  
      
      <?php
      if ($oModelForm->data_completed) { ?>
         <br/>
         <div class="row">
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_FORM_HEADER_FINALIZE'); ?>
            </div>
         </div>
         <?php
         if ($oModelForm->type_task != FModulePlantMaintenanceManagement::TYPE_TASK_REPAIR) { $sCssFinalizeData = 'display:none'; } ?>
         <div id="id_finalize_data" style="<?php echo $sCssFinalizeData; ?>">
            <div class="row">
                <div class="last_cell">
                   <?php echo $formFormTask->labelEx($oModelForm, 'failure_reason', array('style'=>'width:630px;')); ?>
                   <?php echo $formFormTask->textArea($oModelForm, 'failure_reason', array('style'=>'width:630px; height:60px; overflow:auto; resize:none', 'onchange'=>$sJsRefreshInformation)); ?>
                   <?php echo $formFormTask->error($oModelForm, 'failure_reason', array('style'=>'width:630px;')); ?>
                </div>
             </div>
             <div class="row">
                <div class="last_cell">
                   <?php echo $formFormTask->labelEx($oModelForm, 'failure_solution', array('style'=>'width:630px;')); ?>
                   <?php echo $formFormTask->textArea($oModelForm, 'failure_solution', array('style'=>'width:630px; height:60px; overflow:auto; resize:none', 'onchange'=>$sJsRefreshInformation)); ?>
                   <?php echo $formFormTask->error($oModelForm, 'failure_solution', array('style'=>'width:630px;')); ?>
                </div>
             </div>
          </div>
          <div class="row">
             <div class="last_cell">
                <?php echo $formFormTask->labelEx($oModelForm, 'comments', array('style'=>'width:630px;')); ?>
                <?php echo $formFormTask->textArea($oModelForm, 'comments', array('style'=>'width:630px; height:105px; overflow:auto; resize:none', 'onchange'=>$sJsRefreshInformation)); ?>
                <?php echo $formFormTask->error($oModelForm, 'comments', array('style'=>'width:630px;')); ?>
             </div>
          </div>
      <?php 
      } ?>  
 
      <?php if ($oModelForm->data_completed) { ?>
          <br/>
          <div class="row">
             <div class="cell_header">
                <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_FORM_HEADER_STATUS'); ?>
             </div>
          </div>
         <div id="idStatus" class="row">
          <?php if ($oModelForm->status == FModulePlantMaintenanceManagement::STATUS_PENDING) { ?>
             <div id="id_item_pending" class="cell">
          <?php } else { ?>
             <div id="id_item_pending" class="cell" style="cursor:pointer;" onclick="aj('<?php echo $sRefreshStatusUrl . '&sStatus=' . FModulePlantMaintenanceManagement::STATUS_PENDING;?>', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'<?php echo FModulePlantMaintenanceManagement::STATUS_PENDING;?>\'');">
          <?php } ?>

                <div class="item-image">
                   <?php if ($oModelForm->status == FModulePlantMaintenanceManagement::STATUS_PENDING) { ?>
                      <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)?>/status_pending.png" width="48px" height="48px">
                   <?php } else { ?>
                      <img class="item-image-fade-20-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)?>/status_pending.png" width="48px" height="48px">
                   <?php } ?>
                </div>
                <div class="item-image-description-center">
                   <font color="<?php echo FModulePlantMaintenanceManagement::COLOR_STATUS_PENDING;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS_VALUE_PENDING'); ?></font>
                </div>
             </div>

          <?php if ($oModelForm->status == FModulePlantMaintenanceManagement::STATUS_RUNNING) { ?>
             <div id="id_item_running" class="cell">
          <?php } else { ?>
             <div id="id_item_running" class="cell" style="cursor:pointer;" onclick="aj('<?php echo $sRefreshStatusUrl . '&sStatus=' . FModulePlantMaintenanceManagement::STATUS_RUNNING;?>', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'<?php echo FModulePlantMaintenanceManagement::STATUS_RUNNING;?>\'');">
          <?php } ?>

                <div class="item-image">
                   <?php if ($oModelForm->status == FModulePlantMaintenanceManagement::STATUS_RUNNING) { ?>
                      <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)?>/status_running.png" width="48px" height="48px">
                   <?php } else { ?>
                      <img class="item-image-fade-20-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)?>/status_running.png" width="48px" height="48px">
                   <?php } ?>
                </div>
                <div class="item-image-description-center">
                   <font color="<?php echo FModulePlantMaintenanceManagement::COLOR_STATUS_RUNNING;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS_VALUE_RUNNING'); ?></font>
                </div>
             </div>
          
          <?php if ($oModelForm->status == FModulePlantMaintenanceManagement::STATUS_FINALIZED) { ?>
             <div id="id_item_finalized" class="last_cell">
          <?php } else { ?>
             <div id="id_item_finalized" class="last_cell" style="cursor:pointer;" onclick="aj('<?php echo $sRefreshStatusUrl . '&sStatus=' . FModulePlantMaintenanceManagement::STATUS_FINALIZED;?>', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'<?php echo FModulePlantMaintenanceManagement::STATUS_FINALIZED;?>\'');">
          <?php } ?>

                <div class="item-image">
                   <?php if ($oModelForm->status == FModulePlantMaintenanceManagement::STATUS_FINALIZED) { ?>
                      <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)?>/status_finalized.png" width="48px" height="48px">
                   <?php } else { ?>
                      <img class="item-image-fade-20-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)?>/status_finalized.png" width="48px" height="48px">
                   <?php } ?>
                </div>
                <div class="item-image-description-center">
                   <font color="<?php echo FModulePlantMaintenanceManagement::COLOR_STATUS_FINALIZED;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS_VALUE_FINALIZED'); ?></font>
                </div>
             </div>
          </div>
       <?php 
       } ?>
       
       <?php echo $formFormTask->hiddenField($oModelForm, 'status', array('id'=>'idStatusField', 'style'=>'width:180px;')); ?>  
       <?php echo $formFormTask->hiddenField($oModelForm, 'sWorkingPartPost'); ?>
       <?php echo $formFormTask->hiddenField($oModelForm, 'sWorkingPartNumberPost'); ?>
   </div>

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
   
   <div class="row buttons">
      <?php echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormsTasks') . '\'')); ?>
      <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
   </div>     
                      
   <?php $this->endWidget(); ?>
</div>