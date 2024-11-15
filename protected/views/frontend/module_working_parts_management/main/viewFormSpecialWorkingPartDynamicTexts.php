<?php 
   $dataCompleted = true;
   $oModelFormParent = FormsSpecialWorkingParts::getFormSpecialWorkingPart($oModelFormMeasure->id_form_special_working_part);
   if ((!is_null($oModelFormParent)) && ($oModelFormParent->data_completed == false)) $dataCompleted = false; 
   
   if (!$dataCompleted) { ?>
      <div class="item-header">
         <div class="item-header-image">
            <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/item_dynamictexts.png' ?>" />
         </div>
         <div class="item-header-text">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTDYNAMICTEXTS_HEADER', array('{1}'=>$oModelFormMeasure->id_form_special_working_part))); ?>
         </div>
      </div>
      <div class="separator_30"></div>
<?php }

$nWorkingPartMeasures = count(FormSpecialWorkingPartMeasures::getFormSpecialWorkingPartMeasuresByIdFormFK($oModelFormMeasure->id_form_special_working_part));
$nWorkingPartEquipmentConditions = count(FormSpecialWorkingPartEquipmentConditions::getFormSpecialWorkingPartEquipmentConditionsByIdFormFK($oModelFormEquipmentCondition->id_form_special_working_part));
$nVisibleForms = 0;

if ($nWorkingPartMeasures < (FModuleWorkingPartsManagement::MAX_MEASURES_SPECIAL_WORKING_PARTS_SIMULTANEOUS + 1)) $nVisibleForms++;
if ($nWorkingPartEquipmentConditions < (FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_SPECIAL_WORKING_PARTS_SIMULTANEOUS + 1)) $nVisibleForms++;

if ($nVisibleForms != 0) { ?>
   <div class="form_header">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTDYNAMICTEXTS_FORM_DYNAMICTEXT_NEW_DESCRIPTION'); ?>
   </div>
<?php
}

