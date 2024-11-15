<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/people.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_VISITORS_MANAGEMENT_HEADER_LINE_PEOPLE')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWPEOPLE_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formPeople = $this->beginWidget('CActiveForm', array(
      'id'=>'visitors-people-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/report/viewPeople'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   ));
   ?>

   <div id="id_form_content">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWPEOPLE_FORM_LIST_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formPeople->labelEx($oModelForm, 'sType', array('style'=>'width:300px;')); ?>
               <?php if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) {
                        echo $formPeople->dropDownList($oModelForm, 'sType', array(FModuleVisitorsManagement::TYPE_PEOPLE_VISIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSPEOPLEFORM_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_PEOPLE_VISIT), FModuleVisitorsManagement::TYPE_PEOPLE_EMPLOYEE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSPEOPLEFORM_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_PEOPLE_EMPLOYEE), FModuleVisitorsManagement::TYPE_PEOPLE_VISIT_EMPLOYEE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSPEOPLEFORM_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_PEOPLE_VISIT_EMPLOYEE)), array('style'=>'width:300px;')); 
                     }
                     else {
                        echo $formPeople->dropDownList($oModelForm, 'sType', array(FModuleVisitorsManagement::TYPE_PEOPLE_VISIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSPEOPLEFORM_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_PEOPLE_VISIT)), array('style'=>'width:300px;'));   
                     } ?>
               <?php echo $formPeople->error($oModelForm, 'sType', array('style'=>'width:300px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formPeople->labelEx($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
               <?php echo $formPeople->dropDownList($oModelForm, 'sDocFormat', array(FFile::FILE_XLS_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL'), FFile::FILE_XLSX_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL_2007'), FFile::FILE_PDF_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_PDF')), array('style'=>'width:300px;')); ?>
               <?php echo $formPeople->error($oModelForm, 'sDocFormat', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_LIST'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>                                                             
     
   <?php $this->endWidget(); ?>
</div>