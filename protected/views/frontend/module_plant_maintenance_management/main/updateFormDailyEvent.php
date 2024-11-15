<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/forms_daily_events.png' ?>" />
   </div>                                                                                                                                                                                                                                                                                                   
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMDAILYEVENT_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($oModelForm->formDailyEvent->date), '{2}'=>$oModelForm->formDailyEvent->owner))); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMDAILYEVENT_DESCRIPTION'); ?>
</div>

<?php if (FModulePlantMaintenanceManagement::allowUpdateMaintenanceFormDailyEvent($oModelForm->id_form_daily_event)) { ?>
   <div class="form">
      <?php $formFormDailyEventLine = $this->beginWidget('CActiveForm', array(
         'id'=>'maintenance-form-daily-event-line-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/updateFormDailyEvent', array('nIdForm'=>$oModelForm->id_form_daily_event)),
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
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMDAILYEVENT_FORM_NEW_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
       
      <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMDAILYEVENT_FORM_NEW_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="row">
               <div class="cell">
                   <?php echo $formFormDailyEventLine->labelEx($oModelForm, 'hour'); ?>
                   <?php echo $formFormDailyEventLine->dropdownlist($oModelForm, 'sHourHour', FForm::getCbHours(), array('style'=>'width:45px;')); ?>
                   <?php echo ':'; ?>
                   <?php echo $formFormDailyEventLine->dropdownlist($oModelForm, 'sHourMinutes', array(0=>'00', 15=>'15', 30=>'30', 45=>'45'), array('style'=>'width:45px;')); ?>
                   <?php echo $formFormDailyEventLine->error($oModelForm, 'hour'); ?>
               </div>
               <div class="last_cell">
                   <?php echo $formFormDailyEventLine->labelEx($oModelForm, 'duration'); ?>
                   <?php echo $formFormDailyEventLine->dropdownlist($oModelForm, 'sDurationHour', FForm::getCbHours(), array('style'=>'width:45px;')); ?>
                   <?php echo ':'; ?>
                   <?php echo $formFormDailyEventLine->dropdownlist($oModelForm, 'sDurationMinutes', array(0=>'00', 15=>'15', 30=>'30', 45=>'45'), array('style'=>'width:45px;')); ?>
                   <?php echo $formFormDailyEventLine->error($oModelForm, 'duration'); ?>
               </div>
            </div>
            <div class="row">
               <div class="last_cell">  
                  <?php echo $formFormDailyEventLine->labelEx($oModelForm, 'description', array('style'=>'width:705px;')); ?>  
                  <?php echo $formFormDailyEventLine->textArea($oModelForm, 'description', array('class'=>'mceEditor', 'style'=>'width:885px; height:300px')); ?>
                  <?php echo $formFormDailyEventLine->error($oModelForm, 'description', array('style'=>'width:705px;')); ?>
               </div>
            </div>
         </div> 
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit', 'onclick'=>'tinyMCE.triggerSave(true, true);')); ?>
         </div>     
      </div>
        
      <?php $this->endWidget(); ?>
   </div>
<?php } ?>

<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">                                                                             
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMDAILYEVENT_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('maintenanceFormDailyEventLines', FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT, 'MaintenanceFormDailyEventLines', $oModelForm->id_form_daily_event, FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelForm->search($oModelForm->id_form_daily_event),
   'columns'=> array(
      array(
         'name'=>'hour',
         'htmlOptions'=>array('width'=>40),
      ),
      array(
         'name'=>'duration',
         'htmlOptions'=>array('width'=>40),
      ),
      array(
         'type'=>'raw',
         'name'=>'description',
         'value'=>'FString::getAbbreviationSentence(strip_tags($data->description), 300)', 
         'htmlOptions'=>array('width'=>600),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormDailyEventLine", array("nIdForm"=>$data->primaryKey))', 'FModulePlantMaintenanceManagement::allowUpdateMaintenanceFormDailyEvent($data->id_form_daily_event)'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormDailyEventLine", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormDailyEventLine", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_daily_event))', 'FModulePlantMaintenanceManagement::allowDeleteMaintenanceFormDailyEvent($data->id_form_daily_event)'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>

<div class="form">
   <div class="row buttons">
      <?php echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormsDailyEvents') . '\'')); ?>
   </div>
</div>