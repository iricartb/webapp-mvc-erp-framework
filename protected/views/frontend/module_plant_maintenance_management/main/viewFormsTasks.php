<?php 
if ($oModelForm->sFilterStatusPending) $sFilterStatusPending = 'checked';
else $sFilterStatusPending = FString::STRING_EMPTY; 
           
if ($oModelForm->sFilterStatusRunning) $sFilterStatusRunning = 'checked';
else $sFilterStatusRunning = FString::STRING_EMPTY;

if ($oModelForm->sFilterStatusFinalized) $sFilterStatusFinalized = 'checked';
else $sFilterStatusFinalized = FString::STRING_EMPTY; 

$oDiscartParameters = array('r', 'MaintenanceFormsTasks[sFilterStatusPending]', 'MaintenanceFormsTasks[sFilterStatusRunning]', 'MaintenanceFormsTasks[sFilterStatusFinalized]');

$sJsParameters = 'function createUrlParameters() {
                     var sFilterStatusPending = \'&MaintenanceFormsTasks[sFilterStatusPending]=\';
                     if (document.getElementById(\'id_filter_status_pending\').checked) sFilterStatusPending += \'1\';
                     else sFilterStatusPending += \'0\';
                     
                     var sFilterStatusRunning = \'&MaintenanceFormsTasks[sFilterStatusRunning]=\';    
                     if (document.getElementById(\'id_filter_status_running\').checked) sFilterStatusRunning += \'1\';
                     else sFilterStatusRunning += \'0\';
                     
                     var sFilterStatusFinalized = \'&MaintenanceFormsTasks[sFilterStatusFinalized]=\';    
                     if (document.getElementById(\'id_filter_status_finalized\').checked) sFilterStatusFinalized += \'1\';
                     else sFilterStatusFinalized += \'0\';
                     
                     return sFilterStatusPending + sFilterStatusRunning + sFilterStatusFinalized; 
                  };';
?>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/forms_tasks.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PLANT_MAINTENANCE_MANAGEMENT_HEADER_LINE_FORMS_TASKS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWFORMSTASKS_DESCRIPTION'); ?>
</div>

<div class="toolbox_table">
   <?php 
      if (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) { 
         $oModuleParameters = MaintenanceModuleParameters::getMaintenanceModuleParameters();
         $bAllowCreate = false;
         
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) $bAllowCreate = true;
         else if ((!is_null($oModuleParameters) && ($oModuleParameters->allow_users_create_tasks))) {
            $oEmployee = Users::getEmployeeByIdUser(Yii::app()->user->id);
            if (!is_null($oEmployee)) {
               $oEmployeeDepartments = EmployeesDepartments::getEmployeesDepartmentsByEmployeeIdentification($oEmployee->identification);
               if (count($oEmployeeDepartments) > 0) $bAllowCreate = true;
            }  
         }
         
         if ($bAllowCreate) {
         ?>
         <div class="toolbox_table_first_cell_button_left">
            <?php $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('createFormTask') . '\''; ?>      
            <?php echo FWidget::showIconImageButton('maintenanceFormsTasks', 'document_new_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWFORMSTASKS_NEW_BTN_DESCRIPTION'), $sAction); ?>   
         </div>
<?php   }
     } ?>
   <div class="toolbox_table_first_cell_button">      
      <?php echo FWidget::showToolboxExporterData('maintenanceFormsTasks', FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT, 'MaintenanceFormsTasks', $oModelForm->sFilterStatusPending . ',' . $oModelForm->sFilterStatusRunning . ',' . $oModelForm->sFilterStatusFinalized, FString::STRING_EMPTY, $this, true); ?>   
   </div>
</div>
                                                                                                                        
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelForm->search(),
   'filter'=>$oModelForm,
   'rowCssClassExpression'=>'strtolower($data->status)',
   'columns'=>array(
      array(
         'name'=>'id',
         'htmlOptions'=>array('width'=>50),
      ),
      array(
         'name'=>'owner',
         'htmlOptions'=>array('width'=>110),
      ),
      array(
         'name'=>'task',
         'htmlOptions'=>array('width'=>210),
      ),
      array(
         'name'=>'priority',
         'filter'=>CHtml::listData(MaintenancePriorities::getMaintenancePriorities(), 'description', 'description'),
         'htmlOptions'=>array('width'=>70),
      ),
      array(
         'name'=>'sDepartments',
         'filter'=>false,
         'value'=>'MaintenanceFormsTasks::getDepartmentsDescription($data->id)',
         'htmlOptions'=>array('width'=>130),
      ),
      array(
         'name'=>'start_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->start_date, true)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'start_date', false, FString::STRING_EMPTY, 'strtotime()'), true), 
         'htmlOptions'=>array('width'=>130),
      ),
      FGrid::getAttachmentButton('Yii::app()->controller->createUrl("viewAttachmentFormTask", array("nIdForm"=>$data->primaryKey))', '(!FString::isNullOrEmpty($data->attachment))'),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormTask", array("nIdForm"=>$data->primaryKey))', 'FModulePlantMaintenanceManagement::allowUpdateMaintenanceFormTask($data->primaryKey)', false),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormTask", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormTask", array("nIdForm"=>$data->primaryKey))', 'FModulePlantMaintenanceManagement::allowDeleteMaintenanceFormTask($data->primaryKey)'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));   
?>

<div class="row">
   <div class="cell">
      <input id="id_filter_status_pending" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/viewFormsTasks') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusPending;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePlantMaintenanceManagement::COLOR_GRID_STATUS_PENDING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS_VALUE_PENDING');?>
   </div>
   <div class="cell">
      <input id="id_filter_status_running" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/viewFormsTasks') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusRunning;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePlantMaintenanceManagement::COLOR_GRID_STATUS_RUNNING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS_VALUE_RUNNING');?>
   </div>
   <div class="last_cell">
      <input id="id_filter_status_finalized" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/viewFormsTasks') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusFinalized;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePlantMaintenanceManagement::COLOR_GRID_STATUS_FINALIZED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS_VALUE_FINALIZED');?>
   </div>
</div>