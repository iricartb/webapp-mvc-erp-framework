<div class="form">
   <?php $formRegionEquipment = $this->beginWidget('CActiveForm', array(
      'id'=>'region-equipment-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/updateRegionEquipment', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEREGIONEQUIPMENT_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formRegionEquipment->labelEx($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>
               <?php echo $formRegionEquipment->dropDownList($oModelForm, 'id_region', CHtml::listData(Regions::getFullRegions(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formRegionEquipment->error($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formRegionEquipment->labelEx($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
               <?php echo $formRegionEquipment->dropDownList($oModelForm, 'id_equipment', CHtml::listData(Equipments::getFullEquipments(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formRegionEquipment->error($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>