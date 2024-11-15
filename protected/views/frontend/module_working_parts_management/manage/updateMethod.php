<div class="form">
   <?php $formMethod = $this->beginWidget('CActiveForm', array(
      'id'=>'method-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/updateMethod', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_content_popup_modify" >
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEMETHOD_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formMethod->labelEx($oModelForm, 'code', array('style'=>'width:180px;')); ?>
               <?php echo $formMethod->textField($oModelForm, 'code', array('style'=>'width:180px;')); ?>
               <?php echo $formMethod->error($oModelForm, 'code', array('style'=>'width:360px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formMethod->labelEx($oModelForm, 'description', array('style'=>'width:180px;')); ?>
               <?php echo $formMethod->textArea($oModelForm, 'description', array('style'=>'width:630px; height:40px; overflow:auto; resize:none')); ?>
               <?php echo $formMethod->error($oModelForm, 'description', array('style'=>'width:360px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formMethod->labelEx($oModelForm, 'visible_working_part', array('style'=>'width:140px;')); ?>
               <?php echo $formMethod->checkBox($oModelForm, 'visible_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formMethod->error($oModelForm, 'visible_working_part', array('style'=>'width:140px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formMethod->labelEx($oModelForm, 'visible_maintenance_working_part', array('style'=>'width:160px;')); ?>
               <?php echo $formMethod->checkBox($oModelForm, 'visible_maintenance_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formMethod->error($oModelForm, 'visible_maintenance_working_part', array('style'=>'width:160px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formMethod->labelEx($oModelForm, 'visible_special_working_part', array('style'=>'width:140px;')); ?>
               <?php echo $formMethod->checkBox($oModelForm, 'visible_special_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formMethod->error($oModelForm, 'visible_special_working_part', array('style'=>'width:140px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>
     
   <?php $this->endWidget(); ?>
</div>