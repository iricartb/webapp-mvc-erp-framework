<?php 
   $dataCompleted = true;
   $oModelFormParent = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($oModelFormMeasure->id_form_maintenance_working_part);
   if ((!is_null($oModelFormParent)) && ($oModelFormParent->data_completed == false)) $dataCompleted = false; 
   
   if (!$dataCompleted) { ?>
      <div class="item-header">
         <div class="item-header-image">
            <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/item_dynamictexts.png' ?>" />
         </div>
         <div class="item-header-text">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMMAINTENANCEWORKINGPARTDYNAMICTEXTS_HEADER', array('{1}'=>$oModelFormMeasure->id_form_maintenance_working_part))); ?>
         </div>
      </div>
      <div class="separator_30"></div>
<?php }

$nWorkingPartMeasures = count(FormMaintenanceWorkingPartMeasures::getFormMaintenanceWorkingPartMeasuresByIdFormFK($oModelFormMeasure->id_form_maintenance_working_part));
$nWorkingPartEquipmentConditions = count(FormMaintenanceWorkingPartEquipmentConditions::getFormMaintenanceWorkingPartEquipmentConditionsByIdFormFK($oModelFormEquipmentCondition->id_form_maintenance_working_part));
$nVisibleForms = 0;

if ($nWorkingPartMeasures < (FModuleWorkingPartsManagement::MAX_MEASURES_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS + 1)) $nVisibleForms++;
if ($nWorkingPartEquipmentConditions < (FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS + 1)) $nVisibleForms++;

if ($nVisibleForms != 0) { ?>
   <div class="form_header">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMMAINTENANCEWORKINGPARTDYNAMICTEXTS_FORM_DYNAMICTEXT_NEW_DESCRIPTION'); ?>
   </div>
<?php
}

if ($nVisibleForms == 3) { $sSelectionText = 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'; $sCellClass = 'cell_padding10'; $sCellWidth = '188px'; }
else { $sSelectionText = 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'; $sCellClass = 'cell'; $sCellWidth = '300px'; }

if ($nWorkingPartEquipmentConditions < (FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS + 1)) { ?>
   <div class="<?php echo $sCellClass;?>">
      <div class="form">
         <?php $formMaintenanceWorkingPartEquipmentCondition = $this->beginWidget('CActiveForm', array(
            'id'=>'form-maintenance-working-part-equipment-condition-form',
            'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormMaintenanceWorkingPartDynamicTexts', array('nIdForm'=>$oModelFormEquipmentCondition->id_form_maintenance_working_part)),
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
               'validateOnSubmit'=>true,
            ),
         )); ?>
         
         <div class="form_content_popup_add">
            <div class="form_content">
               <div class="first_row">
                  <div class="last_cell">
                     <?php echo $formMaintenanceWorkingPartEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'description', array('style'=>'width:' . $sCellWidth)); ?>
                     <?php echo $formMaintenanceWorkingPartEquipmentCondition->dropDownList($oModelFormEquipmentCondition, 'description', CHtml::listData(EquipmentConditions::getEquipmentConditions(), 'description', 'description'), array('empty'=>Yii::t('system', $sSelectionText), 'style'=>'width:' . $sCellWidth)); ?>
                     <?php echo $formMaintenanceWorkingPartEquipmentCondition->error($oModelFormEquipmentCondition, 'description', array('style'=>'width:' . $sCellWidth)); ?>
                  </div>
               </div>
            </div>
            <div class="row buttons">
               <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_ADD'), array('class'=>'form_button_submit')); ?>
            </div>  
         </div>
             
         <?php $this->endWidget(); ?>
      </div>
   </div>
