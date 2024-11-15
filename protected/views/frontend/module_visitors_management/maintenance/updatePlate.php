<div class="form">
   <?php $formPlate = $this->beginWidget('CActiveForm', array(
      'id'=>'visitors-plate-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/maintenance/updatePlate', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_UPDATEPLATE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formPlate->labelEx($oModelForm, 'plate', array('style'=>'width:180px;')); ?>
               <?php echo $formPlate->textField($oModelForm, 'plate', array('style'=>'width:180px;')); ?>
               <?php echo $formPlate->error($oModelForm, 'plate', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formPlate->labelEx($oModelForm, 'comments', array('style'=>'width:510px;')); ?>
               <?php echo $formPlate->textField($oModelForm, 'comments', array('style'=>'width:510px;')); ?>
               <?php echo $formPlate->error($oModelForm, 'comments', array('style'=>'width:510px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>