if ($nWorkingPartEquipmentConditions < (FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_SPECIAL_WORKING_PARTS_SIMULTANEOUS + 1)) { ?>
   <div class="cell">
      <div class="form">
         <?php $formSpecialWorkingPartEquipmentCondition = $this->beginWidget('CActiveForm', array(
            'id'=>'form-special-working-part-equipment-condition-form',
            'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartDynamicTexts', array('nIdForm'=>$oModelFormEquipmentCondition->id_form_special_working_part)),
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
                     <?php echo $formSpecialWorkingPartEquipmentCondition->labelEx($oModelFormEquipmentCondition, 'description', array('style'=>'width:300px')); ?>
                     <?php echo $formSpecialWorkingPartEquipmentCondition->dropDownList($oModelFormEquipmentCondition, 'description', CHtml::listData(EquipmentConditions::getEquipmentConditions(), 'description', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px')); ?>
                     <?php echo $formSpecialWorkingPartEquipmentCondition->error($oModelFormEquipmentCondition, 'description', array('style'=>'width:300px')); ?>
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
if ($nWorkingPartMeasures < (FModuleWorkingPartsManagement::MAX_MEASURES_SPECIAL_WORKING_PARTS_SIMULTANEOUS + 1)) { ?>
   <div class="cell">
      <div class="form">
         <?php $formSpecialWorkingPartMeasure = $this->beginWidget('CActiveForm', array(
            'id'=>'form-special-working-part-measure-form',
            'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartDynamicTexts', array('nIdForm'=>$oModelFormMeasure->id_form_special_working_part)),
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
                     <?php echo $formSpecialWorkingPartMeasure->labelEx($oModelFormMeasure, 'description', array('style'=>'width:300px')); ?>
                     <?php echo $formSpecialWorkingPartMeasure->dropDownList($oModelFormMeasure, 'description', CHtml::listData(Measures::getMeasures(), 'description', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px')); ?>
                     <?php echo $formSpecialWorkingPartMeasure->error($oModelFormMeasure, 'description', array('style'=>'width:300px')); ?>
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
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTDYNAMICTEXTS_FORM_EQUIPMENTCONDITION_DESCRIPTION'); ?>
   </div>
   
   <div class="form_questionary_content">
      <div class="row_emphasis">
         <div class="cell" style="width:420px;">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTEQUIPMENTCONDITIONS_FIELD_DESCRIPTION')); ?>
         </div>
         <div class="cell" style="width:20px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_YES')); ?>
         </div>
         <div class="cell" style="width:20px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_NO')); ?>
         </div>
         <div class="last_cell" style="width:10px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_NP')); ?>
         </div>
      </div>
      
      <?php $formFormSpecialWorkingPartDynamicText = $this->beginWidget('CActiveForm', array(
         'id'=>'form-special-working-part-dynamic-text-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/updateFormSpecialWorkingPartDynamicTexts', array('nIdForm'=>$oModelFormMeasure->id_form_special_working_part)),
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
         ),
      )); ?>
      
      <?php 
      $oFormSpecialWorkingPartEquipmentConditions = FormSpecialWorkingPartEquipmentConditions::getFormSpecialWorkingPartEquipmentConditionsByIdFormFK($oModelFormEquipmentCondition->id_form_special_working_part);
      $i = 0; $num = 1;
      $oValuesList = array(1=>FString::STRING_EMPTY, 2=>FString::STRING_EMPTY, 3=>FString::STRING_EMPTY);
      foreach($oFormSpecialWorkingPartEquipmentConditions as $oFormSpecialWorkingPartEquipmentCondition) {
         $sRefreshEquipmentConditionUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormSpecialWorkingPartEquipmentCondition') . '&nIdForm=' . $oFormSpecialWorkingPartEquipmentCondition->id . '&nValue=';               
         ?>
         <div class="form_questionary_row_content">
            <input type="hidden" name="FormSpecialWorkingPartEquipmentConditions[<?php echo $i;?>][ID]" value="<?php echo $oFormSpecialWorkingPartEquipmentCondition->id;?>"/>
            <div class="row">
               <div class="cell" style="width:405px"><?php
                  if ($oFormSpecialWorkingPartEquipmentCondition->custom) {
                     echo $num . '. ' . $formFormSpecialWorkingPartDynamicText->textField($oFormSpecialWorkingPartEquipmentCondition, 'custom_field', array('name'=>'FormSpecialWorkingPartEquipmentConditions[' . $i . '][custom_field]', 'style'=>'width:380px;')); 
                  }
                  else echo $num . '. ' . $oFormSpecialWorkingPartEquipmentCondition->description;    
               ?>
               </div>
               <div id="cell" style="width:160px">
                  <?php echo $formFormSpecialWorkingPartDynamicText->radioButtonList($oFormSpecialWorkingPartEquipmentCondition, 'value', $oValuesList, array('separator'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp', 'name'=>'FormSpecialWorkingPartEquipmentConditions[' . $i . '][value]', 'onchange'=>'aj(\'' . $sRefreshEquipmentConditionUrl . '\' + this.value, null, \'id_equipment_condition_alert_' . $oFormSpecialWorkingPartEquipmentCondition->id . '\');')); ?>                        
               </div>
               <div class="last_cell" style="width:10px;"> 
                  <?php if (!$oFormSpecialWorkingPartEquipmentCondition->custom) { ?>
                  <a class="borrar" title="borrar" href="<?php echo Yii::app()->controller->createUrl("deleteFormSpecialWorkingPartEquipmentCondition", array("nIdForm"=>$oFormSpecialWorkingPartEquipmentCondition->id, "nIdFormParent"=>$oFormSpecialWorkingPartEquipmentCondition->id_form_special_working_part))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                     <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" alt="borrar" />
                  </a>
                  <?php } ?>
               </div>
            </div>
            <?php
            if (strlen($oFormSpecialWorkingPartEquipmentCondition->information) > 0) { ?>
               <div class="row">
                  <div class="cell" style="padding-left:15px;">
                  <?php
                     echo $oFormSpecialWorkingPartEquipmentCondition->information;   
                  ?>
                  </div>
                  <div class="last_cell">
                     <?php echo $formFormSpecialWorkingPartDynamicText->textField($oFormSpecialWorkingPartEquipmentCondition, 'information_field', array('name'=>'FormSpecialWorkingPartEquipmentConditions[' . $i . '][information_field]', 'style'=>'width:150px;')); ?>
                  </div>
               </div>
            <?php 
            } ?>
            <div id="id_equipment_condition_alert_<?php echo $oFormSpecialWorkingPartEquipmentCondition->id;?>" class="row" style="color:red; padding-left:15px;">
               <?php
               if (((is_null($oFormSpecialWorkingPartEquipmentCondition->value)) && ($oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_default)) || ((!is_null($oFormSpecialWorkingPartEquipmentCondition->value)) && ($oFormSpecialWorkingPartEquipmentCondition->value == 1) && ($oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_yes)) || ((!is_null($oFormSpecialWorkingPartEquipmentCondition->value)) && ($oFormSpecialWorkingPartEquipmentCondition->value == 2) && ($oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_no)) || ((!is_null($oFormSpecialWorkingPartEquipmentCondition->value)) && ($oFormSpecialWorkingPartEquipmentCondition->value == 3) && ($oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_np))) {
                  echo $oFormSpecialWorkingPartEquipmentCondition->alert;      
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
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTDYNAMICTEXTS_FORM_MEASURE_DESCRIPTION'); ?>
   </div>

   <div class="form_questionary_content">
      <div class="row_emphasis">
         <div class="cell" style="width:420px;">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTMEASURES_FIELD_DESCRIPTION')); ?>
         </div>
         <div class="cell" style="width:20px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTMEASURES_FIELD_VALUE_VALUE_YES')); ?>
         </div>
         <div class="cell" style="width:20px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTMEASURES_FIELD_VALUE_VALUE_NO')); ?>
         </div>
         <div class="last_cell" style="width:10px">
            <?php echo strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTMEASURES_FIELD_VALUE_VALUE_NP')); ?>
         </div>
      </div>
          
      <?php 
      $oFormSpecialWorkingPartMeasures = FormSpecialWorkingPartMeasures::getFormSpecialWorkingPartMeasuresByIdFormFK($oModelFormMeasure->id_form_special_working_part);
      $i = 0; $num = 1;
      $oValuesList = array(1=>FString::STRING_EMPTY, 2=>FString::STRING_EMPTY, 3=>FString::STRING_EMPTY);
      foreach($oFormSpecialWorkingPartMeasures as $oFormSpecialWorkingPartMeasure) {
         $sRefreshMeasureUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormSpecialWorkingPartMeasure') . '&nIdForm=' . $oFormSpecialWorkingPartMeasure->id . '&nValue=';               
         ?>
         <div class="form_questionary_row_content">
            <input type="hidden" name="FormSpecialWorkingPartMeasures[<?php echo $i;?>][ID]" value="<?php echo $oFormSpecialWorkingPartMeasure->id;?>"/>
            <div class="row">
               <div class="cell" style="width:405px"><?php
                  if ($oFormSpecialWorkingPartMeasure->custom) {
                     echo $num . '. ' . $formFormSpecialWorkingPartDynamicText->textField($oFormSpecialWorkingPartMeasure, 'custom_field', array('name'=>'FormSpecialWorkingPartMeasures[' . $i . '][custom_field]', 'style'=>'width:380px;')); 
                  }
                  else echo $num . '. ' . $oFormSpecialWorkingPartMeasure->description;    
               ?>
               </div>
               <div id="cell" style="width:160px">
                  <?php echo $formFormSpecialWorkingPartDynamicText->radioButtonList($oFormSpecialWorkingPartMeasure, 'value', $oValuesList, array('separator'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp', 'name'=>'FormSpecialWorkingPartMeasures[' . $i . '][value]', 'onchange'=>'aj(\'' . $sRefreshMeasureUrl . '\' + this.value, null, \'id_measure_alert_' . $oFormSpecialWorkingPartMeasure->id . '\');')); ?>                        
               </div>
               <div class="last_cell" style="width:10px;"> 
                  <?php if (!$oFormSpecialWorkingPartMeasure->custom) { ?>
                  <a class="borrar" title="borrar" href="<?php echo Yii::app()->controller->createUrl("deleteFormSpecialWorkingPartMeasure", array("nIdForm"=>$oFormSpecialWorkingPartMeasure->id, "nIdFormParent"=>$oFormSpecialWorkingPartMeasure->id_form_special_working_part))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                     <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" alt="borrar" />
                  </a>
                  <?php } ?>
               </div>
            </div>
            <?php
            if (strlen($oFormSpecialWorkingPartMeasure->information) > 0) { ?>
               <div class="row">
                  <div class="cell" style="padding-left:15px;">
                  <?php
                     echo $oFormSpecialWorkingPartMeasure->information;   
                  ?>
                  </div>
                  <div class="last_cell">
                     <?php echo $formFormSpecialWorkingPartDynamicText->textField($oFormSpecialWorkingPartMeasure, 'information_field', array('name'=>'FormSpecialWorkingPartMeasures[' . $i . '][information_field]', 'style'=>'width:150px;')); ?>
                  </div>
               </div>
            <?php 
            } ?>
            <div id="id_measure_alert_<?php echo $oFormSpecialWorkingPartMeasure->id;?>" class="row" style="color:red; padding-left:15px;">
               <?php
               if (((is_null($oFormSpecialWorkingPartMeasure->value)) && ($oFormSpecialWorkingPartMeasure->visible_alert_value_default)) || ((!is_null($oFormSpecialWorkingPartMeasure->value)) && ($oFormSpecialWorkingPartMeasure->value == 1) && ($oFormSpecialWorkingPartMeasure->visible_alert_value_yes)) || ((!is_null($oFormSpecialWorkingPartMeasure->value)) && ($oFormSpecialWorkingPartMeasure->value == 2) && ($oFormSpecialWorkingPartMeasure->visible_alert_value_no)) || ((!is_null($oFormSpecialWorkingPartMeasure->value)) && ($oFormSpecialWorkingPartMeasure->value == 3) && ($oFormSpecialWorkingPartMeasure->visible_alert_value_np))) {
                  echo $oFormSpecialWorkingPartMeasure->alert;      
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
            echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK_STEP'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormSpecialWorkingPartMeansIPEs', array('nIdForm'=>$oModelFormMeasure->id_form_special_working_part)) . '\'')); 
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


