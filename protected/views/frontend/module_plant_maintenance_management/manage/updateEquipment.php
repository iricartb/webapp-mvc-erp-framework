<div class="form">
   <?php $formEquipment = $this->beginWidget('CActiveForm', array(
      'id'=>'equipment-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/updateEquipment', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEEQUIPMENT_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'name', array('style'=>'width:392px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'name', array('style'=>'width:392px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'name', array('style'=>'width:392px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'tag', array('style'=>'width:150px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'tag', array('style'=>'width:150px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'tag', array('style'=>'width:150px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'manufacturer', array('style'=>'width:355px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'manufacturer', array('style'=>'width:355px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'manufacturer', array('style'=>'width:355px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
                <?php echo $formEquipment->labelEx($oModelForm, 'installation_date'); ?>
                <?php
                   if (!FString::isNullOrEmpty($oModelForm->installation_date)) {
                      $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'installation_date', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '160px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate($oModelForm->installation_date)));
                   }
                   else {
                      $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'installation_date', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '160px', FString::STRING_EMPTY, FString::STRING_EMPTY));   
                   }
                ?>
                <?php echo $formEquipment->error($oModelForm, 'installation_date'); ?>
            </div>
            <div class="cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'model', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'model', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'model', array('style'=>'width:160px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'serial_number', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'serial_number', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'serial_number', array('style'=>'width:160px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'dimension_x_m', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'dimension_x', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'dimension_x', array('style'=>'width:160px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'dimension_y_m', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'dimension_y', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'dimension_y', array('style'=>'width:160px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'dimension_z_m', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'dimension_z', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'dimension_z', array('style'=>'width:160px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'image', array('style'=>'width:355px;')); ?>
               
               <?php if ((!FString::isNullOrEmpty($oModelForm->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oModelForm->image))) { ?>
                  <div class="rectangle_content" style="width:200px; height:150px;">
                     <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oModelForm->image; ?>" width="200px" height="150px" />
                  </div>
                  <br>
               <?php } ?>
                         
               <?php echo $formEquipment->fileField($oModelForm, 'image', array('style'=>'width:355px;')); ?>      
               <?php echo $formEquipment->error($oModelForm, 'image', array('style'=>'width:355px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'attachment', array('style'=>'width:355px;')); ?>
               <?php echo $formEquipment->fileField($oModelForm, 'attachment', array('style'=>'width:355px;')); ?>      
               <?php echo $formEquipment->error($oModelForm, 'attachment', array('style'=>'width:355px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>