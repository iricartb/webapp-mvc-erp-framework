<?php 
   $dataCompleted = true;
   $oModelFormParent = FormsWorkingParts::getFormWorkingPart($oModelFormMeasure->id_form_working_part);
   if ((!is_null($oModelFormParent)) && ($oModelFormParent->data_completed == false)) $dataCompleted = false; 
   
   if (!$dataCompleted) { ?>
      <div class="item-header">
         <div class="item-header-image">
            <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/item_dynamictexts.png' ?>" />
         </div>
         <div class="item-header-text">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTDYNAMICTEXTS_HEADER', array('{1}'=>$oModelFormMeasure->id_form_working_part))); ?>
         </div>
      </div>
      <div class="separator_30"></div>
<?php } 
$nWorkingPartMeasures = count(FormWorkingPartMeasures::getFormWorkingPartMeasuresByIdFormFK($oModelFormMeasure->id_form_working_part));
$nWorkingPartEquipmentConditions = count(FormWorkingPartEquipmentConditions::getFormWorkingPartEquipmentConditionsByIdFormFK($oModelFormEquipmentCondition->id_form_working_part));
$nVisibleForms = 0;
   
if ($nWorkingPartMeasures < (FModuleWorkingPartsManagement::MAX_MEASURES_WORKING_PARTS_SIMULTANEOUS + 1)) $nVisibleForms++;
if ($nWorkingPartEquipmentConditions < (FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_WORKING_PARTS_SIMULTANEOUS + 1)) $nVisibleForms++;

if ($nVisibleForms != 0) { ?>
   <div class="form_header">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTDYNAMICTEXTS_FORM_DYNAMICTEXT_NEW_DESCRIPTION'); ?>
   </div>
<?php
}

