<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/forms_contracting_procedure.png' ?>" />
   </div>                                                                                                                                                                                                                                                                                                   
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date), '{2}'=>$oModelForm->owner, '{3}'=>$oModelForm->contracting_procedure_expedient))); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_DESCRIPTION'); ?>
</div>

<div class="tab_button tab_active">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_GENERAL'); ?>
</div>
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureMoreInformation', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_MORE_INFORMATION'); ?>
</div>
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureDocumentation', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_DOCUMENTATION'); ?>
</div>
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureRecords', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_RECORDS'); ?>
</div>  
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureNotifications', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_NOTIFICATIONS'); ?>
</div>   
<div class="form">
   <?php $formFormContractingProcedure = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-contracting-procedure-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureGeneral', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_content container_tab">
      <div class="first_row">
         <div class="last_cell">
            <?php echo $formFormContractingProcedure->labelEx($oModelForm, 'description', array('style'=>'width:625px;')); ?>  
            <?php echo $formFormContractingProcedure->textArea($oModelForm, 'description', array('style'=>'width:625px; height:100px')); ?>
            <?php echo $formFormContractingProcedure->error($oModelForm, 'description', array('style'=>'width:625px;')); ?>
         </div>
      </div>
      <div class="row"> 
         <div class="cell">
            <?php echo $formFormContractingProcedure->labelEx($oModelForm, 'contracting_procedure_expedient', array('style'=>'width:120px;')); ?>
            <?php echo $formFormContractingProcedure->textField($oModelForm, 'contracting_procedure_expedient', array('style'=>'width:120px;', 'disabled'=>'disabled')); ?>
            <?php echo $formFormContractingProcedure->error($oModelForm, 'contracting_procedure_expedient', array('style'=>'width:120px;')); ?>
         </div>
         <div class="last_cell">
            <?php echo $formFormContractingProcedure->labelEx($oModelForm, 'contracting_procedure_expedient_external', array('style'=>'width:150px;')); ?>
            <?php echo $formFormContractingProcedure->textField($oModelForm, 'contracting_procedure_expedient_external', array('style'=>'width:150px;')); ?>
            <?php echo $formFormContractingProcedure->error($oModelForm, 'contracting_procedure_expedient_external', array('style'=>'width:150px;')); ?>
         </div>
      </div>
      <div class="row"> 
         <div class="cell">
            <?php echo $formFormContractingProcedure->labelEx($oModelForm, 'contracting_procedure_type', array('style'=>'width:120px;')); ?>
            <?php echo $formFormContractingProcedure->textField($oModelForm, 'contracting_procedure_type', array('style'=>'width:120px;', 'disabled'=>'disabled', 'value'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURETYPE_VALUE_' . $oModelForm->contracting_procedure_type))); ?>
            <?php echo $formFormContractingProcedure->error($oModelForm, 'contracting_procedure_type', array('style'=>'width:120px;')); ?>
         </div>
         <div class="last_cell">
            <?php echo $formFormContractingProcedure->labelEx($oModelForm, 'id_contracting_procedure', array('style'=>'width:280px;')); ?>
            <?php echo $formFormContractingProcedure->dropDownList($oModelForm, 'id_contracting_procedure', CHtml::listData(PurchasesContractingProcedures::getPurchasesContractingProcedures(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:280px;')); ?> 
            <?php echo $formFormContractingProcedure->error($oModelForm, 'id_contracting_procedure', array('style'=>'width:280px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormContractingProcedure->labelEx($oModelForm, 'contracting_procedure_project_code', array('style'=>'width:120px;')); ?>
            <?php echo $formFormContractingProcedure->textField($oModelForm, 'contracting_procedure_project_code', array('style'=>'width:120px;')); ?>
            <?php echo $formFormContractingProcedure->error($oModelForm, 'contracting_procedure_project_code', array('style'=>'width:120px;')); ?> 
         </div>
         <div class="cell">
            <?php
            echo $formFormContractingProcedure->labelEx($oModelForm, 'contracting_procedure_start_date', array('style'=>'width:120px;'));
            
            if (FString::isNullOrEmpty($oModelForm->contracting_procedure_start_date)) {
               $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'contracting_procedure_start_date', false, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '120px', FString::STRING_EMPTY, FString::STRING_EMPTY));
            }
            else {
               $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'contracting_procedure_start_date', false, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '120px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate($oModelForm->contracting_procedure_start_date)));
            }
            
            echo $formFormContractingProcedure->error($oModelForm, 'contracting_procedure_start_date', array('style'=>'width:120px;')); 
            ?>
         </div>
         <div class="last_cell">
            <?php
            echo $formFormContractingProcedure->labelEx($oModelForm, 'contracting_procedure_end_date', array('style'=>'width:120px;'));
            
            if (FString::isNullOrEmpty($oModelForm->contracting_procedure_end_date)) {
               $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'contracting_procedure_end_date', false, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '120px', FString::STRING_EMPTY, FString::STRING_EMPTY));
            }
            else {
               $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'contracting_procedure_end_date', false, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '120px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate($oModelForm->contracting_procedure_end_date)));
            }
            
            echo $formFormContractingProcedure->error($oModelForm, 'contracting_procedure_end_date', array('style'=>'width:120px;')); 
            ?>
         </div>
      </div>
   </div> 
   <div class="row buttons">
      <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
   </div>     
     
   <?php $this->endWidget(); ?>
</div>

<br/><br/>

<div class="form">
   <?php $formFormContractingProcedureLine = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-contracting-procedure-line-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureGeneral', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_expand_collapse_image_line" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image_line'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse_line');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDUREGENERAL_FORM_NEW_LINE_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse_line" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDUREGENERAL_FORM_NEW_LINE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formFormContractingProcedureLine->labelEx($oModelFormContractingProcedureLine, 'id_provider', array('style'=>'width:400px;')); ?>
               <?php echo FForm::textFieldAutoComplete($oModelFormContractingProcedureLine, 'id_provider', CHtml::listData(Providers::getProviders(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:400px;')); ?>
               <?php echo $formFormContractingProcedureLine->error($oModelFormContractingProcedureLine, 'id_provider', array('style'=>'width:400px;')); ?>  
            </div>
         </div>
      </div> 
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
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


<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDUREGENERAL_LINE_GRID_DESCRIPTION'); ?>
      </div>
   </div>
</div>

<?php                         
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormContractingProcedureLineFilters->search($oModelForm->id),
   'rowCssClassExpression'=>'(!FString::isNullOrEmpty($data->offer)) ? (($data->selected) ? \'completed\' :  \'pending\') : \'no_completed\'',
   'columns'=>array(
      array(
         'name'=>'id',
         'htmlOptions'=>array('width'=>60),
      ),
      array(
         'name'=>'id_provider',
         'value'=>'Providers::getProviderName($data->id_provider)',
         'htmlOptions'=>array('width'=>400),
      ),
      array(
         'name'=>'price',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_PRICE_CONTRACTING_PROCEDURE'),
         'value'=>'($data->price >= 0) ? FFormat::getFormatPrice($data->price) . FString::STRING_SPACE . Yii::t(\'system\', \'SYS_EUR\') : FString::STRING_EMPTY',
         'htmlOptions'=>array('width'=>200, 'style'=>'text-align:right'),
      ), 
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormContractingProcedureLineObjectives", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowUpdateFormContractingProcedureLineObjectives($data->primaryKey)', FString::STRING_BOOLEAN_TRUE, false, 'currency_coins_1.png'),                                                                                                                                                                                                                                                                      
      FGrid::getSelectorButton('Yii::app()->controller->createUrl("selectFormContractingProcedureLine", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_request_offer))', 'FModulePurchasesManagement::allowSelectFormContractingProcedureLine($data->primaryKey)'),
      FGrid::getAttachmentButton('Yii::app()->controller->createUrl("viewAttachmentFormContractingProcedureLine", array("nIdForm"=>$data->primaryKey))', '((!FString::isNullOrEmpty($data->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $data->offer)))'),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormContractingProcedureLine", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowUpdateFormContractingProcedureLine($data->primaryKey)', FString::STRING_BOOLEAN_TRUE, false, 'attachment_clip_4.png'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormContractingProcedureLine", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormContractingProcedureLine", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_request_offer))', 'FModulePurchasesManagement::allowDeleteFormContractingProcedureLine($data->primaryKey)'),
   ),
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
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_DISCARDED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_STATUS_VALUE_CREATED');?>
   </div>
   
   <div class="cell">
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_PENDING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_STATUS_VALUE_PENDING');?>
   </div>

   <div class="last_cell">
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_RUNNING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_STATUS_VALUE_SELECTED');?>
   </div>
</div>

<br/>
<hr>

<?php
$oPurchasesFormsContractingProcedureLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oModelForm->id);
foreach($oPurchasesFormsContractingProcedureLines as $oPurchasesFormContractingProcedureLine) {
   if ($oPurchasesFormContractingProcedureLine->selected) {
      ?>
      <div style="display:table; width:100%; font-size:12px; padding-top:10px;">
         <div style="display:table-row; background-color:#4BA1E0; color:white;">
            <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:30%"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_IDPROVIDER'); ?></div>
            <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:70%"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_PRICE_CONTRACTING_PROCEDURE'); ?></div> 
         </div>
         <div style="display:table-row; background-color:#C3EABB">
            <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px; width:400px"><?php echo Providers::getProviderName($oPurchasesFormContractingProcedureLine->id_provider); ?></div>
            <div style="display:table-cell; padding-left:20px; padding-right:10px; padding-top:3px; padding-bottom:3px;"><?php echo FFormat::getFormatPrice($oPurchasesFormContractingProcedureLine->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'); ?></div> 
         </div>
      </div>
      
      <div style="margin-left:6%; display:table; width:94%; font-size:12px;"> 
         <?php 
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
         ?>
      </div>
      <?php
   }   
} 
?>

<div class="form">
   <div class="row buttons">
      <?php echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormsContractingProcedure') . '\'')); ?>
   </div>
</div>