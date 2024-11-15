<div style="padding:10px;">
   <?php 
   $this->widget('zii.widgets.CDetailView', array(
      'data'=>$oModelForm,
      'attributes'=>array(
         array(
            'name'=>'description',
            'type'=>'raw',
            'value'=>Providers::getProviderName(PurchasesFormsRequestOffers::getPurchasesFormRequestOfferSelectedProvider($oModelForm->id)) . FString::STRING_SPACE . '|' . FString::STRING_SPACE . $oModelForm->description . FString::STRING_SPACE . '|' . FString::STRING_SPACE . '<font color="green"><b>' . FFormat::getFormatPrice(PurchasesFormsRequestOffers::getPurchasesFormRequestOfferSelectedPrice($oModelForm->id)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') . '</b></font>', 
         ),
      ),
      'nullDisplay'=>FString::STRING_EMPTY,
   ));
   ?>

   <?php
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
            if ($oPurchasesFormManagementContractingProcedureLineObjective->type == FModulePurchasesManagement::TYPE_FORM_CONTRACTING_PROCEDURE_SUPPLY) {
               $sSentencePrice = FString::STRING_SPACE;
               if ($oPurchasesFormManagementContractingProcedureLineObjective->accomplished_price >= 0) $sSentencePrice = '<font color="green"> (' . $oPurchasesFormManagementContractingProcedureLineObjective->quantity . ' x ' . FFormat::getFormatPrice($oPurchasesFormManagementContractingProcedureLineObjective->accomplished_price, false, true) . ' = ' . FFormat::getFormatPrice($oPurchasesFormManagementContractingProcedureLineObjective->accomplished_price * $oPurchasesFormManagementContractingProcedureLineObjective->quantity) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') . ')</font>';
               
               $this->widget('zii.widgets.CDetailView', array(
                  'data'=>$oPurchasesFormManagementContractingProcedureLineObjective,
                  'attributes'=>array(
                     array(
                        'label'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFORMREQUESTOFFER_ARTICLE_NAME'),
                        'type'=>'raw',
                        'value'=>$oPurchasesFormManagementContractingProcedureLineObjective->quantity . FString::STRING_SPACE . $oPurchasesFormManagementContractingProcedureLineObjective->description . $sSentencePrice,
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
   }
   ?>
</div>