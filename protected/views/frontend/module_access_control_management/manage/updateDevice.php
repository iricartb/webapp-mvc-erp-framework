<div class="form">
   <?php $formDevice = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-device-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/updateDevice', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEDEVICE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formDevice->labelEx($oModelForm, 'name', array('style'=>'width:180px;')); ?>
               <?php echo $formDevice->textField($oModelForm, 'name', array('style'=>'width:180px;')); ?>
               <?php echo $formDevice->error($oModelForm, 'name', array('style'=>'width:180px;')); ?>
            </div>
   <?php if (!(AccessControlDevices::isAccessControlDeviceLocked($oModelForm->id))) { ?>
            <div class="cell">
               <?php echo $formDevice->labelEx($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
               <?php echo $formDevice->textField($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
               <?php echo $formDevice->error($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formDevice->labelEx($oModelForm, 'disabled', array('style'=>'width:180px;')); ?>
               <?php echo $formDevice->checkBox($oModelForm, 'disabled', array('style'=>'width:20px;')); ?>
               <?php echo $formDevice->error($oModelForm, 'disabled', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formDevice->labelEx($oModelForm, 'type', array('style'=>'width:400px;')); ?>
               <?php echo $formDevice->dropDownList($oModelForm, 'type', array(FModuleAccessControlManagement::TYPE_MAIN_INPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_MAIN_INPUT), FModuleAccessControlManagement::TYPE_MAIN_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_MAIN_OUTPUT), FModuleAccessControlManagement::TYPE_INPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_INPUT), FModuleAccessControlManagement::TYPE_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_OUTPUT), FModuleAccessControlManagement::TYPE_INPUT_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_INPUT_OUTPUT)), array('style'=>'width:400px;')); ?>
               <?php echo $formDevice->error($oModelForm, 'type', array('style'=>'width:400px;')); ?>   
            </div>
         </div>
      </div>
   <?php } else { ?>
         <div class="last_cell">
            <?php echo $formDevice->labelEx($oModelForm, 'disabled', array('style'=>'width:180px;')); ?>
            <?php echo $formDevice->checkBox($oModelForm, 'disabled', array('style'=>'width:20px;')); ?>
            <?php echo $formDevice->error($oModelForm, 'disabled', array('style'=>'width:180px;')); ?>
         </div>
      </div>
   <?php } ?>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>