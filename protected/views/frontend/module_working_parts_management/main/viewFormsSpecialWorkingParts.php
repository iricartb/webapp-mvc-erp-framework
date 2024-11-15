<?php 
$oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters();

if ($oModelForm->sFilterStatusCreated) $sFilterStatusCreated = 'checked';
else $sFilterStatusCreated = FString::STRING_EMPTY; 
           
if ($oModelForm->sFilterStatusPending) $sFilterStatusPending = 'checked';
else $sFilterStatusPending = FString::STRING_EMPTY; 

if ($oModelForm->sFilterStatusRunning) $sFilterStatusRunning = 'checked';
else $sFilterStatusRunning = FString::STRING_EMPTY;

if ($oModelForm->sFilterStatusPendingAbsence) $sFilterStatusPendingAbsence = 'checked';
else $sFilterStatusPendingAbsence = FString::STRING_EMPTY;

if ($oModelForm->sFilterStatusHalted) $sFilterStatusHalted = 'checked'; 
else $sFilterStatusHalted = FString::STRING_EMPTY;  

if ($oModelForm->sFilterStatusFinalized) $sFilterStatusFinalized = 'checked';
else $sFilterStatusFinalized = FString::STRING_EMPTY;

$oDiscartParameters = array('r', 'FormsSpecialWorkingParts[sFilterStatusCreated]', 'FormsSpecialWorkingParts[sFilterStatusPending]', 'FormsSpecialWorkingParts[sFilterStatusRunning]', 'FormsSpecialWorkingParts[sFilterStatusPendingAbsence]', 'FormsSpecialWorkingParts[sFilterStatusHalted]', 'FormsSpecialWorkingParts[sFilterStatusFinalized]');

