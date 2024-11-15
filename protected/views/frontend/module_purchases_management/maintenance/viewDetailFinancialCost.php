<div class="row_emphasis" style="background-color:<?php echo '#' . FModulePurchasesManagement::HEADER_MAIN_COLOR;?>">
   <div style="display:table-cell">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/financial_costs.png'; ?>" width="32px">
   </div>
   <div style="display:table-cell; padding-left:5px; vertical-align:middle;">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFINANCIALCOST_HEADER', array('{1}'=>$oModelForm->year))); ?>   
   </div>
</div>

<div style="padding-top:10px"></div>

<?php 
$this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'year',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>

<div style="padding-top:10px"></div>

<?php $oPurchasesFinancialCostLines = PurchasesFinancialCostsLines::getPurchasesFinancialCostsLinesByIdFormFK($oModelForm->id);
foreach($oPurchasesFinancialCostLines as $oPurchasesFinancialCostLine) { ?> 
   <div style="padding-top:30px"></div>
   
   <div class="row_emphasis">
      <div class="cell" style="width:420px;">
         <?php echo FString::castStrToUpper($oPurchasesFinancialCostLine->group . '/' . $oPurchasesFinancialCostLine->concept); ?>
      </div>
   </div>
         
   <?php
   $this->widget('zii.widgets.CDetailView', array(
      'data'=>$oPurchasesFinancialCostLine,
      'attributes'=>array(
         array(
            'name'=>'max_price',
            'value'=>FFormat::getFormatPrice($oPurchasesFinancialCostLine->max_price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'),
         ),
         array(
            'name'=>'consumption',
            'value'=>FFormat::getFormatPrice(PurchasesFinancialCostsLines::getPurchasesFinancialCostLineConsumption($oPurchasesFinancialCostLine->id)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'),
         ),
      ),
      'nullDisplay'=>FString::STRING_EMPTY,
   ));  
   ?><div style="padding-top:10px"></div><?php
   
   $oPurchasesFinancialCostAccountingAccounts = PurchasesFinancialCostsAccountingAccounts::getPurchasesFinancialCostsAccountingAccountsByIdFormFK($oPurchasesFinancialCostLine->id);

   if (count($oPurchasesFinancialCostAccountingAccounts) > 0) { ?>
      <div style="padding-left:40px;">
         <div style="padding-top:30px"></div>
              
         <div class="row_emphasis" style="background-color: #EDEDFF;">                            
            <div class="cell" style="width:420px;">
               <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDETAILFINANCIALCOSTLINE_ACCOUNTING_ACCOUNTS_HEADER')); ?>
            </div>
         </div>
         
         <?php
         foreach($oPurchasesFinancialCostAccountingAccounts as $oPurchasesFinancialCostAccountingAccount) { ?> 
            <div style="padding-top:10px"></div>
              
            <?php
            $this->widget('zii.widgets.CDetailView', array(
               'data'=>$oPurchasesFinancialCostAccountingAccount,
               'attributes'=>array(
                  array(
                     'name'=>'account',
                  ),
                  array(
                     'name'=>'description',
                  ),
               ),
               'nullDisplay'=>FString::STRING_EMPTY,
            ));  
            ?><div style="padding-top:10px"></div><?php
         }
      ?>
      </div>
      <?php
   }
}
?>