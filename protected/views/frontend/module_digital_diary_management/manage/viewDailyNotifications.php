<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/daily_notifications.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER_LINE_DAILY_NOTIFICATIONS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWDAILYNOTIFICATIONS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formDailyNotification = $this->beginWidget('CActiveForm', array(
      'id'=>'digitaldiary-daily-notification-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewDailyNotifications'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWDAILYNOTIFICATIONS_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWDAILYNOTIFICATIONS_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formDailyNotification->labelEx($oModelForm, 'mail', array('style'=>'width:300px;')); ?>
               <?php echo $formDailyNotification->textField($oModelForm, 'mail', array('style'=>'width:300px;')); ?>
               <?php echo $formDailyNotification->error($oModelForm, 'mail', array('style'=>'width:300px;')); ?>
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
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWDAILYNOTIFICATIONS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('digitalDiaryDailyNotifications', FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT, 'DigitalDiaryDailyNotifications', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'name'=>'mail',
         'htmlOptions'=>array('width'=>710),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateDailyNotification", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailDailyNotification", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteDailyNotification", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>