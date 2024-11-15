<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/invoices.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER_LINE_INVOICES')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWINVOICES_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formInvoices = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-invoices-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/report/viewInvoices'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   ));
   ?>

   <div id="id_form_content">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWINVOICES_FORM_LIST_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formInvoices->labelEx($oModelForm, 'nIdProvider', array('style'=>'width:300px;')); ?>
               <?php echo FForm::textFieldAutoComplete($oModelForm, 'nIdProvider', CHtml::listData(Providers::getProviders(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formInvoices->error($oModelForm, 'nIdProvider', array('style'=>'width:300px;')); ?>    
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formInvoices->labelEx($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
               <?php echo $formInvoices->dropDownList($oModelForm, 'sDocFormat', array(FFile::FILE_XLS_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL'), FFile::FILE_XLSX_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL_2007'), FFile::FILE_PDF_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_PDF')), array('style'=>'width:300px;')); ?>
               <?php echo $formInvoices->error($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_LIST'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>                                                             
     
   <?php $this->endWidget(); ?>
</div>