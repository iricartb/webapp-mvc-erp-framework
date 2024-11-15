<div class="row_emphasis" style="background-color:<?php echo '#' . FModulePurchasesManagement::HEADER_MAIN_COLOR;?>">
   <div style="display:table-cell">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/forms_request_offers.png'; ?>" width="32px">
   </div>
   <div style="display:table-cell; padding-left:5px; vertical-align:middle;">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMCONTRACTINGPROCEDURE_HEADER')); ?>   
   </div>
</div>

<div style="padding-top:10px"></div>

<?php 
if ($oModelForm->status == FModulePurchasesManagement::STATUS_CREATED) {
   $sColorStatus = 'blue';   
} 
else if ($oModelForm->status == FModulePurchasesManagement::STATUS_PENDING) {
   $sColorStatus = 'orange';
}
else if ($oModelForm->status == FModulePurchasesManagement::STATUS_ACCEPTED) {
   $sColorStatus = 'green';
}
else {
   $sColorStatus = 'red';
}

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
         'name'=>'user_accept_discard',
      ),
      array(
         'name'=>'contracting_procedure_service',
      ),
      array(
         'name'=>'contracting_procedure_expedient',
      ),
      array(
         'name'=>'id_contracting_procedure',
         'value'=>PurchasesContractingProcedures::getPurchasesContractingProcedureName($oModelForm->id_contracting_procedure),
      ),
      array(
         'name'=>'description',
      ),
      array(
         'name'=>'contracting_procedure_project_code',
      ),
      array(
         'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURESTARTDATE') . ' /' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDUREENDDATE'),
         'value'=>FDate::getTimeZoneFormattedDate($oModelForm->contracting_procedure_start_date) . ' - ' . FDate::getTimeZoneFormattedDate($oModelForm->contracting_procedure_end_date),
      ),
      array(
         'name'=>'contracting_procedure_comments',
         'type'=>'raw',
         'value'=>nl2br($oModelForm->contracting_procedure_comments),
      ),
      array(
         'name'=>'discard_reason',
      ),
      array(
         'name'=>'start_date',
         'value'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date, true),
      ),
      array(
         'name'=>'accept_date',
         'value'=>(!FString::isNullOrEmpty($oModelForm->accept_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->accept_date, true) : FString::STRING_EMPTY,
      ),
      /*
      array(
         'name'=>'type',
         'value'=>(strlen(FModulePurchasesManagement::getTypeFormRequestOffer($oModelForm->id)) > 0) ? Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_TYPE_VALUE_' . FModulePurchasesManagement::getTypeFormRequestOffer($oModelForm->id)) : FString::STRING_EMPTY,
      ),*/
      array(
         'name'=>'status',
         'type'=>'raw',
         'value'=>'<b><font style="color:' . $sColorStatus . '">' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_STATUS_VALUE_' . $oModelForm->status) . '</font></b>',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>

<?php
$sFolderExpedient = str_replace('\\', '-', str_replace('/', '-', $oModelForm->contracting_procedure_expedient));
$sFolderExpedientPath = FApplication::FOLDER_DOCUMENTS_MODULE_PURCHASES_MANAGEMENT . 'expedients/' . $sFolderExpedient;
 
$oPurchasesFormsRequestOffersDocuments = PurchasesFormsRequestOffersDocuments::getPurchasesFormsRequestOffersDocumentsByIdFormFK($oModelForm->id);      
$oArrayDocuments = array();

foreach($oPurchasesFormsRequestOffersDocuments as $oPurchasesFormRequestOfferDocument) { 
   if ((!FString::isNullOrEmpty($oPurchasesFormRequestOfferDocument->document)) && (file_exists($sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferDocument->folder . '/' . $oPurchasesFormRequestOfferDocument->document))) {
      $sDocumentReview = FString::STRING_EMPTY;
      $sDocumentPrefix = $oPurchasesFormRequestOfferDocument->type . ' · ';
      if (!FString::isNullOrEmpty($oPurchasesFormRequestOfferDocument->version)) {
         $sDocumentPrefix = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; · ' . $oPurchasesFormRequestOfferDocument->type . ' · ';
         $sDocumentReview = ' · ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_VERSION_ABBREVIATION', array('{1}'=>$oPurchasesFormRequestOfferDocument->version));
      }
      
      array_push($oArrayDocuments, array(
                                         'name'=>$sDocumentPrefix . FString::castStrSpecialChars($oPurchasesFormRequestOfferDocument->name) . $sDocumentReview,
                                         'type'=>'raw',
                                         'value'=>'<a href="' . $sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferDocument->folder . '/' . $oPurchasesFormRequestOfferDocument->document . '" target="_blank"><img src="' . FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'document_download_1.png"></img></a>',
                                   ));
   }
}

if (count($oArrayDocuments) > 0) {
   ?>
   <br/>
   <?php
   $this->widget('zii.widgets.CDetailView', array(
      'data'=>$oModelForm,
      'itemTemplate'=>"<tr class=\"{class}\"><td style='width:50%'><b>{label}</b></td><td>{value}</td></tr>\n",
      'attributes'=>$oArrayDocuments,
      'nullDisplay'=>FString::STRING_EMPTY,
   ));
}

$oSelectedPurchasesFormManagementContractingProcedureLine = null;
$oPurchasesFormsManagementContractingProcedureLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oModelForm->id);
foreach($oPurchasesFormsManagementContractingProcedureLines as $oPurchasesFormManagementContractingProcedureLine) {
   if ($oPurchasesFormManagementContractingProcedureLine->selected) $oSelectedPurchasesFormManagementContractingProcedureLine = $oPurchasesFormManagementContractingProcedureLine;
}

