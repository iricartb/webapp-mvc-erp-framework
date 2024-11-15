<div class="form">
   <?php $formIncidence = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-incidence-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/updateIncidence', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEINCIDENCE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formIncidence->labelEx($oModelForm, 'code', array('style'=>'width:180px;')); ?>
               <?php echo $formIncidence->textField($oModelForm, 'code', array('style'=>'width:180px;')); ?>
               <?php echo $formIncidence->error($oModelForm, 'code', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formIncidence->labelEx($oModelForm, 'description', array('style'=>'width:392px;')); ?>
               <?php echo $formIncidence->textField($oModelForm, 'description', array('style'=>'width:392px;')); ?>
               <?php echo $formIncidence->error($oModelForm, 'description', array('style'=>'width:392px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>