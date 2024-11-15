<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/inventory.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WAREHOUSE_MANAGEMENT_HEADER_LINE_INVENTORY')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWINVENTORY_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formInventory = $this->beginWidget('CActiveForm', array(
      'id'=>'warehouse-inventory-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/report/viewInventory'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   ));
   ?>

   <div id="id_form_content">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWINVENTORY_FORM_LIST_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row"> 
            <div class="cell">
               <?php echo $formInventory->labelEx($oModelForm, 'nIdArticle', array('style'=>'width:400px;')); ?>
               <?php echo $formInventory->dropDownList($oModelForm, 'nIdArticle', CHtml::listData(Articles::getArticles(), 'id', 'fullName'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:400px;')); ?>
               <?php echo $formInventory->error($oModelForm, 'nIdArticle', array('style'=>'width:400px;')); ?>   
            </div>
            <div class="cell">
               <?php echo $formInventory->labelEx($oModelForm, 'bOnlyAbsolete', array('style'=>'width:80px;')); ?>
               <?php echo $formInventory->checkBox($oModelForm, 'bOnlyAbsolete', array('style'=>'width:10px;')); ?>
               <?php echo $formInventory->error($oModelForm, 'bOnlyAbsolete', array('style'=>'width:80px;')); ?> 
            </div>
            <div class="last_cell">
               <?php echo $formInventory->labelEx($oModelForm, 'bOnlyCommonwealth', array('style'=>'width:80px;')); ?>
               <?php echo $formInventory->checkBox($oModelForm, 'bOnlyCommonwealth', array('style'=>'width:10px;')); ?>
               <?php echo $formInventory->error($oModelForm, 'bOnlyCommonwealth', array('style'=>'width:80px;')); ?> 
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formInventory->labelEx($oModelForm, 'sProvider', array('style'=>'width:300px;')); ?>
               <?php echo $formInventory->textField($oModelForm, 'sProvider', array('style'=>'width:300px;')); ?>
               <?php echo $formInventory->error($oModelForm, 'sProvider', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formInventory->labelEx($oModelForm, 'sDate', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'sDate', false, FDate::getTimeZoneFormattedDate(FModuleWarehouseManagement::HISTORICAL_CROSSLINE_DATE), 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '130px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate(date('Ymd')))); ?>
               <?php echo $formInventory->error($oModelForm, 'sDate', array('style'=>'width:130px;')); ?>
            </div>
         </div>
         <div class="row"> 
            <div class="cell">
               <?php echo $formInventory->labelEx($oModelForm, 'nIdSubcategory', array('style'=>'width:300px;')); ?>
               <?php echo $formInventory->dropDownList($oModelForm, 'nIdSubcategory', CHtml::listData(WarehouseArticlesSubcategories::getFullWarehouseArticlesSubcategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formInventory->error($oModelForm, 'nIdSubcategory', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formInventory->labelEx($oModelForm, 'nIdLocation', array('style'=>'width:300px;')); ?>
               <?php echo $formInventory->dropDownList($oModelForm, 'nIdLocation', CHtml::listData(WarehouseArticlesLocationsSubcategories::getFullWarehouseArticlesLocationsSubcategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formInventory->error($oModelForm, 'nIdLocation', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formInventory->labelEx($oModelForm, 'sOrder', array('style'=>'width:300px;')); ?>
               <?php echo $formInventory->dropDownList($oModelForm, 'sOrder', array(FModuleWarehouseManagement::REPORT_INVENTORY_ORDER_CODE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_ORDER_VALUE_CODE'), FModuleWarehouseManagement::REPORT_INVENTORY_ORDER_DESCRIPTION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_ORDER_VALUE_DESCRIPTION')), array('style'=>'width:300px;')); ?>
               <?php echo $formInventory->error($oModelForm, 'sOrder', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formInventory->labelEx($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
               <?php echo $formInventory->dropDownList($oModelForm, 'sDocFormat', array(FFile::FILE_XLS_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL'), FFile::FILE_XLSX_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL_2007'), FFile::FILE_PDF_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_PDF')), array('style'=>'width:300px;')); ?>
               <?php echo $formInventory->error($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_LIST'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>                                                             
     
   <?php $this->endWidget(); ?>
</div>