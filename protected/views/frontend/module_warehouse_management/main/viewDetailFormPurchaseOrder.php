<div class="row_emphasis" style="background-color:<?php echo '#' . FModulePurchasesManagement::HEADER_MAIN_COLOR;?>">
   <div style="display:table-cell">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/forms_purchase_orders.png'; ?>" width="32px">
   </div>
   <div style="display:table-cell; padding-left:5px; vertical-align:middle;">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMPURCHASEORDER_HEADER', array('{1}'=>$oModelForm->id))); ?>   
   </div>
</div>

<div style="padding-top:10px"></div>

<?php 
$this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'id',
      ),
      array(
         'name'=>'owner',
      ),
      array(
         'name'=>'user_accept',
      ),
      array(
         'name'=>'department',
         'value'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oModelForm->department),
      ),
      array(
         'name'=>'description',
      ),
      array(
         'name'=>'id_financial_cost_line',
         'value'=>PurchasesFinancialCostsLines::getPurchasesFinancialCostLineFullDescription($oModelForm->id_financial_cost_line, false),
      ),
      array(
         'name'=>'id_provider',
         'value'=>Providers::getProviderName($oModelForm->id_provider),
      ),
      array(
         'name'=>'price',
         'value'=>($oModelForm->price >= 0) ? FFormat::getFormatPrice($oModelForm->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'send_method',
      ),
      array(
         'name'=>'payment_method',
      ),
      array(
         'name'=>'notify_date',
         'value'=>(!is_null($oModelForm->notify_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->notify_date, true) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'accept_date',
         'value'=>(!FString::isNullOrEmpty($oModelForm->accept_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->accept_date, true) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'type',
         'value'=>(strlen(FModulePurchasesManagement::getTypeFormRequestOffer($oModelForm->id_form_request_offer)) > 0) ? Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_TYPE_VALUE_' . FModulePurchasesManagement::getTypeFormRequestOffer($oModelForm->id_form_request_offer)) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'offer',
         'type'=>'raw',
         'value'=>((!FString::isNullOrEmpty($oModelForm->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oModelForm->offer))) ? '<a href="' . Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . "/main/viewAttachmentOfferFormPurchaseOrder", array("nIdForm"=>$oModelForm->id)) . '">' . Yii::t('system', 'SYS_DOWNLOAD_DOCUMENT') . '</a>' : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'order',
         'type'=>'raw',
         'value'=>((!FString::isNullOrEmpty($oModelForm->order)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_ORDERS . $oModelForm->order))) ? '<a href="' . Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . "/main/viewAttachmentOrderFormPurchaseOrder", array("nIdForm"=>$oModelForm->id)) . '">' . Yii::t('system', 'SYS_DOWNLOAD_DOCUMENT') . '</a>' : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'delivery',
         'type'=>'raw',
         'value'=>((!FString::isNullOrEmpty($oModelForm->delivery)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_DELIVERIES . $oModelForm->delivery))) ? '<a href="' . Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . "/main/viewAttachmentDeliveryFormPurchaseOrder", array("nIdForm"=>$oModelForm->id)) . '">' . Yii::t('system', 'SYS_DOWNLOAD_DOCUMENT') . '</a>' : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'comments',
         'value'=>FString::getAbbreviationSentence($oModelForm->comments, 256, 25),
      ),
      array(
         'name'=>'id_form_request_offer',
         'value'=>$oModelForm->id_form_request_offer,
      ),
      array(
         'name'=>'status',
         'type'=>'raw',
         'value'=>($oModelForm->status == FModulePurchasesManagement::STATUS_PARTIAL_FINALIZED) ? '<b><font style="color:' . FModulePurchasesManagement::COLOR_STATUS_PARTIAL_FINALIZED . '">' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_STATUS_VALUE_PARTIAL_FINALIZED') . '</font></b>' : (($oModelForm->status == FModulePurchasesManagement::STATUS_FINALIZED) ? '<b><font style="color:' . FModulePurchasesManagement::COLOR_STATUS_FINALIZED . '">' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_STATUS_VALUE_FINALIZED') . '</font></b>' : '<b><font style="color:' . eval('return FModulePurchasesManagement::COLOR_STATUS_' . eval('return strtoupper(FModulePurchasesManagement::getStatusFormPurchaseOrderWarehouseReception(' . $oModelForm->id . '));') . ';') . '">' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_STATUS_VALUE_' . strtoupper(FModulePurchasesManagement::getStatusFormPurchaseOrderWarehouseReception($oModelForm->id)))) . '</font></b>',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>