if ($nVisibleForms == 3) { $sSelectionText = 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'; $sCellClass = 'cell_padding10'; $sCellWidth = '188px'; }
else { $sSelectionText = 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'; $sCellClass = 'cell'; $sCellWidth = '300px'; }

if ($nWorkingPartEquipmentConditions < (FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_WORKING_PARTS_SIMULTANEOUS + 1)) { ?>
   <div class="<?php echo $sCellClass;?>">
      <div class="form">
         <?php $formWorkingPartEquipmentCondition = $this->beginWidget('CActiveForm', array(
            'id'=>'form-working-part-equipment-condition-form',
            'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartDynamicTexts', array('nIdForm'=>$oModelFormEquipmentCondition->id_form_working_part)),
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
                     <?php echo $formWorkingPartEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'description', array('style'=>'width:' . $sCellWidth)); ?>
                     <?php echo $formWorkingPartEquipmentCondition->dropDownList($oModelFormEquipmentCondition, 'description', CHtml::listData(EquipmentConditions::getEquipmentConditions(), 'description', 'description'), array('empty'=>Yii::t('system', $sSelectionText), 'style'=>'width:' . $sCellWidth)); ?>
                     <?php echo $formWorkingPartEquipmentCondition->error($oModelFormEquipmentCondition, 'description', array('style'=>'width:' . $sCellWidth)); ?>
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
if ($nWorkingPartMeasures < (FModuleWorkingPartsManagement::MAX_MEASURES_WORKING_PARTS_SIMULTANEOUS + 1)) { ?>
   <div class="<?php echo $sCellClass;?>">
      <div class="form">
         <?php $formWorkingPartMeasure = $this->beginWidget('CActiveForm', array(
            'id'=>'form-working-part-measure-form',
            'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartDynamicTexts', array('nIdForm'=>$oModelFormMeasure->id_form_working_part)),
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
                     <?php echo $formWorkingPartMeasure->labelEx($oModelFormMeasure, 'description', array('style'=>'width:' . $sCellWidth)); ?>
                     <?php echo $formWorkingPartMeasure->dropDownList($oModelFormMeasure, 'description', CHtml::listData(Measures::getMeasures(), 'description', 'description'), array('empty'=>Yii::t('system', $sSelectionText), 'style'=>'width:' . $sCellWidth)); ?>
                     <?php echo $formWorkingPartMeasure->error($oModelFormMeasure, 'description', array('style'=>'width:' . $sCellWidth)); ?>
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
} else if (Yii::app()->user->hasFlash('error')) { ?>
   <div class="flash-error">
      <?php echo Yii::app()->user->getFlash('error'); ?>
   </div> <?php 
}
?>

<div class="separator_20"></div>

<div class="form_questionary">
   <div class="item-description-italic">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTDYNAMICTEXTS_FORM_EQUIPMENTCONDITION_DESCRIPTION'); ?>
   </div>
   
   <div class="form_questionary_content">
      <div class="row_emphasis">
         <div class="cell" style="width:420px;">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTEQUIPMENTCONDITIONS_FIELD_DESCRIPTION')); ?>
         </div>
         <div class="cell" style="width:20px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_YES')); ?>
         </div>
         <div class="cell" style="width:20px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_NO')); ?>
         </div>
         <div class="last_cell" style="width:10px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_NP')); ?>
         </div>
      </div>
      
      <?php $formFormWorkingPartDynamicText = $this->beginWidget('CActiveForm', array(
         'id'=>'form-working-part-dynamic-text-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/updateFormWorkingPartDynamicTexts', array('nIdForm'=>$oModelFormMeasure->id_form_working_part)),
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
         ),
      )); ?>
      
      <?php 
      $oFormWorkingPartEquipmentConditions = FormWorkingPartEquipmentConditions::getFormWorkingPartEquipmentConditionsByIdFormFK($oModelFormEquipmentCondition->id_form_working_part);
      $i = 0; $num = 1;
      $oValuesList = array(1=>FString::STRING_EMPTY, 2=>FString::STRING_EMPTY, 3=>FString::STRING_EMPTY);
      foreach($oFormWorkingPartEquipmentConditions as $oFormWorkingPartEquipmentCondition) {
         $sRefreshEquipmentConditionUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartEquipmentCondition') . '&nIdForm=' . $oFormWorkingPartEquipmentCondition->id . '&nValue=';               
         ?>
         <div class="form_questionary_row_content">
            <input type="hidden" name="FormWorkingPartEquipmentConditions[<?php echo $i;?>][ID]" value="<?php echo $oFormWorkingPartEquipmentCondition->id;?>"/>
            <div class="row">
               <div class="cell" style="width:405px"><?php
                  if ($oFormWorkingPartEquipmentCondition->custom) {
                     echo $num . '. ' . $formFormWorkingPartDynamicText->textField($oFormWorkingPartEquipmentCondition, 'custom_field', array('name'=>'FormWorkingPartEquipmentConditions[' . $i . '][custom_field]', 'style'=>'width:380px;')); 
                  }
                  else echo $num . '. ' . $oFormWorkingPartEquipmentCondition->description;    
               ?>
               </div>
               <div id="cell" style="width:160px">
                  <?php echo $formFormWorkingPartDynamicText->radioButtonList($oFormWorkingPartEquipmentCondition, 'value', $oValuesList, array('separator'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp', 'name'=>'FormWorkingPartEquipmentConditions[' . $i . '][value]', 'onchange'=>'aj(\'' . $sRefreshEquipmentConditionUrl . '\' + this.value, null, \'id_equipment_condition_alert_' . $oFormWorkingPartEquipmentCondition->id . '\');')); ?>                        
               </div>
               <div class="last_cell" style="width:10px;"> 
                  <?php if (!$oFormWorkingPartEquipmentCondition->custom) { ?>
                  <a class="borrar" title="borrar" href="<?php echo Yii::app()->controller->createUrl("deleteFormWorkingPartEquipmentCondition", array("nIdForm"=>$oFormWorkingPartEquipmentCondition->id, "nIdFormParent"=>$oFormWorkingPartEquipmentCondition->id_form_working_part))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                     <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" alt="borrar" />
                  </a>
                  <?php } ?>
               </div>
            </div>
            <?php
            if (strlen($oFormWorkingPartEquipmentCondition->information) > 0) { ?>
               <div class="row">
                  <div class="cell" style="padding-left:15px;">
                  <?php
                     echo $oFormWorkingPartEquipmentCondition->information;   
                  ?>
                  </div>
                  <div class="last_cell">
                     <?php echo $formFormWorkingPartDynamicText->textField($oFormWorkingPartEquipmentCondition, 'information_field', array('name'=>'FormWorkingPartEquipmentConditions[' . $i . '][information_field]', 'style'=>'width:150px;')); ?>
                  </div>
               </div>
            <?php 
            } ?>
            <div id="id_equipment_condition_alert_<?php echo $oFormWorkingPartEquipmentCondition->id;?>" class="row" style="color:red; padding-left:15px;">
               <?php
               if (((is_null($oFormWorkingPartEquipmentCondition->value)) && ($oFormWorkingPartEquipmentCondition->visible_alert_value_default)) || ((!is_null($oFormWorkingPartEquipmentCondition->value)) && ($oFormWorkingPartEquipmentCondition->value == 1) && ($oFormWorkingPartEquipmentCondition->visible_alert_value_yes)) || ((!is_null($oFormWorkingPartEquipmentCondition->value)) && ($oFormWorkingPartEquipmentCondition->value == 2) && ($oFormWorkingPartEquipmentCondition->visible_alert_value_no)) || ((!is_null($oFormWorkingPartEquipmentCondition->value)) && ($oFormWorkingPartEquipmentCondition->value == 3) && ($oFormWorkingPartEquipmentCondition->visible_alert_value_np))) {
                  echo $oFormWorkingPartEquipmentCondition->alert;      
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
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTDYNAMICTEXTS_FORM_MEASURE_DESCRIPTION'); ?>
   </div>

   <div class="form_questionary_content">
      <div class="row_emphasis">
         <div class="cell" style="width:420px;">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTMEASURES_FIELD_DESCRIPTION')); ?>
         </div>
         <div class="cell" style="width:20px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTMEASURES_FIELD_VALUE_VALUE_YES')); ?>
         </div>
         <div class="last_cell" style="width:10px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTMEASURES_FIELD_VALUE_VALUE_NP')); ?>
         </div>
      </div>
          
      <?php 
      $oFormWorkingPartMeasures = FormWorkingPartMeasures::getFormWorkingPartMeasuresByIdFormFK($oModelFormMeasure->id_form_working_part);
      $i = 0; $num = 1;
      $oValuesList = array(1=>FString::STRING_EMPTY, 3=>FString::STRING_EMPTY);
      foreach($oFormWorkingPartMeasures as $oFormWorkingPartMeasure) {
         $sRefreshMeasureUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartMeasure') . '&nIdForm=' . $oFormWorkingPartMeasure->id . '&nValue=';               
         ?>
         <div class="form_questionary_row_content">
            <input type="hidden" name="FormWorkingPartMeasures[<?php echo $i;?>][ID]" value="<?php echo $oFormWorkingPartMeasure->id;?>"/>
            <div class="row">
               <div class="cell" style="width:405px"><?php
                  if ($oFormWorkingPartMeasure->custom) {
                     echo $num . '. ' . $formFormWorkingPartDynamicText->textField($oFormWorkingPartMeasure, 'custom_field', array('name'=>'FormWorkingPartMeasures[' . $i . '][custom_field]', 'style'=>'width:380px;')); 
                  }
                  else echo $num . '. ' . $oFormWorkingPartMeasure->description;    
               ?>
               </div>
               <div id="cell" style="width:110px">
                  <?php echo $formFormWorkingPartDynamicText->radioButtonList($oFormWorkingPartMeasure, 'value', $oValuesList, array('separator'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp', 'name'=>'FormWorkingPartMeasures[' . $i . '][value]', 'onchange'=>'aj(\'' . $sRefreshMeasureUrl . '\' + this.value, null, \'id_measure_alert_' . $oFormWorkingPartMeasure->id . '\');')); ?>                        
               </div>
               <div class="last_cell" style="width:10px;"> 
                  <?php if (!$oFormWorkingPartMeasure->custom) { ?>
                  <a class="borrar" title="borrar" href="<?php echo Yii::app()->controller->createUrl("deleteFormWorkingPartMeasure", array("nIdForm"=>$oFormWorkingPartMeasure->id, "nIdFormParent"=>$oFormWorkingPartMeasure->id_form_working_part))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                     <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" alt="borrar" />
                  </a>
                  <?php } ?>
               </div>
            </div>
            <?php
            if (strlen($oFormWorkingPartMeasure->information) > 0) { ?>
               <div class="row">
                  <div class="cell" style="padding-left:15px;">
                  <?php
                     echo $oFormWorkingPartMeasure->information;   
                  ?>
                  </div>
                  <div class="last_cell">
                     <?php echo $formFormWorkingPartDynamicText->textField($oFormWorkingPartMeasure, 'information_field', array('name'=>'FormWorkingPartMeasures[' . $i . '][information_field]', 'style'=>'width:150px;')); ?>
                  </div>
               </div>
            <?php 
            } ?>
            <div id="id_measure_alert_<?php echo $oFormWorkingPartMeasure->id;?>" class="row" style="color:red; padding-left:15px;">
               <?php
               if (((is_null($oFormWorkingPartMeasure->value)) && ($oFormWorkingPartMeasure->visible_alert_value_default)) || ((!is_null($oFormWorkingPartMeasure->value)) && ($oFormWorkingPartMeasure->value == 1) && ($oFormWorkingPartMeasure->visible_alert_value_yes)) || ((!is_null($oFormWorkingPartMeasure->value)) && ($oFormWorkingPartMeasure->value == 2) && ($oFormWorkingPartMeasure->visible_alert_value_no)) || ((!is_null($oFormWorkingPartMeasure->value)) && ($oFormWorkingPartMeasure->value == 3) && ($oFormWorkingPartMeasure->visible_alert_value_np))) {
                  echo $oFormWorkingPartMeasure->alert;      
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
            echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK_STEP'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormWorkingPartRisksIPEs', array('nIdForm'=>$oModelFormMeasure->id_form_working_part)) . '\'')); 
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


