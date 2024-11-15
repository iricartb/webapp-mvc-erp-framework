<div class="form">
   <?php $formGroupForm = $this->beginWidget('CActiveForm', array(
      'id'=>'monitoring-group-form-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/manage/updateGroupForm', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_UPDATEGROUPFORM_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formGroupForm->labelEx($oModelForm, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formGroupForm->textField($oModelForm, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formGroupForm->error($oModelForm, 'name', array('style'=>'width:200px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formGroupForm->labelEx($oModelForm, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formGroupForm->textField($oModelForm, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formGroupForm->error($oModelForm, 'description', array('style'=>'width:350px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>