if (!is_null($oSelectedPurchasesFormManagementContractingProcedureLine)) { 
   $oPurchasesFormsManagementContractingProcedureLineObjectives = PurchasesFormsRequestOffersLinesObjectives::getPurchasesFormsRequestOffersLinesObjectivesByIdFormFK($oSelectedPurchasesFormManagementContractingProcedureLine->id); 
   if (count($oPurchasesFormsManagementContractingProcedureLineObjectives) > 0) { ?>
      <div style="padding-top:10px"></div>
      
      <div style="margin-left:100px;">
      <?php
      foreach($oPurchasesFormsManagementContractingProcedureLineObjectives as $oPurchasesFormManagementContractingProcedureLineObjective) {
         $this->widget('zii.widgets.CDetailView', array(
            'data'=>$oPurchasesFormManagementContractingProcedureLineObjective,
            'attributes'=>array(
               array(
                  'label'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMCONTRACTINGPROCEDURE_OBJECTIVE_NAME'),
                  'value'=>$oPurchasesFormManagementContractingProcedureLineObjective->quantity . FString::STRING_SPACE . $oPurchasesFormManagementContractingProcedureLineObjective->description,
               ),
            ),
            'nullDisplay'=>FString::STRING_EMPTY,
         )); 
      }
      ?>
      </div>
      <?php
   }
} 
?>

<div style="padding-top:10px"></div>

