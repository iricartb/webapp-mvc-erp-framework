<div class="row_emphasis" style="background-color:<?php echo '#' . FModulePurchasesManagement::HEADER_MAIN_COLOR;?>">
   <div style="display:table-cell">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/forms_request_offers.png'; ?>" width="32px">
   </div>
   <div style="display:table-cell; padding-left:5px; vertical-align:middle;">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMREQUESTOFFDER_HEADER')); ?>   
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
         'name'=>'department',
         'value'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oModelForm->department),
      ),
      array(
         'name'=>'id_financial_cost_line',
         'value'=>PurchasesFinancialCostsLines::getPurchasesFinancialCostLineFullDescription($oModelForm->id_financial_cost_line, false),
      ),
      array(
         'name'=>'description',
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
      ),
      */
      array(
         'name'=>'status',
         'type'=>'raw',
         'value'=>'<b><font style="color:' . $sColorStatus . '">' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_STATUS_VALUE_' . $oModelForm->status) . '</font></b>',
      ),
      array(
         'name'=>'discard_reason',
         'type'=>'raw',
         'value'=>'<b><font style="color:' . $sColorStatus . '">' . $oModelForm->discard_reason . '</font></b>',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>

<?php
$oPurchasesFormsRequestOffersArticles = PurchasesFormsRequestOffersArticles::getPurchasesFormsRequestOffersArticlesByIdFormFK($oModelForm->id);
if (count($oPurchasesFormsRequestOffersArticles) > 0) { ?>
   <div style="padding-top:10px"></div>
   
   <div style="margin-left:100px;">
   <?php
   foreach($oPurchasesFormsRequestOffersArticles as $oPurchasesFormRequestOfferArticle) {
      $this->widget('zii.widgets.CDetailView', array(
         'data'=>$oPurchasesFormRequestOfferArticle,
         'attributes'=>array(
            array(
               'label'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMREQUESTOFFDER_ARTICLE_NAME'),
               'value'=>$oPurchasesFormRequestOfferArticle->quantity . FString::STRING_SPACE . $oPurchasesFormRequestOfferArticle->description,
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

<div style="padding-top:10px"></div>

<?php 
$oPurchasesFormsRequestOffersLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oModelForm->id);
foreach($oPurchasesFormsRequestOffersLines as $oPurchasesFormRequestOfferLine) { ?> 
   <div style="padding-top:30px"></div>
   
   <?php
   $sCssBackgroundColor = FString::STRING_EMPTY;
   $sSentence = FString::STRING_EMPTY;
   if (($oPurchasesFormRequestOfferLine->selected) && (($oModelForm->status == FModulePurchasesManagement::STATUS_ACCEPTED) || ($oModelForm->status == FModulePurchasesManagement::STATUS_PENDING))) {
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
         <?php echo FString::castStrToUpper(Providers::getProviderName($oPurchasesFormRequestOfferLine->id_provider)); ?>
      </div>
   </div>
   
   <?php
   $this->widget('zii.widgets.CDetailView', array(
      'data'=>$oPurchasesFormRequestOfferLine,
      'attributes'=>array(
         array(
            'name'=>'id',
         ),
         array(
            'name'=>'id_provider',
            'value'=>Providers::getProviderName($oPurchasesFormRequestOfferLine->id_provider),
         ),
         array(
            'name'=>'price',
            'value'=>($oPurchasesFormRequestOfferLine->price >= 0) ? FFormat::getFormatPrice($oPurchasesFormRequestOfferLine->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') : FString::STRING_EMPTY,
         ),
         array(
            'name'=>'notify_date',
            'value'=>(!is_null($oPurchasesFormRequestOfferLine->notify_date)) ? FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferLine->notify_date, true) : FString::STRING_EMPTY,
         ),
         array(
            'name'=>'start_date',
            'value'=>(!is_null($oPurchasesFormRequestOfferLine->start_date)) ? FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferLine->start_date, true) : FString::STRING_EMPTY,
         ),
         array(
            'name'=>'offer',
            'type'=>'raw',                                
            'value'=>(($oModelForm->status == FModulePurchasesManagement::STATUS_ACCEPTED) && ($oPurchasesFormRequestOfferLine->price >= 0) && (!FString::isNullOrEmpty($oPurchasesFormRequestOfferLine->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oPurchasesFormRequestOfferLine->offer))) ? $sSentence . '<a href="' . Yii::app()->controller->createUrl("viewAttachmentFormRequestOfferLine", array("nIdForm"=>$oPurchasesFormRequestOfferLine->id)) . '">' . Yii::t('system', 'SYS_DOWNLOAD_DOCUMENT') . '</a>' : FString::STRING_EMPTY,
         )
      ),
      'nullDisplay'=>FString::STRING_EMPTY,
   ));  
   ?><div style="padding-top:10px"></div><?php  
}