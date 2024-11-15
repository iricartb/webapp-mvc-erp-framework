<div class="form">
   <?php $formComponent = $this->beginWidget('CActiveForm', array(
      'id'=>'component-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/updateComponent', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATECOMPONENT_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formComponent->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formComponent->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formComponent->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>