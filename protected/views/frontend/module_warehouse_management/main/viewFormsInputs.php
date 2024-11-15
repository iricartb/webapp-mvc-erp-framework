<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/forms_inputs.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WAREHOUSE_MANAGEMENT_HEADER_LINE_FORMS_INPUTS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWFORMSINPUTS_DESCRIPTION'); ?>
</div>

<div class="toolbox_table">
   <?php 
      if (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) { ?>
         <div class="toolbox_table_first_cell_button_left">
            <?php $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('createFormInput') . '\''; ?>      
            <?php echo FWidget::showIconImageButton('warehouseFormsInputs', 'document_new_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWFORMSINPUTS_NEW_BTN_DESCRIPTION'), $sAction); ?>   
         </div>
      <?php   
     } ?>
   <div class="toolbox_table_first_cell_button">      
      <?php echo FWidget::showToolboxExporterData('warehouseFormsInputs', FApplication::MODULE_WAREHOUSE_MANAGEMENT, 'WarehouseFormsInputs', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>   
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
         'filter'=>array(FModuleWarehouseManagement::TYPE_INPUT_WAYBILL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_WAYBILL'), FModuleWarehouseManagement::TYPE_INPUT_REGULARIZATION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_REGULARIZATION')),
         'value'=>'Yii::t(\'frontend_\' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), \'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_\' . $data->type)',
         'htmlOptions'=>array('width'=>120),
      ),
      array(
         'name'=>'code',
         'htmlOptions'=>array('width'=>100),
      ),
      array(
         'name'=>'comments',
         'htmlOptions'=>array('width'=>220),
      ),
      array(
         'type'=>'raw',
         'name'=>'nTotal',
         'filter'=>false,
         'value'=>'FFormat::getFormatPrice(WarehouseFormsInputs::getWarehouseFormInputTotalPriceCost($data->id)) . \' €\'',
         'htmlOptions'=>array('width'=>70, 'style'=>'text-align:right;'),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormInput", array("nIdForm"=>$data->primaryKey))', 'FModuleWarehouseManagement::allowUpdateWarehouseFormInput($data->primaryKey)', false),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormInput", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormInput", array("nIdForm"=>$data->primaryKey))', 'FModuleWarehouseManagement::allowDeleteWarehouseFormInput($data->primaryKey)'),
   ),
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

<div class="row">
   <div class="cell">
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWarehouseManagement::COLOR_GRID_STATUS_SUCCESS;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_STATUS_VALUE_SUCCESS');?>
   </div>
   
   <div class="cell">
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWarehouseManagement::COLOR_GRID_STATUS_ALERT;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_STATUS_VALUE_ALERT');?>
   </div>
   
   <div class="cell">
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWarehouseManagement::COLOR_GRID_STATUS_ERROR;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_STATUS_VALUE_ERROR');?>
   </div>
</div>