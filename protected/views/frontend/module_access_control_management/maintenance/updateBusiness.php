<div class="form">
   <?php $formBusiness = $this->beginWidget('CActiveForm', array(
      'id'=>'business-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/updateBusiness', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEBUSINESS_FORM_UPDATE_DESCRIPTION'); ?>
      </div>                    
      <div class="form_content">          
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formBusiness->labelEx($oModelForm, 'name', array('style'=>'width:400px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'name', array('style'=>'width:400px;')); ?>
               <?php echo $formBusiness->error($oModelForm, 'name', array('style'=>'width:400px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formBusiness->labelEx($oModelForm, 'nif', array('style'=>'width:180px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'nif', array('style'=>'width:180px;')); ?>
               <?php echo $formBusiness->error($oModelForm, 'nif', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formBusiness->labelEx($oModelForm, 'contact', array('style'=>'width:184px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'contact', array('style'=>'width:184px;')); ?>
               <?php echo $formBusiness->error($oModelForm, 'contact', array('style'=>'width:184px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">  
               <?php echo $formBusiness->labelEx($oModelForm, 'address', array('style'=>'width:400px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'address', array('style'=>'width:400px;')); ?>      
               <?php echo $formBusiness->error($oModelForm, 'address', array('style'=>'width:400px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">  
               <?php echo $formBusiness->labelEx($oModelForm, 'phone', array('style'=>'width:100px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'phone', array('style'=>'width:100px;')); ?>      
               <?php echo $formBusiness->error($oModelForm, 'phone', array('style'=>'width:100px;')); ?>
            </div>
            <div class="cell">  
               <?php echo $formBusiness->labelEx($oModelForm, 'fax', array('style'=>'width:100px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'fax', array('style'=>'width:100px;')); ?>      
               <?php echo $formBusiness->error($oModelForm, 'fax', array('style'=>'width:100px;')); ?>
            </div>
            <div class="cell">  
               <?php echo $formBusiness->labelEx($oModelForm, 'mail', array('style'=>'width:265px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'mail', array('style'=>'width:265px;')); ?>      
               <?php echo $formBusiness->error($oModelForm, 'mail', array('style'=>'width:265px;')); ?>
            </div>
            <div class="last_cell">  
               <?php echo $formBusiness->labelEx($oModelForm, 'www', array('style'=>'width:265px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'www', array('style'=>'width:265px;')); ?>      
               <?php echo $formBusiness->error($oModelForm, 'www', array('style'=>'width:265px;')); ?>
            </div>
         </div>
      </div> 
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>