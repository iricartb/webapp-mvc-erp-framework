<?php $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters(); ?>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/forms_special_working_parts.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php 
      $sTaskDescription = FString::STRING_EMPTY;
      if (!FString::isNullOrEmpty($oModelForm->task)) { 
         $sTaskDescription = ' - ' . $oModelForm->task;
      } ?>
      
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMSPECIALWORKINGPART_HEADER', array('{1}'=>$oModelForm->id))) . $sTaskDescription; ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMSPECIALWORKINGPART_DESCRIPTION'); ?>
</div>

<?php $sRefreshStatusUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormSpecialWorkingPartStatus') . '&nIdForm=' . $oModelForm->id . '&sStatus='; 
      $sRefreshInformationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormSpecialWorkingPartInformation') . '&nIdForm=' . $oModelForm->id;
      $sViewFormSpecialWorkingPartEmployeesUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartEmployees') . '&nIdForm=' . $oModelForm->id;  
      $sViewFormSpecialWorkingPartMeansIpesUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartMeansIPEs') . '&nIdForm=' . $oModelForm->id;
      $sViewFormSpecialWorkingPartDynamicTextsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartDynamicTexts') . '&nIdForm=' . $oModelForm->id;
      
      if ($oModelForm->data_completed) {
         $sJsRefreshInformation = "aj('" . $sRefreshInformationUrl . "', null, 'id_information', null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "', '" . FAjax::TYPE_METHOD_CONTENT_DECORATION_FADE . "', 500)";  
      }  
      else $sJsRefreshInformation = FString::STRING_EMPTY;
      
      $sJsRefreshWorkOthers = "jquerySimpleAnimationFadeAppearDisappearTableCell('#id_work_others', this.value == '" . strtoupper(FString::STRING_OTHERS) . "', 1.0, 1000)";
      ?>

