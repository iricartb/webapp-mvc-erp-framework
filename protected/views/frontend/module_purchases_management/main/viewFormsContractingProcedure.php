<?php 
if ($oModelForm->sFilterStatusCreated) $sFilterStatusCreated = 'checked';
else $sFilterStatusCreated = FString::STRING_EMPTY; 
           
if ($oModelForm->sFilterStatusAccepted) $sFilterStatusAccepted = 'checked';
else $sFilterStatusAccepted = FString::STRING_EMPTY;

if ($oModelForm->sFilterStatusDiscarded) $sFilterStatusDiscarded = 'checked';
else $sFilterStatusDiscarded = FString::STRING_EMPTY;

$oDiscartParameters = array('r', 'PurchasesFormsRequestOffers[sFilterStatusCreated]', 'PurchasesFormsRequestOffers[sFilterStatusAccepted]', 'PurchasesFormsRequestOffers[sFilterStatusDiscarded]');

$sJsParameters = 'function createUrlParameters() {
                     var sFilterStatusCreated = \'&PurchasesFormsRequestOffers[sFilterStatusCreated]=\';
                     if (document.getElementById(\'id_filter_status_created\').checked) sFilterStatusCreated += \'1\';
                     else sFilterStatusCreated += \'0\';
                     
                     var sFilterStatusAccepted = \'&PurchasesFormsRequestOffers[sFilterStatusAccepted]=\';    
                     if (document.getElementById(\'id_filter_status_accepted\').checked) sFilterStatusAccepted += \'1\';
                     else sFilterStatusAccepted += \'0\';
                     
                     var sFilterStatusDiscarded = \'&PurchasesFormsRequestOffers[sFilterStatusDiscarded]=\';    
                     if (document.getElementById(\'id_filter_status_discarded\').checked) sFilterStatusDiscarded += \'1\';
                     else sFilterStatusDiscarded += \'0\';

                     return sFilterStatusCreated + sFilterStatusAccepted + sFilterStatusDiscarded; 
                  };';
?>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/forms_request_offers.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER_LINE_FORMS_CONTRACTING_PROCEDURE')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSCONTRACTINGPROCEDURE_DESCRIPTION'); ?>
</div>

<div class="toolbox_table">
   <div class="toolbox_table_first_cell_button_left">
      <?php $sAction = Yii::app()->controller->createUrl('createFormContractingProcedure'); ?>      
      <?php echo FWidget::showIconImageButton('purchasesFormsRequestOffers', 'document_new_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSCONTRACTINGPROCEDURE_NEW_BTN_DESCRIPTION'), $sAction, true, '11px', '0px', '16x16', false, 'fancybox_wizard'); ?>   
   </div>
   <div class="toolbox_table_first_cell_button">      
      <?php echo FWidget::showToolboxExporterData('purchasesFormsRequestOffers', FApplication::MODULE_PURCHASES_MANAGEMENT, 'PurchasesFormsRequestOffers', '1,' . $oModelForm->sFilterStatusCreated . ',' . $oModelForm->sFilterStatusPending . ',' . $oModelForm->sFilterStatusAccepted . ',' . $oModelForm->sFilterStatusDiscarded, FString::STRING_EMPTY, $this, true); ?>   
   </div>
</div>
                                                                                                                             
<?php 
$oColumns = array(
               array(
                  'name'=>'owner',
                  'htmlOptions'=>array('width'=>110),
               ),
               array(
                  'name'=>'start_date',
                  'header'=>Yii::t('system', 'SYS_DATE'),
                  'value'=>'FDate::getTimeZoneFormattedDate($data->start_date, false)',
                  'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'start_date', false, FString::STRING_EMPTY, 'strtotime()'), true), 
                  'htmlOptions'=>array('width'=>70),
               ),
               array(                          
                  'name'=>'contracting_procedure_expedient',
                  'htmlOptions'=>array('width'=>160),
               ),
               array(                          
                  'name'=>'description',
                  'value'=>'FString::getAbbreviationSentence($data->description, 60)',
                  'htmlOptions'=>array('width'=>400),
               ),

               FGrid::getInformationButton('ORDERS_OR_INVOICES_MAJOR_CONTRACT', 'FModulePurchasesManagement::getFormContractingProcedureAboutToExpire($data->id)'),
               FGrid::getPrintButton('Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . "/report/formContractingProcedureExport", array("nIdForm"=>$data->primaryKey, "sFormat"=>FFile::FILE_XLS_TYPE))'),
               FGrid::getEditButton('Yii::app()->controller->createUrl("changeStatusFormContractingProcedure", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowChangeStatusFormContractingProcedure($data->primaryKey)', FString::STRING_BOOLEAN_TRUE, false, 'refresh_arrow_1.png'),
               FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormContractingProcedure", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowUpdateFormContractingProcedure($data->primaryKey)', false),
               FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormContractingProcedure", array("nIdForm"=>$data->primaryKey))', FString::STRING_BOOLEAN_TRUE, true, false, 'search_magnifying_glass_1.png', 'fancybox'),
               FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormContractingProcedure", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowDeleteFormContractingProcedure($data->primaryKey)'),
            );
            
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelForm->search(true, null, null, null, null, false, null, FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG),
   'filter'=>$oModelForm,
   'rowCssClassExpression'=>'strtolower($data->status)',
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
      <input id="id_filter_status_created" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsContractingProcedure') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusCreated;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_CREATED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSCONTRACTINGPROCEDURE_FIELD_STATUS_VALUE_CREATED');?>
   </div>
   
   <div class="cell">
      <input id="id_filter_status_accepted" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsContractingProcedure') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusAccepted;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_ACCEPTED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSCONTRACTINGPROCEDURE_FIELD_STATUS_VALUE_ACCEPTED');?>
   </div>
   
   <div class="last_cell">
      <input id="id_filter_status_discarded" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsContractingProcedure') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusDiscarded;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_DISCARDED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSCONTRACTINGPROCEDURE_FIELD_STATUS_VALUE_DISCARDED');?>
   </div>
