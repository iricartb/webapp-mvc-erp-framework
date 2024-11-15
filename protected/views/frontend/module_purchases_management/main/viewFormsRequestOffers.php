<?php 
if ($oModelForm->sFilterStatusCreated) $sFilterStatusCreated = 'checked';
else $sFilterStatusCreated = FString::STRING_EMPTY; 
           
if ($oModelForm->sFilterStatusPending) $sFilterStatusPending = 'checked';
else $sFilterStatusPending = FString::STRING_EMPTY;

if ($oModelForm->sFilterStatusAccepted) $sFilterStatusAccepted = 'checked';
else $sFilterStatusAccepted = FString::STRING_EMPTY;

if ($oModelForm->sFilterStatusDiscarded) $sFilterStatusDiscarded = 'checked';
else $sFilterStatusDiscarded = FString::STRING_EMPTY;

$oDiscartParameters = array('r', 'PurchasesFormsRequestOffers[sFilterStatusCreated]', 'PurchasesFormsRequestOffers[sFilterStatusPending]', 'PurchasesFormsRequestOffers[sFilterStatusAccepted]', 'PurchasesFormsRequestOffers[sFilterStatusDiscarded]');

$sJsParameters = 'function createUrlParameters() {
                     var sFilterStatusCreated = \'&PurchasesFormsRequestOffers[sFilterStatusCreated]=\';
                     if (document.getElementById(\'id_filter_status_created\').checked) sFilterStatusCreated += \'1\';
                     else sFilterStatusCreated += \'0\';
                     
                     var sFilterStatusPending = \'&PurchasesFormsRequestOffers[sFilterStatusPending]=\';    
                     if (document.getElementById(\'id_filter_status_pending\').checked) sFilterStatusPending += \'1\';
                     else sFilterStatusPending += \'0\';
                     
                     var sFilterStatusAccepted = \'&PurchasesFormsRequestOffers[sFilterStatusAccepted]=\';    
                     if (document.getElementById(\'id_filter_status_accepted\').checked) sFilterStatusAccepted += \'1\';
                     else sFilterStatusAccepted += \'0\';
                     
                     var sFilterStatusDiscarded = \'&PurchasesFormsRequestOffers[sFilterStatusDiscarded]=\';    
                     if (document.getElementById(\'id_filter_status_discarded\').checked) sFilterStatusDiscarded += \'1\';
                     else sFilterStatusDiscarded += \'0\';
                     
                     return sFilterStatusCreated + sFilterStatusPending + sFilterStatusAccepted + sFilterStatusDiscarded; 
                  };';
?>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/forms_request_offers.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER_LINE_FORMS_REQUEST_OFFERS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSREQUESTOFFERS_DESCRIPTION'); ?>
</div>

<div class="toolbox_table">
   <div class="toolbox_table_first_cell_button_left">
      <?php $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('createFormRequestOffer') . '\''; ?>      
      <?php echo FWidget::showIconImageButton('purchasesFormsRequestOffers', 'document_new_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSREQUESTOFFERS_NEW_BTN_DESCRIPTION'), $sAction); ?>   
   </div>
   <div class="toolbox_table_first_cell_button">      
      <?php echo FWidget::showToolboxExporterData('purchasesFormsRequestOffers', FApplication::MODULE_PURCHASES_MANAGEMENT, 'PurchasesFormsRequestOffers', '0,' . $oModelForm->sFilterStatusCreated . ',' . $oModelForm->sFilterStatusPending . ',' . $oModelForm->sFilterStatusAccepted . ',' . $oModelForm->sFilterStatusDiscarded, FString::STRING_EMPTY, $this, true); ?>   
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
                  'name'=>'department',
                  'filter'=>array(FApplication::EMPLOYEE_DEPARTMENT_ADMINISTRATION=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_ADMINISTRATION'), FApplication::EMPLOYEE_DEPARTMENT_PREVENTION_SECURITY=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_PREVENTION_SECURITY'), FApplication::EMPLOYEE_DEPARTMENT_OPERATING=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_OPERATING'), FApplication::EMPLOYEE_DEPARTMENT_MANAGEMENT=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_MANAGEMENT'), FApplication::EMPLOYEE_DEPARTMENT_LOGISTIC=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_LOGISTIC'), FApplication::EMPLOYEE_DEPARTMENT_MAINTENANCE=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_MAINTENANCE'), FApplication::EMPLOYEE_DEPARTMENT_TECHNICAL_OFFICE=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_TECHNICAL_OFFICE')),
                  'value'=>'Yii::t(\'rainbow\', \'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_\' . $data->department)',
                  'htmlOptions'=>array('width'=>160),
               ),
               array(                          
                  'name'=>'description',
                  'value'=>'FString::getAbbreviationSentence($data->description, 60)',
                  'htmlOptions'=>array('width'=>400),
               ),
               FGrid::getEditButton('Yii::app()->controller->createUrl("changeStatusFormRequestOffer", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowChangeStatusFormRequestOffer($data->primaryKey)', FString::STRING_BOOLEAN_TRUE, false, 'refresh_arrow_1.png'),
               FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormRequestOffer", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowUpdateFormRequestOffer($data->primaryKey)', false),
               FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormRequestOffer", array("nIdForm"=>$data->primaryKey))', FString::STRING_BOOLEAN_TRUE, true, false, 'search_magnifying_glass_1.png', 'fancybox'),
               FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormRequestOffer", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowDeleteFormRequestOffer($data->primaryKey)'),
            );

$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelForm->search(false, null, null, null, null, false, null, FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG),
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
      <input id="id_filter_status_created" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsRequestOffers') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusCreated;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_CREATED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_STATUS_VALUE_CREATED');?>
   </div>
   
   <div class="cell">
      <input id="id_filter_status_pending" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsRequestOffers') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusPending;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_PENDING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_STATUS_VALUE_PENDING');?>
   </div>
   
   <div class="cell">
      <input id="id_filter_status_accepted" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsRequestOffers') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusAccepted;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_ACCEPTED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_STATUS_VALUE_ACCEPTED');?>
   </div>
   
   <div class="last_cell">
      <input id="id_filter_status_discarded" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsRequestOffers') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusDiscarded;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_DISCARDED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_STATUS_VALUE_DISCARDED');?>
   </div>
</div>