<?php
$oPurchasesFormsPurchaseOrdersArticles = PurchasesFormsPurchaseOrdersArticles::getPurchasesFormsPurchasesOrdersArticlesByIdFormFK($oModelForm->id);
if (count($oPurchasesFormsPurchaseOrdersArticles) > 0) { ?>
   <div style="padding-top:10px"></div>
   
   <div style="margin-left:100px;">
   <?php    
   foreach($oPurchasesFormsPurchaseOrdersArticles as $oPurchasesFormPurchaseOrderArticle) {
      $sSentencePrice = FString::STRING_SPACE;
      if ($oPurchasesFormPurchaseOrderArticle->price >= 0) $sSentencePrice = ' (' . $oPurchasesFormPurchaseOrderArticle->quantity . ' x ' . FFormat::getFormatPrice($oPurchasesFormPurchaseOrderArticle->price, false, true) . ' = ' . FFormat::getFormatPrice($oPurchasesFormPurchaseOrderArticle->price * $oPurchasesFormPurchaseOrderArticle->quantity) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') . ')';
      
      $this->widget('zii.widgets.CDetailView', array(
         'data'=>$oPurchasesFormPurchaseOrderArticle,
         'attributes'=>array(
            array(
               'label'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMPURCHASEORDER_ARTICLE_NAME'),
               'value'=>$oPurchasesFormPurchaseOrderArticle->quantity . FString::STRING_SPACE . $oPurchasesFormPurchaseOrderArticle->description . $sSentencePrice,
            ),
         ),
         'nullDisplay'=>FString::STRING_EMPTY,
      ));  
   }
   ?>
   </div>
   <?php
}
?>       

<?php
$oPurchasesFormsPurchaseOrdersInvoices = PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersInvoicesByIdFormFK($oModelForm->id);
if (count($oPurchasesFormsPurchaseOrdersInvoices) > 0) { ?>
   <div style="padding-top:10px"></div>
   
   <div style="margin-left:100px;">
   <?php    
   foreach($oPurchasesFormsPurchaseOrdersInvoices as $oPurchasesFormPurchaseOrderInvoice) {
      $sPurchasesFormPurchaseOrderInvoicePaid = FString::STRING_EMPTY;
      if ($oPurchasesFormPurchaseOrderInvoice->paid) $sPurchasesFormPurchaseOrderInvoicePaid = FString::STRING_SPACE . '<font color="green">[ ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSINVOICES_FIELD_PAID') . ' ]</font>';

      $this->widget('zii.widgets.CDetailView', array(
         'data'=>$oPurchasesFormPurchaseOrderInvoice,
         'attributes'=>array(
            array(
               'label'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMPURCHASEORDER_INVOICE_NAME'),
               'type'=>'raw',
               'value'=>$oPurchasesFormPurchaseOrderInvoice->number . ': ' . FString::STRING_SPACE . FFormat::getFormatPrice($oPurchasesFormPurchaseOrderInvoice->base) . FString::STRING_SPACE . '+' . FString::STRING_SPACE . FFormat::getFormatPrice($oPurchasesFormPurchaseOrderInvoice->iva) . FString::STRING_SPACE . '=' . FString::STRING_SPACE . FFormat::getFormatPrice($oPurchasesFormPurchaseOrderInvoice->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') . $sPurchasesFormPurchaseOrderInvoicePaid,
            ),
         ),
         'nullDisplay'=>FString::STRING_EMPTY,
      ));  
   }
   ?>
   </div>
   <?php
}    
?> 
 
