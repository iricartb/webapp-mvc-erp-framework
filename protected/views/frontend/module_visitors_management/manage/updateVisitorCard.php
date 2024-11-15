<div class="form">
   <?php $formVisitorCard = $this->beginWidget('CActiveForm', array(
      'id'=>'visitor-card-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/manage/updateVisitorCard', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_UPDATEVISITORCARD_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="row">
            <div class="cell">
               <?php echo $formVisitorCard->labelEx($oModelForm, 'code', array('style'=>'width:392px;')); ?>
               <?php echo $formVisitorCard->textField($oModelForm, 'code', array('style'=>'width:392px;')); ?>
               <?php echo $formVisitorCard->error($oModelForm, 'code', array('style'=>'width:392px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>