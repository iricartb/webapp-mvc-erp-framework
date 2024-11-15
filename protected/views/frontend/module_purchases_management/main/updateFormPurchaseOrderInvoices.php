<?php
if ($oModelForm->status != FModulePurchasesManagement::STATUS_FINALIZED) {
   $bAllowUpdate = true;
} 
else $bAllowUpdate = false;

if ($oModelForm->status == FModulePurchasesManagement::STATUS_PARTIAL_FINALIZED) {
   $bAllowFinalized = true;
}
else $bAllowFinalized = false;
?>

<script type="text/javascript">
   function jsRefreshPrice(nInvoice) {
      document.getElementById('PurchasesFormsPurchaseOrdersInvoices_price_' + nInvoice).value = parseFloat(document.getElementById('PurchasesFormsPurchaseOrdersInvoices_base_' + nInvoice).value) + parseFloat(document.getElementById('PurchasesFormsPurchaseOrdersInvoices_iva_' + nInvoice).value);      
   }
</script>

<div class="form">
   <?php $formFormPurchaseOrderInvoices = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-purchase-order-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormPurchaseOrderInvoices', array('nIdForm'=>$oModelForm->id)),
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
         
   <div class="form_content_popup_modify">
   
      <?php
      if ($bAllowUpdate) { 
         $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('createFormPurchaseOrderInvoice', array('nIdForm'=>$oModelForm->id)) . '\'';  
         echo FWidget::showIconImageButton('purchasesFormPurchaseOrdersInvoices', 'document_new_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDERINVOICES_NEW_BTN_DESCRIPTION'), $sAction);
         ?>
         <br/>
      <?php
      }
      ?>

      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDERINVOICES_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <?php
         if ((!FString::isNullOrEmpty($oModelForm->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oModelForm->offer))) { 
            echo '<b>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_OFFER') . '</b>: <a href="' . Yii::app()->controller->createUrl("viewAttachmentOfferFormPurchaseOrder", array("nIdForm"=>$oModelForm->id)) . '">' . Yii::t('system', 'SYS_DOWNLOAD_DOCUMENT') . '</a><br/><br/>';
         }    
         
         if ((!FString::isNullOrEmpty($oModelForm->order)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_ORDERS . $oModelForm->order))) { 
            echo '<b>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_ORDER') . '</b>: <a href="' . Yii::app()->controller->createUrl("viewAttachmentOrderFormPurchaseOrder", array("nIdForm"=>$oModelForm->id)) . '">' . Yii::t('system', 'SYS_DOWNLOAD_DOCUMENT') . '</a><br/><br/>';
         }   
         
         if ((!FString::isNullOrEmpty($oModelForm->delivery)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_DELIVERIES . $oModelForm->delivery))) { 
            echo '<b>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_DELIVERY') . '</b>: <a href="' . Yii::app()->controller->createUrl("viewAttachmentDeliveryFormPurchaseOrder", array("nIdForm"=>$oModelForm->id)) . '">' . Yii::t('system', 'SYS_DOWNLOAD_DOCUMENT') . '</a><br/><br/>';
         }     
         ?> 
         <hr>
         
         <?php 
         $oPurchasesFormsPurchaseOrdersArticles = PurchasesFormsPurchaseOrdersArticles::getPurchasesFormsPurchasesOrdersArticlesByIdFormFK($oModelForm->id);
         if (count($oPurchasesFormsPurchaseOrdersArticles) > 0) {
            $nCurrentArticle = 1;
            
            foreach($oPurchasesFormsPurchaseOrdersArticles as $oPurchasesFormPurchaseOrderArticle) {
               ?>
               <input type="hidden" name="PurchasesFormsPurchaseOrdersArticles[ID][<?php echo $nCurrentArticle; ?>]" value="<?php echo $oPurchasesFormPurchaseOrderArticle->id;?>">
               <div class="row">
                  <div class="cell">
                     <?php echo $formFormPurchaseOrderInvoices->labelEx($oPurchasesFormPurchaseOrderArticle, 'quantity', array('style'=>'width:60px;')); ?>
                     <?php echo $formFormPurchaseOrderInvoices->textField($oPurchasesFormPurchaseOrderArticle, 'quantity', array('name'=>'PurchasesFormsPurchaseOrdersArticles[quantity][' . $nCurrentArticle . ']', 'style'=>'width:60px;', 'disabled'=>'disabled')); ?>
                     <?php echo $formFormPurchaseOrderInvoices->error($oPurchasesFormPurchaseOrderArticle, 'quantity', array('style'=>'width:60px;')); ?>
                  </div>
                  <div class="cell">
                     <?php echo $formFormPurchaseOrderInvoices->labelEx($oPurchasesFormPurchaseOrderArticle, 'description', array('style'=>'width:350px;')); ?>
                     <?php echo $formFormPurchaseOrderInvoices->textField($oPurchasesFormPurchaseOrderArticle, 'description', array('name'=>'PurchasesFormsPurchaseOrdersArticles[description][' . $nCurrentArticle . ']', 'style'=>'width:350px;', 'disabled'=>'disabled')); ?>
                     <?php echo $formFormPurchaseOrderInvoices->error($oPurchasesFormPurchaseOrderArticle, 'description', array('style'=>'width:350px;')); ?>
                  </div>  
                  <div class="cell">
                     <?php echo $formFormPurchaseOrderInvoices->labelEx($oPurchasesFormPurchaseOrderArticle, 'requirements_date', array('style'=>'width:125px;')); ?>
                     <?php 
                        $sRequerimentsDate = FString::STRING_EMPTY;
                        if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrderArticle->requirements_date)) {
                           $sRequerimentsDate = FDate::getTimeZoneFormattedDate($oPurchasesFormPurchaseOrderArticle->requirements_date);
                        }
                     ?>
                     <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oPurchasesFormPurchaseOrderArticle, 'requirements_date', false, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, true, true, '125px', null, $sRequerimentsDate)); ?>
                     <?php echo $formFormPurchaseOrderInvoices->error($oPurchasesFormPurchaseOrderArticle, 'requirements_date', array('style'=>'width:125px;')); ?>
                  </div>       
                  <div class="cell">
                     <?php echo $formFormPurchaseOrderInvoices->labelEx($oPurchasesFormPurchaseOrderArticle, 'price', array('style'=>'width:80px;')); ?>
                     <?php echo $formFormPurchaseOrderInvoices->textField($oPurchasesFormPurchaseOrderArticle, 'price', array('name'=>'PurchasesFormsPurchaseOrdersArticles[price][' . $nCurrentArticle . ']', 'style'=>'width:80px;', 'disabled'=>'disabled')); ?>
                     <?php echo $formFormPurchaseOrderInvoices->error($oPurchasesFormPurchaseOrderArticle, 'price', array('style'=>'width:80px;')); ?>
                  </div>
                  <div class="last_cell" style="vertical-align:middle">
                     <?php 
                     if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrderArticle->comments)) { ?>
                        <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'caution_alert_1.png';?>" title="<?php echo $oPurchasesFormPurchaseOrderArticle->comments; ?>"/>
                     <?php
                     }
                     ?>
                  </div>
               </div> 
               <?php
                  $nCurrentArticle++;
            }
            ?>
            <br/><hr>
            <?php
         }
         ?>

         <?php 
         $nTotalSumInvoices = 0;
         $oPurchasesFormsPurchaseOrdersInvoices = PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersInvoicesByIdFormFK($oModelForm->id);
         if (count($oPurchasesFormsPurchaseOrdersInvoices) > 0) {
            $nCurrentInvoice = 1;
            foreach($oPurchasesFormsPurchaseOrdersInvoices as $oPurchasesFormPurchaseOrderInvoice) {
               ?>
               <input type="hidden" name="PurchasesFormsPurchaseOrdersInvoices[ID][<?php echo $nCurrentInvoice; ?>]" value="<?php echo $oPurchasesFormPurchaseOrderInvoice->id;?>">
               
               <div class="row">
                  <div class="cell">
                     <?php echo $formFormPurchaseOrderInvoices->labelEx($oPurchasesFormPurchaseOrderInvoice, 'number', array('style'=>'width:125px;')); ?>
                     <?php echo $formFormPurchaseOrderInvoices->textField($oPurchasesFormPurchaseOrderInvoice, 'number', array('name'=>'PurchasesFormsPurchaseOrdersInvoices[number][' . $nCurrentInvoice . ']', 'style'=>'width:125px;')); ?>
                     <?php echo $formFormPurchaseOrderInvoices->error($oPurchasesFormPurchaseOrderInvoice, 'number', array('style'=>'width:125px;')); ?>
                  </div>
                  <div class="cell">
                     <?php echo $formFormPurchaseOrderInvoices->labelEx($oPurchasesFormPurchaseOrderInvoice, 'date', array('style'=>'width:90px;')); ?>
                     <?php 
                     if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrderInvoice->date)) {
                        $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oPurchasesFormPurchaseOrderInvoice, 'date', false,  FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '90px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate($oPurchasesFormPurchaseOrderInvoice->date), $nCurrentInvoice, 'PurchasesFormsPurchaseOrdersInvoices[date][' . $nCurrentInvoice . ']'));
                     }
                     else {
                        $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oPurchasesFormPurchaseOrderInvoice, 'date', false, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '90px', FString::STRING_EMPTY, FString::STRING_EMPTY, $nCurrentInvoice, 'PurchasesFormsPurchaseOrdersInvoices[date][' . $nCurrentInvoice . ']'));
                     } ?>
                     <?php echo $formFormPurchaseOrderInvoices->error($oPurchasesFormPurchaseOrderInvoice, 'date', array('style'=>'width:90px;')); ?>
                  </div>
                  <div class="cell">
                     <?php echo $formFormPurchaseOrderInvoices->labelEx($oPurchasesFormPurchaseOrderInvoice, 'base', array('style'=>'width:90px;')); ?>
                     <?php
                     if ($bAllowUpdate) {
                        echo $formFormPurchaseOrderInvoices->textField($oPurchasesFormPurchaseOrderInvoice, 'base', array('name'=>'PurchasesFormsPurchaseOrdersInvoices[base][' . $nCurrentInvoice . ']', 'style'=>'width:90px;', 'onchange'=>'jsRefreshPrice(' . $nCurrentInvoice . ');')); 
                     }
                     else {
                       echo $formFormPurchaseOrderInvoices->textField($oPurchasesFormPurchaseOrderInvoice, 'base', array('name'=>'PurchasesFormsPurchaseOrdersInvoices[base][' . $nCurrentInvoice . ']', 'style'=>'width:90px; background-color:#ddd', 'readonly'=>true)); 
                     }
                     ?>
                     <?php echo $formFormPurchaseOrderInvoices->error($oPurchasesFormPurchaseOrderInvoice, 'base', array('style'=>'width:90px;')); ?>
                  </div>
                  <div class="cell">
                     <?php echo $formFormPurchaseOrderInvoices->labelEx($oPurchasesFormPurchaseOrderInvoice, 'iva', array('style'=>'width:90px;')); ?>
                     <?php
                     if ($bAllowUpdate) {
                        echo $formFormPurchaseOrderInvoices->textField($oPurchasesFormPurchaseOrderInvoice, 'iva', array('name'=>'PurchasesFormsPurchaseOrdersInvoices[iva][' . $nCurrentInvoice . ']', 'style'=>'width:90px;', 'onchange'=>'jsRefreshPrice(' . $nCurrentInvoice . ');')); 
                     }
                     else {
                       echo $formFormPurchaseOrderInvoices->textField($oPurchasesFormPurchaseOrderInvoice, 'iva', array('name'=>'PurchasesFormsPurchaseOrdersInvoices[iva][' . $nCurrentInvoice . ']', 'style'=>'width:90px; background-color:#ddd', 'readonly'=>true)); 
                     }
                     ?>
                     <?php echo $formFormPurchaseOrderInvoices->error($oPurchasesFormPurchaseOrderInvoice, 'iva', array('style'=>'width:90px;')); ?>
                  </div>
                  <div class="cell">
                     <?php echo $formFormPurchaseOrderInvoices->labelEx($oPurchasesFormPurchaseOrderInvoice, 'price', array('style'=>'width:90px;')); ?>
                     <?php echo $formFormPurchaseOrderInvoices->textField($oPurchasesFormPurchaseOrderInvoice, 'price', array('name'=>'PurchasesFormsPurchaseOrdersInvoices[price][' . $nCurrentInvoice . ']', 'style'=>'width:90px; background-color:#ddd', 'readonly'=>true)); ?>
                     <?php echo $formFormPurchaseOrderInvoices->error($oPurchasesFormPurchaseOrderInvoice, 'price', array('style'=>'width:90px;')); ?>
                  </div>
                  <div class="cell">
                     <?php echo $formFormPurchaseOrderInvoices->labelEx($oPurchasesFormPurchaseOrderInvoice, 'paid', array('style'=>'width:64px;')); ?>
                     <?php echo $formFormPurchaseOrderInvoices->checkBox($oPurchasesFormPurchaseOrderInvoice, 'paid', array('name'=>'PurchasesFormsPurchaseOrdersInvoices[paid][' . $nCurrentInvoice . ']', 'style'=>'width:10px;')); ?>
                     <?php echo $formFormPurchaseOrderInvoices->error($oPurchasesFormPurchaseOrderInvoice, 'paid', array('style'=>'width:64px;')); ?>
                  </div>
                  <div class="last_cell" style="vertical-align:middle">
                     <?php
                     if ($bAllowUpdate) { ?>
                        <a href="<?php echo Yii::app()->controller->createUrl("deleteFormPurchaseOrderInvoice", array("nIdForm"=>$oPurchasesFormPurchaseOrderInvoice->id, "nIdFormParent"=>$oPurchasesFormPurchaseOrderInvoice->id_form_purchase_order))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                           <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" />
                        </a>
                     <?php
                     }
                     ?>
                  </div>
               </div>
               
               <?php
               if ($nCurrentInvoice < count($oPurchasesFormsPurchaseOrdersInvoices)) { ?>
                  <br/><hr>
               <?php } 
               $nCurrentInvoice++;
               
               $nTotalSumInvoices += $oPurchasesFormPurchaseOrderInvoice->base; 
            }
            ?>
            <br/><hr>
            <?php
         }
         ?> 
         
         <div class="row">
            <div class="last_cell">
               <?php 
               if (round($oModelForm->price - $nTotalSumInvoices, 2) >= 0) echo FFormat::getFormatPrice($oModelForm->price) . ' - ' . FFormat::getFormatPrice($nTotalSumInvoices) . ' = <font color="green"><b>' . FFormat::getFormatPrice(round($oModelForm->price - $nTotalSumInvoices, 2)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') . ' (' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDERINVOICES_PENDING_PAID') . ')</b></font> ';
               else echo FFormat::getFormatPrice($oModelForm->price) . ' - ' . FFormat::getFormatPrice($nTotalSumInvoices) . ' = <font color="red"><b>' .  FFormat::getFormatPrice(round($oModelForm->price - $nTotalSumInvoices, 2)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') . ' (' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDERINVOICES_PENDING_PAID') . ')</b></font> '; ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo '<b>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_FINALIZED') . FString::STRING_SPACE . '(<font color="red">' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDERINVOICES_FORM_FINALIZED_ALERT') . '</font>)</b><br/>'; ?>      
               <?php echo $formFormPurchaseOrderInvoices->checkBox($oModelForm, 'bFinalized', array('style'=>'width:10px;', 'disabled'=>((!$bAllowFinalized) || (count($oPurchasesFormsPurchaseOrdersInvoices) == 0)))); ?>
               <?php echo $formFormPurchaseOrderInvoices->error($oModelForm, 'bFinalized', array('style'=>'width:200px;')); ?>
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