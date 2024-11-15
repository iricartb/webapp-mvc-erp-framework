<div class="form">
   <?php $formCredentialForm = $this->beginWidget('CActiveForm', array(
      'id'=>'credential-form',
      'action'=>$this->createUrl('frontend/site/updateCredentials'),
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formCredentialForm->labelEx($modelForm, 'passwd', array('style'=>'width:250px;')); ?> 
               <div class="cell">
                  <?php echo $formCredentialForm->passwordField($modelForm, 'passwd', array('style'=>'width:180px;', 'value'=>FString::STRING_EMPTY, 'maxlength'=>'12')); ?>
               </div> 
               <div class="last_cell">  
                  <?php echo $formCredentialForm->error($modelForm, 'passwd', array('style'=>'width:300px;')); ?>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">   
               <?php echo $formCredentialForm->labelEx($modelForm, 'sNewPasswd1', array('style'=>'width:250px;')); ?>
               <div class="cell">
                  <?php echo $formCredentialForm->passwordField($modelForm, 'sNewPasswd1', array('style'=>'width:180px;', 'maxlength'=>'12')); ?>
               </div>  
               <div class="last_cell">    
                  <?php echo $formCredentialForm->error($modelForm, 'sNewPasswd1', array('style'=>'width:300px;')); ?>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">  
               <?php echo $formCredentialForm->labelEx($modelForm, 'sNewPasswd2', array('style'=>'width:250px;')); ?>  
               <div class="cell">
                  <?php echo $formCredentialForm->passwordField($modelForm, 'sNewPasswd2', array('style'=>'width:180px;', 'maxlength'=>'12')); ?>
               </div>
               <div class="last_cell">    
                  <?php echo $formCredentialForm->error($modelForm, 'sNewPasswd2', array('style'=>'width:300px;')); ?> 
               </div>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>