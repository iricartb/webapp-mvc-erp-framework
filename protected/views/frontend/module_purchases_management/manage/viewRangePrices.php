<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/range_prices.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER_LINE_RANGE_PRICES')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWRANGEPRICES_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formPurchasesModuleParameters = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-module-parameters-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/manage/viewRangePrices'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
      
   <div class="form_content">
      <div class="first_row">
         <div class="cell">
            <?php echo $formPurchasesModuleParameters->labelEx($oModelForm, 'range_price_without_authorization', array('style'=>'width:150px;')); ?>
            <?php echo $formPurchasesModuleParameters->textField($oModelForm, 'range_price_without_authorization', array('style'=>'width:150px;')); ?>
            <?php echo $formPurchasesModuleParameters->error($oModelForm, 'range_price_without_authorization', array('style'=>'width:150px;')); ?>
         </div>
         <div class="cell">
            <?php echo $formPurchasesModuleParameters->labelEx($oModelForm, 'range_price_three_offers', array('style'=>'width:150px;')); ?>
            <?php echo $formPurchasesModuleParameters->textField($oModelForm, 'range_price_three_offers', array('style'=>'width:150px;')); ?>
            <?php echo $formPurchasesModuleParameters->error($oModelForm, 'range_price_three_offers', array('style'=>'width:150px;')); ?>
         </div>
         <div class="last_cell">
            <?php echo $formPurchasesModuleParameters->labelEx($oModelForm, 'range_price_tendering', array('style'=>'width:150px;')); ?>
            <?php echo $formPurchasesModuleParameters->textField($oModelForm, 'range_price_tendering', array('style'=>'width:150px;')); ?>
            <?php echo $formPurchasesModuleParameters->error($oModelForm, 'range_price_tendering', array('style'=>'width:150px;')); ?>
         </div>  
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formPurchasesModuleParameters->labelEx($oModelForm, 'range_price_provider_year', array('style'=>'width:150px;')); ?>
            <?php echo $formPurchasesModuleParameters->textField($oModelForm, 'range_price_provider_year', array('style'=>'width:150px;')); ?>
            <?php echo $formPurchasesModuleParameters->error($oModelForm, 'range_price_provider_year', array('style'=>'width:150px;')); ?>
         </div>
      </div> 
      <br/><hr/>
       
      <?php
      if (!Yii::app()->user->hasFlash('error')) { ?>
         <div class="row">
            <div style="color:#157D00; float:left; font-weight:bold;">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESMODULEPARAMETERS_FIELD_RANGEPRICECONTRACTINGPROCEDURE') . ':'; ?>
            </div>
            <div style="color:black; float:left;">
               <?php 
               $nPriceMaxWithoutAuthorization = 0;
               if ($oModelForm->range_price_three_offers > 0) $nPriceMaxWithoutAuthorization = $oModelForm->range_price_three_offers - 0.01; 
               
               echo '&nbsp;<= ' . FFormat::getFormatPrice($nPriceMaxWithoutAuthorization) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'); ?>
            </div>
         </div>
         <div class="row">
            <div style="color:#E37800; float:left; font-weight:bold;">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESMODULEPARAMETERS_FIELD_RANGEPRICETHREEOFFERS') . ':'; ?>
            </div>
            <div style="color:black; float:left;">
               <?php 
               $nPriceMaxThreeOffers = 0;
               if ($oModelForm->range_price_tendering > 0) $nPriceMaxThreeOffers = $oModelForm->range_price_tendering - 0.01; 
               
               echo '&nbsp;' . FFormat::getFormatPrice($oModelForm->range_price_three_offers) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') . FString::STRING_SPACE . '-' . FString::STRING_SPACE . FFormat::getFormatPrice($nPriceMaxThreeOffers) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'); ?>
            </div>
         </div>
         <div class="row">
            <div style="color:#B10000; float:left; font-weight:bold;">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESMODULEPARAMETERS_FIELD_RANGEPRICETENDERING') . ':'; ?>
            </div>
            <div style="color:black; float:left;">
               <?php echo '&nbsp;>= ' . FFormat::getFormatPrice($oModelForm->range_price_tendering) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'); ?>
            </div>
         </div>
      <?php 
      } ?>
   </div>
   
   <div class="row buttons">
      <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
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
} ?>