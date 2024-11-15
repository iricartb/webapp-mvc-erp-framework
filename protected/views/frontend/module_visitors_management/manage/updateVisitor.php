<div class="form">
   <?php $formVisitor = $this->beginWidget('CActiveForm', array(
      'id'=>'visitor-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/manage/updateVisitor', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_UPDATEVISITOR_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'business', array('style'=>'width:392px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'business', array('style'=>'width:392px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'business', array('style'=>'width:392px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'comments', array('style'=>'width:392px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'comments', array('style'=>'width:392px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'comments', array('style'=>'width:392px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>