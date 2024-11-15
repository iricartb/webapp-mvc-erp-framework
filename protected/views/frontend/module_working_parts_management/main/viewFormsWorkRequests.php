<?php 
if ($oModelFormFilters->sFilterStatusPending) $sFilterStatusPending = 'checked';
else $sFilterStatusPending = FString::STRING_EMPTY; 

if ($oModelFormFilters->sFilterStatusFinalized) $sFilterStatusFinalized = 'checked';
else $sFilterStatusFinalized = FString::STRING_EMPTY; 

if (!$oModelFormFilters->bFilterVisibleDate) $sFilterVisibleDate = 'checked';
else $sFilterVisibleDate = FString::STRING_EMPTY; 


$oDiscartParameters = array('r', 'FormsWorkRequests[sFilterStatusPending]', 'FormsWorkRequests[sFilterStatusFinalized]');

$sJsParameters = 'function createUrlParameters() {
                     var sFilterStatusPending = \'&FormsWorkRequests[sFilterStatusPending]=\';    
                     if (document.getElementById(\'id_filter_status_pending\').checked) sFilterStatusPending += \'1\';
                     else sFilterStatusPending += \'0\';
                     
                     var sFilterStatusFinalized = \'&FormsWorkRequests[sFilterStatusFinalized]=\';    
                     if (document.getElementById(\'id_filter_status_finalized\').checked) sFilterStatusFinalized += \'1\';
                     else sFilterStatusFinalized += \'0\';
                     
                     return sFilterStatusPending + sFilterStatusFinalized; 
                  };';
?>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/forms_work_requests.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WORKING_PARTS_MANAGEMENT_HEADER_LINE_FORMS_WORK_REQUESTS')); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSWORKREQUESTS_DESCRIPTION'); ?>
</div>

<?php if (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) { ?>
   <div class="form">
      <?php $formFormWorkRequest = $this->beginWidget('CActiveForm', array(
         'id'=>'form-work-request-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsWorkRequests'),
         'enableAjaxValidation'=>true,
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
         ),
      )); ?>
           
      <div class="form_expand_collapse" >
         <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
         </div>
         <div class="form_expand_collapse_text">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSWORKREQUESTS_FORM_NEW_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
       
      <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSWORKREQUESTS_FORM_NEW_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="last_cell">
                  <?php echo $formFormWorkRequest->labelEx($oModelForm, 'priority', array('style'=>'width:300px;')); ?>
                  <?php echo $formFormWorkRequest->dropDownList($oModelForm, 'priority', CHtml::listData(Priorities::getPriorities(), 'description', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
                  <?php echo $formFormWorkRequest->error($oModelForm, 'priority', array('style'=>'width:300px;')); ?>    
               </div>
            </div>
            <div class="row">
               <div class="last_cell">
                   <?php echo $formFormWorkRequest->labelEx($oModelForm, 'description', array('style'=>'width:630px;')); ?>
                   <?php echo $formFormWorkRequest->textArea($oModelForm, 'description', array('style'=>'width:630px; height:105px; overflow:auto; resize:none')); ?>
                   <?php echo $formFormWorkRequest->error($oModelForm, 'description', array('style'=>'width:630px;')); ?>     
               </div>
            </div>
         </div>
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
         </div>     
      </div>
        
      <?php $this->endWidget(); ?>
   </div>
<?php } ?>
    
<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSWORKREQUESTS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('formsWorkRequests', FApplication::MODULE_WORKING_PARTS_MANAGEMENT, 'FormsWorkRequests', $oModelFormFilters->sFilterStatusPending . ',' . $oModelFormFilters->sFilterStatusFinalized, FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>

<?php $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id); ?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormFilters->search(),
   'filter'=>$oModelFormFilters,
   'rowCssClassExpression'=>'strtolower($data->status)',
   'columns'=> array(
      array(
         'name'=>'owner',
         'htmlOptions'=>array('width'=>140),
      ),
      array(
         'name'=>'description',
         'value'=>'FString::getAbbreviationSentence($data->description, 60)',
         'htmlOptions'=>array('width'=>300),
      ),
      array(
         'name'=>'comments',
         'value'=>'FString::getAbbreviationSentence($data->comments, 40)',
         'htmlOptions'=>array('width'=>150),
      ),
      array(
         'name'=>'priority',
         'filter'=>CHtml::listData(Priorities::getPriorities(), 'description', 'description'),
         'htmlOptions'=>array('width'=>70),
      ),
      array(                     
         'name'=>'start_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->start_date, true)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'start_date', false, FString::STRING_EMPTY, 'strtotime()'), true), 
         'htmlOptions'=>array('width'=>120),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormWorkRequest", array("nIdForm"=>$data->primaryKey))', '(FModuleWorkingPartsManagement::allowUpdateFormWorkRequest($data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormWorkRequest", array("nIdForm"=>$data->primaryKey))', 'true'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormWorkRequest", array("nIdForm"=>$data->primaryKey))', '(FModuleWorkingPartsManagement::allowDeleteFormWorkRequest($data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>

<div class="row">
   <div class="cell">
      <input type="checkbox" <?php echo $sFilterVisibleDate;?> disabled>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWorkingPartsManagement::COLOR_GRID_STATUS_PENDING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_STATUS_VALUE_PENDING_FUTURE');?>
   </div>
   
   <div class="cell">
      <input id="id_filter_status_pending" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsWorkRequests') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusPending;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWorkingPartsManagement::COLOR_GRID_STATUS_PENDING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_STATUS_VALUE_PENDING');?>
   </div>
   
   <div class="last_cell">
      <input id="id_filter_status_finalized" type="checkbox" onclick="<?php echo $sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsWorkRequests') . FUrl::getUrlParameters($oDiscartParameters) . '\' + createUrlParameters()'?>" <?php echo $sFilterStatusFinalized;?>>
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModuleWorkingPartsManagement::COLOR_GRID_STATUS_FINALIZED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_STATUS_VALUE_FINALIZED');?>
   </div>
</div>