</div>

<br/><hr>
<div class="cell_header" style="width:865px;">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSCONTRACTINGPROCEDURE_CALENDAR_NOTIFICATIONS_HEADER'); ?>
</div>
<div class="calendar_contracting_procedure" style="margin-top:10px;">
   <?php echo $oModelFormCalendar->show(); ?>
</div>
<div style="margin-top:10px;">
   <div style="margin-top:30px; margin-bottom:10px">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSCONTRACTINGPROCEDURE_CALENDAR_NOTIFICATIONS_MONTH_YEAR_HEADER', array('{1}'=>FString::castStrToCapitalLetters(FDate::getMonthName($sModelFormCalendarMonth)), '{2}'=>$sModelFormCalendarYear)); ?>                                               
   </div>

   <?php
   foreach($oModelFormsRequestOffersNotifications as $oPurchasesFormRequestOfferNotification) {
      if (($oPurchasesFormRequestOfferNotification->public) || ($oPurchasesFormRequestOfferNotification->id_user == Yii::app()->user->id)) { 
         $bCssNotificationDisabled = false;
         if (FDate::isDateMajor(date('Y-m-d'), $oPurchasesFormRequestOfferNotification->end_date)) $bCssNotificationDisabled = true;
         ?>
         <div style="margin-bottom:5px">
         <?php
            if (!$bCssNotificationDisabled) echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSCONTRACTINGPROCEDURE_NOTIFICATION', array('{1}'=>$oPurchasesFormRequestOfferNotification->form_request_offer->contracting_procedure_expedient, '{2}'=>FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferNotification->start_date, false), '{3}'=>FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferNotification->end_date, false), '{4}'=>$oPurchasesFormRequestOfferNotification->message)); 
            else echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSCONTRACTINGPROCEDURE_NOTIFICATION_DISABLED', array('{1}'=>$oPurchasesFormRequestOfferNotification->form_request_offer->contracting_procedure_expedient, '{2}'=>FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferNotification->start_date, false), '{3}'=>FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferNotification->end_date, false), '{4}'=>$oPurchasesFormRequestOfferNotification->message)); 
         ?>
         </div>
         <?php           
      }
   }
   
   $sCalendarNextYear = date("Y", strtotime("+1 month", strtotime($sModelFormCalendarYear . '-' . $sModelFormCalendarMonth . '-01')));
   $sCalendarNextMonth = date("m", strtotime("+1 month", strtotime($sModelFormCalendarYear . '-' . $sModelFormCalendarMonth . '-01')));                                                                                                                                           

   $oPurchasesFormsRequestOffersNextMonthNotifications = PurchasesFormsRequestOffersNotifications::getPurchasesFormsRequestOffersNotificationsByDates($sCalendarNextYear . '-' . $sCalendarNextMonth . '-01', $sCalendarNextYear . '-' . $sCalendarNextMonth . '-31');
    
   ?>
   <div style="margin-top:30px; margin-bottom:10px">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSCONTRACTINGPROCEDURE_CALENDAR_NOTIFICATIONS_MONTH_YEAR_HEADER', array('{1}'=>FString::castStrToCapitalLetters(FDate::getMonthName($sCalendarNextMonth)), '{2}'=>$sCalendarNextYear)); ?>                                               
   </div>

   <?php
   foreach($oPurchasesFormsRequestOffersNextMonthNotifications as $oPurchasesFormRequestOfferNotification) {
      if (($oPurchasesFormRequestOfferNotification->public) || ($oPurchasesFormRequestOfferNotification->id_user == Yii::app()->user->id)) { 
         $bCssNotificationDisabled = false;
         if (FDate::isDateMajor(date('Y-m-d'), $oPurchasesFormRequestOfferNotification->end_date)) $bCssNotificationDisabled = true;
         ?>
         <div style="margin-bottom:5px">
         <?php
            if (!$bCssNotificationDisabled) echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSCONTRACTINGPROCEDURE_NOTIFICATION', array('{1}'=>$oPurchasesFormRequestOfferNotification->form_request_offer->contracting_procedure_expedient, '{2}'=>FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferNotification->start_date, false), '{3}'=>FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferNotification->end_date, false), '{4}'=>$oPurchasesFormRequestOfferNotification->message)); 
            else echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSCONTRACTINGPROCEDURE_NOTIFICATION_DISABLED', array('{1}'=>$oPurchasesFormRequestOfferNotification->form_request_offer->contracting_procedure_expedient, '{2}'=>FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferNotification->start_date, false), '{3}'=>FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferNotification->end_date, false), '{4}'=>$oPurchasesFormRequestOfferNotification->message));  
         ?>
         </div>
         <?php           
      }
   }
   ?>
</div>