<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/checkins.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_ACCESS_CONTROL_MANAGEMENT_HEADER_LINE_CHECKINS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formCheckin = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-checkin-form',                                                                     
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewCheckins'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINS_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINS_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formCheckin->labelEx($oModelForm, 'employee_identification', array('style'=>'width:300px;')); ?>
               <?php echo $formCheckin->dropDownList($oModelForm, 'employee_identification', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, null, true), 'identification', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php //echo FForm::textFieldAutoComplete($oModelForm, 'employee_identification', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, null, true), 'identification', 'full_name'), array('style'=>'width:300px;')); ?>
               <?php echo $formCheckin->error($oModelForm, 'employee_identification', array('style'=>'width:300px;')); ?>      
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formCheckin->labelEx($oModelForm, 'date', array('style'=>'width:180px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'date', true, '0', null, null, null, true, false, '130px', FString::STRING_EMPTY, null)); ?>
               <?php echo $formCheckin->error($oModelForm, 'date', array('style'=>'width:180px;')); ?>      
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formCheckin->labelEx($oModelForm, 'type', array('style'=>'width:300px;')); ?>
               <?php echo $formCheckin->dropDownList($oModelForm, 'type', array(FModuleAccessControlManagement::TYPE_MAIN_INPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_MAIN_INPUT), FModuleAccessControlManagement::TYPE_MAIN_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_MAIN_OUTPUT), FModuleAccessControlManagement::TYPE_INPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_INPUT), FModuleAccessControlManagement::TYPE_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_OUTPUT), FModuleAccessControlManagement::TYPE_INPUT_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_INPUT_OUTPUT)), array('style'=>'width:300px;')); ?>
               <?php echo $formCheckin->error($oModelForm, 'type', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formCheckin->labelEx($oModelForm, 'incidence_code', array('style'=>'width:300px;')); ?>
               <?php echo $formCheckin->dropDownList($oModelForm, 'incidence_code', CHtml::listData(AccessControlIncidences::getAccessControlIncidences(), 'code', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formCheckin->error($oModelForm, 'incidence_code', array('style'=>'width:300px;')); ?>      
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>
                
   <?php $this->endWidget(); ?>
</div>

<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('accessControlCheckInMachine', FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT, 'AccessControlCheckInMachine', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormFilters->search(),
   'filter'=>$oModelFormFilters,
   'columns'=> array(
      array(
         'name'=>'employee_identification',
         'value'=>'(!is_null(Employees::getEmployeeByIdentification($data->employee_identification))) ? Employees::getEmployeeByIdentification($data->employee_identification)->full_name : FString::STRING_EMPTY',
         'filter'=>CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, null, null), 'identification', 'full_name'),
         'htmlOptions'=>array('width'=>200),
      ),
      array(
         'name'=>'start_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->date, true)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormFilters, 'start_date', false, null, 'strtotime()'), true), 
         'htmlOptions'=>array('width'=>140),
      ),   
      array(
         'name'=>'end_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->date, true)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormFilters, 'end_date', false, null, 'strtotime()'), true), 
         'htmlOptions'=>array('width'=>140),
      ),
      array(
         'name'=>'type',
         'value'=>'(!is_null($data->type)) ? FString::castStrToUpper(Yii::t(\'frontend_\' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), \'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_\' . $data->type)) : FString::castStrToUpper(Yii::t(\'frontend_\' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), \'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_\' . FModuleAccessControlManagement::TYPE_INPUT_OUTPUT . \'_ABBREVIATION\'))',
         'htmlOptions'=>array('width'=>130),
      ),
      array(
         'name'=>'incidence_code',
         'value'=>'(!is_null($data->incidence_code)) ? (!is_null(AccessControlIncidences::getAccessControlIncidenceByCode($data->incidence_code))) ? AccessControlIncidences::getAccessControlIncidenceByCode($data->incidence_code)->description : FString::STRING_EMPTY : FString::STRING_EMPTY',
         'filter'=>CHtml::listData(AccessControlIncidences::getAccessControlIncidences(), 'code', 'description'),
         'htmlOptions'=>array('width'=>100),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateCheckin", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailCheckin", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteCheckin", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>