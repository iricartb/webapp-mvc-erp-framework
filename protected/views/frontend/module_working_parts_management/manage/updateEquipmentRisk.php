<div class="form">
   <?php $formEquipmentRisk = $this->beginWidget('CActiveForm', array(
      'id'=>'equipment-risk-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/updateEquipmentRisk', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEEQUIPMENTRISK_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formEquipmentRisk->labelEx($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
               <?php echo $formEquipmentRisk->dropDownList($oModelForm, 'id_equipment', CHtml::listData(Equipments::getFullEquipments(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formEquipmentRisk->error($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formEquipmentRisk->labelEx($oModelForm, 'id_risk', array('style'=>'width:300px;')); ?>
               <?php echo $formEquipmentRisk->dropDownList($oModelForm, 'id_risk', CHtml::listData(Risks::getRisks(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formEquipmentRisk->error($oModelForm, 'id_risk', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>