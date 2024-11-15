<?php $sRefreshRegionsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/refreshFormTurnEventLinesRegions');                                                                                                                                         
      $sRefreshEquipmentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/refreshFormTurnEventLinesEquipments');
      $sJsRefreshEquipmentOthers = "$('#DigitalDiaryFormTurnEventLines_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', this.value == '" . FApplication::EQUIPMENT_OTHERS . "', 1.0, 1000)";
      $sJsRefreshDisappearEquipmentOthers = "$('#DigitalDiaryFormTurnEventLines_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', false, 1.0, 1000)";      
?>

<div class="form">
   <?php $formFormTurnEventLine = $this->beginWidget('CActiveForm', array(
      'id'=>'digitaldiary-form-turn-event-line-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/updateFormTurnEventLine', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
               
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENTLINE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'section_name', array('style'=>'width:300px;')); ?>
               <?php echo $formFormTurnEventLine->dropDownList($oModelForm, 'section_name', CHtml::listData(DigitalDiaryFormTurnEventSections::getDigitalDiaryFormTurnEventSectionsByIdFormFK($oModelForm->id_form_turn_event), 'name', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formFormTurnEventLine->error($oModelForm, 'section_name', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'urgent', array('style'=>'width:120px;')); ?>
               <?php echo $formFormTurnEventLine->checkBox($oModelForm, 'urgent', array('style'=>'width:10px;')); ?>
               <?php echo $formFormTurnEventLine->error($oModelForm, 'urgent', array('style'=>'width:120px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'id_zone', array('style'=>'width:300px;')); ?>                                                                                                                                                     
               <?php echo $formFormTurnEventLine->dropDownList($oModelForm, 'id_zone', CHtml::listData(Zones::getZones(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsRefreshDisappearEquipmentOthers . ';aj(\'' . $sRefreshRegionsUrl . '&nIdZone=\' + this.value, null, \'id_region\');' . ';aj(\'' . $sRefreshEquipmentsUrl . '&nIdRegion=\', null, \'id_equipment\');')); ?>           
               <?php echo $formFormTurnEventLine->error($oModelForm, 'id_zone', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>                                                                                                                                                     
               <div id="id_region">
                  <?php 
                     if (!FString::isNullOrEmpty($oModelForm->id_zone)) {                        
                        echo $formFormTurnEventLine->dropDownList($oModelForm, 'id_region', CHtml::listData(Regions::getRegions($oModelForm->id_zone), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsRefreshDisappearEquipmentOthers . ';' . ';aj(\'' . $sRefreshEquipmentsUrl . '&nIdRegion=\' + this.value, null, \'id_equipment\');'));                       
                     } else { 
                        echo $formFormTurnEventLine->dropDownList($oModelForm, 'id_region', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); 
                     } 
                  ?>
               </div>
               <?php echo $formFormTurnEventLine->error($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
               <div id="id_equipment">
                  <?php 
                     if ((!FString::isNullOrEmpty($oModelForm->id_zone)) && (!FString::isNullOrEmpty($oModelForm->id_region))) {
                        echo $formFormTurnEventLine->dropDownList($oModelForm, 'id_equipment', CHtml::listData(Equipments::getEquipments($oModelForm->id_region, null, null, null, true), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsRefreshEquipmentOthers . ';'));  
                     } else { 
                        echo $formFormTurnEventLine->dropDownList($oModelForm, 'id_equipment', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); 
                     } 
                  ?>
               </div>
               <?php echo $formFormTurnEventLine->error($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <div id="id_equipment_others" class="last_cell_content_expand_collapse_<?php if ($oModelForm->id_equipment == FApplication::EQUIPMENT_OTHERS) { echo 'show'; } else { echo 'hidden'; } ?>">
                  <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'equipment', array('style'=>'width:300px;')); ?>
                  <?php echo $formFormTurnEventLine->textField($oModelForm, 'equipment', array('style'=>'width:300px;')); ?>
                  <?php echo $formFormTurnEventLine->error($oModelForm, 'equipment', array('style'=>'width:300px;')); ?>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">  
               <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'description', array('style'=>'width:705px;')); ?>  
               <?php echo $formFormTurnEventLine->textArea($oModelForm, 'description', array('class'=>'mceEditor', 'style'=>'width:845px; height:300px')); ?>
               <?php echo $formFormTurnEventLine->error($oModelForm, 'description', array('style'=>'width:705px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit', 'onclick'=>'tinyMCE.triggerSave(true, true);')); ?>
      </div>  
   </div>
   
   <?php $this->endWidget(); ?>
</div>