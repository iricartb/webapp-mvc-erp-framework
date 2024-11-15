<?php $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters(); ?>

<script type="text/javascript">
   <?php 
   if (count($oModelFormComponents) > 0) { ?>
      $(document).ready(function() {
         $('#FormsWorkingParts_sComponents option').each(function() {
            <?php 
            foreach($oModelFormComponents as $oModelFormComponent) {
               echo 'if ($(this).val() == \'' . $oModelFormComponent->id_component . '\') {';
               echo '$(this).prop(\'selected\', \'true\');';
               echo '}'; 
            } ?>  
         });
      });
   <?php
   } ?>
   
   $(document).ready(function(){
      $('#FormsWorkingParts_sComponents').MultiSelect({
         size: 6,
         css_class_selected: 'multiselect_option_selected'
      });
   });
   
   function submit_form(form, data, hasError) {
      var oForm = document.getElementById('form-working-part-form');
      oForm.action += '&sIdComponents=' + $('#FormsWorkingParts_sComponents').val();
      
      return !hasError;
   }
</script>
  
<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/forms_working_parts.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php 
      $sTaskDescription = FString::STRING_EMPTY;
      if (!FString::isNullOrEmpty($oModelForm->task)) { 
         $sTaskDescription = ' - ' . $oModelForm->task;
      } ?>
            
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMWORKINGPART_HEADER', array('{1}'=>$oModelForm->id))) . $sTaskDescription; ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMWORKINGPART_DESCRIPTION'); ?>
</div>

<?php $sRefreshRegionsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartRegions') . '&nIdForm=' . $oModelForm->id;
      $sRefreshEquipmentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartEquipments') . '&nIdForm=' . $oModelForm->id;
      $sRefreshComponentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartComponents') . '&nIdForm=' . $oModelForm->id;
      $sJsRefreshComponentClear = '$(\'#FormsWorkingParts_sComponents option\').remove()';
      
      $sRefreshStatusUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartStatus') . '&nIdForm=' . $oModelForm->id; 
      $sRefreshInformationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartInformation') . '&nIdForm=' . $oModelForm->id;
      
      $sViewFormWorkingPartEmployeesUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartEmployees') . '&nIdForm=' . $oModelForm->id;  
      $sViewFormWorkingPartRisksIpesUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartRisksIPEs') . '&nIdForm=' . $oModelForm->id;
      $sViewFormWorkingPartDynamicTextsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartDynamicTexts') . '&nIdForm=' . $oModelForm->id;
      
      if ($oModelForm->data_completed) {
         $sJsRefreshInformation = "aj('" . $sRefreshInformationUrl . "', null, 'id_information', null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "', '" . FAjax::TYPE_METHOD_CONTENT_DECORATION_FADE . "', 500)";  
      }  
      else $sJsRefreshInformation = FString::STRING_EMPTY;
      
      $sJsRefreshEquipmentOthers = "$('#FormsWorkingParts_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', this.value == '" . FApplication::EQUIPMENT_OTHERS . "', 1.0, 1000)";
      $sJsRefreshDisappearEquipmentOthers = "$('#FormsWorkingParts_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', false, 1.0, 1000)";
      ?>

<?php if ($oModelForm->data_completed) { ?>
<div class="last_row">
   <div class="cell">
      <a id="id_item_employees" rel="fancybox" style="cursor:pointer;" href="<?php echo $sViewFormWorkingPartEmployeesUrl;?>">
         <div class="item-image">
            <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/item_employees.png" width="48px" height="48px">
         </div>
         <div class="item-image-description-center">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMWORKINGPART_ITEM_EMPLOYEES'); ?>
         </div>
      </a>
   </div>
   <div class="cell">
      <a id="id_item_risks_ipes" rel="fancybox" style="cursor:pointer;" href="<?php echo $sViewFormWorkingPartRisksIpesUrl;?>">
         <div class="item-image">
            <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/item_risksipes.png" width="48px" height="48px">
         </div>
         <div class="item-image-description-center">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMWORKINGPART_ITEM_RISKSIPES'); ?>
         </div>
      </a>
   </div>
   <div class="cell">
      <a id="id_item_dynamic_texts" rel="fancybox" style="cursor:pointer;" href="<?php echo $sViewFormWorkingPartDynamicTextsUrl;?>">
         <div class="item-image">
            <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/item_dynamictexts.png" width="48px" height="48px">
         </div>
         <div class="item-image-description-center">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMWORKINGPART_ITEM_DYNAMICTEXTS'); ?>
         </div>
      </a>
   </div>
   <div class="last_cell" style="width:100%; vertical-align:bottom; text-align:right;">
      <?php echo FWidget::showToolboxExporterCustomData('formWorkingPart', FApplication::MODULE_WORKING_PARTS_MANAGEMENT, 'formWorkingPart', $oModelForm->id, $this, true, true); ?>   
   </div>
</div>
<?php } ?>

