<div class="form">
   <?php $formFormDailyEventLine = $this->beginWidget('CActiveForm', array(
      'id'=>'maintenance-form-daily-event-line-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/updateFormDailyEventLine', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
               
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMDAILYEVENTLINE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
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
               <?php echo $formFormDailyEventLine->textArea($oModelForm, 'description', array('class'=>'mceEditor', 'style'=>'width:705px; height:300px')); ?>
               <?php echo $formFormDailyEventLine->error($oModelForm, 'description', array('style'=>'width:705px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit', 'onclick'=>'tinyMCE.triggerSave(true, true);')); ?>
      </div>  
   </div>
   
   <?php $this->endWidget(); ?>
</div>