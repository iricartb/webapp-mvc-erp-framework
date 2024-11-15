<div style="padding:10px;">
   <?php 
   if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PURCHASES_MANAGEMENT)) {
      $this->widget('zii.widgets.CDetailView', array(
         'data'=>$oModelForm,
         'attributes'=>array(
            array(
               'name'=>'id',
            ), 
            array(
               'name'=>'description',
               'type'=>'raw',
               'value'=>Providers::getProviderName($oModelForm->id_provider) . FString::STRING_SPACE . '|' . FString::STRING_SPACE . $oModelForm->description . FString::STRING_SPACE . '|' . FString::STRING_SPACE . '<font color="green"><b>' . FFormat::getFormatPrice($oModelForm->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') . '</b></font>', 
            ),       
            array(
               'name'=>'offer',
               'type'=>'raw',
               'value'=>((!FString::isNullOrEmpty($oModelForm->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oModelForm->offer))) ? '<a href="' . Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . "/main/viewAttachmentOfferFormPurchaseOrder", array("nIdForm"=>$oModelForm->id)) . '">' . Yii::t('system', 'SYS_DOWNLOAD_DOCUMENT') . '</a>' : FString::STRING_EMPTY,
            ),
            array(
               'name'=>'delivery',
               'type'=>'raw',
               'value'=>((!FString::isNullOrEmpty($oModelForm->delivery)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_DELIVERIES . $oModelForm->delivery))) ? '<input style="width:435px;" name="WarehouseFormsInputs[delivery]" id="WarehouseFormsInputs_delivery" type="file">&nbsp;<a href="' . Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . "/main/viewAttachmentDeliveryFormPurchaseOrder", array("nIdForm"=>$oModelForm->id)) . '">' . Yii::t('system', 'SYS_DOWNLOAD_DOCUMENT') . '</a>' : '<input style="width:435px;" name="WarehouseFormsInputs[delivery]" id="WarehouseFormsInputs_delivery" type="file">',
            ),    
         ),
         'nullDisplay'=>FString::STRING_EMPTY,
      ));
   }
   else {
      $this->widget('zii.widgets.CDetailView', array(
         'data'=>$oModelForm,
         'attributes'=>array(
            array(
               'name'=>'description',
               'type'=>'raw',
               'value'=>Providers::getProviderName($oModelForm->id_provider) . FString::STRING_SPACE . '|' . FString::STRING_SPACE . $oModelForm->description . FString::STRING_SPACE . '|' . FString::STRING_SPACE . '<font color="green"><b>' . FFormat::getFormatPrice($oModelForm->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') . '</b></font>', 
            ),
         ),
         'nullDisplay'=>FString::STRING_EMPTY,
      ));  
   }
   ?>

   <?php
   $oPurchasesFormsPurchaseOrdersArticles = PurchasesFormsPurchaseOrdersArticles::getPurchasesFormsPurchasesOrdersArticlesByIdFormFK($oModelForm->id);
   if (count($oPurchasesFormsPurchaseOrdersArticles) > 0) { ?>
      <div style="padding-top:10px"></div>
      
      <div style="margin-left:100px;">
      <?php    
      foreach($oPurchasesFormsPurchaseOrdersArticles as $oPurchasesFormPurchaseOrderArticle) {
         if (!$oPurchasesFormPurchaseOrderArticle->service) {
            $sSentencePrice = FString::STRING_SPACE;
            if ($oPurchasesFormPurchaseOrderArticle->price >= 0) $sSentencePrice = '<font color="green"> (' . $oPurchasesFormPurchaseOrderArticle->quantity . ' x ' . FFormat::getFormatPrice($oPurchasesFormPurchaseOrderArticle->price, false, true) . ' = ' . FFormat::getFormatPrice($oPurchasesFormPurchaseOrderArticle->price * $oPurchasesFormPurchaseOrderArticle->quantity) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') . ')</font>';
            
            $this->widget('zii.widgets.CDetailView', array(
               'data'=>$oPurchasesFormPurchaseOrderArticle,
               'attributes'=>array(
                  array(
                     'label'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMPURCHASEORDER_ARTICLE_NAME'),
                     'type'=>'raw',
                     'value'=>$oPurchasesFormPurchaseOrderArticle->quantity . FString::STRING_SPACE . $oPurchasesFormPurchaseOrderArticle->description . $sSentencePrice,
                  ),
               ),
               'nullDisplay'=>FString::STRING_EMPTY,
            )); 
         } 
      }
      ?>
      </div>
      <?php
   }
   ?>
</div>