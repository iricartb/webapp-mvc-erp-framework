<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/orders.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER_LINE_ORDERS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formOrders = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-orders-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/report/viewOrders'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   ));
   ?>

   <div id="id_form_content">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERS_FORM_LIST_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formOrders->labelEx($oModelForm, 'nIdProvider', array('style'=>'width:300px;')); ?>
               <?php echo FForm::textFieldAutoComplete($oModelForm, 'nIdProvider', CHtml::listData(Providers::getProviders(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formOrders->error($oModelForm, 'nIdProvider', array('style'=>'width:300px;')); ?>    
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formOrders->labelEx($oModelForm, 'sOwner', array('style'=>'width:297px;')); ?>
               <?php echo $formOrders->textField($oModelForm, 'sOwner', array('style'=>'width:297px;')); ?>
               <?php echo $formOrders->error($oModelForm, 'sOwner', array('style'=>'width:297px;')); ?>  
            </div>
            <div class="last_cell">
               <?php echo $formOrders->labelEx($oModelForm, 'sDepartment', array('style'=>'width:297px;')); ?>
               <?php echo $formOrders->dropDownList($oModelForm, 'sDepartment', array(FApplication::EMPLOYEE_DEPARTMENT_ADMINISTRATION=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_ADMINISTRATION'), FApplication::EMPLOYEE_DEPARTMENT_PREVENTION_SECURITY=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_PREVENTION_SECURITY'), FApplication::EMPLOYEE_DEPARTMENT_OPERATING=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_OPERATING'), FApplication::EMPLOYEE_DEPARTMENT_MANAGEMENT=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_MANAGEMENT'), FApplication::EMPLOYEE_DEPARTMENT_LOGISTIC=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_LOGISTIC'), FApplication::EMPLOYEE_DEPARTMENT_MAINTENANCE=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_MAINTENANCE'), FApplication::EMPLOYEE_DEPARTMENT_TECHNICAL_OFFICE=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_TECHNICAL_OFFICE')), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:297px;')); ?>
               <?php echo $formOrders->error($oModelForm, 'sDepartment', array('style'=>'width:297px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formOrders->labelEx($oModelForm, 'sStartDate', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'sStartDate', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '130px', null, FDate::getTimeZoneFormattedDate($oModelForm->sStartDate))); ?>
               <?php echo $formOrders->error($oModelForm, 'sStartDate', array('style'=>'width:130px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formOrders->labelEx($oModelForm, 'sEndDate', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'sEndDate', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '130px', null, FDate::getTimeZoneFormattedDate($oModelForm->sEndDate))); ?>
               <?php echo $formOrders->error($oModelForm, 'sEndDate', array('style'=>'width:130px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formOrders->labelEx($oModelForm, 'bOnlyNotInvoices', array('style'=>'width:80px;')); ?>
               <?php echo $formOrders->checkBox($oModelForm, 'bOnlyNotInvoices', array('style'=>'width:10px;')); ?>
               <?php echo $formOrders->error($oModelForm, 'bOnlyNotInvoices', array('style'=>'width:80px;')); ?> 
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formOrders->labelEx($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
               <?php echo $formOrders->dropDownList($oModelForm, 'sDocFormat', array(FFile::FILE_XLS_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL'), FFile::FILE_XLSX_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL_2007'), FFile::FILE_PDF_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_PDF')), array('style'=>'width:300px;')); ?>
               <?php echo $formOrders->error($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_LIST'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>                                                             
     
   <?php $this->endWidget(); ?>
</div>