<div class="form">
   <?php $formDailyNotification = $this->beginWidget('CActiveForm', array(
      'id'=>'digitaldiary-daily-notification-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/updateDailyNotification', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEDAILYNOTIFICATION_FORM_UPDATE_DESCRIPTION'); ?>
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
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>