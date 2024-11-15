<div class="form">
   <?php $formProvider = $this->beginWidget('CActiveForm', array(
      'id'=>'provider-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/updateProvider', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEPROVIDER_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formProvider->labelEx($oModelForm, 'name', array('style'=>'width:395px;')); ?>
               <?php echo $oModelForm->name; ?>
               <?php echo $formProvider->error($oModelForm, 'name', array('style'=>'width:395px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formProvider->labelEx($oModelForm, 'nif', array('style'=>'width:180px;')); ?>
               <?php echo $oModelForm->nif; ?>
               <?php echo $formProvider->error($oModelForm, 'nif', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formProvider->labelEx($oModelForm, 'account', array('style'=>'width:180px;')); ?>
               <?php echo $oModelForm->account; ?>
               <?php echo $formProvider->error($oModelForm, 'account', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">  
               <?php echo $formProvider->labelEx($oModelForm, 'mail', array('style'=>'width:265px;')); ?>
               <?php echo $formProvider->textField($oModelForm, 'mail', array('style'=>'width:265px;')); ?>      
               <?php echo $formProvider->error($oModelForm, 'mail', array('style'=>'width:265px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>