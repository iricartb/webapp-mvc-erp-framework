<div class="form">
   <?php $formSection = $this->beginWidget('CActiveForm', array(
      'id'=>'digitaldiary-section-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/updateSection', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATESECTION_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formSection->labelEx($oModelForm, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formSection->textField($oModelForm, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formSection->error($oModelForm, 'name', array('style'=>'width:200px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formSection->labelEx($oModelForm, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formSection->textField($oModelForm, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formSection->error($oModelForm, 'description', array('style'=>'width:350px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>