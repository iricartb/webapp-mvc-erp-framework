<?php 
if (!FString::isNullOrEmpty($oModelForm->sFilterInvoiceNumber)) $sFilterInvoiceNumber = $oModelForm->sFilterInvoiceNumber;
else $sFilterInvoiceNumber = FString::STRING_EMPTY;

if ($oModelForm->sFilterStatusPending) $sFilterStatusPending = 'checked';
else $sFilterStatusPending = FString::STRING_EMPTY;

if ($oModelForm->sFilterStatusPartialFinalized) $sFilterStatusPartialFinalized = 'checked';
else $sFilterStatusPartialFinalized = FString::STRING_EMPTY;

if ($oModelForm->sFilterStatusFinalized) $sFilterStatusFinalized = 'checked';
else $sFilterStatusFinalized = FString::STRING_EMPTY;

$oDiscartParameters = array('r', 'PurchasesFormsPurchaseOrders[sFilterInvoiceNumber], PurchasesFormsPurchaseOrders[sFilterStatusPending], PurchasesFormsPurchaseOrders[sFilterStatusPartialFinalized], PurchasesFormsPurchaseOrders[sFilterStatusFinalized]');

$sJsParameters = 'function createUrlParameters() {
                     var sFilterInvoiceNumber = \'&PurchasesFormsPurchaseOrders[sFilterInvoiceNumber]=\';    
                     sFilterInvoiceNumber += document.getElementById(\'id_filter_invoice_number\').value;
                     
                     var sFilterStatusPending = \'&PurchasesFormsPurchaseOrders[sFilterStatusPending]=\';    
                     if (document.getElementById(\'id_filter_status_pending\').checked) sFilterStatusPending += \'1\';
                     else sFilterStatusPending += \'0\';
                     
                     var sFilterStatusPartialFinalized = \'&PurchasesFormsPurchaseOrders[sFilterStatusPartialFinalized]=\';    
                     if (document.getElementById(\'id_filter_status_partial_finalized\').checked) sFilterStatusPartialFinalized += \'1\';
                     else sFilterStatusPartialFinalized += \'0\';
                     
                     var sFilterStatusFinalized = \'&PurchasesFormsPurchaseOrders[sFilterStatusFinalized]=\';    
                     if (document.getElementById(\'id_filter_status_finalized\').checked) sFilterStatusFinalized += \'1\';
                     else sFilterStatusFinalized += \'0\';
                     
                     return sFilterInvoiceNumber + sFilterStatusPending + sFilterStatusPartialFinalized + sFilterStatusFinalized; 
                  };';
?>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/forms_purchase_orders.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER_LINE_FORMS_PURCHASE_ORDERS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSPURCHASEORDERS_DESCRIPTION'); ?>
</div>

<div class="first_row">   
   <div class="last_cell">
      <div class="cell">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT),'MODEL_PURCHASESFORMSPURCHASEORDERSINVOICES_FIELD_NUMBER') . ':';?>&nbsp;<input id="id_filter_invoice_number" type="input" onchange="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsPurchaseOrders') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" value="<?php echo $sFilterInvoiceNumber;?>">
      </div>
   </div>
</div>
<br/><hr>
   
<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">                                 
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSPURCHASEORDERS_FORM_GRID_DESCRIPTION'); ?>
      </div>      
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('purchasesFormsPurchaseOrders', FApplication::MODULE_PURCHASES_MANAGEMENT, 'PurchasesFormsPurchaseOrders', ',' . $oModelForm->sFilterStatusPending . ',' . $oModelForm->sFilterStatusPartialFinalized . ',' . $oModelForm->sFilterStatusFinalized, FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>
                                                                                                                      
<?php 
$oColumns = array(
               array(
                  'name'=>'id',
                  'htmlOptions'=>array('width'=>45),
               ),
               array(
                  'name'=>'owner',
                  'htmlOptions'=>array('width'=>120),
               ),
               array(
                  'name'=>'accept_date',
                  'header'=>Yii::t('system', 'SYS_DATE'),
                  'value'=>'FDate::getTimeZoneFormattedDate($data->accept_date, false)',
                  'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'accept_date', false, FString::STRING_EMPTY, 'strtotime()'), true), 
                  'htmlOptions'=>array('width'=>60),
               ),
               array(                          
                  'name'=>'description',
                  'value'=>'FString::getAbbreviationSentence($data->description, 50)',
                  'htmlOptions'=>array('width'=>250),
               ),
               array(
                  'name'=>'id_provider',
                  'filter'=>CHtml::listData(Providers::getProviders(), 'id', 'name'),
                  'value'=>'Providers::getProviderName($data->id_provider)',
                  'htmlOptions'=>array('width'=>230),
               ),       
               FGrid::getInformationButton('REGISTER_PAID_OK', 'PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrderPaid($data->primaryKey)', FString::STRING_EMPTY, 'cbuttoncolumn_green'),                                                                                                                 
               FGrid::getSendButton('Yii::app()->controller->createUrl("notifyFormPurchaseOrder", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowNotifyFormPurchaseOrder($data->primaryKey)', 'send_mail_1.png'),
               FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormPurchaseOrderInvoices", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowUpdateFormPurchaseOrderInvoices($data->primaryKey)', true, false, 'currency_coins_1.png'),
               FGrid::getAttachmentButton('Yii::app()->controller->createUrl("viewAttachmentOrderFormPurchaseOrder", array("nIdForm"=>$data->primaryKey))', '((!FString::isNullOrEmpty($data->order)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_ORDERS . $data->order)))'),
               FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormPurchaseOrder", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowUpdateFormPurchaseOrder($data->primaryKey)'),
               FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormPurchaseOrder", array("nIdForm"=>$data->primaryKey))', FString::STRING_BOOLEAN_TRUE, true, false, 'search_magnifying_glass_1.png', 'fancybox'),
               FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormPurchaseOrder", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowDeleteFormPurchaseOrder($data->primaryKey)'),
            );                             

$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelForm->search(null, ($oModelForm->sFilterInvoiceNumber), ($oModelForm->sFilterStatusPending), ($oModelForm->sFilterStatusPartialFinalized), ($oModelForm->sFilterStatusFinalized), FApplication::GRID_MAX_ITEMS_PER_PAGE_MORE_BIG),
   'filter'=>$oModelForm,
   'rowCssClassExpression'=>'($data->status == FModulePurchasesManagement::STATUS_PARTIAL_FINALIZED) ? strtolower(FModulePurchasesManagement::STATUS_PARTIAL_FINALIZED) : (($data->status == FModulePurchasesManagement::STATUS_FINALIZED) ? strtolower(FModulePurchasesManagement::STATUS_FINALIZED) : FModulePurchasesManagement::getStatusFormPurchaseOrderWarehouseReception($data->id))',
   'columns'=>$oColumns,
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>

<?php
if ((Yii::app()->user->hasFlash('success-generic')) || (Yii::app()->user->hasFlash('notice-generic')) || (Yii::app()->user->hasFlash('error-generic'))) { ?>
   <?php if (Yii::app()->user->hasFlash('success-generic')) { ?>
      <div class="flash-success">
         <?php echo Yii::app()->user->getFlash('success-generic'); ?>
      </div> 
   <?php } else if (Yii::app()->user->hasFlash('notice-generic')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice-generic'); ?>
      </div>   
   <?php } else { ?>
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error-generic'); ?>
      </div>
   <?php }
}
?>

<div class="row">
   <div class="cell">
      <input id="id_filter_status_pending" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsPurchaseOrders') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusPending;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_PENDING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_STATUS_VALUE_PENDING');?>
   </div>
   
   <div class="cell">
      <input id="id_filter_status_partial_finalized" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsPurchaseOrders') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusPartialFinalized;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_PARTIAL_FINALIZED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_STATUS_VALUE_PARTIAL_FINALIZED');?>
   </div>
   
   <div class="last_cell">
      <input id="id_filter_status_finalized" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsPurchaseOrders') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusFinalized;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_FINALIZED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_STATUS_VALUE_FINALIZED');?>
   </div>
</div>

<br/><hr>
<p>
   <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_COMPLETED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_STATUS_VALUE_COMPLETED_FULL_DESCRIPTION');?>
</p>
<p>
   <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_ALERT_ORANGE;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_STATUS_VALUE_ALERT_ORANGE_FULL_DESCRIPTION');?>
</p>
<p>
   <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_ERROR;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_STATUS_VALUE_ERROR_FULL_DESCRIPTION');?>
</p>