<?php 
if (Yii::app()->user->hasFlash('success')) { ?>
   <div class="flash-success">
      <?php echo Yii::app()->user->getFlash('success'); ?>
   </div> <?php 
} ?>

<div class="form">       
   <?php $formFormWorkingPart = $this->beginWidget('CActiveForm', array(
      'id'=>'form-working-part-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/updateFormWorkingPart', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:submit_form',
      ),
   )); ?>
   
   <div class="form_content">
      <div class="first_row">
         <div class="cell_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMWORKINGPART_FORM_HEADER_MAIN'); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_OWNER') . ':' . FString::STRING_SPACE . $oModelForm->owner; ?>
         </div>
      </div>
      <?php if ($oModelForm->data_completed) { ?>
      <div class="row">
         <div class="last_cell">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STARTDATE_DETAIL') . ':' . FString::STRING_SPACE . FDate::getTimeZoneFormattedDate($oModelForm->start_date, true); ?>
         </div>
      </div>
      <?php } ?>
      
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'priority', array('style'=>'width:215px;')); ?>
            <?php echo $formFormWorkingPart->dropDownList($oModelForm, 'priority', CHtml::listData(Priorities::getPriorities(), 'description', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:215px;', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormWorkingPart->error($oModelForm, 'priority', array('style'=>'width:215px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'first_responsible', array('style'=>'width:215px;')); ?>
            <?php echo $formFormWorkingPart->dropDownList($oModelForm, 'first_responsible', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS), array(array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_OPERATING_TURN), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_MECHANICAL), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_ELECTRIC), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_TECHNICAL_OFFICE), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_OPERATING), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_MAINTENANCE), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_PREVENTION_SECURITY), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_TECHNICAL_DIRECTOR)), null, true), 'full_name', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:215px;', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormWorkingPart->error($oModelForm, 'first_responsible', array('style'=>'width:215px;')); ?>
         </div>
         <div class="last_cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'second_responsible', array('style'=>'width:215px;')); ?>
            <?php echo $formFormWorkingPart->dropDownList($oModelForm, 'second_responsible', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS), array(array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_OPERATING_TURN), array(null, FApplication::EMPLOYEE_DEPARTMENT_OPERATING, true), array(null, FApplication::EMPLOYEE_DEPARTMENT_MECHANICAL), array(null, FApplication::EMPLOYEE_DEPARTMENT_ELECTRIC), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_TECHNICAL_OFFICE), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_OPERATING), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_MAINTENANCE), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_PREVENTION_SECURITY), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_TECHNICAL_DIRECTOR)), null, true), 'full_name', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:215px;', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormWorkingPart->error($oModelForm, 'second_responsible', array('style'=>'width:215px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'fourth_responsible', array('style'=>'width:215px;')); ?>
            <?php echo FForm::textFieldAutoComplete($oModelForm, 'fourth_responsible', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS), array(array(null, FApplication::EMPLOYEE_DEPARTMENT_MECHANICAL), array(null, FApplication::EMPLOYEE_DEPARTMENT_ELECTRIC)), null, true, true), 'full_name', 'full_name'), array('style'=>'width:215px;'), false, true); ?>                 
            <?php echo $formFormWorkingPart->error($oModelForm, 'fourth_responsible', array('style'=>'width:215px;')); ?>
         </div>
         <div class="last_cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'third_responsible', array('style'=>'width:215px;')); ?>
            <?php echo FForm::textFieldAutoComplete($oModelForm, 'third_responsible', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS), null, null, true, true), 'full_name', 'full_name'), array('style'=>'width:215px;'), false, true); ?>                 
            <?php echo $formFormWorkingPart->error($oModelForm, 'third_responsible', array('style'=>'width:215px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'method_description', array('style'=>'width:705px;')); ?>
            <?php echo FForm::textFieldAutoComplete($oModelForm, 'method_code', CHtml::listData(Methods::getMethods(true), 'code', 'cbDescription'), array('style'=>'width:705px;font-size:11px;height:20px')); ?>
            <?php echo $formFormWorkingPart->error($oModelForm, 'method_code', array('style'=>'width:705px;')); ?>
         </div>
      </div>
      <?php
      if (!$oModelForm->data_completed) { ?>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'id_form_work_request', array('style'=>'width:705px;')); ?>
            <?php echo $formFormWorkingPart->dropDownList($oModelForm, 'id_form_work_request', CHtml::listData(FormsWorkRequests::getFormsWorkRequests(true, FModuleWorkingPartsManagement::STATUS_PENDING), 'id', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:705px;font-size:11px;height:20px', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormWorkingPart->error($oModelForm, 'id_form_work_request', array('style'=>'width:705px;')); ?>
         </div>
      </div>
      <?php 
      } ?>
      <br/>
      <div class="row">
         <div class="cell_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMWORKINGPART_FORM_HEADER_EQUIPMENT'); ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'id_zone', array('style'=>'width:300px;')); ?>                                                                                                                                                     
            <?php echo $formFormWorkingPart->dropDownList($oModelForm, 'id_zone', CHtml::listData(Zones::getZones(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsRefreshDisappearEquipmentOthers . ';aj(\'' . $sRefreshRegionsUrl . '&nIdZone=\' + this.value, null, \'id_region\');' . ';aj(\'' . $sRefreshEquipmentsUrl . '&nIdRegion=\', null, \'id_equipment\');' . $sJsRefreshComponentClear . ';' . $sJsRefreshInformation)); ?>           
            <?php echo $formFormWorkingPart->error($oModelForm, 'id_zone', array('style'=>'width:300px;')); ?>
         </div>
         <div class="last_cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>
            <div id="id_region">
               <?php 
                  if (!FString::isNullOrEmpty($oModelForm->id_zone)) {
                     echo $formFormWorkingPart->dropDownList($oModelForm, 'id_region', CHtml::listData(Regions::getRegions($oModelForm->id_zone), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsRefreshDisappearEquipmentOthers . ';' . ';aj(\'' . $sRefreshEquipmentsUrl . '&nIdRegion=\' + this.value, null, \'id_equipment\');' . $sJsRefreshComponentClear . ';' . $sJsRefreshInformation));                       
                  } else { 
                     echo $formFormWorkingPart->dropDownList($oModelForm, 'id_region', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); 
                  } 
               ?>
            </div>
            <?php echo $formFormWorkingPart->error($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
            <div id="id_equipment">
               <?php 
                  if ((!FString::isNullOrEmpty($oModelForm->id_zone)) && (!FString::isNullOrEmpty($oModelForm->id_region))) {
                     echo $formFormWorkingPart->dropDownList($oModelForm, 'id_equipment', CHtml::listData(Equipments::getEquipments($oModelForm->id_region, null, null, null, true), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsRefreshEquipmentOthers . ';' . ';aj(\'' . $sRefreshComponentsUrl . '&nIdEquipment=\' + this.value, null, \'FormsWorkingParts_sComponents\');' . $sJsRefreshInformation));  
                  } else { 
                     echo $formFormWorkingPart->dropDownList($oModelForm, 'id_equipment', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); 
                  } 
               ?>
            </div>
            <?php echo $formFormWorkingPart->error($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
         </div>
         <div class="last_cell">
            <div id="id_equipment_others" class="last_cell_content_expand_collapse_<?php if ($oModelForm->id_equipment == FApplication::EQUIPMENT_OTHERS) { echo 'show'; } else { echo 'hidden'; } ?>">
               <?php echo $formFormWorkingPart->labelEx($oModelForm, 'equipment', array('style'=>'width:300px;')); ?>
               <?php echo $formFormWorkingPart->textField($oModelForm, 'equipment', array('style'=>'width:300px;', 'onchange'=>$sJsRefreshInformation)); ?>
               <?php echo $formFormWorkingPart->error($oModelForm, 'equipment', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>

      <?php 
      if ((Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && (!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->show_components)) { ?> 
      <div class="row">
         <div class="first_row">
            <div class="cell">
               <?php echo $formFormWorkingPart->labelEx($oModelForm, 'sComponents', array('style'=>'width:300px;')); ?>
               <div id="id_components">
                  <?php 
                  if ((!FString::isNullOrEmpty($oModelForm->id_zone)) && (!FString::isNullOrEmpty($oModelForm->id_region)) && (!FString::isNullOrEmpty($oModelForm->id_equipment))) { 
                     echo $formFormWorkingPart->listBox($oModelForm, 'sComponents', CHtml::listData(Components::getComponents($oModelForm->id_equipment), 'id', 'name'), array('style'=>'width:630px;', 'multiple'=>'multiple', 'size'=>'6'));
                  } else {
                     echo $formFormWorkingPart->listBox($oModelForm, 'sComponents', array(), array('style'=>'width:630px;', 'multiple'=>'multiple'));   
                  } 
                  ?>
               </div>
               <?php echo $formFormWorkingPart->error($oModelForm, 'sComponents', array('style'=>'width:300px;')); ?>
            </div>
         </div> 
      </div>  
      <?php
      } ?>
      
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'equipment_failure_reason', array('style'=>'width:630px;')); ?>
            <?php echo $formFormWorkingPart->textArea($oModelForm, 'equipment_failure_reason', array('style'=>'width:630px; height:30px; overflow:auto; resize:none', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormWorkingPart->error($oModelForm, 'equipment_failure_reason', array('style'=>'width:630px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'equipment_studio_mechanic', array('style'=>'width:70px;')); ?>
            <?php echo $formFormWorkingPart->checkBox($oModelForm, 'equipment_studio_mechanic', array('style'=>'width:10px;', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormWorkingPart->error($oModelForm, 'equipment_studio_mechanic', array('style'=>'width:70px;')); ?>
         </div>
         <div class="cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'equipment_studio_electric', array('style'=>'width:70px;')); ?>
            <?php echo $formFormWorkingPart->checkBox($oModelForm, 'equipment_studio_electric', array('style'=>'width:10px;', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormWorkingPart->error($oModelForm, 'equipment_studio_electric', array('style'=>'width:70px;')); ?>
         </div>
         <div class="cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'equipment_studio_instrument', array('style'=>'width:100px;')); ?>
            <?php echo $formFormWorkingPart->checkBox($oModelForm, 'equipment_studio_instrument', array('style'=>'width:10px;', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormWorkingPart->error($oModelForm, 'equipment_studio_instrument', array('style'=>'width:100px;')); ?>
         </div>
         <div class="last_cell">
            <?php echo $formFormWorkingPart->labelEx($oModelForm, 'equipment_studio_others', array('style'=>'width:180px;')); ?>
            <?php echo $formFormWorkingPart->textField($oModelForm, 'equipment_studio_others', array('style'=>'width:180px;', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormWorkingPart->error($oModelForm, 'equipment_studio_others', array('style'=>'width:180px;')); ?>
         </div>
      </div>
      
      <?php 
      if ($oModelForm->data_completed) { ?>
         <br/>
         <div class="row">
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMWORKINGPART_FORM_HEADER_FINALIZE'); ?>
            </div>
         </div>
          <div class="row">
             <div class="last_cell">
                <?php echo $formFormWorkingPart->labelEx($oModelForm, 'failure_reason', array('style'=>'width:630px;')); ?>
                <?php echo $formFormWorkingPart->textArea($oModelForm, 'failure_reason', array('style'=>'width:630px; height:60px; overflow:auto; resize:none', 'onchange'=>$sJsRefreshInformation)); ?>
                <?php echo $formFormWorkingPart->error($oModelForm, 'failure_reason', array('style'=>'width:630px;')); ?>
             </div>
          </div>
          <div class="row">
             <div class="last_cell">
                <?php echo $formFormWorkingPart->labelEx($oModelForm, 'failure_solution', array('style'=>'width:630px;')); ?>
                <?php echo $formFormWorkingPart->textArea($oModelForm, 'failure_solution', array('style'=>'width:630px; height:60px; overflow:auto; resize:none', 'onchange'=>$sJsRefreshInformation)); ?>
                <?php echo $formFormWorkingPart->error($oModelForm, 'failure_solution', array('style'=>'width:630px;')); ?>
             </div>
          </div>
          <div class="row">
             <div class="last_cell">
                <?php echo $formFormWorkingPart->labelEx($oModelForm, 'comments', array('style'=>'width:630px;')); ?>
                <?php echo $formFormWorkingPart->textArea($oModelForm, 'comments', array('style'=>'width:630px; height:105px; overflow:auto; resize:none', 'onchange'=>$sJsRefreshInformation)); ?>
                <?php echo $formFormWorkingPart->error($oModelForm, 'comments', array('style'=>'width:630px;')); ?>
             </div>
          </div>
       <?php 
       } ?>
       
       <br/>   
       <div class="row">
          <div class="cell_header">
             <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMWORKINGPART_FORM_HEADER_STATUS'); ?>
          </div>
       </div>
       <div id="idStatus" class="row">
       <?php 
          if ((is_null($oWorkingPartModuleParameters)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_created)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_created == false) && ($oWorkingPartModuleParameters->working_part_show_status_pending == false) && ($oWorkingPartModuleParameters->working_part_show_status_running == false) && ($oWorkingPartModuleParameters->working_part_show_status_pending_absence == false) && ($oWorkingPartModuleParameters->working_part_show_status_halted == false) && ($oWorkingPartModuleParameters->working_part_show_status_finalized == false))) { ?>
       <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_CREATED) { ?>
          <div id="id_item_created" class="cell">
       <?php } else { ?>                                                                                                                                                                                                         
          <div id="id_item_created" class="cell" style="cursor:pointer;" onclick="aj('<?php echo $sRefreshStatusUrl . '&sStatus=' . FModuleWorkingPartsManagement::STATUS_CREATED;?>', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'<?php echo FModuleWorkingPartsManagement::STATUS_CREATED;?>\'');<?php echo $sJsRefreshInformation;?>;">
       <?php } ?>
              
             <div class="item-image">
                <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_CREATED) { ?>
                   <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_created.png" width="48px" height="48px">
                <?php } else { ?>
                   <img class="item-image-fade-20-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_created.png" width="48px" height="48px">
                <?php } ?>
             </div>
             <div class="item-image-description-center">
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_CREATED;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_CREATED'); ?></font>
             </div>
          </div>
       <?php
       }
       ?>
       
       <?php
       if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_pending)) { ?>  
       <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_PENDING) { ?>
          <div id="id_item_pending" class="cell">
       <?php } else { ?>
          <div id="id_item_pending" class="cell" style="cursor:pointer;" onclick="aj('<?php echo $sRefreshStatusUrl . '&sStatus=' . FModuleWorkingPartsManagement::STATUS_PENDING;?>', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'<?php echo FModuleWorkingPartsManagement::STATUS_PENDING;?>\'');<?php echo $sJsRefreshInformation;?>;">
       <?php } ?>

             <div class="item-image">
                <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_PENDING) { ?>
                   <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_pending.png" width="48px" height="48px">
                <?php } else { ?>
                   <img class="item-image-fade-20-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_pending.png" width="48px" height="48px">
                <?php } ?>
             </div>
             <div class="item-image-description-center">
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_PENDING;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_PENDING'); ?></font>
             </div>
          </div>
       <?php
       }
       ?>
       
       <?php
       if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_running)) { ?>
       <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_RUNNING) { ?>
          <div id="id_item_running" class="cell">
       <?php } else { ?>
          <div id="id_item_running" class="cell" style="cursor:pointer;" onclick="aj('<?php echo $sRefreshStatusUrl . '&sStatus=' . FModuleWorkingPartsManagement::STATUS_RUNNING;?>', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'<?php echo FModuleWorkingPartsManagement::STATUS_RUNNING;?>\'');<?php echo $sJsRefreshInformation;?>;">
       <?php } ?>

             <div class="item-image">
                <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_RUNNING) { ?>
                   <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_running.png" width="48px" height="48px">
                <?php } else { ?>
                   <img class="item-image-fade-20-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_running.png" width="48px" height="48px">
                <?php } ?>
             </div>
             <div class="item-image-description-center">
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_RUNNING;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_RUNNING'); ?></font>
             </div>
          </div>
       <?php
       }
       ?>
       
       <?php
       if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_pending_absence)) { ?>
       <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE) { ?>
          <div id="id_item_pending_absence" class="cell">
       <?php } else { ?>
          <div id="id_item_pending_absence" class="cell" style="cursor:pointer;" onclick="aj('<?php echo $sRefreshStatusUrl . '&sStatus=' . FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE;?>', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'<?php echo FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE;?>\'');<?php echo $sJsRefreshInformation;?>;">
       <?php } ?>

             <div class="item-image">
                <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE) { ?>
                   <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_pending_absence.png" width="48px" height="48px">
                <?php } else { ?>
                   <img class="item-image-fade-20-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_pending_absence.png" width="48px" height="48px">
                <?php } ?>
             </div>
             <div class="item-image-description-center">
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_PENDING_ABSENCE;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_PENDING_ABSENCE'); ?></font>
             </div>
          </div>
       <?php
       }
       ?>
       
       <?php
       if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_halted)) { ?>
       <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_HALTED) { ?>
          <div id="id_item_halted" class="cell">
       <?php } else { ?>
          <div id="id_item_halted" class="cell" style="cursor:pointer;" onclick="aj('<?php echo $sRefreshStatusUrl . '&sStatus=' . FModuleWorkingPartsManagement::STATUS_HALTED;?>', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'<?php echo FModuleWorkingPartsManagement::STATUS_HALTED;?>\'');<?php echo $sJsRefreshInformation;?>;">
       <?php } ?>
             <div class="item-image">
                <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_HALTED) { ?>
                   <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_halted.png" width="48px" height="48px">
                <?php } else { ?>
                   <img class="item-image-fade-20-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_halted.png" width="48px" height="48px">
                <?php } ?>
             </div>
             <div class="item-image-description-center">
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_HALTED;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_HALTED'); ?></font>
             </div>
          </div>
       <?php
       }
       ?>
        
       <?php
       if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_finalized)) { ?>
       <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_FINALIZED) { ?>
          <div id="id_item_finalized" class="last_cell">
       <?php } else { ?>
          <div id="id_item_finalized" class="last_cell" style="cursor:pointer;" onclick="aj('<?php echo $sRefreshStatusUrl . '&sStatus=' . FModuleWorkingPartsManagement::STATUS_FINALIZED;?>', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'<?php echo FModuleWorkingPartsManagement::STATUS_FINALIZED;?>\'');<?php echo $sJsRefreshInformation;?>;">
       <?php } ?>

             <div class="item-image">
                <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_FINALIZED) { ?>
                   <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_finalized.png" width="48px" height="48px">
                <?php } else { ?>
                   <img class="item-image-fade-20-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_finalized.png" width="48px" height="48px">
                <?php } ?>
             </div>
             <div class="item-image-description-center">
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_FINALIZED;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_FINALIZED'); ?></font>
             </div>
          </div>
       </div>
       <?php
       }
       ?>
       
       <?php echo $formFormWorkingPart->hiddenField($oModelForm, 'status', array('id'=>'idStatusField', 'style'=>'width:180px;')); ?>  
   </div>

   <div id="id_information">
   </div>

   <div class="row buttons">
      <?php echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormsWorkingParts') . '\'')); ?>
      
      <?php if ($oModelForm->data_completed) { 
               echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); 
            } else {
               echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_NEXT_STEP'), array('class'=>'form_button_submit'));
            }
         ?>
   </div>     

   <?php $this->endWidget(); ?>
</div>