<?php 
$oPurchasesFormsContractingProceduresLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oModelForm->id);
foreach($oPurchasesFormsContractingProceduresLines as $oPurchasesFormContractingProcedureLine) { ?> 
   <div style="padding-top:30px"></div>
   
   <?php
   $sCssBackgroundColor = FString::STRING_EMPTY;
   $sSentence = FString::STRING_EMPTY;
   if ($oPurchasesFormContractingProcedureLine->selected) {
      $sCssBackgroundColor = 'background-color:lightgreen';
      $sSentence = '<b><font color="green">' . Yii::t('system', 'SYS_SELECTED') . '</font></b><br/><br/>';
   }
   else {
      $sCssBackgroundColor = 'background-color:#EEEEEE'; 
      $sSentence = '<b><font color="red">' . Yii::t('system', 'SYS_NO') . FString::STRING_SPACE . Yii::t('system', 'SYS_SELECTED') . '</font></b><br/><br/>';
   }
   ?>
   <div class="row_emphasis" style="<?php echo $sCssBackgroundColor; ?>">
      <div class="cell" style="width:420px;">
         <?php echo FString::castStrToUpper(Providers::getProviderName($oPurchasesFormContractingProcedureLine->id_provider)); ?>
      </div>
   </div>
   
   <?php
   $this->widget('zii.widgets.CDetailView', array(
      'data'=>$oPurchasesFormContractingProcedureLine,
      'attributes'=>array(
         array(
            'name'=>'id',
         ),
         array(
            'name'=>'id_provider',
            'value'=>Providers::getProviderName($oPurchasesFormContractingProcedureLine->id_provider),
         ),
         array(
            'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_PRICE_CONTRACTING_PROCEDURE'),
            'value'=>($oPurchasesFormContractingProcedureLine->price >= 0) ? FFormat::getFormatPrice($oPurchasesFormContractingProcedureLine->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') : FString::STRING_EMPTY,
         ),
         array(
            'name'=>'notify_date',
            'value'=>(!is_null($oPurchasesFormContractingProcedureLine->notify_date)) ? FDate::getTimeZoneFormattedDate($oPurchasesFormContractingProcedureLine->notify_date, true) : FString::STRING_EMPTY,
         ),
         array(
            'name'=>'start_date',
            'value'=>(!is_null($oPurchasesFormContractingProcedureLine->start_date)) ? FDate::getTimeZoneFormattedDate($oPurchasesFormContractingProcedureLine->start_date, true) : FString::STRING_EMPTY,
         ),
         array(
            'name'=>'offer',
            'type'=>'raw',
            'value'=>(($oPurchasesFormContractingProcedureLine->price >= 0) && (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureLine->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oPurchasesFormContractingProcedureLine->offer))) ? $sSentence . '<a href="' . Yii::app()->controller->createUrl("viewAttachmentFormRequestOfferLine", array("nIdForm"=>$oPurchasesFormContractingProcedureLine->id)) . '">' . Yii::t('system', 'SYS_DOWNLOAD_DOCUMENT') . '</a>' : FString::STRING_EMPTY,
         )
      ),
      'nullDisplay'=>FString::STRING_EMPTY,
   ));  
   ?>
   
   <div style="font-size:12px; margin-top:20px;">
   <?php
   if ($oPurchasesFormContractingProcedureLine->selected) {
      $i = 0;
      $oPruchasesFormsPurchaseOrders = PurchasesFormsPurchaseOrders::getPurchasesFormsPurchaseOrdersByIdProviderAndIdFormFK($oPurchasesFormContractingProcedureLine->id_provider, $oModelForm->id);
      if (count($oPruchasesFormsPurchaseOrders) > 0) {
         $nTotalSumOrders = 0;
         $nTotalSumInvoices = 0;
         $nTotalSumPaidInvoices = 0;
         foreach($oPruchasesFormsPurchaseOrders as $oPruchasesFormPurchaseOrder) {
            if ($i == 0) {
               ?>                            
               <div style="display:table-row; background-color:#4BA1E0; color:white;">
                  <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:5%"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_ID'); ?></div>
                  <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:35%"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_DESCRIPTION'); ?></div>
                  <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:20%"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_PRICE'); ?></div>
                  <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:20%"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_INVOICE'); ?></div>
                  <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:20%"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_PAID_INVOICE'); ?></div> 
               </div>
               <?php
            }
            ?>
            <div style="display:table-row; background-color:#F9EBAE">
               <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; text-align:center; width:5%"><?php echo $oPruchasesFormPurchaseOrder->id;?></div>
               <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:35%"><?php echo $oPruchasesFormPurchaseOrder->description;?></div>
               <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:20%"><?php $nTotalSumOrders += $oPruchasesFormPurchaseOrder->price; echo FFormat::getFormatPrice($oPruchasesFormPurchaseOrder->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'); ?></div>
               <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:20%"><?php $nTotalSumInvoices += PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersTotalSumInvoicesByIdFormFK($oPruchasesFormPurchaseOrder->id, false); echo FFormat::getFormatPrice(PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersTotalSumInvoicesByIdFormFK($oPruchasesFormPurchaseOrder->id, false)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'); ?></div>
               <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:20%"><?php $nTotalSumPaidInvoices += PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersTotalSumInvoicesByIdFormFK($oPruchasesFormPurchaseOrder->id, true); echo FFormat::getFormatPrice(PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersTotalSumInvoicesByIdFormFK($oPruchasesFormPurchaseOrder->id, true)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'); ?></div>
            </div>
            <?php 
            $i++;   
         }
         ?>
         
         <div style="display:table-row; background-color:#F9C1AE">
            <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; text-align:center; width:5%"></div>
            <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:35%"></div>
            <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:20%">
            <?php 
               echo FFormat::getFormatPrice($nTotalSumOrders) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'); 
               if ($nTotalSumOrders > $oPurchasesFormContractingProcedureLine->price) {
                  ?>
                  &nbsp;&nbsp;<img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'caution_alert_1.png'; ?>" title="<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_FORMCONTRACTINGPROCEDUREGENERAL_ALERT_ORDERS_MAJOR_CONTRACT');?>">
                  <?php
               }
            ?>
            </div>
            <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:20%">
            <?php 
               echo FFormat::getFormatPrice($nTotalSumInvoices) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR');
               if ($nTotalSumInvoices > $oPurchasesFormContractingProcedureLine->price) {
                  ?>
                  &nbsp;&nbsp;<img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'caution_alert_1.png'; ?>" title="<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_FORMCONTRACTINGPROCEDUREGENERAL_ALERT_INVOICES_MAJOR_CONTRACT');?>">
                  <?php
               } 
            ?>
            </div>
            <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:20%"><?php echo FFormat::getFormatPrice($nTotalSumPaidInvoices) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'); ?></div>   
         </div>
         <?php
      }
   }
   ?>
   </div>
   
   <div style="padding-top:10px"></div><?php  
}