<?php 
}       
if ($nWorkingPartMeasures < (FModuleWorkingPartsManagement::MAX_MEASURES_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS + 1)) { ?>
   <div class="<?php echo $sCellClass;?>">
      <div class="form">
         <?php $formMaintenanceWorkingPartMeasure = $this->beginWidget('CActiveForm', array(
            'id'=>'form-maintenance-working-part-measure-form',
            'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormMaintenanceWorkingPartDynamicTexts', array('nIdForm'=>$oModelFormMeasure->id_form_maintenance_working_part)),
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
               'validateOnSubmit'=>true,
            ),
         )); ?>
         
         <div class="form_content_popup_add">
            <div class="form_content">
               <div class="first_row">
                  <div class="last_cell">
                     <?php echo $formMaintenanceWorkingPartMeasure->labelEx($oModelFormMeasure, 'description', array('style'=>'width:' . $sCellWidth)); ?>
                     <?php echo $formMaintenanceWorkingPartMeasure->dropDownList($oModelFormMeasure, 'description', CHtml::listData(Measures::getMeasures(), 'description', 'description'), array('empty'=>Yii::t('system', $sSelectionText), 'style'=>'width:' . $sCellWidth)); ?>
                     <?php echo $formMaintenanceWorkingPartMeasure->error($oModelFormMeasure, 'description', array('style'=>'width:' . $sCellWidth)); ?>
                  </div>
               </div>
            </div>
            <div class="row buttons">
               <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_ADD'), array('class'=>'form_button_submit')); ?>
            </div>  
         </div>
             
         <?php $this->endWidget(); ?>
      </div>
   </div>
<?php 
} 
if (Yii::app()->user->hasFlash('success')) { ?>
   <div class="flash-success">
      <?php echo Yii::app()->user->getFlash('success'); ?>
   </div> <?php 
} ?>

<div class="separator_20"></div>

