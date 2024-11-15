<div class="form">
   <?php $formController = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-controller-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/updateController', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEDEVICE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formController->labelEx($oModelForm, 'name', array('style'=>'width:180px;')); ?>
               <?php echo $formController->textField($oModelForm, 'name', array('style'=>'width:180px;')); ?>
               <?php echo $formController->error($oModelForm, 'name', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formController->labelEx($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
               <?php echo $formController->textField($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
               <?php echo $formController->error($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formController->labelEx($oModelForm, 'mac', array('style'=>'width:180px;')); ?>
               <?php echo $formController->textField($oModelForm, 'mac', array('style'=>'width:180px;')); ?>
               <?php echo $formController->error($oModelForm, 'mac', array('style'=>'width:180px;')); ?>
            </div
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>