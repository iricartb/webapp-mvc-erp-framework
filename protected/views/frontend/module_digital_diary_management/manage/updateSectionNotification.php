<div class="form">
   <?php $formSectionNotification = $this->beginWidget('CActiveForm', array(
      'id'=>'digitaldiary-section-notification-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/updateSectionNotification', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATESECTIONNOTIFICATION_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formSectionNotification->labelEx($oModelForm, 'id_section', array('style'=>'width:300px;')); ?>
               <?php echo $formSectionNotification->dropDownList($oModelForm, 'id_section', CHtml::listData(DigitalDiarySections::getDigitalDiarySections(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formSectionNotification->error($oModelForm, 'id_section', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formSectionNotification->labelEx($oModelForm, 'mail', array('style'=>'width:300px;')); ?>
               <?php echo $formSectionNotification->textField($oModelForm, 'mail', array('style'=>'width:300px;')); ?>
               <?php echo $formSectionNotification->error($oModelForm, 'mail', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formSectionNotification->labelEx($oModelForm, 'only_recv_urgent_events', array('style'=>'width:200px;')); ?>
               <?php echo $formSectionNotification->checkBox($oModelForm, 'only_recv_urgent_events', array('style'=>'width:10px;')); ?>
               <?php echo $formSectionNotification->error($oModelForm, 'only_recv_urgent_events', array('style'=>'width:200px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>