<div class="form_questionary">
   <div class="item-description-italic">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMMAINTENANCEWORKINGPARTDYNAMICTEXTS_FORM_EQUIPMENTCONDITION_DESCRIPTION'); ?>
   </div>
   
   <div class="form_questionary_content">
      <div class="row_emphasis">
         <div class="cell" style="width:420px;">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTEQUIPMENTCONDITIONS_FIELD_DESCRIPTION')); ?>
         </div>
         <div class="cell" style="width:20px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_YES')); ?>
         </div>
         <div class="cell" style="width:20px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_NO')); ?>
         </div>
         <div class="last_cell" style="width:10px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_NP')); ?>
         </div>
      </div>
      
      <?php $formFormMaintenanceWorkingPartDynamicText = $this->beginWidget('CActiveForm', array(
         'id'=>'form-maintenance-working-part-dynamic-text-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/updateFormMaintenanceWorkingPartDynamicTexts', array('nIdForm'=>$oModelFormMeasure->id_form_maintenance_working_part)),
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
         ),
      )); ?>
      
      <?php 
      $oFormMaintenanceWorkingPartEquipmentConditions = FormMaintenanceWorkingPartEquipmentConditions::getFormMaintenanceWorkingPartEquipmentConditionsByIdFormFK($oModelFormEquipmentCondition->id_form_maintenance_working_part);
      $i = 0; $num = 1;
      $oValuesList = array(1=>FString::STRING_EMPTY, 2=>FString::STRING_EMPTY, 3=>FString::STRING_EMPTY);
      foreach($oFormMaintenanceWorkingPartEquipmentConditions as $oFormMaintenanceWorkingPartEquipmentCondition) {
         $sRefreshEquipmentConditionUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormMaintenanceWorkingPartEquipmentCondition') . '&nIdForm=' . $oFormMaintenanceWorkingPartEquipmentCondition->id . '&nValue=';               
         ?>
         <div class="form_questionary_row_content">
            <input type="hidden" name="FormMaintenanceWorkingPartEquipmentConditions[<?php echo $i;?>][ID]" value="<?php echo $oFormMaintenanceWorkingPartEquipmentCondition->id;?>"/>
            <div class="row">
               <div class="cell" style="width:405px"><?php
                  if ($oFormMaintenanceWorkingPartEquipmentCondition->custom) {
                     echo $num . '. ' . $formFormMaintenanceWorkingPartDynamicText->textField($oFormMaintenanceWorkingPartEquipmentCondition, 'custom_field', array('name'=>'FormMaintenanceWorkingPartEquipmentConditions[' . $i . '][custom_field]', 'style'=>'width:380px;')); 
                  }
                  else echo $num . '. ' . $oFormMaintenanceWorkingPartEquipmentCondition->description;    
               ?>
               </div>
               <div id="cell" style="width:160px">
                  <?php echo $formFormMaintenanceWorkingPartDynamicText->radioButtonList($oFormMaintenanceWorkingPartEquipmentCondition, 'value', $oValuesList, array('separator'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp', 'name'=>'FormMaintenanceWorkingPartEquipmentConditions[' . $i . '][value]', 'onchange'=>'aj(\'' . $sRefreshEquipmentConditionUrl . '\' + this.value, null, \'id_equipment_condition_alert_' . $oFormMaintenanceWorkingPartEquipmentCondition->id . '\');')); ?>                        
               </div>
               <div class="last_cell" style="width:10px;"> 
                  <?php if (!$oFormMaintenanceWorkingPartEquipmentCondition->custom) { ?>
                  <a class="borrar" title="borrar" href="<?php echo Yii::app()->controller->createUrl("deleteFormMaintenanceWorkingPartEquipmentCondition", array("nIdForm"=>$oFormMaintenanceWorkingPartEquipmentCondition->id, "nIdFormParent"=>$oFormMaintenanceWorkingPartEquipmentCondition->id_form_maintenance_working_part))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                     <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" alt="borrar" />
                  </a>
                  <?php } ?>
               </div>
            </div>
            <?php
            if (strlen($oFormMaintenanceWorkingPartEquipmentCondition->information) > 0) { ?>
               <div class="row">
                  <div class="cell" style="padding-left:15px;">
                  <?php
                     echo $oFormMaintenanceWorkingPartEquipmentCondition->information;   
                  ?>
                  </div>
                  <div class="last_cell">
                     <?php echo $formFormMaintenanceWorkingPartDynamicText->textField($oFormMaintenanceWorkingPartEquipmentCondition, 'information_field', array('name'=>'FormMaintenanceWorkingPartEquipmentConditions[' . $i . '][information_field]', 'style'=>'width:150px;')); ?>
                  </div>
               </div>
            <?php 
            } ?>
            <div id="id_equipment_condition_alert_<?php echo $oFormMaintenanceWorkingPartEquipmentCondition->id;?>" class="row" style="color:red; padding-left:15px;">
               <?php
               if (((is_null($oFormMaintenanceWorkingPartEquipmentCondition->value)) && ($oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_default)) || ((!is_null($oFormMaintenanceWorkingPartEquipmentCondition->value)) && ($oFormMaintenanceWorkingPartEquipmentCondition->value == 1) && ($oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_yes)) || ((!is_null($oFormMaintenanceWorkingPartEquipmentCondition->value)) && ($oFormMaintenanceWorkingPartEquipmentCondition->value == 2) && ($oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_no)) || ((!is_null($oFormMaintenanceWorkingPartEquipmentCondition->value)) && ($oFormMaintenanceWorkingPartEquipmentCondition->value == 3) && ($oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_np))) {
                  echo $oFormMaintenanceWorkingPartEquipmentCondition->alert;      
               }
               ?>
            </div>
         </div>
         <?php 
         $i++; $num++;      
      }
      ?>
   </div>
   
   <div class="separator_30"></div>
   
   <div class="item-description-italic">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMMAINTENANCEWORKINGPARTDYNAMICTEXTS_FORM_MEASURE_DESCRIPTION'); ?>
   </div>

   <div class="form_questionary_content">
      <div class="row_emphasis">
         <div class="cell" style="width:420px;">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_DESCRIPTION')); ?>
         </div>
         <div class="cell" style="width:20px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_VALUE_VALUE_YES')); ?>
         </div>
         <div class="last_cell" style="width:10px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_VALUE_VALUE_NP')); ?>
         </div>
      </div>
          
      <?php 
      $oFormMaintenanceWorkingPartMeasures = FormMaintenanceWorkingPartMeasures::getFormMaintenanceWorkingPartMeasuresByIdFormFK($oModelFormMeasure->id_form_maintenance_working_part);
      $i = 0; $num = 1;
      $oValuesList = array(1=>FString::STRING_EMPTY, 3=>FString::STRING_EMPTY);
      foreach($oFormMaintenanceWorkingPartMeasures as $oFormMaintenanceWorkingPartMeasure) {
         $sRefreshMeasureUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormMaintenanceWorkingPartMeasure') . '&nIdForm=' . $oFormMaintenanceWorkingPartMeasure->id . '&nValue=';               
         ?>
         <div class="form_questionary_row_content">
            <input type="hidden" name="FormMaintenanceWorkingPartMeasures[<?php echo $i;?>][ID]" value="<?php echo $oFormMaintenanceWorkingPartMeasure->id;?>"/>
            <div class="row">
               <div class="cell" style="width:405px"><?php
                  if ($oFormMaintenanceWorkingPartMeasure->custom) {
                     echo $num . '. ' . $formFormMaintenanceWorkingPartDynamicText->textField($oFormMaintenanceWorkingPartMeasure, 'custom_field', array('name'=>'FormMaintenanceWorkingPartMeasures[' . $i . '][custom_field]', 'style'=>'width:380px;')); 
                  }
                  else echo $num . '. ' . $oFormMaintenanceWorkingPartMeasure->description;    
               ?>
               </div>
               <div id="cell" style="width:110px">
                  <?php echo $formFormMaintenanceWorkingPartDynamicText->radioButtonList($oFormMaintenanceWorkingPartMeasure, 'value', $oValuesList, array('separator'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp', 'name'=>'FormMaintenanceWorkingPartMeasures[' . $i . '][value]', 'onchange'=>'aj(\'' . $sRefreshMeasureUrl . '\' + this.value, null, \'id_measure_alert_' . $oFormMaintenanceWorkingPartMeasure->id . '\');')); ?>                        
               </div>
               <div class="last_cell" style="width:10px;"> 
                  <?php if (!$oFormMaintenanceWorkingPartMeasure->custom) { ?>
                  <a class="borrar" title="borrar" href="<?php echo Yii::app()->controller->createUrl("deleteFormMaintenanceWorkingPartMeasure", array("nIdForm"=>$oFormMaintenanceWorkingPartMeasure->id, "nIdFormParent"=>$oFormMaintenanceWorkingPartMeasure->id_form_maintenance_working_part))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                     <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" alt="borrar" />
                  </a>
                  <?php } ?>
               </div>
            </div>
            <?php
            if (strlen($oFormMaintenanceWorkingPartMeasure->information) > 0) { ?>
               <div class="row">
                  <div class="cell" style="padding-left:15px;">
                  <?php
                     echo $oFormMaintenanceWorkingPartMeasure->information;   
                  ?>
                  </div>
                  <div class="last_cell">
                     <?php echo $formFormMaintenanceWorkingPartDynamicText->textField($oFormMaintenanceWorkingPartMeasure, 'information_field', array('name'=>'FormMaintenanceWorkingPartMeasures[' . $i . '][information_field]', 'style'=>'width:150px;')); ?>
                  </div>
               </div>
            <?php 
            } ?>
            <div id="id_measure_alert_<?php echo $oFormMaintenanceWorkingPartMeasure->id;?>" class="row" style="color:red; padding-left:15px;">
               <?php
               if (((is_null($oFormMaintenanceWorkingPartMeasure->value)) && ($oFormMaintenanceWorkingPartMeasure->visible_alert_value_default)) || ((!is_null($oFormMaintenanceWorkingPartMeasure->value)) && ($oFormMaintenanceWorkingPartMeasure->value == 1) && ($oFormMaintenanceWorkingPartMeasure->visible_alert_value_yes)) || ((!is_null($oFormMaintenanceWorkingPartMeasure->value)) && ($oFormMaintenanceWorkingPartMeasure->value == 2) && ($oFormMaintenanceWorkingPartMeasure->visible_alert_value_no)) || ((!is_null($oFormMaintenanceWorkingPartMeasure->value)) && ($oFormMaintenanceWorkingPartMeasure->value == 3) && ($oFormMaintenanceWorkingPartMeasure->visible_alert_value_np))) {
                  echo $oFormMaintenanceWorkingPartMeasure->alert;      
               }
               ?>
            </div>
         </div>
         <?php 
         $i++; $num++;      
      }
      ?>
   </div>
   
   <div class="separator_15"></div>
   
   <?php 
   if (!$dataCompleted) { ?>
      <div class="separator_30"></div>
      <div class="form">
         <?php 
            echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK_STEP'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormMaintenanceWorkingPartRisksIPEs', array('nIdForm'=>$oModelFormMeasure->id_form_maintenance_working_part)) . '\'')); 
         ?>
         <?php 
            echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_FINALIZE'), array('class'=>'form_button_submit')); 
         ?>
      </div>
   <?php 
   }
   else { ?>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
      </div>
   <?php 
   }  
   ?>
   
   <?php $this->endWidget(); ?>
</div>


