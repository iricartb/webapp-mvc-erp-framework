<div class="form">
   <?php $formForm = $this->beginWidget('CActiveForm', array(
      'id'=>'monitoring-form-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/manage/updateForm', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_UPDATEFORM_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formForm->labelEx($oModelForm, 'id_group_form', array('style'=>'width:300px;')); ?>
               <?php echo $formForm->dropDownList($oModelForm, 'id_group_form', CHtml::listData(MonitoringGroupForms::getMonitoringGroupForms(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formForm->error($oModelForm, 'id_group_form', array('style'=>'width:300px;')); ?>  
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formForm->labelEx($oModelForm, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formForm->textField($oModelForm, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formForm->error($oModelForm, 'name', array('style'=>'width:200px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formForm->labelEx($oModelForm, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formForm->textField($oModelForm, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formForm->error($oModelForm, 'description', array('style'=>'width:350px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>