<?php if ($oModelForm->data_completed) { ?>
<div class="last_row">
   <div class="cell">
      <a id="id_item_employees" rel="fancybox" style="cursor:pointer;" href="<?php echo $sViewFormSpecialWorkingPartEmployeesUrl;?>">
         <div class="item-image">
            <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/item_employees.png" width="48px" height="48px">
         </div>
         <div class="item-image-description-center">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMSPECIALWORKINGPART_ITEM_EMPLOYEES'); ?>
         </div>
      </a>
   </div>
   <div class="cell">
      <a id="id_item_means_ipes" rel="fancybox" style="cursor:pointer;" href="<?php echo $sViewFormSpecialWorkingPartMeansIpesUrl;?>">
         <div class="item-image">
            <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/item_meansipes.png" width="48px" height="48px">
         </div>
         <div class="item-image-description-center">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMSPECIALWORKINGPART_ITEM_MEANSIPES'); ?>
         </div>
      </a>
   </div>
   <div class="cell">
      <a id="id_item_dynamic_texts" rel="fancybox" style="cursor:pointer;" href="<?php echo $sViewFormSpecialWorkingPartDynamicTextsUrl;?>">
         <div class="item-image">
            <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/item_dynamictexts.png" width="48px" height="48px">
         </div>
         <div class="item-image-description-center">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMSPECIALWORKINGPART_ITEM_DYNAMICTEXTS'); ?>
         </div>
      </a>
   </div>
   <div class="last_cell" style="width:100%; vertical-align:bottom; text-align:right;">
      <?php echo FWidget::showToolboxExporterCustomData('formSpecialWorkingPart', FApplication::MODULE_WORKING_PARTS_MANAGEMENT, 'formSpecialWorkingPart', $oModelForm->id, $this, true, true); ?>   
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
   <?php $formFormSpecialWorkingPart = $this->beginWidget('CActiveForm', array(
      'id'=>'form-special-working-part-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/updateFormSpecialWorkingPart', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content">
      <div class="first_row">
         <div class="cell_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMSPECIALWORKINGPART_FORM_HEADER_MAIN'); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_OWNER') . ':' . FString::STRING_SPACE . $oModelForm->owner; ?>
         </div>
      </div>
      <?php if ($oModelForm->data_completed) { ?>
      <div class="row">
         <div class="last_cell">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STARTDATE_DETAIL') . ':' . FString::STRING_SPACE . FDate::getTimeZoneFormattedDate($oModelForm->start_date, true); ?>
         </div>
      </div>
      <?php } ?>
      <div class="row">
         <div class="cell">
            <?php echo $formFormSpecialWorkingPart->labelEx($oModelForm, 'first_responsible', array('style'=>'width:260px;')); ?>
            <?php echo $formFormSpecialWorkingPart->dropDownList($oModelForm, 'first_responsible', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS), array(array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_OPERATING_TURN), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_MECHANICAL), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_ELECTRIC), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_TECHNICAL_OFFICE), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_OPERATING), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_MAINTENANCE), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_PREVENTION_SECURITY), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_TECHNICAL_DIRECTOR)), null, true), 'full_name', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:260px;', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormSpecialWorkingPart->error($oModelForm, 'first_responsible', array('style'=>'width:260px;')); ?>
         </div>
         <div class="last_cell">
            <?php echo $formFormSpecialWorkingPart->labelEx($oModelForm, 'third_responsible', array('style'=>'width:260px;')); ?>
            <?php echo FForm::textFieldAutoComplete($oModelForm, 'third_responsible', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS), null, null, true, true), 'full_name', 'full_name'), array('style'=>'width:215px;'), false, true); ?>                 
            <?php echo $formFormSpecialWorkingPart->error($oModelForm, 'third_responsible', array('style'=>'width:260px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormSpecialWorkingPart->labelEx($oModelForm, 'installation', array('style'=>'width:550px;')); ?>
            <?php echo $formFormSpecialWorkingPart->textField($oModelForm, 'installation', array('style'=>'width:550px;', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormSpecialWorkingPart->error($oModelForm, 'installation', array('style'=>'width:550px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormSpecialWorkingPart->labelEx($oModelForm, 'method_description', array('style'=>'width:705px;')); ?>
            <?php echo FForm::textFieldAutoComplete($oModelForm, 'method_code', CHtml::listData(Methods::getMethods(true), 'code', 'cbDescription'), array('style'=>'width:705px;font-size:11px;height:20px')); ?>
            <?php echo $formFormSpecialWorkingPart->error($oModelForm, 'method_code', array('style'=>'width:705px;')); ?>
         </div>
      </div>
      <?php
      if (!$oModelForm->data_completed) { ?>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormSpecialWorkingPart->labelEx($oModelForm, 'id_form_work_request', array('style'=>'width:705px;')); ?>
            <?php echo $formFormSpecialWorkingPart->dropDownList($oModelForm, 'id_form_work_request', CHtml::listData(FormsWorkRequests::getFormsWorkRequests(true, FModuleWorkingPartsManagement::STATUS_PENDING), 'id', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:705px;font-size:11px;height:20px', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormSpecialWorkingPart->error($oModelForm, 'id_form_work_request', array('style'=>'width:705px;')); ?>
         </div>
      </div>
      <?php 
      } ?>
      <br/>
      <div class="row">
         <div class="cell_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMSPECIALWORKINGPART_FORM_HEADER_WORK'); ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormSpecialWorkingPart->labelEx($oModelForm, 'work', array('style'=>'width:300px;')); ?>                                                                                                                                                     
            <?php
               $oArrayWorks = array();
               $oArrayWorks[FModuleWorkingPartsManagement::TYPE_WORK_CONFINED_SPACE] = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORK_VALUE_CONFINED_SPACE'); 
               $oArrayWorks[FModuleWorkingPartsManagement::TYPE_WORK_VOLTAGE] = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORK_VALUE_VOLTAGE'); 
               $oArrayWorks[FModuleWorkingPartsManagement::TYPE_WORK_HEIGHT] = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORK_VALUE_HEIGHT'); 
               $oArrayWorks[FModuleWorkingPartsManagement::TYPE_WORK_FIRE_EXPLOSION] = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORK_VALUE_FIRE_EXPLOSION'); 
               $oArrayWorks[strtoupper(FString::STRING_OTHERS)] = Yii::t('system', 'SYS_OTHERS_M');
            
               echo $formFormSpecialWorkingPart->dropDownList($oModelForm, 'work', $oArrayWorks, array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsRefreshWorkOthers . ';' . $sJsRefreshInformation)); 
            ?>
            <?php echo $formFormSpecialWorkingPart->error($oModelForm, 'work', array('style'=>'width:300px;')); ?>
         </div>
         <div class="last_cell">
            <div id="id_work_others" class="last_cell_content_expand_collapse_<?php if ($oModelForm->work == strtoupper(FString::STRING_OTHERS)) { echo 'show'; } else { echo 'hidden'; } ?>">
               <?php echo $formFormSpecialWorkingPart->labelEx($oModelForm, 'work_others', array('style'=>'width:370px;')); ?>
               <?php echo $formFormSpecialWorkingPart->textField($oModelForm, 'work_others', array('style'=>'width:370px;', 'onchange'=>$sJsRefreshInformation)); ?>
               <?php echo $formFormSpecialWorkingPart->error($oModelForm, 'work_others', array('style'=>'width:370px;')); ?>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormSpecialWorkingPart->labelEx($oModelForm, 'work_description', array('style'=>'width:700px;')); ?>
            <?php echo $formFormSpecialWorkingPart->textArea($oModelForm, 'work_description', array('style'=>'width:700px; height:30px; overflow:auto; resize:none', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormSpecialWorkingPart->error($oModelForm, 'work_description', array('style'=>'width:700px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormSpecialWorkingPart->labelEx($oModelForm, 'supplement_instructions', array('style'=>'width:700px;')); ?>
            <?php echo $formFormSpecialWorkingPart->textArea($oModelForm, 'supplement_instructions', array('style'=>'width:700px; height:60px; overflow:auto; resize:none', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormSpecialWorkingPart->error($oModelForm, 'supplement_instructions', array('style'=>'width:700px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormSpecialWorkingPart->labelEx($oModelForm, 'permission_renovation', array('style'=>'width:240px;')); ?>
            <?php echo $formFormSpecialWorkingPart->checkBox($oModelForm, 'permission_renovation', array('style'=>'width:10px;', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormSpecialWorkingPart->error($oModelForm, 'permission_renovation', array('style'=>'width:240px;')); ?>
         </div>
      </div>  
      <br/>
      <div class="row">
         <div class="cell_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMSPECIALWORKINGPART_FORM_HEADER_STATUS'); ?>
         </div>
      </div>
       
      <div id="idStatus" class="row">
       <?php 
          if ((is_null($oWorkingPartModuleParameters)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_created)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_created == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_running == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending_absence == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_halted == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_finalized == false))) { ?>
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
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_CREATED;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_CREATED'); ?></font>
             </div>
          </div>
       <?php
       }
       ?>
       
       <?php
       if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending)) { ?>  
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
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_PENDING;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_PENDING'); ?></font>
             </div>
          </div>
       <?php
       }
       ?>
       
       <?php
       if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_running)) { ?> 
       <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_RUNNING) { ?>
          <div id="id_item_running" class="cell">
       <?php } else { ?>
          <div id="id_item_running" class="cell" style="cursor:pointer;" onclick="aj('<?php echo $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_RUNNING;?>', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'<?php echo FModuleWorkingPartsManagement::STATUS_RUNNING;?>\'');<?php echo $sJsRefreshInformation;?>;">
       <?php } ?>

             <div class="item-image">
                <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_RUNNING) { ?>
                   <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_running.png" width="48px" height="48px">
                <?php } else { ?>
                   <img class="item-image-fade-20-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_running.png" width="48px" height="48px">
                <?php } ?>
             </div>
             <div class="item-image-description-center">
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_RUNNING;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_RUNNING'); ?></font>
             </div>
          </div>
       <?php
       }
       ?>
      
       <?php
       if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending_absence)) { ?>
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
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_PENDING_ABSENCE;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_PENDING_ABSENCE'); ?></font>
             </div>
          </div>
       <?php
       }
       ?>
        
       <?php
       if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_halted)) { ?>
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
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_HALTED;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_HALTED'); ?></font>
             </div>
          </div>
       <?php
       }
       ?>
       
       <?php
       if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_finalized)) { ?>
       <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_FINALIZED) { ?>
          <div id="id_item_finalized" class="last_cell">
       <?php } else { ?>
          <div id="id_item_finalized" class="last_cell" style="cursor:pointer;" onclick="aj('<?php echo $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_FINALIZED;?>', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'<?php echo FModuleWorkingPartsManagement::STATUS_FINALIZED;?>\'');<?php echo $sJsRefreshInformation;?>;">
       <?php } ?>

             <div class="item-image">
                <?php if ($oModelForm->status == FModuleWorkingPartsManagement::STATUS_FINALIZED) { ?>
                   <img class="item-image-normal-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_finalized.png" width="48px" height="48px">
                <?php } else { ?>
                   <img class="item-image-fade-20-round-border" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)?>/status_finalized.png" width="48px" height="48px">
                <?php } ?>
             </div>
             <div class="item-image-description-center">
                <font color="<?php echo FModuleWorkingPartsManagement::COLOR_STATUS_FINALIZED;?>"><?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_FINALIZED'); ?></font>
             </div>
          </div>
       </div>
       <?php
       }
       ?>
       
       <?php echo $formFormSpecialWorkingPart->hiddenField($oModelForm, 'status', array('id'=>'idStatusField', 'style'=>'width:180px;')); ?>  
   </div>

   <div id="id_information">
   </div>

   <div class="row buttons">
      <?php echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormsSpecialWorkingParts') . '\'')); ?>
      
      <?php if ($oModelForm->data_completed) { 
               echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); 
            } else {
               echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_NEXT_STEP'), array('class'=>'form_button_submit')); 
            }
         ?>
   </div>     

   <?php $this->endWidget(); ?>
</div>