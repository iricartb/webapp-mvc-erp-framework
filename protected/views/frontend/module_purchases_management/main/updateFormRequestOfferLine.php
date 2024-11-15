<?php
   $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
?>

<div class="form">
   <?php $formFormRequestOfferLine = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-request-offer-line-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormRequestOfferLine', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFERLINE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formFormRequestOfferLine->labelEx($oModelForm, 'offer', array('style'=>'width:300px;')); ?>      
               <?php echo $formFormRequestOfferLine->fileField($oModelForm, 'offer', array('style'=>'width:300px;')); ?>      
               <?php echo $formFormRequestOfferLine->error($oModelForm, 'offer', array('style'=>'width:300px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formFormRequestOfferLine->labelEx($oModelForm, 'price', array('style'=>'width:200px;')); ?>      
               <?php echo $formFormRequestOfferLine->textField($oModelForm, 'price', array('style'=>'width:200px;')) . ' < ' . $oPurchasesModuleParameters->range_price_three_offers . FString::STRING_SPACE . yii::t('system', 'SYS_EUR'); ?>      
               <?php echo $formFormRequestOfferLine->error($oModelForm, 'price', array('style'=>'width:200px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>

<?php
if ((Yii::app()->user->hasFlash('success')) || (Yii::app()->user->hasFlash('error'))) { ?>
   <?php if (Yii::app()->user->hasFlash('success')) { ?>
      <div class="flash-success">
         <?php echo Yii::app()->user->getFlash('success'); ?>
      </div> 
   <?php } else if (Yii::app()->user->hasFlash('notice')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice'); ?>
      </div>   
   <?php } else { ?>
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error'); ?>
      </div>
   <?php }
}
?>