$sJsParameters = 'function createUrlParameters() {
                     var sFilterStatusCreated = \'&FormsSpecialWorkingParts[sFilterStatusCreated]=\';
                     if (document.getElementById(\'id_filter_status_created\').checked) sFilterStatusCreated += \'1\';
                     else sFilterStatusCreated += \'0\';
                     
                     var sFilterStatusPending = \'&FormsSpecialWorkingParts[sFilterStatusPending]=\';    
                     if (document.getElementById(\'id_filter_status_pending\').checked) sFilterStatusPending += \'1\';
                     else sFilterStatusPending += \'0\';
                     
                     var sFilterStatusRunning = \'&FormsSpecialWorkingParts[sFilterStatusRunning]=\';    
                     if (document.getElementById(\'id_filter_status_running\').checked) sFilterStatusRunning += \'1\';
                     else sFilterStatusRunning += \'0\';
                     
                     var sFilterStatusPendingAbsence = \'&FormsSpecialWorkingParts[sFilterStatusPendingAbsence]=\';    
                     if (document.getElementById(\'id_filter_status_pending_absence\').checked) sFilterStatusPendingAbsence += \'1\';
                     else sFilterStatusPendingAbsence += \'0\';
                     
                     var sFilterStatusHalted = \'&FormsSpecialWorkingParts[sFilterStatusHalted]=\';    
                     if (document.getElementById(\'id_filter_status_halted\').checked) sFilterStatusHalted += \'1\';
                     else sFilterStatusHalted += \'0\';
                     
                     var sFilterStatusFinalized = \'&FormsSpecialWorkingParts[sFilterStatusFinalized]=\';    
                     if (document.getElementById(\'id_filter_status_finalized\').checked) sFilterStatusFinalized += \'1\';
                     else sFilterStatusFinalized += \'0\';
                     
                     return sFilterStatusCreated + sFilterStatusPending + sFilterStatusRunning + sFilterStatusPendingAbsence + sFilterStatusHalted + sFilterStatusFinalized; 
                  };';
?>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/forms_special_working_parts.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WORKING_PARTS_MANAGEMENT_HEADER_LINE_FORMS_SPECIAL_WORKING_PARTS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSSPECIALWORKINGPARTS_DESCRIPTION'); ?>
</div>

<div class="toolbox_table">
   <?php if (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) { ?>
      <div class="toolbox_table_first_cell_button_left">
         <?php $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('createFormSpecialWorkingPart') . '\''; ?>      
         <?php echo FWidget::showIconImageButton('formsSpecialWorkingParts', 'document_new_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSSPECIALWORKINGPARTS_NEW_BTN_DESCRIPTION'), $sAction); ?>   
      </div>
   <?php } ?>
   <div class="toolbox_table_first_cell_button">      
      <?php echo FWidget::showToolboxExporterData('formsSpecialWorkingParts', FApplication::MODULE_WORKING_PARTS_MANAGEMENT, 'FormsSpecialWorkingParts', $oModelForm->sFilterStatusCreated . ',' . $oModelForm->sFilterStatusPending . ',' . $oModelForm->sFilterStatusRunning . ',' . $oModelForm->sFilterStatusPendingAbsence . ',' . $oModelForm->sFilterStatusHalted . ',' . $oModelForm->sFilterStatusFinalized, FString::STRING_EMPTY, $this, true); ?>   
   </div>
</div>
                                                                                                                        
<?php 
$oColumns = array(
               array(
                  'name'=>'id',
                  'htmlOptions'=>array('width'=>60),
               ),
               array(
                  'name'=>'owner',
                  'htmlOptions'=>array('width'=>160),
               ), 
               array(
                  'name'=>'work',
                  'value'=>'($data->work == \'' . strtoupper(FString::STRING_OTHERS) . '\') ? $data->work_others : Yii::t(\'frontend_\' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), \'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORK_VALUE_\' . $data->work)',
                  'htmlOptions'=>array('width'=>160),
               ),
               array(
                  'name'=>'installation',
                  'value'=>'FString::getAbbreviationSentence($data->installation, 20)', 
                  'htmlOptions'=>array('width'=>190),
               ),
               array(
                  'name'=>'start_date',
                  'value'=>'FDate::getTimeZoneFormattedDate($data->start_date, true)',
                  'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'start_date', false, FString::STRING_EMPTY, 'strtotime()'), true), 
                  'htmlOptions'=>array('width'=>140),
               ),
               FGrid::getPrintButton('Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/report/formSpecialWorkingPartExport", array("nIdForm"=>$data->primaryKey, "sFormat"=>FFile::FILE_XLS_TYPE))'),
               FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormSpecialWorkingPart", array("nIdForm"=>$data->primaryKey))', '((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) || ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) && ($data->status != FModuleWorkingPartsManagement::STATUS_FINALIZED)))', false),
               FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormSpecialWorkingPart", array("nIdForm"=>$data->primaryKey))', 'true'),
               FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormSpecialWorkingPart", array("nIdForm"=>$data->primaryKey))', '((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) || ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) && ($data->status != FModuleWorkingPartsManagement::STATUS_FINALIZED)))'),
            );
   
if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {
   $oMaintenanceModuleParameters = MaintenanceModuleParameters::getMaintenanceModuleParameters();
   if (!is_null($oMaintenanceModuleParameters)) {
      if ($oMaintenanceModuleParameters->allow_create_working_part) {
         $oColumnMaintenanceTask = array(FGrid::getDetailButton('Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . "/main/viewDetailFormTask", array("nIdForm"=>$data->id_maintenance_form_task))', '(!FString::isNullOrEmpty($data->id_maintenance_form_task))', true, false, 'caution_alert_1.png'));
            
         $oColumns = array_merge($oColumns, $oColumnMaintenanceTask); 
      } 
   }    
}

$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelForm->search(),
   'filter'=>$oModelForm,
   'rowCssClassExpression'=>'strtolower($data->status)',
   'columns'=>$oColumns,
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>

<div class="row">
   <?php 
   if ((is_null($oWorkingPartModuleParameters)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_created)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_created == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_running == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending_absence == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_halted == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_finalized == false))) { ?>
      <div class="cell">
         <input id="id_filter_status_created" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsSpecialWorkingParts') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusCreated;?>>
         <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWorkingPartsManagement::COLOR_GRID_STATUS_CREATED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_CREATED');?>
      </div>
   <?php
   } else { ?>
      <input id="id_filter_status_created" style="display:none" type="checkbox">
   <?php
   } 
   ?>
   
   <?php
   if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending)) { ?>  
      <div class="cell">
         <input id="id_filter_status_pending" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsSpecialWorkingParts') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusPending;?>>
         <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWorkingPartsManagement::COLOR_GRID_STATUS_PENDING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_PENDING');?>
      </div>
   <?php
   } else { ?>
      <input id="id_filter_status_pending" style="display:none" type="checkbox">
   <?php
   } 
   ?>
   
   <?php
   if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_running)) { ?> 
      <div class="cell">
         <input id="id_filter_status_running" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsSpecialWorkingParts') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusRunning;?>>
         <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWorkingPartsManagement::COLOR_GRID_STATUS_RUNNING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_RUNNING');?>
      </div>
   <?php
   } else { ?>
      <input id="id_filter_status_running" style="display:none" type="checkbox">
   <?php
   } 
   ?>
   
   <?php
   if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending_absence)) { ?>  
      <div class="cell">
         <input id="id_filter_status_pending_absence" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsSpecialWorkingParts') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusPendingAbsence;?>>
         <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWorkingPartsManagement::COLOR_GRID_STATUS_PENDING_ABSENCE;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_PENDING_ABSENCE');?>
      </div>
   <?php
   } else { ?>
      <input id="id_filter_status_pending_absence" style="display:none" type="checkbox">
   <?php
   } 
   ?>
      
   <?php
   if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_halted)) { ?> 
      <div class="cell">
         <input id="id_filter_status_halted" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsSpecialWorkingParts') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusHalted;?>>
         <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWorkingPartsManagement::COLOR_GRID_STATUS_HALTED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_HALTED');?>
      </div>
   <?php
   } else { ?>
      <input id="id_filter_status_halted" style="display:none" type="checkbox">
   <?php
   } 
   ?>
   
   <?php
   if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_finalized)) { ?> 
      <div class="last_cell">
         <input id="id_filter_status_finalized" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsSpecialWorkingParts') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusFinalized;?>>
         <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWorkingPartsManagement::COLOR_GRID_STATUS_FINALIZED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_FINALIZED');?>
      </div>
   <?php
   } else { ?>
      <input id="id_filter_status_finalized" style="display:none" type="checkbox">
   <?php
   } 
   ?>
</div>