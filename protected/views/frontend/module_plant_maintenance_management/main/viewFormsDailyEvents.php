<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/forms_daily_events.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PLANT_MAINTENANCE_MANAGEMENT_HEADER_LINE_FORMS_DAILY_EVENTS')); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWFORMSDAILYEVENTS_DESCRIPTION'); ?>
</div>

<?php if (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) { ?>
   <div class="form">
      <?php $formFormDailyEvent = $this->beginWidget('CActiveForm', array(
         'id'=>'maintenance-form-daily-event-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/viewFormsDailyEvents'),
         'enableAjaxValidation'=>true,
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
         ),
      )); ?>
           
      <div class="form_expand_collapse" >
         <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
         </div>
         <div class="form_expand_collapse_text">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWFORMSDAILYEVENTS_FORM_NEW_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
       
      <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWFORMSDAILYEVENTS_FORM_NEW_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="cell">
                  <?php echo $formFormDailyEvent->labelEx($oModelForm, 'date', array('style'=>'width:180px;')); ?>
                  <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'date', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '180px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate(date("YmdHis")))); ?>
                  <?php echo $formFormDailyEvent->error($oModelForm, 'date', array('style'=>'width:180px;')); ?>      
               </div>
            </div>
         </div>
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
         </div>     
      </div>
        
      <?php $this->endWidget(); ?>
   </div>
<?php } ?>
    
<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWFORMSDAILYEVENTS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('maintenanceFormsDailyEvents', FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT, 'MaintenanceFormsDailyEvents', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
   'columns'=> array(
      array(
         'name'=>'date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->date)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormFilters, 'date', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, 'filter'), true), 
         'htmlOptions'=>array('width'=>200),
      ),
      array(
         'name'=>'owner',
         'htmlOptions'=>array('width'=>510),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormDailyEvent", array("nIdForm"=>$data->primaryKey))', 'true', false),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormDailyEvent", array("nIdForm"=>$data->primaryKey))', 'true'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormDailyEvent", array("nIdForm"=>$data->primaryKey))', 'FModulePlantMaintenanceManagement::allowDeleteMaintenanceFormDailyEvent($data->primaryKey)'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>