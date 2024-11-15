<div class="form">
   <?php $formPurchasesDocumentContractingProcedure = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-document-contracting-procedure-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/updateDocumentContractingProcedure', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEDOCUMENTCONTRACTINGPROCEDURE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formPurchasesDocumentContractingProcedure->labelEx($oModelForm, 'type', array('style'=>'width:120px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->textField($oModelForm, 'type', array('style'=>'width:120px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->error($oModelForm, 'type', array('style'=>'width:120px;')); ?>   
            </div>
            <div class="cell">
               <?php echo $formPurchasesDocumentContractingProcedure->labelEx($oModelForm, 'description', array('style'=>'width:250px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->textField($oModelForm, 'description', array('style'=>'width:250px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->error($oModelForm, 'description', array('style'=>'width:250px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formPurchasesDocumentContractingProcedure->labelEx($oModelForm, 'folder', array('style'=>'width:250px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->textField($oModelForm, 'folder', array('style'=>'width:250px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->error($oModelForm, 'folder', array('style'=>'width:250px;')); ?>   
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>