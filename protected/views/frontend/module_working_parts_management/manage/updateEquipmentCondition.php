<div class="form">
   <?php $formEquipmentCondition = $this->beginWidget('CActiveForm', array(
      'id'=>'equipment-condition-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/updateEquipmentCondition', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEEQUIPMENTCONDITION_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formEquipmentCondition->labelEx($oModelForm, 'description', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->textField($oModelForm, 'description', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelForm, 'description', array('style'=>'width:480px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEquipmentCondition->labelEx($oModelForm, 'visible_default_working_part', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelForm, 'visible_default_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelForm, 'visible_default_working_part', array('style'=>'width:140px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formEquipmentCondition->labelEx($oModelForm, 'visible_default_maintenance_working_part', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelForm, 'visible_default_maintenance_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelForm, 'visible_default_maintenance_working_part', array('style'=>'width:160px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipmentCondition->labelEx($oModelForm, 'visible_default_special_working_part', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelForm, 'visible_default_special_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelForm, 'visible_default_special_working_part', array('style'=>'width:140px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formEquipmentCondition->labelEx($oModelForm, 'alert', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->textField($oModelForm, 'alert', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelForm, 'alert', array('style'=>'width:480px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEquipmentCondition->labelEx($oModelForm, 'visible_alert_value_yes', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelForm, 'visible_alert_value_yes', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelForm, 'visible_alert_value_yes', array('style'=>'width:140px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formEquipmentCondition->labelEx($oModelForm, 'visible_alert_value_no', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelForm, 'visible_alert_value_no', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelForm, 'visible_alert_value_no', array('style'=>'width:140px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formEquipmentCondition->labelEx($oModelForm, 'visible_alert_value_np', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelForm, 'visible_alert_value_np', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelForm, 'visible_alert_value_np', array('style'=>'width:140px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipmentCondition->labelEx($oModelForm, 'visible_alert_value_default', array('style'=>'width:140px;')); ?>
               <?php echo $formEquipmentCondition->checkBox($oModelForm, 'visible_alert_value_default', array('style'=>'width:10px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelForm, 'visible_alert_value_default', array('style'=>'width:140px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formEquipmentCondition->labelEx($oModelForm, 'information', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->textField($oModelForm, 'information', array('style'=>'width:480px;')); ?>
               <?php echo $formEquipmentCondition->error($oModelForm, 'information', array('style'=>'width:480px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>

<?php 
if ((Yii::app()->user->hasFlash('success')) || (Yii::app()->user->hasFlash('error'))) { ?>
   <?php if (Yii::app()->user->hasFlash('success')) { ?>
      <div class="flash-success">
         <?php echo Yii::app()->user->getFlash('success'); ?>
      </div> 
   <?php } else if (Yii::app()->user->hasFlash('notice')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice'); ?>
      </div>   
   <?php } else { ?>
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error'); ?>
      </div>
   <?php }
} ?>