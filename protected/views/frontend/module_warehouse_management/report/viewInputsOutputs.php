<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/inputs_outputs.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WAREHOUSE_MANAGEMENT_HEADER_LINE_INPUTS_OUTPUTS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWINPUTSOUTPUTS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formInputsOutputs = $this->beginWidget('CActiveForm', array(
      'id'=>'warehouse-inputs-outputs-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/report/viewInputsOutputs'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   ));
   ?>

   <div id="id_form_content">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWINPUTSOUTPUTS_FORM_LIST_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell"> 
               <?php echo $formInputsOutputs->labelEx($oModelForm, 'sType', array('style'=>'width:300px;')); ?>
               <?php echo $formInputsOutputs->dropDownList($oModelForm, 'sType', array(FModuleWarehouseManagement::REPORT_TYPE_INPUTS=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_TYPE_INPUTS'), FModuleWarehouseManagement::REPORT_TYPE_OUTPUTS=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_TYPE_OUTPUTS')), array('style'=>'width:300px;', 'onchange'=>'window.location = \'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/report/viewInputsOutputs') . '&WarehouseInputsOutputsForm[sType]=\' + this.value')); ?>
               <?php echo $formInputsOutputs->error($oModelForm, 'sType', array('style'=>'width:300px;')); ?>           
            </div>
            <?php
            if ((FString::isNullOrEmpty($oModelForm->sType)) || ($oModelForm->sType == FModuleWarehouseManagement::REPORT_TYPE_INPUTS)) { ?>
               <div class="last_cell"> 
                  <?php echo $formInputsOutputs->labelEx($oModelForm, 'sSubtype', array('style'=>'width:300px;')); ?>
                  <?php echo $formInputsOutputs->dropDownList($oModelForm, 'sSubtype', array(FModuleWarehouseManagement::TYPE_INPUT_WAYBILL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_WAYBILL'), FModuleWarehouseManagement::TYPE_INPUT_BENEFIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_BENEFIT'), FModuleWarehouseManagement::TYPE_INPUT_REPAIR=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_REPAIR'), FModuleWarehouseManagement::TYPE_INPUT_REGULARIZATION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_REGULARIZATION')), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
                  <?php echo $formInputsOutputs->error($oModelForm, 'sSubtype', array('style'=>'width:300px;')); ?>           
               </div>   
            <?php
            } else { ?>
               <div class="last_cell"> 
                  <?php echo $formInputsOutputs->labelEx($oModelForm, 'sSubtype', array('style'=>'width:300px;')); ?>
                  <?php echo $formInputsOutputs->dropDownList($oModelForm, 'sSubtype', array(FModuleWarehouseManagement::TYPE_OUTPUT_PLANT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_PLANT'), FModuleWarehouseManagement::TYPE_OUTPUT_DEVOLUTION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_DEVOLUTION'), FModuleWarehouseManagement::TYPE_OUTPUT_BENEFIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_BENEFIT'), FModuleWarehouseManagement::TYPE_OUTPUT_REPAIR=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_REPAIR'), FModuleWarehouseManagement::TYPE_OUTPUT_REGULARIZATION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_REGULARIZATION')), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
                  <?php echo $formInputsOutputs->error($oModelForm, 'sSubtype', array('style'=>'width:300px;')); ?>           
               </div> 
            <?php
            }
            ?>                                                         
         </div>
         <div class="row"> 
            <div class="cell">
               <?php echo $formInputsOutputs->labelEx($oModelForm, 'nIdArticle', array('style'=>'width:585px;')); ?>
               <?php echo $formInputsOutputs->dropDownList($oModelForm, 'nIdArticle', CHtml::listData(Articles::getArticles(), 'id', 'fullName'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:585px;')); ?>
               <?php echo $formInputsOutputs->error($oModelForm, 'nIdArticle', array('style'=>'width:585px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formInputsOutputs->labelEx($oModelForm, 'bOnlyIPE', array('style'=>'width:60px;')); ?>
               <?php echo $formInputsOutputs->checkBox($oModelForm, 'bOnlyIPE', array('style'=>'width:10px;')); ?>
               <?php echo $formInputsOutputs->error($oModelForm, 'bOnlyIPE', array('style'=>'width:60px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formInputsOutputs->labelEx($oModelForm, 'sProvider', array('style'=>'width:297px;')); ?>
               <?php echo $formInputsOutputs->textField($oModelForm, 'sProvider', array('style'=>'width:297px;')); ?>
               <?php echo $formInputsOutputs->error($oModelForm, 'sProvider', array('style'=>'width:297px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formInputsOutputs->labelEx($oModelForm, 'sEmployee', array('style'=>'width:297px;')); ?>
               <?php echo $formInputsOutputs->textField($oModelForm, 'sEmployee', array('style'=>'width:297px;')); ?>
               <?php echo $formInputsOutputs->error($oModelForm, 'sEmployee', array('style'=>'width:297px;')); ?>   
            </div>
         </div>
         <div class="row"> 
            <div class="cell">
               <?php echo $formInputsOutputs->labelEx($oModelForm, 'nIdSubcategory', array('style'=>'width:300px;')); ?>
               <?php echo $formInputsOutputs->dropDownList($oModelForm, 'nIdSubcategory', CHtml::listData(WarehouseArticlesSubcategories::getFullWarehouseArticlesSubcategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formInputsOutputs->error($oModelForm, 'nIdSubcategory', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formInputsOutputs->labelEx($oModelForm, 'nIdLocation', array('style'=>'width:300px;')); ?>
               <?php echo $formInputsOutputs->dropDownList($oModelForm, 'nIdLocation', CHtml::listData(WarehouseArticlesLocationsSubcategories::getFullWarehouseArticlesLocationsSubcategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formInputsOutputs->error($oModelForm, 'nIdLocation', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formInputsOutputs->labelEx($oModelForm, 'sStartDate', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'sStartDate', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '130px', null, FDate::getTimeZoneFormattedDate($oModelForm->sStartDate))); ?>
               <?php echo $formInputsOutputs->error($oModelForm, 'sStartDate', array('style'=>'width:130px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formInputsOutputs->labelEx($oModelForm, 'sEndDate', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'sEndDate', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '130px', null, FDate::getTimeZoneFormattedDate($oModelForm->sEndDate))); ?>
               <?php echo $formInputsOutputs->error($oModelForm, 'sEndDate', array('style'=>'width:130px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formInputsOutputs->labelEx($oModelForm, 'sOrder', array('style'=>'width:300px;')); ?>
               <?php echo $formInputsOutputs->dropDownList($oModelForm, 'sOrder', array(FModuleWarehouseManagement::REPORT_INPUTSOUTPUTS_ORDER_DATE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_ORDER_VALUE_DATE'), FModuleWarehouseManagement::REPORT_INPUTSOUTPUTS_ORDER_PROVIDER=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_ORDER_VALUE_PROVIDER')), array('style'=>'width:300px;')); ?>
               <?php echo $formInputsOutputs->error($oModelForm, 'sOrder', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formInputsOutputs->labelEx($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
               <?php echo $formInputsOutputs->dropDownList($oModelForm, 'sDocFormat', array(FFile::FILE_XLS_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL'), FFile::FILE_XLSX_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL_2007'), FFile::FILE_PDF_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_PDF')), array('style'=>'width:300px;')); ?>
               <?php echo $formInputsOutputs->error($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_LIST'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>                                                             
     
   <?php $this->endWidget(); ?>
</div>