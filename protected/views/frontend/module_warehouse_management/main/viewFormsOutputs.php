<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/forms_outputs.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WAREHOUSE_MANAGEMENT_HEADER_LINE_FORMS_OUTPUTS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWFORMSOUTPUTS_DESCRIPTION'); ?>
</div>

<div class="toolbox_table">
   <?php 
      if (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) { ?>
         <div class="toolbox_table_first_cell_button_left">
            <?php $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('createFormOutput') . '\''; ?>      
            <?php echo FWidget::showIconImageButton('warehouseFormsOutputs', 'document_new_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWFORMSOUTPUTS_NEW_BTN_DESCRIPTION'), $sAction); ?>   
         </div>
      <?php   
     } ?>
   <div class="toolbox_table_first_cell_button">      
      <?php echo FWidget::showToolboxExporterData('warehouseFormsOutputs', FApplication::MODULE_WAREHOUSE_MANAGEMENT, 'WarehouseFormsOutputs', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>   
   </div>
</div>
                                                                                                                        
<?php 
$oColumns = array(
               array(
                  'name'=>'owner',
                  'htmlOptions'=>array('width'=>110),
               ),
               array(
                  'name'=>'date',
                  'value'=>'FDate::getTimeZoneFormattedDate($data->date, false)',
                  'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'date', false, FString::STRING_EMPTY, 'strtotime()'), true), 
                  'htmlOptions'=>array('width'=>70),
               ),
               array(
                  'name'=>'type',
                  'filter'=>array(FModuleWarehouseManagement::TYPE_OUTPUT_PLANT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_PLANT'), FModuleWarehouseManagement::TYPE_OUTPUT_REGULARIZATION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_REGULARIZATION'), FModuleWarehouseManagement::TYPE_OUTPUT_DEVOLUTION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_DEVOLUTION')),
                  'value'=>'Yii::t(\'frontend_\' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), \'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_\' . $data->type)',
                  'htmlOptions'=>array('width'=>120),
               ),
               array(
                  'name'=>'employee',
                  'htmlOptions'=>array('width'=>130),
               ),
               array(
                  'name'=>'comments',
                  'htmlOptions'=>array('width'=>220),
               ),
               array(
                  'type'=>'raw',
                  'name'=>'nTotal',
                  'filter'=>false,
                  'value'=>'FFormat::getFormatPrice(WarehouseFormsOutputs::getWarehouseFormOutputTotalPriceCost($data->id)) . \' €\'',
                  'htmlOptions'=>array('width'=>70, 'style'=>'text-align:right;'),
               ),                  
               FGrid::getPrintButton('Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . "/report/" . (($data->type == FModuleWarehouseManagement::TYPE_OUTPUT_PLANT) ? "formOutputMaterialReleaseAuthorizationExport" : "formOutputMaterialReleaseRepairBenefitExport"), array("nIdForm"=>$data->primaryKey, "sFormat"=>FFile::FILE_XLS_TYPE))', '(($data->type == ' . FModuleWarehouseManagement::TYPE_OUTPUT_PLANT . ') || ($data->type == ' . FModuleWarehouseManagement::TYPE_OUTPUT_REPAIR . ') || ($data->type == ' . FModuleWarehouseManagement::TYPE_OUTPUT_BENEFIT . '))'),
               FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormOutput", array("nIdForm"=>$data->primaryKey))', 'FModuleWarehouseManagement::allowUpdateWarehouseFormOutput($data->primaryKey)', false),
               FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormOutput", array("nIdForm"=>$data->primaryKey))'),
               FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormOutput", array("nIdForm"=>$data->primaryKey))', 'FModuleWarehouseManagement::allowDeleteWarehouseFormOutput($data->primaryKey)'),
            );
            
/*if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {
   $oColumnMaintenanceTask = array(FGrid::getDetailButton('Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . "/main/viewDetailFormTask", array("nIdForm"=>$data->id_maintenance_form_task))', '(!FString::isNullOrEmpty($data->id_maintenance_form_task))', true, false, 'caution_alert_1.png'));
                   
   $oColumns = array_merge($oColumns, $oColumnMaintenanceTask);      
}*/
       
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelForm->search(),
   'filter'=>$oModelForm,
   'columns'=>$oColumns,
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));   
?>

<?php
if ((Yii::app()->user->hasFlash('success-generic')) || (Yii::app()->user->hasFlash('notice-generic')) || (Yii::app()->user->hasFlash('error-generic'))) { ?>
   <?php if (Yii::app()->user->hasFlash('success-generic')) { ?>
      <div class="flash-success">
         <?php echo Yii::app()->user->getFlash('success-generic'); ?>
      </div> 
   <?php } else if (Yii::app()->user->hasFlash('notice-generic')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice-generic'); ?>
      </div>   
   <?php } else { ?>
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error-generic'); ?>
      </div>
   <?php }
}
?>