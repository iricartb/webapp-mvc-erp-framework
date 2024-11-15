<div class="form">
   <?php $formFormContractingProcedure = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-contracting-procedure-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureStep1', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_content" style="height:270px">
      <div class="item-header">                                                                                                                                                                                                                                                                                            
         <div class="item-header-text" style="padding-top:0px">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURESTEP1_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date), '{2}'=>$oModelForm->owner))); ?>
         </div>          
      </div>
      <p>
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURESTEP1_DESCRIPTION'); ?>
      </p>
      
      <div class="first_row" style="height:130px;">
         <div class="last_cell">
            <?php echo $formFormContractingProcedure->labelEx($oModelForm, 'description', array('style'=>'width:680px;')); ?>  
            <?php echo $formFormContractingProcedure->textArea($oModelForm, 'description', array('style'=>'width:680px; height:100px')); ?>
            <?php echo $formFormContractingProcedure->error($oModelForm, 'description', array('style'=>'width:680px;')); ?>
         </div>
      </div>
    
      <br/><hr>
      <div style="text-align:right">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_NEXT_STEP'), array('class'=>'form_button_submit', 'style'=>'background-color:#007a9b; color:white; border-width:0px; padding:7px;', 'onmouseover'=>'this.style.backgroundColor = \'#008aab\'', 'onmouseout'=>'this.style.backgroundColor = \'#007a9b\'')); ?> 
      </div>
   </div> 

   <?php $this->endWidget(); ?>
</div>