<div class="form">
   <?php $formPurchasesContractingProcedure = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-contracting-procedure-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/updateContractingProcedure', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATECONTRACTINGPROCEDURE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formPurchasesContractingProcedure->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formPurchasesContractingProcedure->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formPurchasesContractingProcedure->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>