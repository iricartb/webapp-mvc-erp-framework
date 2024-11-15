<div class="form">
   <?php $formEquipmentComponent = $this->beginWidget('CActiveForm', array(
      'id'=>'equipment-component-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/updateEquipmentComponent', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEREGIONEQUIPMENT_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formEquipmentComponent->labelEx($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
               <?php echo $formEquipmentComponent->dropDownList($oModelForm, 'id_equipment', CHtml::listData(Equipments::getFullEquipments(), 'id', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formEquipmentComponent->error($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formEquipmentComponent->labelEx($oModelForm, 'id_component', array('style'=>'width:300px;')); ?>
               <?php echo $formEquipmentComponent->dropDownList($oModelForm, 'id_component', CHtml::listData(Components::getFullComponents(), 'id', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formEquipmentComponent->error($oModelForm, 'id_component', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>