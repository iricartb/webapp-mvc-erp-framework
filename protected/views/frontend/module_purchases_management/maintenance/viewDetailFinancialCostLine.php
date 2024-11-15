<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'group',
      ),
      array(
         'name'=>'concept',
      ),
      array(
         'name'=>'department',
         'value'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oModelForm->department),
      ),
      array(
         'name'=>'max_price',
         'value'=>FFormat::getFormatPrice($oModelForm->max_price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'),
      ),
      array(
         'name'=>'consumption',
         'value'=>FFormat::getFormatPrice(PurchasesFinancialCostsLines::getPurchasesFinancialCostLineConsumption($oModelForm->id)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'),
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>

<div style="padding-top:10px"></div>

<?php 
$oPurchasesFinancialCostAccountingAccounts = PurchasesFinancialCostsAccountingAccounts::getPurchasesFinancialCostsAccountingAccountsByIdFormFK($oModelForm->id);

if (count($oPurchasesFinancialCostAccountingAccounts) > 0) { ?>
   <div style="padding-top:30px"></div>
        
   <div class="row_emphasis">                            
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
}
?>