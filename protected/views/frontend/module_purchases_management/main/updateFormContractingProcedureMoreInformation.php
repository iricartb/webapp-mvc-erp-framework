<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/forms_contracting_procedure.png' ?>" />
   </div>                                                                                                                                                                                                                                                                                                   
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date), '{2}'=>$oModelForm->owner, '{3}'=>$oModelForm->contracting_procedure_expedient))); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_DESCRIPTION'); ?>
</div>

<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureGeneral', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_GENERAL'); ?>
</div>
<div class="tab_button tab_active"> 
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_MORE_INFORMATION'); ?>
</div>
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureDocumentation', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_DOCUMENTATION'); ?>
</div>
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureRecords', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_RECORDS'); ?>
</div> 
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureNotifications', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_NOTIFICATIONS'); ?>
</div>
<div class="form">
   <?php $formFormContractingProcedure = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-contracting-procedure-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureMoreInformation', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_content container_tab">
      <div class="first_row">
         <div class="last_cell">
            <?php echo $formFormContractingProcedure->labelEx($oModelForm, 'contracting_procedure_service', array('style'=>'width:625px;')); ?>  
            <?php echo $formFormContractingProcedure->textField($oModelForm, 'contracting_procedure_service', array('style'=>'width:625px;')); ?>
            <?php echo $formFormContractingProcedure->error($oModelForm, 'contracting_procedure_service', array('style'=>'width:625px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormContractingProcedure->labelEx($oModelForm, 'contracting_procedure_comments', array('style'=>'width:625px;')); ?>  
            <?php echo $formFormContractingProcedure->textArea($oModelForm, 'contracting_procedure_comments', array('style'=>'width:625px; height:100px')); ?>
            <?php echo $formFormContractingProcedure->error($oModelForm, 'contracting_procedure_comments', array('style'=>'width:625px;')); ?>
         </div>
      </div>
   </div> 
   <div class="row buttons">
      <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
   </div>     
     
   <?php $this->endWidget(); ?>
</div>