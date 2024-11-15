<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/stock.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WAREHOUSE_MANAGEMENT_HEADER_LINE_STOCK')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWSTOCK_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formStock = $this->beginWidget('CActiveForm', array(
      'id'=>'warehouse-stock-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/report/viewStock'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   ));
   ?>

   <div id="id_form_content">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWSTOCK_FORM_LIST_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row"> 
            <div class="cell">
               <?php echo $formStock->labelEx($oModelForm, 'nIdArticle', array('style'=>'width:400px;')); ?>
               <?php echo $formStock->dropDownList($oModelForm, 'nIdArticle', CHtml::listData(Articles::getArticles(), 'id', 'fullName'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:400px;')); ?>
               <?php echo $formStock->error($oModelForm, 'nIdArticle', array('style'=>'width:400px;')); ?>   
            </div>
            <div class="cell">
               <?php echo $formStock->labelEx($oModelForm, 'bOnlyStock', array('style'=>'width:80px;')); ?>
               <?php echo $formStock->checkBox($oModelForm, 'bOnlyStock', array('style'=>'width:10px;')); ?>
               <?php echo $formStock->error($oModelForm, 'bOnlyStock', array('style'=>'width:80px;')); ?> 
            </div>
            <div class="cell">
               <?php echo $formStock->labelEx($oModelForm, 'bOnlyAbsolete', array('style'=>'width:80px;')); ?>
               <?php echo $formStock->checkBox($oModelForm, 'bOnlyAbsolete', array('style'=>'width:10px;')); ?>
               <?php echo $formStock->error($oModelForm, 'bOnlyAbsolete', array('style'=>'width:80px;')); ?> 
            </div>
            <div class="last_cell">
               <?php echo $formStock->labelEx($oModelForm, 'bOnlyCommonwealth', array('style'=>'width:80px;')); ?>
               <?php echo $formStock->checkBox($oModelForm, 'bOnlyCommonwealth', array('style'=>'width:10px;')); ?>
               <?php echo $formStock->error($oModelForm, 'bOnlyCommonwealth', array('style'=>'width:80px;')); ?> 
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formStock->labelEx($oModelForm, 'sProvider', array('style'=>'width:300px;')); ?>
               <?php echo $formStock->textField($oModelForm, 'sProvider', array('style'=>'width:300px;')); ?>
               <?php echo $formStock->error($oModelForm, 'sProvider', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
         <div class="row"> 
            <div class="cell">
               <?php echo $formStock->labelEx($oModelForm, 'nIdSubcategory', array('style'=>'width:300px;')); ?>
               <?php echo $formStock->dropDownList($oModelForm, 'nIdSubcategory', CHtml::listData(WarehouseArticlesSubcategories::getFullWarehouseArticlesSubcategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formStock->error($oModelForm, 'nIdSubcategory', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formStock->labelEx($oModelForm, 'nIdLocation', array('style'=>'width:300px;')); ?>
               <?php echo $formStock->dropDownList($oModelForm, 'nIdLocation', CHtml::listData(WarehouseArticlesLocationsSubcategories::getFullWarehouseArticlesLocationsSubcategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formStock->error($oModelForm, 'nIdLocation', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formStock->labelEx($oModelForm, 'sOrder', array('style'=>'width:300px;')); ?>
               <?php echo $formStock->dropDownList($oModelForm, 'sOrder', array(FModuleWarehouseManagement::REPORT_STOCK_ORDER_CODE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSESTOCK_FIELD_ORDER_VALUE_CODE'), FModuleWarehouseManagement::REPORT_STOCK_ORDER_DESCRIPTION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSESTOCK_FIELD_ORDER_VALUE_DESCRIPTION')), array('style'=>'width:300px;')); ?>
               <?php echo $formStock->error($oModelForm, 'sOrder', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formStock->labelEx($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
               <?php echo $formStock->dropDownList($oModelForm, 'sDocFormat', array(FFile::FILE_XLS_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL'), FFile::FILE_XLSX_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL_2007'), FFile::FILE_PDF_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_PDF')), array('style'=>'width:300px;')); ?>
               <?php echo $formStock->error($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_LIST'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>                                                             
     
   <?php $this->endWidget(); ?>
</div>