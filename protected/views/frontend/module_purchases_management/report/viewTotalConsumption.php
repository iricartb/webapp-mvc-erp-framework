<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/total_consumption.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER_LINE_TOTAL_CONSUMPTION')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWTOTALCONSUMPTION_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formTotalConsumption = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-total-consumption-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/report/viewTotalConsumption'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   ));
   ?>

   <div id="id_form_content">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWTOTALCONSUMPTION_FORM_LIST_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formTotalConsumption->labelEx($oModelForm, 'nIdProvider', array('style'=>'width:300px;')); ?>
               <?php echo FForm::textFieldAutoComplete($oModelForm, 'nIdProvider', CHtml::listData(Providers::getProviders(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formTotalConsumption->error($oModelForm, 'nIdProvider', array('style'=>'width:300px;')); ?>    
            </div>
            <div class="last_cell">
               <?php echo $formTotalConsumption->labelEx($oModelForm, 'nYear', array('style'=>'width:200px;')); ?>
               <?php echo $formTotalConsumption->dropDownList($oModelForm, 'nYear', FForm::getLastFiveYears(), array('style'=>'width:200px;')); ?>  
               <?php echo $formTotalConsumption->error($oModelForm, 'nYear', array('style'=>'width:200px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formTotalConsumption->labelEx($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
               <?php echo $formTotalConsumption->dropDownList($oModelForm, 'sDocFormat', array(FFile::FILE_XLS_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL'), FFile::FILE_XLSX_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL_2007'), FFile::FILE_PDF_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_PDF')), array('style'=>'width:300px;')); ?>
               <?php echo $formTotalConsumption->error($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_LIST'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>                                                             
     
   <?php $this->endWidget(); ?>
</div>