<?php 
if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WAREHOUSE_MANAGEMENT)) {
   $oWarehouseFormsInputs = WarehouseFormsInputs::getWarehouseFormsInputs(true, null, $oModelForm->id);

   if (count($oWarehouseFormsInputs) > 0) { ?>
      <div style="padding-top:10px"></div>
      
      <div class="row_emphasis" style="margin-top:20px; background-color:<?php echo '#' . FModulePurchasesManagement::HEADER_MAIN_COLOR;?>">
         <div style="display:table-cell">
            <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/warehouse.png'; ?>" width="32px">
         </div>
         <div style="display:table-cell; padding-left:5px; vertical-align:middle;">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMPURCHASEORDER_WAREHOUSE_HEADER')); ?>   
         </div>
      </div>

      <div style="padding-top:10px"></div> 

      <?php    
      foreach($oWarehouseFormsInputs as $oWarehouseFormInput) {  
         $oWarehouseFormInputArticles = WarehouseFormInputArticles::getWarehouseFormInputArticlesByIdFormFK($oWarehouseFormInput->id);
                                               
         if ($oWarehouseFormInput->status == FModuleWarehouseManagement::STATUS_SUCCESS) {              
            $sColorStatus = 'green';
         }
         else if ($oWarehouseFormInput->status == FModuleWarehouseManagement::STATUS_ALERT) {      
            $sColorStatus = 'orange';
         }
         else {
            $sColorStatus = 'red';
         }

         $this->widget('zii.widgets.CDetailView', array(
            'data'=>$oWarehouseFormInput,
            'attributes'=>array(
               array(
                  'name'=>'date',
                  'value'=>FDate::getTimeZoneFormattedDate($oWarehouseFormInput->date, true),
               ),
               array(
                  'name'=>'code',
               ),
               array(
                  'name'=>'comments',
                  'value'=>FString::getAbbreviationSentence($oWarehouseFormInput->comments, 256, 25),
               ),
               array(
                  'name'=>'status',
                  'type'=>'raw',
                  'value'=>'<b><font style="color:' . $sColorStatus . '">' . Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_STATUS_VALUE_' . $oWarehouseFormInput->status) . '</font></b>',
               ),
            ),
            'nullDisplay'=>FString::STRING_EMPTY,
         ));
         
         if (count($oWarehouseFormInputArticles) > 0) { ?>
            <div style="padding-top:10px"></div>
            
            <div style="margin-left:100px;">
            <?php    
            foreach($oWarehouseFormInputArticles as $oWarehouseFormInputArticle) {
               $this->widget('zii.widgets.CDetailView', array(
                  'data'=>$oWarehouseFormInputArticle,
                  'attributes'=>array(
                     array(
                        'label'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMMANAGEMENTCONTRACTINGPROCEDURE_ARTICLE_NAME'),
                        'type'=>'raw',
                        'value'=>'<font style="color:green">' . $oWarehouseFormInputArticle->quantity . FString::STRING_SPACE . $oWarehouseFormInputArticle->article . '</font>',
                     ),
                  ),
                  'nullDisplay'=>FString::STRING_EMPTY,
               ));  
            }
            ?>
            </div>
            <?php
         }  
         ?>
         <br/>
         <?php
         if (!FString::isNullOrEmpty($oWarehouseFormInput->code)) {
            $oWarehouseFormsOutputs = WarehouseFormsOutputs::getWarehouseFormsOutputsByCode($oWarehouseFormInput->code);
            foreach($oWarehouseFormsOutputs as $oWarehouseFormOutput) {
               $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdFormFK($oWarehouseFormOutput->id);

               $this->widget('zii.widgets.CDetailView', array(
                  'data'=>$oWarehouseFormOutput,
                  'attributes'=>array(
                     array(
                        'name'=>'date',
                        'value'=>FDate::getTimeZoneFormattedDate($oWarehouseFormOutput->date, true),
                     ),
                     array(
                        'name'=>'comments',
                        'value'=>FString::getAbbreviationSentence($oWarehouseFormOutput->comments, 256, 25),
                     ),
                     array(
                        'name'=>'sStatus',
                        'type'=>'raw',
                        'value'=>'<b><font style="color:red">' . Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_DEVOLUTION_ABBR') . '</font></b>',
                     ),
                  ),
                  'nullDisplay'=>FString::STRING_EMPTY,
               ));
               
               if (count($oWarehouseFormOutputArticles) > 0) { ?>
                  <div style="padding-top:10px"></div>
                  
                  <div style="margin-left:100px;">
                  <?php    
                  foreach($oWarehouseFormOutputArticles as $oWarehouseFormOutputArticle) {
                     $this->widget('zii.widgets.CDetailView', array(
                        'data'=>$oWarehouseFormOutputArticle,
                        'attributes'=>array(
                           array(
                              'label'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMPURCHASEORDER_ARTICLE_NAME'),
                              'type'=>'raw',
                              'value'=>'<font style="color:red">' . $oWarehouseFormOutputArticle->quantity . FString::STRING_SPACE . $oWarehouseFormOutputArticle->article . '</font>',
                           ),
                        ),
                        'nullDisplay'=>FString::STRING_EMPTY,
                     ));  
                  }
                  ?>
                  </div>
                  <?php
               }
               ?>
               <br />
               <?php   
            }
         }
      }
   }
} ?> 