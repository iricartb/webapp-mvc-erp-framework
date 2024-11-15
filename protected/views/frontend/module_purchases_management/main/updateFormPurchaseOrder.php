<?php
   $bAllowUpdateFormPurchaseOrderArticles = FModulePurchasesManagement::allowUpdateFormPurchaseOrderArticles($oModelForm->id);   
   $bAllowDeleteFormPurchaseOrderArticles = FModulePurchasesManagement::allowDeleteFormPurchaseOrderArticles($oModelForm->id);   
?>

<div class="form">
   <?php $formFormPurchaseOrder = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-purchase-order-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormPurchaseOrder', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>
   
   <div class="form_content_popup_modify"> 
   
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDER_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="cell_header"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDER_FORM_ORDER_HEADER_ARTICLES'); ?></div>
            
         <?php 
         $oPurchasesFormsPurchaseOrdersArticles = PurchasesFormsPurchaseOrdersArticles::getPurchasesFormsPurchasesOrdersArticlesByIdFormFK($oModelForm->id);
         if (count($oPurchasesFormsPurchaseOrdersArticles) > 0) {
            $nCurrentArticle = 1; 
            
            foreach($oPurchasesFormsPurchaseOrdersArticles as $oPurchasesFormPurchaseOrderArticle) {
               ?>
               <input type="hidden" name="PurchasesFormsPurchaseOrdersArticles[ID][<?php echo $nCurrentArticle; ?>]" value="<?php echo $oPurchasesFormPurchaseOrderArticle->id;?>">
               <div class="row">
                  <div class="cell">
                     <?php echo $formFormPurchaseOrder->labelEx($oPurchasesFormPurchaseOrderArticle, 'quantity', array('style'=>'width:60px;')); ?>
                     <?php echo $formFormPurchaseOrder->textField($oPurchasesFormPurchaseOrderArticle, 'quantity', array('name'=>'PurchasesFormsPurchaseOrdersArticles[quantity][' . $nCurrentArticle . ']', 'style'=>'width:60px;', 'disabled'=>!$bAllowUpdateFormPurchaseOrderArticles)); ?>
                     <?php echo $formFormPurchaseOrder->error($oPurchasesFormPurchaseOrderArticle, 'quantity', array('style'=>'width:60px;')); ?>
                  </div>
                  <div class="cell">
                     <?php echo $formFormPurchaseOrder->labelEx($oPurchasesFormPurchaseOrderArticle, 'description', array('style'=>'width:330px;')); ?>
                     <?php echo $formFormPurchaseOrder->textField($oPurchasesFormPurchaseOrderArticle, 'description', array('name'=>'PurchasesFormsPurchaseOrdersArticles[description][' . $nCurrentArticle . ']', 'style'=>'width:330px;', 'disabled'=>!$bAllowUpdateFormPurchaseOrderArticles)); ?>
                     <?php echo $formFormPurchaseOrder->error($oPurchasesFormPurchaseOrderArticle, 'description', array('style'=>'width:330px;')); ?>
                  </div>  
                  <div class="cell">
                     <?php echo $formFormPurchaseOrder->labelEx($oPurchasesFormPurchaseOrderArticle, 'requirements_date', array('style'=>'width:140px;')); ?>
                     <?php 
                        $sRequerimentsDate = FString::STRING_EMPTY;
                        if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrderArticle->requirements_date)) {
                           $sRequerimentsDate = FDate::getTimeZoneFormattedDate($oPurchasesFormPurchaseOrderArticle->requirements_date);
                        }
                     ?>
                     <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oPurchasesFormPurchaseOrderArticle, 'requirements_date', false, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, !$bAllowUpdateFormPurchaseOrderArticles, '140px', null, $sRequerimentsDate, FString::STRING_EMPTY, 'PurchasesFormsPurchaseOrdersArticles[requirements_date][' . $nCurrentArticle . ']')); ?>
                     <?php echo $formFormPurchaseOrder->error($oPurchasesFormPurchaseOrderArticle, 'requirements_date', array('style'=>'width:140px;')); ?>
                  </div>       
                  <div class="last_cell">
                     <?php echo $formFormPurchaseOrder->labelEx($oPurchasesFormPurchaseOrderArticle, 'price', array('style'=>'width:80px;')); ?>
                     <?php echo $formFormPurchaseOrder->textField($oPurchasesFormPurchaseOrderArticle, 'price', array('name'=>'PurchasesFormsPurchaseOrdersArticles[price][' . $nCurrentArticle . ']', 'style'=>'width:80px;', 'disabled'=>!$bAllowUpdateFormPurchaseOrderArticles)); ?>
                     <?php echo $formFormPurchaseOrder->error($oPurchasesFormPurchaseOrderArticle, 'price', array('style'=>'width:80px;')); ?>
                  </div>
               </div> 
               <div class="first_row">
                  <div class="cell" style="padding-left:94px">
                     <?php echo $formFormPurchaseOrder->labelEx($oPurchasesFormPurchaseOrderArticle, 'comments', array('style'=>'width:618px;')); ?>
                     <?php echo $formFormPurchaseOrder->textField($oPurchasesFormPurchaseOrderArticle, 'comments', array('name'=>'PurchasesFormsPurchaseOrdersArticles[comments][' . $nCurrentArticle . ']', 'style'=>'width:618px;', 'disabled'=>!$bAllowUpdateFormPurchaseOrderArticles)); ?>
                     <?php echo $formFormPurchaseOrder->error($oPurchasesFormPurchaseOrderArticle, 'comments', array('style'=>'width:618px;')); ?>
                  </div>
                  <div class="last_cell" style="vertical-align:top">
                     <?php
                     if ($bAllowDeleteFormPurchaseOrderArticles) { ?>
                        <a href="<?php echo Yii::app()->controller->createUrl("deleteFormPurchaseOrderArticle", array("nIdForm"=>$oPurchasesFormPurchaseOrderArticle->id, "nIdFormParent"=>$oPurchasesFormPurchaseOrderArticle->id_form_purchase_order))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                           <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" />
                        </a>
                     <?php
                     }
                     ?>
                  </div> 
               </div>
               <?php         
                  $nCurrentArticle++;
            }
         }

         if ($bAllowUpdateFormPurchaseOrderArticles) { ?>
            <div class="row">
               <div class="cell" style="padding-left:530px">
               </div>
               <div class="last_cell">
                  <?php
                  $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('createFormPurchaseOrderArticle', array('nIdForm'=>$oModelForm->id)) . '\'';  
                  echo FWidget::showIconImageButton('purchasesFormPurchaseOrdersArticles', 'document_new_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDER_NEW_BTN_DESCRIPTION'), $sAction);
                  ?>
               </div>
            </div>
         <?php
         }
         ?>
         <br/><hr>
         <div class="cell_header"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDER_FORM_ORDER_HEADER_ADVANCED'); ?></div>
         
         <div class="row">
            <div class="cell">
               <?php echo $formFormPurchaseOrder->labelEx($oModelForm, 'price', array('style'=>'width:100px;')); ?>
               <?php echo $formFormPurchaseOrder->textField($oModelForm, 'price', array('style'=>'width:100px;', 'disabled'=>true)); ?>
               <?php echo $formFormPurchaseOrder->error($oModelForm, 'price', array('style'=>'width:100px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formFormPurchaseOrder->labelEx($oModelForm, 'changes_price', array('style'=>'width:100px;')); ?>
               <?php echo $formFormPurchaseOrder->textField($oModelForm, 'changes_price', array('style'=>'width:100px;', 'disabled'=>!$bAllowUpdateFormPurchaseOrderArticles)); ?>
               <?php echo $formFormPurchaseOrder->error($oModelForm, 'changes_price', array('style'=>'width:100px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formFormPurchaseOrder->labelEx($oModelForm, 'changes_reason', array('style'=>'width:445px;')); ?>
               <?php echo $formFormPurchaseOrder->textField($oModelForm, 'changes_reason', array('style'=>'width:445px;', 'disabled'=>!$bAllowUpdateFormPurchaseOrderArticles)); ?>
               <?php echo $formFormPurchaseOrder->error($oModelForm, 'changes_reason', array('style'=>'width:445px;')); ?>
            </div>
         </div>
         
         <br/><hr>
         <div class="cell_header"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDER_FORM_ORDER_HEADER_INFORMATION'); ?></div>
             
         <div class="row">
            <div class="last_cell">
               <?php echo $formFormPurchaseOrder->labelEx($oModelForm, 'delivery', array('style'=>'width:435px;')); ?>      
               <?php echo $formFormPurchaseOrder->fileField($oModelForm, 'delivery', array('style'=>'width:435px;')); ?>      
               <?php echo $formFormPurchaseOrder->error($oModelForm, 'delivery', array('style'=>'width:435px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formFormPurchaseOrder->labelEx($oModelForm, 'send_method', array('style'=>'width:200px;')); ?>      
               <?php echo $formFormPurchaseOrder->textField($oModelForm, 'send_method', array('style'=>'width:200px;')); ?>      
               <?php echo $formFormPurchaseOrder->error($oModelForm, 'send_method', array('style'=>'width:200px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formFormPurchaseOrder->labelEx($oModelForm, 'payment_method', array('style'=>'width:200px;')); ?>
               <?php echo $formFormPurchaseOrder->dropDownList($oModelForm, 'payment_method', array(FModulePurchasesManagement::TYPE_PAYMENT_METHOD_30_DAYS=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_PAYMENTMETHOD_VALUE_30_DAYS'), FModulePurchasesManagement::TYPE_PAYMENT_METHOD_60_DAYS=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_PAYMENTMETHOD_VALUE_60_DAYS'), FModulePurchasesManagement::TYPE_PAYMENT_METHOD_90_DAYS=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_PAYMENTMETHOD_VALUE_90_DAYS'), FModulePurchasesManagement::TYPE_PAYMENT_METHOD_CASH=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_PAYMENTMETHOD_VALUE_CASH'), FModulePurchasesManagement::TYPE_PAYMENT_METHOD_TRANSFER=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_PAYMENTMETHOD_VALUE_TRANSFER')), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:200px;')); ?>
               <?php echo $formFormPurchaseOrder->error($oModelForm, 'payment_method', array('style'=>'width:200px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formFormPurchaseOrder->labelEx($oModelForm, 'comments', array('style'=>'width:600px;')); ?>      
               <?php echo $formFormPurchaseOrder->textArea($oModelForm, 'comments', array('style'=>'width:600px; height:70px')); ?>
               <?php echo $formFormPurchaseOrder->error($oModelForm, 'comments', array('style'=>'width:600px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formFormPurchaseOrder->labelEx($oModelForm, 'bPartialFinalized', array('style'=>'width:200px;')); ?>      
               <?php echo $formFormPurchaseOrder->checkBox($oModelForm, 'bPartialFinalized', array('style'=>'width:10px;')); ?>
               <?php echo $formFormPurchaseOrder->error($oModelForm, 'bPartialFinalized', array('style'=>'width:200px;')); ?>
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