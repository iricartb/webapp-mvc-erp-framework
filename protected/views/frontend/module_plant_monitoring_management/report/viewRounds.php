<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/rounds.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PLANT_MONITORING_MANAGEMENT_HEADER_LINE_ROUNDS')); ?>
   </div>
</div>
    
<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWROUNDS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formRounds = $this->beginWidget('CActiveForm', array(
      'id'=>'monitoring-rounds-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/report/viewRounds'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   ));
   ?>

   <div id="id_form_content">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWROUNDS_FORM_LIST_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell"> 
               <?php echo $formRounds->labelEx($oModelForm, 'sEmployee', array('style'=>'width:300px;')); ?>
               <?php echo $formRounds->dropDownList($oModelForm, 'sEmployee', CHtml::listData(MonitoringFormsTurnRounds::getMonitoringFormsTurnRoundsUsers(), 'user_name', 'user_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formRounds->error($oModelForm, 'sEmployee', array('style'=>'width:300px;')); ?>           
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formRounds->labelEx($oModelForm, 'sStartDate', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'sStartDate', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '130px')); ?>
               <?php echo $formRounds->error($oModelForm, 'sStartDate', array('style'=>'width:130px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formRounds->labelEx($oModelForm, 'sEndDate', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'sEndDate', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '130px')); ?>
               <?php echo $formRounds->error($oModelForm, 'sEndDate', array('style'=>'width:130px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formRounds->labelEx($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
               <?php echo $formRounds->dropDownList($oModelForm, 'sDocFormat', array(FFile::FILE_XLS_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL'), FFile::FILE_XLSX_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL_2007'), FFile::FILE_PDF_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_PDF')), array('style'=>'width:300px;')); ?>
               <?php echo $formRounds->error($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_LIST'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>                                                             
     
   <?php $this->endWidget(); ?>
</div>