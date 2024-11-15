<div class="form">
   <?php $formRegion = $this->beginWidget('CActiveForm', array(
      'id'=>'region-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/updateRegion', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEREGION_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formRegion->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formRegion->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formRegion->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>